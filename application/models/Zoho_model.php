<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zoho_model extends CI_Model {

    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $api_base;

    public function __construct() {
        parent::__construct();
        $this->load->config('zoho');

        $this->client_id     = $this->config->item('zoho_client_id');
        $this->client_secret = $this->config->item('zoho_client_secret');
        $this->redirect_uri  = $this->config->item('zoho_redirect_uri');
        $this->api_base      = rtrim($this->config->item('zoho_api_base'), '/') . '/';

        $this->load->database();
    }

    /* =====================================================
     * ACCESS TOKEN
     * ===================================================== */

    public function get_access_token1() {
        $token = $this->db->get('zoho_tokens')->row_array();

        if (!$token) {
            log_message('error', 'Zoho tokens missing');
            return null;
        }

        if (!$this->check_token_valid($token['access_token'])) {
            return $this->refresh_access_token($token['refresh_token']);
        }

        return $token['access_token'];
    }

    private function check_token_valid($access_token) {
        $ch = curl_init($this->api_base . 'org');
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ["Authorization: Zoho-oauthtoken $access_token"],
            CURLOPT_RETURNTRANSFER => true
        ]);
        curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($status === 200);
    }

    private function refresh_access_token1($refresh_token) {
        $ch = curl_init('https://accounts.zoho.com/oauth/v2/token');

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'refresh_token' => $refresh_token,
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type'    => 'refresh_token'
            ]),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (!empty($data['access_token'])) {
            $this->db->update('zoho_tokens', [
                'access_token' => $data['access_token']
            ], ['id' => 1]);

            return $data['access_token'];
        }

        log_message('error', 'Zoho token refresh failed: ' . $response);
        return null;
    }

    public function get_access_token() {
    $token = $this->db->get('zoho_tokens')->row_array();

    if (!$token) {
        log_message('error', 'Zoho tokens missing');
        return null;
    }

    if (!empty($token['expires_at']) && time() < strtotime($token['expires_at'])) {
        return $token['access_token'];
    }

    return $this->refresh_access_token($token['refresh_token']);
}

private function refresh_access_token($refresh_token) {
    $ch = curl_init('https://accounts.zoho.com/oauth/v2/token');

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'refresh_token' => $refresh_token,
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type'    => 'refresh_token'
        ]),
        CURLOPT_RETURNTRANSFER => true
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'Zoho cURL error during token refresh: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (!empty($data['access_token'])) {
        $expires_at = date('Y-m-d H:i:s', time() + 3500);

        $this->db->where('id', 1);
        $this->db->update('zoho_tokens', [
            'access_token' => $data['access_token'],
            'expires_at'   => $expires_at
        ]);

        return $data['access_token'];
    }

    log_message('error', 'Zoho token refresh failed: ' . $response);
    return null;
}

    /* =====================================================
     * CORE REQUEST
     * ===================================================== */

    public function send_request($url, $headers, $payload = null, $method = 'GET') {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_CUSTOMREQUEST  => $method
        ]);

        if ($payload !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $response = curl_exec($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        log_message('error', 'ZOHO URL: ' . $url);
        log_message('error', 'ZOHO METHOD: ' . $method);
        log_message('error', 'ZOHO PAYLOAD: ' . $payload);
        log_message('error', 'ZOHO RESPONSE: ' . $response);
        log_message('error', 'ZOHO STATUS: ' . $status);

        curl_close($ch);

        return [
            'status_code' => $status,
            'response'    => json_decode($response, true),
            'raw'         => $response
        ];
    }

    /* =====================================================
     * LEADS
     * ===================================================== */

    public function create_lead(array $leadData)
    {
        $access = $this->get_access_token();

        // 🔒 FORCE OWNER (MANDATORY)
        if (empty($leadData['Owner'])) {
            $leadData['Owner'] = [
                'id' => '5653678000000401001'
            ];
        }

        return $this->send_request(
            $this->api_base . 'Leads',
            [
                // ✅ CONSISTENT AUTH
                "Authorization: Zoho-oauthtoken {$access}",
                "Content-Type: application/json"
            ],
            json_encode([
                'data' => [$leadData]
            ]),
            'POST'
        );
    }


    public function convert_lead_to_deal($leadId, array $dealData)
    {
        if (empty($leadId)) {
            return ['status_code' => 0, 'response' => 'Missing Lead ID'];
        }

        $access = $this->get_access_token();

        // ✅ ALWAYS HAVE ACCOUNT
        $accountId = $this->get_or_create_account([
            'company_name' => $dealData['Deal_Name'] ?? 'Default Account'
        ]);

        if (!$accountId) {
            return ['status_code' => 0, 'response' => 'Account creation failed'];
        }

        $payload = [
            'data' => [[
                'overwrite' => true,
                'Deals' => [
                    'Deal_Name'     => $dealData['Deal_Name'],
                    'Stage'         => $dealData['Stage'] ?? 'Qualification',
                    'Pipeline'      => $dealData['Pipeline'] ?? 'Standard (Standard)',
                    'Probability'   => $dealData['Probability'] ?? 10,
                    'Closing_Date'  => $dealData['Closing_Date'] ?? date('Y-m-d', strtotime('+30 days')),
                    'VZ_App_Status' => $dealData['VZ_App_Status'] ?? 'Pending',

                    // 🔴 MANDATORY FIELD (SAFE DEFAULT)
                    'Assign_Department1' => $dealData['Assign_Department1'],
                //    'Assign_Department1' => $dealData['Assign_Department1'] ?? 'VOLTRONIX CONTRACTING LLC', (Samia made this comment)

                    // 🔑 ACCOUNT LINK (REQUIRED)
                    'Account_Name' => [
                        'id' => $accountId
                    ]
                ]
            ]]
        ];

        $resp = $this->send_request(
            $this->api_base . "Leads/{$leadId}/actions/convert",
            [
                // ✅ MUST MATCH WORKING CRM
                "Authorization: Bearer {$access}",
                "Content-Type: application/json"
            ],
            json_encode($payload),
            'POST'
        );

        /* =====================================================
        * 🔁 HANDLE DUPLICATE CONTACT (CRITICAL)
        * ===================================================== */
        if (
            ($resp['status_code'] ?? 0) === 202 &&
            isset($resp['response']['data'][0]['code']) &&
            $resp['response']['data'][0]['code'] === 'DUPLICATE_DATA' &&
            $resp['response']['data'][0]['details']['module'] === 'Contacts'
        ) {
            $contactId = $resp['response']['data'][0]['details']['id'];

            return $this->create_deal_for_existing_contact($contactId, $dealData);
        }

        return $resp;
    }

    public function create_deal_for_existing_contact($contactId, array $dealData)
    {
        $access = $this->get_access_token();

        $payload = [
            'data' => [[
                'Deal_Name' => $dealData['Deal_Name'],
                'Stage'     => $dealData['Stage'] ?? 'Qualification',
                'Pipeline'  => $dealData['Pipeline'] ?? 'Standard (Standard)',
                'Probability' => $dealData['Probability'] ?? 10,
                'Closing_Date' => $dealData['Closing_Date'] ?? date('Y-m-d'),
                'VZ_App_Status' => $dealData['VZ_App_Status'] ?? 'Pending',
                'Assign_Department1' => $dealData['Assign_Department1'],

                // 🔗 EXISTING CONTACT
                'Contact_Name' => [
                    'id' => $contactId
                ],

                // 🔗 ACCOUNT IS STILL REQUIRED
                'Account_Name' => [
                    'id' => $this->get_or_create_account([
                        'company_name' => $dealData['Deal_Name']
                    ])
                ]
            ]]
        ];

        return $this->send_request(
            $this->api_base . 'Deals',
            [
                "Authorization: Bearer {$access}",
                "Content-Type: application/json"
            ],
            json_encode($payload),
            'POST'
        );
    }


    /* =====================================================
     * DEALS
     * ===================================================== */

    public function get_deal($dealId) {
        $access = $this->get_access_token();

        return $this->send_request(
            $this->api_base . "Deals/{$dealId}",
            ["Authorization: Zoho-oauthtoken {$access}"],
            null,
            'GET'
        );
    }

    public function update_vz_app_status1($dealId, $newStatus, $service_charge) {
        $access = $this->get_access_token();

        return $this->send_request(
            $this->api_base . "Deals/{$dealId}",
            [
                "Authorization: Zoho-oauthtoken {$access}",
                "Content-Type: application/json"
            ],
            json_encode([
                'data' => [[
                    'VZ_App_Status' => $newStatus,
                    'Stage' => $newStatus,
                    'Amount' => $service_charge,
                    
                ]]
            ]),
            'PUT'
        );
    }

    public function update_vz_app_status($dealId, $newStatus, $service_charge)
{
    $access = $this->get_access_token();

    $record = [
        'VZ_App_Status' => $newStatus,
        'Stage'         => $newStatus,
    ];

    if ($service_charge !== '' && $service_charge !== null) {
        $record['Amount'] = $service_charge;
    }

    $payload = [
        'data' => [$record]
    ];

    log_message('info', 'Zoho update payload: ' . json_encode($payload));

    $response = $this->send_request(
        $this->api_base . "Deals/{$dealId}",
        [
            "Authorization: Zoho-oauthtoken {$access}",
            "Content-Type: application/json"
        ],
        json_encode($payload),
        'PUT'
    );

    log_message('info', 'Zoho update response: ' . json_encode($response));

    return $response;
}

    /* =====================================================
     * ACCOUNTS
     * ===================================================== */

    public function get_or_create_account($data)
    {
        // ✅ FIX: define token first
        $access_token = $this->get_access_token();

        if (!$access_token) {
            log_message('error', 'Access token missing in get_or_create_account');
            return null;
        }

        $headers = [
            "Authorization: Bearer {$access_token}",
            "Content-Type: application/json"
        ];

        $company_name = $data['company_name'] ?? 'Default Company';

        /* =========================
        1️⃣ SEARCH ACCOUNT
        ========================= */
        $search_url = "https://www.zohoapis.com/crm/v2/Accounts/search?criteria=(Account_Name:equals:" . urlencode($company_name) . ")";
        $search = $this->send_request($search_url, $headers, null, 'GET');

        if (
            ($search['status_code'] ?? 0) === 200 &&
            !empty($search['response']['data'][0]['id'])
        ) {
            return $search['response']['data'][0]['id'];
        }

        /* =========================
        2️⃣ CREATE ACCOUNT
        ========================= */
        $payload = json_encode([
            'data' => [[
                'Account_Name' => $company_name,
                'Phone'        => $data['phone'] ?? null,
                'Email'        => $data['customer_email'] ?? null,
                'Owner'        => [
                    'id' => '5653678000000401001'
                ]
            ]]
        ]);

        $create = $this->send_request(
            "https://www.zohoapis.com/crm/v2/Accounts",
            $headers,
            $payload,
            'POST'
        );

        return $create['response']['data'][0]['details']['id'] ?? null;
    }

    public function get_deal_by_id($dealId)
    {
        $access_token = $this->get_access_token();

        $ch = curl_init($this->api_base . 'Deals/' . $dealId);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                "Authorization: Zoho-oauthtoken {$access_token}"
            ],
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    /***************** Samia Testing ******************/

/*    public function get_deal_attachments($dealId)
{
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $this->get_access_token(),
            "Accept: application/json",
        ],
        CURLOPT_TIMEOUT => 60,
    ]);

    $body = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    return [
        'http' => $http,
        'err'  => $err,
        'body' => $body,
        'json' => json_decode($body, true),
    ];
}

public function download_deal_attachment($dealId, $attachmentId)
{
    $token = $this->get_access_token();
    if (!$token) {
        return ['ok' => false, 'http' => 0, 'err' => 'No access token', 'headers' => [], 'bytes' => null];
    }

    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments/" . rawurlencode($attachmentId);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Zoho-oauthtoken " . $token,
        ],
        CURLOPT_HEADER         => true,  // capture headers (for filename/content-type)
    ]);

    $resp     = curl_exec($ch);
    $http     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $hdrSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($resp === false) {
        return ['ok' => false, 'http' => $http, 'err' => $err ?: 'Curl error', 'headers' => [], 'bytes' => null];
    }

    $rawHeaders = substr($resp, 0, $hdrSize);
    $bytes      = substr($resp, $hdrSize);

    $headers = [];
    foreach (explode("\r\n", $rawHeaders) as $line) {
        if (strpos($line, ':') !== false) {
            [$k, $v] = explode(':', $line, 2);
            $headers[strtolower(trim($k))] = trim($v);
        }
    }

    return [
        'ok'      => ($http >= 200 && $http < 300),
        'http'    => $http,
        'err'     => $err ?: null,
        'headers' => $headers,
        'bytes'   => $bytes,
    ];
}*/


/**** Samia Testing New Codes on 11th March ****/

public function get_deal_attachments($dealId)
{
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $this->get_access_token(),
            "Accept: application/json",
        ],
        CURLOPT_TIMEOUT => 60,
    ]);

    $body = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    return [
        'http' => $http,
        'err'  => $err,
        'body' => $body,
        'json' => json_decode($body, true),
    ];
}

/*public function download_deal_attachment($dealId, $attachmentId)
{
    $token = $this->get_access_token();
    if (!$token) {
        return ['ok' => false, 'http' => 0, 'err' => 'No access token', 'headers' => [], 'bytes' => null];
    }

    $url = "https://www.zohoapis.com/crm/v2/Deals/" . rawurlencode($dealId) . "/Attachments/" . rawurlencode($attachmentId);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Zoho-oauthtoken " . $token,
        ],
        CURLOPT_HEADER         => true,  // capture headers (for filename/content-type)
    ]);

    $resp     = curl_exec($ch);
    $http     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $hdrSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($resp === false) {
        return ['ok' => false, 'http' => $http, 'err' => $err ?: 'Curl error', 'headers' => [], 'bytes' => null];
    }

    $rawHeaders = substr($resp, 0, $hdrSize);
    $bytes      = substr($resp, $hdrSize);

    $headers = [];
    foreach (explode("\r\n", $rawHeaders) as $line) {
        if (strpos($line, ':') !== false) {
            [$k, $v] = explode(':', $line, 2);
            $headers[strtolower(trim($k))] = trim($v);
        }
    }

    return [
        'ok'      => ($http >= 200 && $http < 300),
        'http'    => $http,
        'err'     => $err ?: null,
        'headers' => $headers,
        'bytes'   => $bytes,
    ];
}*/

/** New Model on 16th March **/

public function download_deal_attachment($dealId, $attachmentId, $token = null)
{
    if (!$token) {
        $token = $this->get_access_token();
    }

    if (!$token) {
        return [
            'ok' => false,
            'http' => 0,
            'err' => 'No access token',
            'headers' => [],
            'bytes' => null
        ];
    }

    $url = "https://www.zohoapis.com/crm/v2/Deals/" .
        rawurlencode($dealId) .
        "/Attachments/" .
        rawurlencode($attachmentId);

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $token,
        ],
        CURLOPT_HEADER => true
    ]);

    $resp = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $hdrSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $err = curl_error($ch);

    curl_close($ch);

    if ($resp === false) {
        return [
            'ok' => false,
            'http' => $http,
            'err' => $err ?: 'Curl error',
            'headers' => [],
            'bytes' => null
        ];
    }

    $rawHeaders = substr($resp, 0, $hdrSize);
    $bytes = substr($resp, $hdrSize);

    $headers = [];

    foreach (explode("\r\n", $rawHeaders) as $line) {
        if (strpos($line, ':') !== false) {
            list($k, $v) = explode(':', $line, 2);
            $headers[strtolower(trim($k))] = trim($v);
        }
    }

    return [
        'ok' => ($http >= 200 && $http < 300),
        'http' => $http,
        'err' => $err ?: null,
        'headers' => $headers,
        'bytes' => $bytes
    ];
}

public function update_lead_note_in_zoho($zoho_note_id, $note_title, $note_content, $access_token)
{
    $url = "https://www.zohoapis.com/crm/v2/Notes/{$zoho_note_id}";

    $data = [
        'data' => [
            [
                'Note_Title'   => $note_title,
                'Note_Content' => $note_content
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Zoho-oauthtoken {$access_token}",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response_data = json_decode($response, true);

    log_message('error', 'Zoho update lead note response: ' . $response);

    if (
        isset($response_data['data'][0]['code']) &&
        $response_data['data'][0]['code'] === 'SUCCESS'
    ) {
        return [
            'success' => true,
            'note_id' => $zoho_note_id
        ];
    }

    if (
        isset($response_data['code']) &&
        in_array($response_data['code'], ['INVALID_TOKEN', 'AUTHENTICATION_FAILURE'])
    ) {
        $new_token = $this->refresh_access_token();
        if ($new_token) {
            return $this->update_lead_note_in_zoho($zoho_note_id, $note_title, $note_content, $new_token);
        }
    }

    return [
        'success' => false,
        'message' => $response_data['message'] ?? ('Failed to update note in Zoho. HTTP Code: ' . $http_code)
    ];
}

public function add_lead_note_to_zoho1($zoho_crm_id, $note_title, $note_content, $access_token)
{
    $url = "https://www.zohoapis.com/crm/v2/Leads/{$zoho_crm_id}/Notes";

    $data = [
        'data' => [
            [
                'Note_Title'   => $note_title,
                'Note_Content' => $note_content
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Zoho-oauthtoken {$access_token}",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $curl_error = curl_error($ch);
        curl_close($ch);

        return [
            'success' => false,
            'message' => 'cURL Error: ' . $curl_error
        ];
    }

    curl_close($ch);

    $response_data = json_decode($response, true);

    log_message('error', 'Zoho add lead note response: ' . $response);

    if (isset($response_data['data'][0]['details']['id'])) {
        return [
            'success' => true,
            'note_id' => $response_data['data'][0]['details']['id']
        ];
    }

    if (
        isset($response_data['code']) &&
        in_array($response_data['code'], ['INVALID_TOKEN', 'AUTHENTICATION_FAILURE'])
    ) {
        $new_token = $this->refresh_access_token();
        if ($new_token) {
            return $this->add_lead_note_to_zoho($zoho_crm_id, $note_title, $note_content, $new_token);
        }
    }

    return [
        'success' => false,
        'message' => $response_data['message'] ?? ('Failed to add note in Zoho. HTTP Code: ' . $http_code)
    ];
}

public function add_lead_note_to_zoho2($zoho_crm_id, $note_title, $note_content, $access_token)
{
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . $zoho_crm_id . "/Notes";

    $data = [
        'data' => [
            [
                'Note_Title'   => $note_title,
                'Note_Content' => $note_content
            ]
        ]
    ];

    $jsonData = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Zoho-oauthtoken " . $access_token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response   = curl_exec($ch);
    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    echo "===== ZOHO MODEL DEBUG START =====\n\n";
    echo "ZOHO URL:\n" . $url . "\n\n";
    echo "ZOHO PAYLOAD:\n" . $jsonData . "\n\n";
    echo "ZOHO HTTP CODE:\n" . $http_code . "\n\n";
    echo "ZOHO RAW RESPONSE:\n" . $response . "\n\n";
    echo "ZOHO CURL ERROR:\n" . $curl_error . "\n\n";

    if (!empty($curl_error)) {
        echo "===== ZOHO MODEL DEBUG END =====\n\n";
        return [
            'success' => false,
            'message' => 'cURL Error: ' . $curl_error
        ];
    }

    $response_data = json_decode($response, true);

    echo "ZOHO PARSED RESPONSE:\n";
    print_r($response_data);
    echo "\n";

    if (isset($response_data['data'][0]['details']['id']) && !empty($response_data['data'][0]['details']['id'])) {
        echo "SUCCESS: Note ID found in Zoho response.\n";
        echo "===== ZOHO MODEL DEBUG END =====\n\n";

        return [
            'success' => true,
            'note_id' => $response_data['data'][0]['details']['id']
        ];
    }

    if (
        isset($response_data['data'][0]['status']) &&
        strtolower($response_data['data'][0]['status']) === 'success' &&
        !empty($response_data['data'][0]['details']['id'])
    ) {
        echo "SUCCESS: Note ID found in Zoho response.\n";
        echo "===== ZOHO MODEL DEBUG END =====\n\n";

        return [
            'success' => true,
            'note_id' => $response_data['data'][0]['details']['id']
        ];
    }

    // refresh token only for auth/token issues
    if (
        isset($response_data['code']) &&
        in_array($response_data['code'], ['INVALID_TOKEN', 'AUTHENTICATION_FAILURE'])
    ) {
        echo "TOKEN ISSUE DETECTED. TRYING REFRESH TOKEN...\n\n";

        $new_token = $this->refresh_access_token();

        echo "NEW TOKEN:\n";
        echo $new_token ? $new_token : 'TOKEN REFRESH FAILED';
        echo "\n\n";

        if ($new_token && $new_token !== $access_token) {
            echo "RETRYING NOTE CREATION WITH NEW TOKEN...\n\n";
            echo "===== ZOHO MODEL DEBUG END =====\n\n";

            return $this->add_lead_note_to_zoho($zoho_crm_id, $note_title, $note_content, $new_token);
        }
    }

    $message = 'Failed to add note in Zoho.';
    if (!empty($response_data['message'])) {
        $message .= ' ' . $response_data['message'];
    }
    if (!empty($response_data['code'])) {
        $message .= ' [Code: ' . $response_data['code'] . ']';
    }
    if (!empty($http_code)) {
        $message .= ' [HTTP: ' . $http_code . ']';
    }

    echo "FINAL ERROR MESSAGE:\n" . $message . "\n\n";
    echo "===== ZOHO MODEL DEBUG END =====\n\n";

    return [
        'success' => false,
        'message' => $message,
        'response' => $response_data
    ];
}

public function add_lead_note_to_zoho($zoho_crm_id, $note_title, $note_content, $access_token)
{
    $url = "https://www.zohoapis.com/crm/v2/Deals/" . $zoho_crm_id . "/Notes";

    $data = [
        'data' => [
            [
                'Note_Title'   => $note_title,
                'Note_Content' => $note_content
            ]
        ]
    ];

    $jsonData = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Zoho-oauthtoken " . $access_token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response   = curl_exec($ch);
    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);

    curl_close($ch);

    if (!empty($curl_error)) {
        return [
            'success' => false,
            'message' => 'cURL Error: ' . $curl_error
        ];
    }

    $response_data = json_decode($response, true);

    // Success case
    if (isset($response_data['data'][0]['details']['id']) && !empty($response_data['data'][0]['details']['id'])) {
        return [
            'success' => true,
            'note_id' => $response_data['data'][0]['details']['id']
        ];
    }

    if (
        isset($response_data['data'][0]['status']) &&
        strtolower($response_data['data'][0]['status']) === 'success' &&
        !empty($response_data['data'][0]['details']['id'])
    ) {
        return [
            'success' => true,
            'note_id' => $response_data['data'][0]['details']['id']
        ];
    }

    // Token refresh handling
    if (
        isset($response_data['code']) &&
        in_array($response_data['code'], ['INVALID_TOKEN', 'AUTHENTICATION_FAILURE', 'OAUTH_SCOPE_MISMATCH'])
    ) {
        $new_token = $this->refresh_access_token();

        if ($new_token && $new_token !== $access_token) {
            return $this->add_lead_note_to_zoho($zoho_crm_id, $note_title, $note_content, $new_token);
        }
    }

    $message = 'Failed to add note in Zoho.';
    if (!empty($response_data['message'])) {
        $message .= ' ' . $response_data['message'];
    }
    if (!empty($response_data['code'])) {
        $message .= ' [Code: ' . $response_data['code'] . ']';
    }
    if (!empty($http_code)) {
        $message .= ' [HTTP: ' . $http_code . ']';
    }

    return [
        'success' => false,
        'message' => $message
    ];
}

public function get_deals_page($page = 1, $perPage = 200)
{
    $accessToken = $this->get_access_token();

    $url = "https://www.zohoapis.com/crm/v2/Deals?page={$page}&per_page={$perPage}";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $accessToken
        ]
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'get_deals_page curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    return json_decode($response, true);
}

 public function generate_next_enquiry_number()
{
    $accessToken = $this->get_access_token();

    if (!$accessToken) {
        log_message('error', 'Zoho token missing in enquiry number generation.');
        return 'ENQ-1001'; // fallback
    }

    $url = 'https://www.zohoapis.com/crm/v2/Deals?fields=EnquiryNumber&sort_by=Created_Time&sort_order=desc&per_page=1';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Zoho-oauthtoken ' . $accessToken
        ],
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'Curl error in enquiry number: ' . curl_error($ch));
        curl_close($ch);
        return 'ENQ-1001';
    }

    curl_close($ch);

    $result = json_decode($response, true);

    $latest = $result['data'][0]['EnquiryNumber'] ?? '';

    if (preg_match('/ENQ-(\d+)/', $latest, $match)) {
        $next = (int)$match[1] + 1;
        return 'ENQ-' . $next;
    }

    return 'ENQ-1001';
}

public function create_contact($data)
{
    $accessToken = $this->get_access_token();

    if (!$accessToken) {
        log_message('error', 'Zoho token missing in create_contact.');
        return false;
    }

    $postData = [
        'data' => [[
            'First_Name'   => $data['first_name'] ?? '',
            'Last_Name'    => $data['last_name'] ?? 'Unknown',
            'Email'        => $data['email'] ?? '',
            'Mobile'       => $data['mobile'] ?? '',
            'Phone'        => $data['phone'] ?? '',
            'Mailing_Street' => $data['address'] ?? '',
        ]]
    ];

    // Add account lookup only if account id exists
    if (!empty($data['account_id'])) {
        $postData['data'][0]['Account_Name'] = ['id' => $data['account_id']];
    }

    $ch = curl_init('https://www.zohoapis.com/crm/v2/Contacts');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => [
            'Authorization: Zoho-oauthtoken ' . $accessToken,
            'Content-Type: application/json'
        ],
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'Zoho create_contact curl error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    log_message('error', 'Zoho create_contact response: ' . $response);

    if (!empty($result['data'][0]['details']['id'])) {
        return $result['data'][0]['details']['id'];
    }

    return false;
}

public function create_deal($data)
{
    $accessToken = $this->get_access_token();

    if (!$accessToken) {
        log_message('error', 'Zoho token missing in create_deal.');
        return false;
    }

    $postFields = [
        'Deal_Name'    => $data['deal_name'] ?? '',
        'Stage'        => 'Qualification',
        'Description'  => $data['description'] ?? '',
        'VZ_App_Status' => 'Pending'
    ];

    // Account lookup
    if (!empty($data['account_id'])) {
        $postFields['Account_Name'] = ['id' => $data['account_id']];
    }

    // Contact lookup
    if (!empty($data['contact_id'])) {
        $postFields['Contact_Name'] = ['id' => $data['contact_id']];
    }

    // Optional custom fields
    if (!empty($data['enquiry_number'])) {
        $postFields['EnquiryNumber'] = $data['enquiry_number'];
    }

    // VX App User lookup/custom user field
    if (!empty($data['session_zoho_user'])) {
        $postFields['VZ_app_user'] = ['id' => $data['session_zoho_user']];
    }

    // Only include these if these exact API names exist in your Deals module
    if (!empty($data['email'])) {
        $postFields['Email'] = $data['email'];
    }

    if (!empty($data['phone'])) {
        $postFields['Phone'] = $data['phone'];
    }

    if (!empty($data['mobile'])) {
        $postFields['Mobile'] = $data['mobile'];
    }

    if (!empty($data['address'])) {
        $postFields['Address'] = $data['address'];
    }

    if (!empty($data['p_box'])) {
        $postFields['P_Box'] = $data['p_box'];
    }

    if (!empty($data['trn'])) {
        $postFields['TRN'] = $data['trn'];
    }

    if (!empty($data['department'])) {
        $postFields['Department'] = $data['department'];
    }

    $payload = [
        'data' => [$postFields]
    ];

    $ch = curl_init('https://www.zohoapis.com/crm/v2/Deals');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Authorization: Zoho-oauthtoken ' . $accessToken,
            'Content-Type: application/json'
        ],
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'Zoho create_deal curl error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    log_message('error', 'Zoho create_deal response: ' . $response);

    $result = json_decode($response, true);

    if (!empty($result['data'][0]['details']['id'])) {
        return $result['data'][0]['details']['id'];
    }

    return false;
}

public function list_items($page = 1, $per_page = 200)
{
    $access_token = $this->get_access_token();

    if (!$access_token) {
        return [
            'status_code' => 401,
            'response' => ['message' => 'Unable to get Zoho access token']
        ];
    }

    $url = "https://www.zohoapis.com/crm/v2.1/Products?page={$page}&per_page={$per_page}&sort_by=Product_Name&sort_order=asc";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Zoho-oauthtoken " . $access_token,
            "Content-Type: application/json"
        ],
        CURLOPT_TIMEOUT => 30,
    ]);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'status_code' => 500,
            'response' => ['message' => $error]
        ];
    }

    curl_close($ch);

    $decoded = json_decode($result, true);

    return [
        'status_code' => $http_code,
        'response' => $decoded
    ];
}

    



}
