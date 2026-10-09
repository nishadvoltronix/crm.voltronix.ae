public function update_quotation()
{
    try {
        log_message('error', '=== update_quotation called ===');

        $raw = $this->input->raw_input_stream;
        log_message('error', 'Raw input: ' . $raw);

        $post = json_decode($raw, true);
        log_message('error', 'Decoded post: ' . print_r($post, true));

        if (!$post) {
            echo json_encode([
                'success' => false,
                'error'   => 'No data received.'
            ]);
            return;
        }

        if (empty($post['task_id'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Task ID is required.'
            ]);
            return;
        }

        if (empty($post['subject'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Subject is required.'
            ]);
            return;
        }

        if (empty($post['items']) || !is_array($post['items'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'At least one item is required.'
            ]);
            return;
        }

        $task = $this->Task_model->get_task($post['task_id']);
        log_message('error', 'Task found: ' . print_r($task, true));

        if (!$task) {
            echo json_encode([
                'success' => false,
                'error'   => 'Task not found in local CRM.'
            ]);
            return;
        }

        if (empty($task['zoho_crm_id'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Zoho CRM deal ID not found for this task.'
            ]);
            return;
        }

        if (empty($task['quote_id'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Zoho quote ID not found for this task.'
            ]);
            return;
        }

        $proposal_data = [
    'subject'            => $post['subject'] ?? 'Default Subject',
    'project'            => $post['project'] ?? null,
    'kind_attention'     => $post['kind_attention'] ?? null,
    'terms_of_payment'   => $post['termsOfPayment'] ?? null,
    'specification'      => $post['specification'] ?? null,
    'general_exclusion'  => $post['generalExclusion'] ?? null,
    'brand'              => $post['brand'] ?? null,
    'warranty'           => $post['warranty'] ?? null,
    'delivery'           => $post['delivery'] ?? null,
    'notes'              => $post['notes'] ?? null,
    'valid_until'        => $post['validUntil'] ?? null,
    'discount'           => $post['discount'] ?? 0,
    'adjustment'         => $post['adjustment'] ?? 0,
    'items'              => $post['items']
];

        log_message('error', 'Proposal data before Zoho update: ' . print_r($proposal_data, true));

        $result = $this->update_proposal_in_zoho(
            $task['zoho_crm_id'],
            $task['quote_id'],
            $proposal_data,
            $task['id'],
            $task['quote_number'] ?? null
        );

        log_message('error', 'update_proposal_in_zoho result: ' . print_r($result, true));

        echo json_encode($result);
    } catch (Throwable $e) {
        log_message('error', 'update_quotation exception: ' . $e->getMessage());
        log_message('error', 'update_quotation trace: ' . $e->getTraceAsString());

        echo json_encode([
            'success' => false,
            'error'   => 'Server error in update_quotation: ' . $e->getMessage()
        ]);
    }
}

private function update_proposal_in_zoho($deal_id, $quote_id, $proposal_data, $task_id, $existing_quote_number = null)
{
    try {
        log_message('error', '=== update_proposal_in_zoho called ===');
        log_message('error', 'Deal ID: ' . $deal_id);
        log_message('error', 'Quote ID: ' . $quote_id);
        log_message('error', 'Task ID: ' . $task_id);
        log_message('error', 'Proposal data: ' . print_r($proposal_data, true));

        $this->access_token = $this->Zoho_model->get_access_token();

        if (!$this->access_token) {
            return ['success' => false, 'error' => 'Access token not found.'];
        }

        $valid_until_date = null;
        if (!empty($proposal_data['valid_until'])) {
            try {
                $date = new DateTime($proposal_data['valid_until']);
                $valid_until_date = $date->format('Y-m-d');
            } catch (Exception $e) {
                return ['success' => false, 'error' => 'Invalid valid_until date format.'];
            }
        }

        $headers = [
            'Content-Type: application/json',
            'Authorization: Zoho-oauthtoken ' . $this->access_token
        ];

        // Find/Create Contact
        $last_name = trim($proposal_data['kind_attention'] ?? 'Default Last Name');

        $existing_contact_response = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Contacts/search?criteria=(Last_Name:equals:' . rawurlencode($last_name) . ')',
            $headers,
            null,
            'GET'
        );

        log_message('error', 'Existing contact response: ' . print_r($existing_contact_response, true));

        $existing_contact_data = [];
        if (!empty($existing_contact_response['body'])) {
            $existing_contact_data = json_decode($existing_contact_response['body'], true);
        }

        if (!empty($existing_contact_data['data'][0]['id'])) {
            $contact_id = $existing_contact_data['data'][0]['id'];
            $contact_name = $existing_contact_data['data'][0]['Last_Name'];
        } else {
            $contact_payload = json_encode([
                'data' => [[
                    'Last_Name' => $last_name ?: 'Default Last Name'
                ]]
            ]);

            $contact_response = $this->execute_curl_request(
                'https://www.zohoapis.com/crm/v2.1/Contacts',
                $headers,
                $contact_payload,
                'POST'
            );

            log_message('error', 'Create contact response: ' . print_r($contact_response, true));

            $contact_response_body = [];
            if (!empty($contact_response['body'])) {
                $contact_response_body = json_decode($contact_response['body'], true);
            }

            if (!empty($contact_response_body['data'][0]['details']['id'])) {
                $contact_id = $contact_response_body['data'][0]['details']['id'];
                $contact_name = $last_name ?: 'Default Last Name';
            } else {
                return [
                    'success' => false,
                    'error'   => 'Failed to create contact in Zoho.',
                    'details' => $contact_response_body
                ];
            }
        }

        // Build Quote Items
        $quoted_items = [];
        $product_descriptions = [];

        foreach ($proposal_data['items'] as $item) {
            $product_id = $item['product_id'] ?? null;

            if (empty($product_id)) {
                return [
                    'success' => false,
                    'error'   => 'Product ID missing in one item.',
                    'item'    => $item
                ];
            }

            $product_description = trim($item['itemDescription'] ?? '');

            if ($product_description === '') {
                $product_response = $this->execute_curl_request(
                    "https://www.zohoapis.com/crm/v2.1/Products/{$product_id}",
                    $headers,
                    null,
                    'GET'
                );

                log_message('error', 'Product fetch response: ' . print_r($product_response, true));

                $product_data = [];
                if (!empty($product_response['body'])) {
                    $product_data = json_decode($product_response['body'], true);
                }

                if (!empty($product_data['data'][0])) {
                    $product_description = $product_data['data'][0]['Description'] ?? '';
                }
            }

            $product_descriptions[$product_id] = $product_description;

            $quoted_items[] = [
                'Product_Name' => ['id' => $product_id],
                'Quantity'     => (float)($item['quantity'] ?? 0),
                'List_Price'   => (float)($item['unitPrice'] ?? 0),
                'ItemDiscount' => $item['itemDiscount'] ?? 0,
                'U_O_M'        => $item['uom'] ?? '',
                'Description'  => $product_description
            ];
        }

        $quote_payload = json_encode([
            'data' => [[
                'id'                => $quote_id,
                'Deal_Name'         => $deal_id,
                'Subject'           => $proposal_data['subject'] ?? 'Default Subject',
                'Project'           => $proposal_data['project'] ?? null,
                'Terms_of_Payment'  => $proposal_data['terms_of_payment'] ?? null,
                'Specification'     => $proposal_data['specification'] ?? null,
                'General_Exclusion' => $proposal_data['general_exclusion'] ?? null,
                'Brand'             => $proposal_data['brand'] ?? null,
                'Warranty'          => $proposal_data['warranty'] ?? null,
                'Delivery'          => $proposal_data['delivery'] ?? null,
                'Valid_Till'        => $valid_until_date,
                'Contact_Name'      => [
                    'name' => $contact_name,
                    'id'   => $contact_id,
                ],
                'Quoted_Items'      => $quoted_items
            ]]
        ]);

        log_message('error', 'Quote update payload: ' . $quote_payload);

        $response = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Quotes',
            $headers,
            $quote_payload,
            'PUT'
        );

        log_message('error', 'Quote update response: ' . print_r($response, true));

        $response_body = [];
        if (!empty($response['body'])) {
            $response_body = json_decode($response['body'], true);
        }

        if (empty($response_body['data'][0]['code']) || strtoupper($response_body['data'][0]['code']) !== 'SUCCESS') {
            return [
                'success' => false,
                'error'   => 'Quote update failed in Zoho CRM.',
                'details' => $response_body
            ];
        }

        // Fetch updated quote details
        $quote_details_response = $this->execute_curl_request(
            "https://www.zohoapis.com/crm/v2.1/Quotes/{$quote_id}",
            $headers,
            null,
            'GET'
        );

        log_message('error', 'Updated quote details response: ' . print_r($quote_details_response, true));

        $quote_details = [];
        if (!empty($quote_details_response['body'])) {
            $quote_details = json_decode($quote_details_response['body'], true);
        }

        $quote_number  = $quote_details['data'][0]['Quote_No'] ?? $existing_quote_number;
        $modified_time = $quote_details['data'][0]['Modified_Time'] ?? date('Y-m-d H:i:s');

        $first_item = $proposal_data['items'][0] ?? [];

        $task_update_data = [
    'quote_id'            => $quote_id,
    'quote_number'        => $quote_number,
    'subject'             => $proposal_data['subject'] ?? null,
    'project_name'        => $proposal_data['project'] ?? null,
    'kind_attention'      => $proposal_data['kind_attention'] ?? null,
    'terms_of_payment'    => $proposal_data['terms_of_payment'] ?? null,
    'general_exclusion'   => $proposal_data['general_exclusion'] ?? null,
    'specification'       => $proposal_data['specification'] ?? null,
    'brand'               => $proposal_data['brand'] ?? null,
    'warranty'            => $proposal_data['warranty'] ?? null,
    'delivery'            => $proposal_data['delivery'] ?? null,
    'notes'               => $proposal_data['notes'] ?? null,
    'valid_until'         => $proposal_data['valid_until'] ?? null,
    'discount'            => $proposal_data['discount'] ?? 0,
    'adjustment'          => $proposal_data['adjustment'] ?? 0,
    'product_id'          => $first_item['product_id'] ?? null,
    'product_name'        => $first_item['product_name'] ?? null,
    'product_description' => isset($first_item['product_id'])
        ? ($product_descriptions[$first_item['product_id']] ?? ($first_item['itemDescription'] ?? ''))
        : null,
    'uom'                 => $first_item['uom'] ?? null,
    'quantity'            => $first_item['quantity'] ?? null,
    'service_charge'      => $first_item['unitPrice'] ?? 0,
    'updated_at'          => $modified_time
];

        log_message('error', 'Task update data: ' . print_r($task_update_data, true));

        if (!$this->Task_model->save_proposal_data($task_update_data, $task_id)) {
            return [
                'success' => false,
                'error'   => 'Failed to update tasks table.'
            ];
        }

        // Replace items locally
        $this->Task_model->delete_proposal_items($task_id);

        foreach ($proposal_data['items'] as $item) {
            $product_id = $item['product_id'] ?? null;

            $item_save_data = [
                'task_id'             => $task_id,
                'quote_number'        => $quote_number,
                'product_id'          => $product_id,
                'product_name'        => $item['product_name'] ?? null,
                'product_description' => $product_descriptions[$product_id] ?? ($item['itemDescription'] ?? ''),
                'uom'                 => $item['uom'] ?? null,
                'quantity'            => $item['quantity'] ?? 0,
                'service_charge'      => $item['unitPrice'] ?? 0,
                'item_discount'       => $item['itemDiscount'] ?? 0,
                'total'               => $item['total'] ?? 0,
                'updated_at'          => $modified_time
            ];

            log_message('error', 'Saving proposal item: ' . print_r($item_save_data, true));

            if (!$this->Task_model->save_proposal_item($item_save_data)) {
                return [
                    'success' => false,
                    'error'   => 'Failed to update proposal items in local CRM.'
                ];
            }
        }

        return [
            'success'      => true,
            'message'      => 'Quotation updated successfully.',
            'quote_id'     => $quote_id,
            'quote_number' => $quote_number,
            'task_id'      => $task_id
        ];
    } catch (Throwable $e) {
        log_message('error', 'update_proposal_in_zoho exception: ' . $e->getMessage());
        log_message('error', 'update_proposal_in_zoho trace: ' . $e->getTraceAsString());

        return [
            'success' => false,
            'error'   => 'Server error in update_proposal_in_zoho: ' . $e->getMessage()
        ];
    }
}