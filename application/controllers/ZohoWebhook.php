<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZohoWebhook extends CI_Controller {

    public function __construct()
    {
                parent::__construct();

                
                $this->load->model('Zoho_model');
               
    }


    public function deal_created1()
    {
        log_message('error', 'deal_created webhook HIT | deal_id: ' . $dealId);
        // 🔐 Secret check (optional but recommended)
        $secret = $this->input->get_request_header('X-ZOHO-SECRET');
        if ($secret !== 'voltronix_zoho_deal') {
            show_error('Unauthorized', 401);
        }

        // ✅ Get Deal ID from URL
        $dealId = $this->input->get('deal_id');

        if (empty($dealId)) {
            show_error('Missing deal_id', 400);
        }

        $this->load->model('Zoho_model');
        $this->load->model('Task_model');

        // Fetch full deal from Zoho
        $resp = $this->Zoho_model->get_deal_by_id($dealId);
        $data = $resp['data'][0] ?? [];

        if (!$data) {
            show_error('Deal not found in Zoho', 404);
        }

        if($data['Stage'] == "Qualification")
        {
            $data['Stage'] = 'Pending';
        }

        // Prepare DB data (your existing mapping)
        $insertData = [

            // 🔑 Core Identifiers
            'zoho_crm_id' => $data['id'],
            'deal_name'   => $data['Deal_Name'] ?? '',

            // 🔢 Deal Numbers & Dates
            'deal_number'       => $data['Deal_Number'] ?? null,
            'enq_number'        => $data['EnquiryNumber'] ?? null,
            'enq_deal_date'     => $this->formatZohoTime($data['Created_Time'] ?? null),

            'deal_number'       => $data['DealNumber'] ?? null,

            'qual_deal_number'  => $data['QualDealNumber'] ?? null,
            'qual_deal_date'    => $this->formatZohoTime($data['Qualified_Time'] ?? null),

            'site_deal_number'  => $data['SiteDealNumber'] ?? null,
            'site_deal_date'    => $this->formatZohoTime($data['Site_Deal_Date'] ?? null),

            'quote_deal_number' => $data['QuoteDealNumber'] ?? null,
            'quote_deal_date'   => $this->formatZohoTime($data['Quote_Date'] ?? null),

            'job_deal_number'   => $data['JobDealNumber'] ?? null,
            'job_deal_date'     => $this->formatZohoTime($data['Job_Date'] ?? null),

            'lost_deal_number'  => $data['LostDealNumber'] ?? null,
            'lost_deal_date'    => $this->formatZohoTime($data['Lost_Time'] ?? null),

            // 🏢 Account & Ownership
            'account_name' => $data['Account_Name']['name'] ?? null,
            'owner_id'     => $data['Owner']['id'] ?? null,
            'assigned_to'  => $data['VZ_app_user']['id'] ?? null,
            'Assign_Department' => $data['Assign_Department1'] ?? null,

            // 👤 Customer Info
            'customer_name'    => $data['Contact_Name']['name'] ?? '',
            'customer_email'   => $data['Email'] ?? '',
            'customer_contact' => $data['Phone'] ?? '',

            // 📍 Address (custom fields – adjust if names differ)
            'p_box'    => $data['PO_Box'] ?? null,
            'trn'      => $data['TRN'] ?? null,
            'street'   => $data['Street'] ?? '',
            'city'     => $data['City'] ?? '',
            'state'    => $data['State'] ?? '',
            'country'  => $data['Country'] ?? '',
            'zip_code' => $data['Zip_Code'] ?? '',
            'location' => $data['Location'] ?? '',
            'address'  => $data['Address'] ?? '',

            // 🧾 Business Fields
            'title'            => $data['Deal_Name'] ?? '',
            'device_category'  => $data['Device_Category'] ?? '',
            'complaint_info'   => $data['Description'] ?? '',
            'status'           => $data['Stage'] ?? 'Pending',
            'remark'           => $data['Description'] ?? null,

            // 📄 Quote & Project
            'quote_id'        => $data['Quote_ID'] ?? null,
            'quote_number'    => $data['Quote_No'] ?? null,
            'kind_attention'  => $data['Kind_Attention'] ?? null,
            'subject'         => $data['Subject'] ?? null,
            'project_name'    => $data['Project_Name'] ?? null,

            // 📜 Commercial
            'terms_of_payment' => $data['Terms_of_Payment'] ?? null,
            'general_exclusion'=> $data['General_Exclusion'] ?? null,
            'specification'   => $data['Specification'] ?? null,
            'brand'           => $data['Brand'] ?? null,
            'warranty'        => $data['Warranty'] ?? null,
            'delivery'        => $data['Delivery'] ?? null,

            // 📝 Notes
            'assign_notes' => $data['Assign_Notes'] ?? null,
            'notes'        => $data['Notes'] ?? null,

            // 📦 Product (ONLY if you fetch Line_Items separately)
            'product_id'          => null,
            'product_name'        => null,
            'product_description' => null,
            'uom'                 => null,
            'quantity'            => null,

            // 💰 Financials
            'valid_until'   => $data['Closing_Date'] ?? null,
            'discount'      => $data['Discount'] ?? null,
            'adjustment'    => $data['Adjustment'] ?? null,
            'service_charge'=> $data['Amount'] ?? null,

            // 🔐 System
            'user_id' => 1,
        ];


        // UPSERT (important)
        $exists = $this->Task_model->get_by_zoho_id($dealId);
        if ($exists) {
            $this->Task_model->update_by_zoho_id($dealId, $insertData);
        } else {
            $this->Task_model->create_task($insertData);
        }
        

        // ✅ Sync attachments at the same time
        $this->sync_attachments_by_deal($dealId);

        // ✅ Respond OK to Zoho
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success']));
    }

    public function deal_created()
{
    // 🔐 Secret check
    $secret = $this->input->get_request_header('X-ZOHO-SECRET');
    if ($secret !== 'voltronix_zoho_deal') {
        show_error('Unauthorized', 401);
    }

    // ✅ Get Deal ID from URL
    $dealId = $this->input->get('deal_id');
    log_message('error', 'deal_created webhook HIT | deal_id: ' . $dealId);

    if (empty($dealId)) {
        show_error('Missing deal_id', 400);
    }

    $this->load->model('Zoho_model');
    $this->load->model('Task_model');

    // Fetch full deal from Zoho
    $resp = $this->Zoho_model->get_deal_by_id($dealId);
    $data = $resp['data'][0] ?? [];

    log_message('error', 'Zoho full deal response: ' . json_encode($data));

    if (!$data) {
        show_error('Deal not found in Zoho', 404);
    }

    if (isset($data['Stage']) && $data['Stage'] == "Qualification") {
        $data['Stage'] = 'Pending';
    }

    // ✅ Base data for insert
    $insertData = [
        'zoho_crm_id'       => $data['id'] ?? null,
        'deal_name'         => $data['Deal_Name'] ?? '',
        'deal_number'       => $data['DealNumber'] ?? ($data['Deal_Number'] ?? null),
        'enq_number'        => $data['EnquiryNumber'] ?? null,
        'enq_deal_date'     => $this->formatZohoTime($data['Created_Time'] ?? null),

        'qual_deal_number'  => $data['QualDealNumber'] ?? null,
        'qual_deal_date'    => $this->formatZohoTime($data['Qualified_Time'] ?? null),

        'site_deal_number'  => $data['SiteDealNumber'] ?? null,
        'site_deal_date'    => $this->formatZohoTime($data['Site_Deal_Date'] ?? null),

        'quote_deal_number' => $data['QuoteDealNumber'] ?? null,
        'quote_deal_date'   => $this->formatZohoTime($data['Quote_Date'] ?? null),

        'job_deal_number'   => $data['JobDealNumber'] ?? null,
        'job_deal_date'     => $this->formatZohoTime($data['Job_Date'] ?? null),

        'lost_deal_number'  => $data['LostDealNumber'] ?? null,
        'lost_deal_date'    => $this->formatZohoTime($data['Lost_Time'] ?? null),

        'account_name'      => $data['Account_Name']['name'] ?? null,
        'owner_id'          => $data['Owner']['id'] ?? null,
        'assigned_to'       => $data['VZ_app_user']['id'] ?? null,
        'Assign_Department' => $data['Assign_Department1'] ?? null,

        'customer_name'     => $data['Contact_Name']['name'] ?? '',
        'customer_email'    => $data['Email'] ?? '',
        'customer_contact'  => $data['Phone'] ?? '',

        'p_box'             => $data['PO_Box'] ?? null,
        'trn'               => $data['TRN'] ?? null,
        'street'            => $data['Street'] ?? '',
        'city'              => $data['City'] ?? '',
        'state'             => $data['State'] ?? '',
        'country'           => $data['Country'] ?? '',
        'zip_code'          => $data['Zip_Code'] ?? '',
        'location'          => $data['Location'] ?? '',
        'address'           => $data['Address'] ?? '',

        'title'             => $data['Deal_Name'] ?? '',
        'device_category'   => $data['Device_Category'] ?? '',
        'complaint_info'    => $data['Description'] ?? '',
        'status'            => $data['Stage'] ?? 'Pending',
        'remark'            => $data['Description'] ?? null,

        'quote_id'          => $data['Quote_ID'] ?? null,
        'quote_number'      => $data['Quote_No'] ?? null,
        'kind_attention'    => $data['Kind_Attention'] ?? null,
        'subject'           => $data['Subject'] ?? null,
        'project_name'      => $data['Project_Name'] ?? null,

        'terms_of_payment'  => $data['Terms_of_Payment'] ?? null,
        'general_exclusion' => $data['General_Exclusion'] ?? null,
        'specification'     => $data['Specification'] ?? null,
        'brand'             => $data['Brand'] ?? null,
        'warranty'          => $data['Warranty'] ?? null,
        'delivery'          => $data['Delivery'] ?? null,

        'assign_notes'      => $data['Assign_Notes'] ?? null,
        'notes'             => $data['Notes'] ?? null,

        'product_id'          => null,
        'product_name'        => null,
        'product_description' => null,
        'uom'                 => null,
        'quantity'            => null,

        'valid_until'       => $data['Closing_Date'] ?? null,
        'discount'          => $data['Discount'] ?? null,
        'adjustment'        => $data['Adjustment'] ?? null,
        'service_charge'    => $data['Amount'] ?? null,

        'user_id'           => 1,
    ];

    $exists = $this->Task_model->get_by_zoho_id($dealId);

    if ($exists) {
        // ✅ For UPDATE: do not overwrite existing fields with null/empty
        $updateData = [];

        foreach ($insertData as $key => $value) {
            if ($value !== null && $value !== '') {
                $updateData[$key] = $value;
            }
        }

        log_message('error', 'Filtered webhook update data: ' . json_encode($updateData));

        $this->Task_model->update_by_zoho_id($dealId, $updateData);
    } else {
        // ✅ For INSERT: allow full insert
        log_message('error', 'Webhook insert data: ' . json_encode($insertData));
        $this->Task_model->create_task($insertData);
    }

    // ✅ Sync attachments
    $this->sync_attachments_by_deal($dealId);

    // ✅ Respond OK to Zoho
    $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'success']));
}


    private function formatZohoTime($time)
    {
        if (!$time) return null;
        $dt = new DateTime($time);
        $dt->setTimezone(new DateTimeZone('Asia/Dubai'));
        return $dt->format('Y-m-d H:i:s');
    }

/* New Function for Attachment Sync on 24th March */
private function sync_attachments_by_deal($dealId)
{
    log_message('error', 'sync_attachments_by_deal started for deal: ' . $dealId);

    date_default_timezone_set('Asia/Dubai');
    $currentDateTime = date('Y-m-d H:i:s');

    $this->load->model('Zoho_model');
    $this->load->model('ZohoAttachments_model');

    $token = $this->Zoho_model->get_access_token();
    if (!$token) {
        log_message('error', 'Zoho token missing while syncing attachments for deal: ' . $dealId);
        return false;
    }

    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $token,
            "Accept: application/json",
        ],
        CURLOPT_TIMEOUT => 60,
    ]);

    $body = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($http !== 200) {
        log_message('error', 'Zoho attachment list failed for deal ' . $dealId . ' | HTTP: ' . $http . ' | CURL: ' . $curlError . ' | Response: ' . $body);
        return false;
    }

    $json = json_decode($body, true);
    $rows = $json['data'] ?? [];
    log_message('error', 'attachments found: ' . count($rows));

    $baseDir = FCPATH . 'uploads/deal_attachments/';
    if (!is_dir($baseDir)) {
        if (!mkdir($baseDir, 0775, true) && !is_dir($baseDir)) {
            log_message('error', 'Failed to create directory: ' . $baseDir);
            return false;
        }
    }

    $downloaded = 0;
    $inserted   = 0;
    $updated    = 0;

    foreach ($rows as $a) {
        $attachmentId = $a['id'] ?? null;
        if (!$attachmentId) {
            continue;
        }

        $fileName = $a['File_Name'] ?? ('attachment_' . $attachmentId);
        $fileName = $this->sanitizeFileName($fileName);

        $finalName = $attachmentId . '_' . $fileName;
        $fullPath  = $baseDir . $finalName;
        $relative  = 'uploads/deal_attachments/' . $finalName;

        log_message('error', 'Processing attachment | deal: ' . $dealId . ' | attachment: ' . $attachmentId . ' | file: ' . $fileName);

        // Check existing by BOTH deal_id and attachment_id
        $existing = $this->db->get_where('job_attachments', [
            'deal_id'       => $dealId,
            'attachment_id' => $attachmentId
        ])->row_array();

        // If file already exists physically, still ensure DB row exists/updates
        if (file_exists($fullPath)) {

            $dbData = [
                'deal_id'   => $dealId,
                'attachment_id' => $attachmentId,
                'file_name' => $fileName,
                'file_path' => $relative,
                'file_size' => isset($a['Size']) ? (int)$a['Size'] : null,
            ];

            if ($existing) {
                $this->db->where('deal_id', $dealId);
                $this->db->where('attachment_id', $attachmentId);
                $this->db->update('job_attachments', $dbData);

                log_message('error', 'Attachment DB updated (existing physical file): ' . $attachmentId . ' | DB Error: ' . json_encode($this->db->error()));
                $updated++;
            } else {
                $dbData['file_type']  = null;
                $dbData['created_at'] = $currentDateTime;

                $this->db->insert('job_attachments', $dbData);

                log_message('error', 'Attachment DB inserted (existing physical file): ' . $attachmentId . ' | DB Error: ' . json_encode($this->db->error()));
                $inserted++;
            }

            continue;
        }

        // Download from Zoho
        $dl = $this->Zoho_model->download_deal_attachment($dealId, $attachmentId);

        if (!$dl['ok'] || empty($dl['bytes'])) {
            log_message('error', 'Attachment download failed for deal ' . $dealId . ' | attachment: ' . $attachmentId);
            continue;
        }

        // Save file
        $saved = file_put_contents($fullPath, $dl['bytes']);
        if ($saved === false) {
            log_message('error', 'File save failed: ' . $fullPath);
            continue;
        }

        $downloaded++;

        $size = @filesize($fullPath) ?: (isset($a['Size']) ? (int)$a['Size'] : null);

        $mime = $dl['headers']['content-type'] ?? null;
        if ($mime) {
            $mime = explode(';', $mime)[0];
        }

        $dbData = [
            'deal_id'       => $dealId,
            'attachment_id' => $attachmentId,
            'file_name'     => $fileName,
            'file_path'     => $relative,
            'file_size'     => $size,
            'file_type'     => $mime,
        ];

        if ($existing) {
            $this->db->where('deal_id', $dealId);
            $this->db->where('attachment_id', $attachmentId);
            $this->db->update('job_attachments', $dbData);

            log_message('error', 'Attachment DB updated: ' . $attachmentId . ' | DB Error: ' . json_encode($this->db->error()));
            $updated++;
        } else {
            $dbData['created_at'] = $currentDateTime;

            $this->db->insert('job_attachments', $dbData);

            log_message('error', 'Attachment DB inserted: ' . $attachmentId . ' | DB Error: ' . json_encode($this->db->error()));
            $inserted++;
        }
    }

    log_message('error', 'Attachment sync finished for deal: ' . $dealId . ' | found: ' . count($rows) . ' | downloaded: ' . $downloaded . ' | inserted: ' . $inserted . ' | updated: ' . $updated);

    return true;
}

/** New Code Again on 16th March **/
public function deal_updated()
    {
        // Optional security using query key
       /* $key = $this->input->get('key');
        if ($key && $key !== 'voltronix_zoho_deal') {
            show_error('Unauthorized', 401);
        }*/

        $secret = $this->input->get_request_header('X-ZOHO-SECRET');
    if ($secret !== 'voltronix_zoho_deal') {
        show_error('Unauthorized', 401);
    }

        // 1) Try GET
        $dealId = $this->input->get('deal_id');

        // 2) Try POST form-data
        if (!$dealId) {
            $dealId = $this->input->post('deal_id');
        }

        // 3) Try raw JSON body: { "id": "..." }
        if (!$dealId) {
            $payload = json_decode(file_get_contents('php://input'), true);
            $dealId  = $payload['id'] ?? null;
        }

        if (!$dealId) {
            show_error('Missing deal_id', 400);
        }

        $this->sync_attachments_by_deal($dealId);

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'deal_id' => $dealId
            ]));
    }


/*******Samia Testing New ********/

public function debug_insert_attachments()
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    echo "<h3>Step 1: Controller hit ✅</h3>";

    $dealId = $this->input->get('deal_id');
    echo "<b>deal_id:</b> " . htmlspecialchars((string)$dealId) . "<br>";
    if (!$dealId) { echo "<b style='color:red'>Missing deal_id</b>"; exit; }

    $this->load->model('Zoho_model');
    $this->load->model('ZohoAttachments_model');

    echo "<h3>Step 2: Get token ✅</h3>";
    $token = $this->Zoho_model->get_access_token();
    echo "<b>Token length:</b> " . strlen((string)$token) . "<br>";
    if (!$token) { echo "<b style='color:red'>Token missing</b>"; exit; }

    echo "<h3>Step 3: Call Zoho attachments ✅</h3>";
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $token,
            "Accept: application/json",
        ],
        CURLOPT_TIMEOUT => 60,
    ]);
    $body = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    echo "<b>HTTP:</b> " . (int)$http . "<br>";
    echo "<b>CURL err:</b> " . htmlspecialchars((string)$err) . "<br>";
    if ($http !== 200) { echo "<pre>" . htmlspecialchars($body) . "</pre>"; exit; }

    $json = json_decode($body, true);
    $rows = $json['data'] ?? [];
    echo "<b>Total attachments found:</b> " . count($rows) . "<br>";

    if (empty($rows)) {
        echo "<b>No attachments found.</b>";
        exit;
    }

    echo "<h3>Step 4: DB insert loop ✅</h3>";

    $inserted = 0;
    $skipped  = 0;

    foreach ($rows as $a) {
        $attachmentId = $a['id'] ?? '';
        $fileName     = $a['File_Name'] ?? '';
        $fileSize     = isset($a['Size']) ? (int)$a['Size'] : null;
        $fileType     = $a['$type'] ?? null; // Zoho returns $type = Attachment (not MIME)

        echo "<hr>";
        echo "<b>Attachment ID:</b> " . htmlspecialchars($attachmentId) . "<br>";
        echo "<b>File:</b> " . htmlspecialchars($fileName) . "<br>";
        echo "<b>Size:</b> " . htmlspecialchars((string)$fileSize) . "<br>";

        // skip if exists
        $existing = $this->db->get_where('job_attachments', ['attachment_id' => $attachmentId])->row_array();
        if ($existing) {
            echo "<span style='color:orange'><b>SKIP:</b> already exists in DB (id {$existing['id']})</span><br>";
            $skipped++;
            continue;
        }

        $data = [
            'deal_id'       => $dealId,
            'attachment_id' => $attachmentId,
            'file_name'     => $fileName ?: ('attachment_' . $attachmentId),
            /*'file_path'     => '',      // keep empty for now*/
            'file_path' => 'uploads/deal_attachments/'.$fileName,
            'file_size'     => $fileSize,
            'file_type'     => null,    // MIME not provided in list API
        ];

        $ok = $this->db->insert('job_attachments', $data);

        echo "<b>Insert result:</b> " . ($ok ? '✅ OK' : '❌ FAIL') . "<br>";

        if (!$ok) {
            echo "<b style='color:red'>DB ERROR:</b><br>";
            echo "<pre>";
            print_r($this->db->error());
            echo "</pre>";

            echo "<b>Last Query:</b><br>";
            echo "<pre>" . htmlspecialchars($this->db->last_query()) . "</pre>";
            exit;
        }

        echo "<b>Inserted ID:</b> " . (int)$this->db->insert_id() . "<br>";
        $inserted++;
    }

    echo "<h3>DONE ✅</h3>";
    echo "<b>Inserted:</b> $inserted<br>";
    echo "<b>Skipped:</b> $skipped<br>";
    exit;
}


/******* Manual Function Trigger Download Attachment New Code *******/

public function sync_attachments_and_download()
{
    $dealId = $this->input->get('deal_id');
    if (!$dealId) {
        show_error('Missing deal_id', 400);
    }

    $this->load->model('Zoho_model');
    $this->load->model('ZohoAttachments_model');

    $token = $this->Zoho_model->get_access_token();
    if (!$token) {
        log_message('error', 'Zoho token missing');
        return;
    }

    // Fetch attachment list
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $token,
            "Accept: application/json",
        ],
        CURLOPT_TIMEOUT => 60,
    ]);

    $body = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http !== 200) {
        log_message('error', 'Zoho attachment list failed: ' . $body);
        return;
    }

    $json = json_decode($body, true);
    $rows = $json['data'] ?? [];

    // Ensure folder exists
    $baseDir = FCPATH . 'uploads/deal_attachments/';
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0775, true);
    }

    foreach ($rows as $a) {

        $attachmentId = $a['id'] ?? null;
        if (!$attachmentId) continue;

        $fileName = $a['File_Name'] ?? ('attachment_' . $attachmentId);
        $fileName = $this->sanitizeFileName($fileName);

        $finalName = $attachmentId . '_' . $fileName;

        $fullPath = $baseDir . $finalName;
        $relative = 'uploads/deal_attachments/' . $finalName;

        // Check DB
        $existing = $this->db->get_where('job_attachments', [
            'attachment_id' => $attachmentId
        ])->row_array();

        // If file already exists
        if (file_exists($fullPath)) {

            if (!$existing) {
                $this->db->insert('job_attachments', [
                    'deal_id'       => $dealId,
                    'attachment_id' => $attachmentId,
                    'file_name'     => $fileName,
                    'file_path'     => $relative,
                    'file_size'     => isset($a['Size']) ? (int)$a['Size'] : null,
                    'file_type'     => null,
                ]);
            }

            continue;
        }

        // Download from Zoho
    /*    $dl = $this->Zoho_model->download_deal_attachment($dealId, $attachmentId); */

        $dl = $this->Zoho_model->download_deal_attachment($dealId, $attachmentId, $token);

        if (!$dl['ok'] || empty($dl['bytes'])) {
            log_message('error', 'Attachment download failed: ' . $attachmentId);
            continue;
        }

        // Save file
        $saved = file_put_contents($fullPath, $dl['bytes']);
        if ($saved === false) {
            log_message('error', 'File save failed: ' . $fullPath);
            continue;
        }

        $size = @filesize($fullPath) ?: (isset($a['Size']) ? (int)$a['Size'] : null);

        $mime = $dl['headers']['content-type'] ?? null;
        if ($mime) {
            $mime = explode(';', $mime)[0];
        }

        if ($existing) {

            $this->db->where('attachment_id', $attachmentId)->update('job_attachments', [
                'deal_id'   => $dealId,
                'file_name' => $fileName,
                'file_path' => $relative,
                'file_size' => $size,
                'file_type' => $mime,
            ]);

        } else {

            $this->db->insert('job_attachments', [
                'deal_id'       => $dealId,
                'attachment_id' => $attachmentId,
                'file_name'     => $fileName,
                'file_path'     => $relative,
                'file_size'     => $size,
                'file_type'     => $mime,
            ]);

        }
    }

    $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'success']));
}

private function sanitizeFileName($name)
{
    $name = trim($name);
    $name = str_replace(['../', '..\\', '/', '\\'], '-', $name);
    $name = preg_replace('/[^A-Za-z0-9\-\_\.\s]/', '', $name);
    $name = preg_replace('/\s+/', '_', $name);
    return $name ?: ('file_' . time());
}

/**** Testing End ****/

    public function delete()
    {

        $this->load->model('Task_model');

        // Delete task by Zoho CRM ID
        $dealId = $this->input->get('deal_id');
        $deleted = $this->Task_model->delete_task_by_zoho_crm_id($dealId);

        if ($deleted) {
            log_message('error', 'deal_deleted: Deal deleted successfully | deal_id: ' . $dealId);

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Deal deleted successfully',
                    'deal_id' => $dealId
                ]));
        } else {
            log_message('error', 'deal_deleted: Failed to delete deal or deal not found | deal_id: ' . $dealId);

            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Failed to delete deal or deal not found',
                    'deal_id' => $dealId
                ]));
        }
    }

    public function getZohoDealFields()
{
    $this->load->model('Zoho_model');
    $accessToken = $this->Zoho_model->get_access_token(); // your existing function

    $url = "https://www.zohoapis.com/crm/v2/settings/fields?module=Deals";

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken $accessToken",
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'Zoho Fields Error: ' . curl_error($ch));
    }

    curl_close($ch);

    $result = json_decode($response, true);

    // Debug
    echo "<pre>";
    print_r($result);
    exit;
}

 public function getZohoProductsFields()
{
    $this->load->model('Zoho_model');

    $accessToken = $this->Zoho_model->get_access_token();

   // $url = "https://www.zohoapis.com/crm/v2/settings/fields?module=Products";
    $url = "https://www.zohoapis.com/crm/v2.1/Products";

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $accessToken,
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo curl_error($ch);
        exit;
    }

    curl_close($ch);

    echo "<pre>";
    echo "HTTP Code: " . $httpCode . "\n\n";
    print_r(json_decode($response, true));
    exit;
}

public function check_zoho_deal_fields($dealId = null)
{
    if (empty($dealId)) {
        echo "<pre>Deal ID is required.</pre>";
        return;
    }

    $this->load->model('Zoho_model');

    // Get access token from your existing token method
    $accessToken = $this->Zoho_model->get_access_token(); // use your existing function name

    if (empty($accessToken)) {
        echo "<pre>Access token not found.</pre>";
        return;
    }

    $url = "https://www.zohoapis.com/crm/v2/Deals/" . $dealId;

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $accessToken,
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo "<pre>Curl Error: " . curl_error($ch) . "</pre>";
        curl_close($ch);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    echo "<pre>";
    echo "HTTP CODE: " . $httpCode . "\n\n";

    if (!isset($result['data'][0])) {
        echo "Invalid response:\n";
        print_r($result);
        exit;
    }

    $deal = $result['data'][0];

    echo "=========== FULL DEAL DATA ===========\n";
    print_r($deal);

    echo "\n=========== FIELD NAMES ONLY ===========\n";
    foreach ($deal as $key => $value) {
        echo $key . "\n";
    }
 
    echo "\n=========== IMPORTANT DATE FIELDS CHECK ===========\n";
    echo "Site_Deal_Date: " . (!empty($deal['Site_Deal_Date']) ? $deal['Site_Deal_Date'] : 'NOT FOUND OR EMPTY') . "\n";
    echo "Quote_Date: " . (!empty($deal['Quote_Date']) ? $deal['Quote_Date'] : 'NOT FOUND OR EMPTY') . "\n";
    echo "Job_Date: " . (!empty($deal['Job_Date']) ? $deal['Job_Date'] : 'NOT FOUND OR EMPTY') . "\n";

    exit;
}

public function vx_app_user_updated()
{
    $secret = $this->input->get_request_header('X-ZOHO-SECRET');
    if ($secret !== 'voltronix_zoho_user') {
        show_error('Unauthorized', 401);
        return;
    }

    $json_input = file_get_contents('php://input');
    $data = json_decode($json_input, true);

    if (empty($data)) {
        show_error('Invalid JSON body', 400);
        return;
    }

    $userId = trim($data['user_id'] ?? '');
    if ($userId === '') {
        show_error('Missing user_id', 400);
        return;
    }

    $this->load->model('Admin');

    $user_data = array(
        'username'     => $data['username'] ?? null,
        'email'        => $data['email'] ?? null,
        'user_id'      => $userId,
        'status'       => $data['status'] ?? null,
        'department'   => $data['department'] ?? null,
        'quote_access' => $data['quote_access'] ?? null,
        'role'         => $data['role'] ?? null,
        'company'      => $data['company'] ?? null,
        'sale_name'    => $data['sale_name'] ?? null,
    );

    if (isset($data['password']) && trim($data['password']) !== '') {
        $user_data['password'] = password_hash(trim($data['password']), PASSWORD_BCRYPT);
    }

    $existing_user = $this->Admin->get_user_by_user_id($userId);

    if ($existing_user) {
        $this->Admin->update_user($existing_user['id'], $user_data);

        echo json_encode(array(
            'status'  => 'success',
            'message' => 'User updated successfully'
        ));
    } else {
        $this->Admin->create_user($user_data);

        echo json_encode(array(
            'status'  => 'success',
            'message' => 'User created successfully'
        ));
    }
}

public function sync_all_deals()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        // Security key for cron/manual run
        $key = $this->input->get('key');
        if ($key !== 'voltronix_cron_123') {
            show_error('Unauthorized', 401);
            return;
        }

        $page    = 1;
        $perPage = 200;

        $totalChecked = 0;
        $totalUpdated = 0;
        $totalFailed  = 0;
        $moreRecords  = true;

        log_message('error', '===== FULL DEAL FIELD SYNC STARTED =====');

        while ($moreRecords) {
            $resp  = $this->Zoho_model->get_deals_page($page, $perPage);
            $deals = $resp['data'] ?? [];

            $moreRecords = $resp['info']['more_records'] ?? false;

            log_message('error', 'SYNC PAGE: ' . $page . ' | DEALS: ' . count($deals));

            if (empty($deals)) {
                break;
            }

            foreach ($deals as $deal) {
                $dealId = $deal['id'] ?? '';

                if (empty($dealId)) {
                    $totalFailed++;
                    log_message('error', 'Skipped one deal because id is missing on page ' . $page);
                    continue;
                }

                $totalChecked++;

                // Get full deal details from Zoho
                $fullResp = $this->Zoho_model->get_deal_by_id($dealId);
                $data     = $fullResp['data'][0] ?? [];

                if (empty($data)) {
                    $totalFailed++;
                    log_message('error', 'No full deal data found for Zoho ID: ' . $dealId);
                    continue;
                }

                // Update only these fields
                $updateData = [
                    'site_deal_number'  => $data['SiteDealNumber'] ?? null,
                    'site_deal_date'    => !empty($data['Site_Deal_Date']) ? $this->formatZohoTime($data['Site_Deal_Date']) : null,

                    'quote_deal_number' => $data['QuoteDealNumber'] ?? null,
                    'quote_deal_date'   => !empty($data['Quote_Deal_Date']) ? $this->formatZohoTime($data['Quote_Deal_Date']) : null,

                    'job_deal_number'   => $data['JobDealNumber'] ?? null,
                    'job_deal_date'     => !empty($data['Job_Deal_Date']) ? $this->formatZohoTime($data['Job_Deal_Date']) : null,

                    'lost_deal_number'  => $data['LostDealNumber'] ?? null
                ];

                // Remove null values only
                $cleanData = [];
                foreach ($updateData as $field => $value) {
                    if ($value !== null) {
                        $cleanData[$field] = $value;
                    }
                }

                // Prevent empty update crash
                if (empty($cleanData)) {
                    log_message('error', 'No fields available to update for Zoho ID: ' . $dealId);
                    continue;
                }

                // Update local record only if this Zoho deal exists in tasks table
                $existing = $this->db
                    ->select('id')
                    ->from('tasks')
                    ->where('zoho_crm_id', $dealId)
                    ->get()
                    ->row_array();

                if (!$existing) {
                    log_message('error', 'No local task found for Zoho ID: ' . $dealId);
                    continue;
                }

                $this->db->where('zoho_crm_id', $dealId);
                $updated = $this->db->update('tasks', $cleanData);

                if ($updated) {
                    $totalUpdated++;
                    log_message('error', 'Updated task for Zoho ID: ' . $dealId . ' | Data: ' . json_encode($cleanData));
                } else {
                    $totalFailed++;
                    log_message('error', 'DB update failed for Zoho ID: ' . $dealId . ' | Error: ' . json_encode($this->db->error()));
                }
            }

            $page++;
        }

        log_message('error', '===== FULL DEAL FIELD SYNC COMPLETED ===== Checked: ' . $totalChecked . ' | Updated: ' . $totalUpdated . ' | Failed: ' . $totalFailed);

        echo json_encode([
            'success' => true,
            'message' => 'All deals sync completed',
            'checked' => $totalChecked,
            'updated' => $totalUpdated,
            'failed'  => $totalFailed
        ]);
    }


public function sync_all_missing_deals_crm()
{
    $secret = $this->input->get_request_header('X-ZOHO-SECRET');

    if (empty($secret)) {
        $secret = $this->input->get('secret');
    }

    if ($secret !== 'voltronix_zoho_deal') {
        show_error('Unauthorized', 401);
    }

    set_time_limit(0);
    date_default_timezone_set('Asia/Dubai');

    $this->load->model('Zoho_model');
    $this->load->model('Task_model');

    $access_token = $this->Zoho_model->get_access_token();

    if (!$access_token) {
        show_error('Zoho access token not found', 500);
    }

    $page       = 1;
    $per_page   = 200;
    $inserted   = 0;
    $skipped    = 0;
    $failed     = 0;

    do {
        $url = "https://www.zohoapis.com/crm/v2/Deals?page={$page}&per_page={$per_page}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Zoho-oauthtoken {$access_token}",
                "Content-Type: application/json"
            ],
            CURLOPT_TIMEOUT        => 90
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            show_error('Curl Error: ' . $curlErr, 500);
        }

        $result = json_decode($response, true);

        if ($httpCode < 200 || $httpCode >= 300) {
            show_error('Zoho API Error: ' . $response, 500);
        }

        if (!empty($result['data'])) {
            foreach ($result['data'] as $data) {

                $dealId = $data['id'] ?? null;

                if (!$dealId) {
                    $failed++;
                    continue;
                }

                $exists = $this->Task_model->get_by_zoho_id($dealId);

                if ($exists) {
                    $skipped++;
                    continue;
                }

                if (isset($data['Stage']) && $data['Stage'] == "Qualification") {
                    $data['Stage'] = 'Pending';
                }

                $insertData = [
                    'zoho_crm_id'       => $data['id'] ?? null,
                    'deal_name'         => $data['Deal_Name'] ?? '',
                    'deal_number'       => $data['DealNumber'] ?? ($data['Deal_Number'] ?? null),
                    'enq_number'        => $data['EnquiryNumber'] ?? null,
                    'enq_deal_date'     => $this->formatZohoTime($data['Created_Time'] ?? null),

                    'qual_deal_number'  => $data['QualDealNumber'] ?? null,
                    'qual_deal_date'    => $this->formatZohoTime($data['Qualified_Time'] ?? null),

                    'site_deal_number'  => $data['SiteDealNumber'] ?? null,
                    'site_deal_date'    => $this->formatZohoTime($data['Site_Deal_Date'] ?? null),

                    'quote_deal_number' => $data['QuoteDealNumber'] ?? null,
                    'quote_deal_date'   => $this->formatZohoTime($data['Quote_Date'] ?? null),

                    'job_deal_number'   => $data['JobDealNumber'] ?? null,
                    'job_deal_date'     => $this->formatZohoTime($data['Job_Date'] ?? null),

                    'lost_deal_number'  => $data['LostDealNumber'] ?? null,
                    'lost_deal_date'    => $this->formatZohoTime($data['Lost_Time'] ?? null),

                    'account_name'      => $data['Account_Name']['name'] ?? null,
                    'owner_id'          => $data['Owner']['id'] ?? null,
                    'assigned_to'       => $data['VZ_app_user']['id'] ?? null,
                    'Assign_Department' => $data['Assign_Department1'] ?? null,

                    'customer_name'     => $data['Contact_Name']['name'] ?? '',
                    'customer_email'    => $data['Email'] ?? '',
                    'customer_contact'  => $data['Phone'] ?? '',

                    'p_box'             => $data['PO_Box'] ?? null,
                    'trn'               => $data['TRN'] ?? null,
                    'street'            => $data['Street'] ?? '',
                    'city'              => $data['City'] ?? '',
                    'state'             => $data['State'] ?? '',
                    'country'           => $data['Country'] ?? '',
                    'zip_code'          => $data['Zip_Code'] ?? '',
                    'location'          => $data['Location'] ?? '',
                    'address'           => $data['Address'] ?? '',

                    'title'             => $data['Deal_Name'] ?? '',
                    'device_category'   => $data['Device_Category'] ?? '',
                    'complaint_info'    => $data['Description'] ?? '',
                    'status'            => $data['Stage'] ?? 'Pending',
                    'remark'            => $data['Description'] ?? null,

                    'quote_id'          => $data['Quote_ID'] ?? null,
                    'quote_number'      => $data['Quote_No'] ?? null,
                    'kind_attention'    => $data['Kind_Attention'] ?? null,
                    'subject'           => $data['Subject'] ?? null,
                    'project_name'      => $data['Project_Name'] ?? null,

                    'terms_of_payment'  => $data['Terms_of_Payment'] ?? null,
                    'general_exclusion' => $data['General_Exclusion'] ?? null,
                    'specification'     => $data['Specification'] ?? null,
                    'brand'             => $data['Brand'] ?? null,
                    'warranty'          => $data['Warranty'] ?? null,
                    'delivery'          => $data['Delivery'] ?? null,

                    'assign_notes'      => $data['Assign_Notes'] ?? null,
                    'notes'             => $data['Notes'] ?? null,

                    'valid_until'       => $data['Closing_Date'] ?? null,
                    'discount'          => $data['Discount'] ?? null,
                    'adjustment'        => $data['Adjustment'] ?? null,
                    'service_charge'    => $data['Amount'] ?? null,

                    'user_id'           => 1,
                ];

                $this->Task_model->create_task($insertData);
                $inserted++;

                // Optional, but can make sync slow
                // $this->sync_attachments_by_deal($dealId);
            }
        }

        $more_records = $result['info']['more_records'] ?? false;
        $page++;

    } while ($more_records);

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'   => 'success',
            'message'  => 'Missing Zoho deals synced successfully',
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'failed'   => $failed
        ]));
}

/************* Testing Zoho Items Products Sync on 18th June *************/

public function sync_all_zoho_products1()
{
    $secret = $this->input->get('secret');

    if ($secret !== 'voltronix_zoho_product') {
        show_error('Unauthorized', 401);
    }

    set_time_limit(0);
    date_default_timezone_set('Asia/Dubai');

    $this->load->model('Zoho_model');

    $access_token = $this->Zoho_model->get_access_token();

    if (!$access_token) {
        show_error('Zoho access token not found', 500);
    }

    $page     = 1;
    $per_page = 200;

    $inserted = 0;
    $updated  = 0;
    $failed   = 0;

    do {
        $url = "https://www.zohoapis.com/crm/v2/Products?page={$page}&per_page={$per_page}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Zoho-oauthtoken {$access_token}",
                "Content-Type: application/json"
            ],
            CURLOPT_TIMEOUT        => 90
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            show_error('Curl Error: ' . $curlErr, 500);
        }

        $result = json_decode($response, true);

        if ($httpCode < 200 || $httpCode >= 300) {
            show_error('Zoho API Error: ' . $response, 500);
        }

        if (!empty($result['data'])) {
            foreach ($result['data'] as $product) {

                $zohoProductId = $product['id'] ?? null;

                if (!$zohoProductId) {
                    $failed++;
                    continue;
                }

                $insertData = [
                    'zoho_product_id'      => $zohoProductId,
                    'product_name'         => $product['Product_Name'] ?? null,
                    'product_code'         => $product['Product_Code'] ?? null,
                    'product_category'     => $product['Product_Category'] ?? null,
                    'unit_price'           => $product['Unit_Price'] ?? null,
                    'description'          => $product['Description'] ?? null,
                    'manufacturer'         => $product['Manufacturer'] ?? null,
                    'vendor_name'          => $product['Vendor_Name']['name'] ?? null,
                    'vendor_id'            => $product['Vendor_Name']['id'] ?? null,
                    'qty_in_stock'         => $product['Qty_in_Stock'] ?? null,
                    'reorder_level'        => $product['Reorder_Level'] ?? null,
                    'usage_unit'           => $product['Usage_Unit'] ?? null,
                    'quantity_ordered'     => $product['Qty_Ordered'] ?? null,
                    'quantity_in_demand'   => $product['Qty_in_Demand'] ?? null,
                    'taxable'              => !empty($product['Taxable']) ? 1 : 0,
                    'created_time'         => $this->formatZohoTime($product['Created_Time'] ?? null),
                    'modified_time'        => $this->formatZohoTime($product['Modified_Time'] ?? null),
                    'owner_id'             => $product['Owner']['id'] ?? null,
                    'owner_name'           => $product['Owner']['name'] ?? null,
                    'raw_data'             => json_encode($product),
                ];

                $exists = $this->db
                    ->where('zoho_product_id', $zohoProductId)
                    ->get('zoho_products')
                    ->row_array();

                if ($exists) {
                    $this->db
                        ->where('zoho_product_id', $zohoProductId)
                        ->update('zoho_products', $insertData);

                    $updated++;
                } else {
                    $this->db->insert('zoho_products', $insertData);
                    $inserted++;
                }
            }
        }

        $more_records = $result['info']['more_records'] ?? false;
        $page++;

    } while ($more_records);

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'   => 'success',
            'message'  => 'Zoho products synced successfully',
            'inserted' => $inserted,
            'updated'  => $updated,
            'failed'   => $failed
        ]));
}

public function sync_all_zoho_products()
{
    $secret = $this->input->get('secret');

    if ($secret !== 'voltronix_zoho_deal') {
        show_error('Unauthorized', 401);
    }

    set_time_limit(0);

    $this->load->model('Zoho_model');

    $accessToken = $this->Zoho_model->get_access_token();

    $page = 1;
    $perPage = 200;

    $inserted = 0;
    $updated = 0;

    do {

        $url = "https://www.zohoapis.com/crm/v2/Products?page={$page}&per_page={$perPage}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Zoho-oauthtoken {$accessToken}",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!empty($result['data'])) {

            foreach ($result['data'] as $product) {

                $data = [
                    'zoho_product_id' => $product['id'] ?? null,
                    'product_name'    => $product['Product_Name'] ?? null,
                    'description'     => $product['Description'] ?? null,
                ];

                $exists = $this->db
                    ->where('zoho_product_id', $data['zoho_product_id'])
                    ->get('zoho_products')
                    ->row();

                if ($exists) {
                    $this->db
                        ->where('zoho_product_id', $data['zoho_product_id'])
                        ->update('zoho_products', $data);

                    $updated++;
                } else {
                    $this->db->insert('zoho_products', $data);
                    $inserted++;
                }
            }
        }

        $moreRecords = $result['info']['more_records'] ?? false;
        $page++;

    } while ($moreRecords);

    echo json_encode([
        'status'   => 'success',
        'inserted' => $inserted,
        'updated'  => $updated
    ]);
}


}
