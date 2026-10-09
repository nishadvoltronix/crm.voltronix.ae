<?php
class Task_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function convert_number_to_words($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        ];
    
        if (!is_numeric($number)) {
            return false;
        }
    
        // Handle negative numbers
        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }
    
        // Split into integer and decimal parts
        $number = (float) $number;
        $integerPart = (int) $number;
        $decimalPart = round(($number - $integerPart) * 100); // Convert to fils (2 decimal places)
    
        // Convert the integer part
        $string = $this->convert_integer_to_words($integerPart, $dictionary, $hyphen, $conjunction, $separator);
    
        // Prepend "DIRHAMS" only once
        $string = 'DIRHAMS ' . ucfirst($string);
    
        // Handle decimal part (fils)
        if ($decimalPart > 0) {
            $decimalString = '';
            if ($decimalPart < 21) {
                $decimalString = $dictionary[$decimalPart];
            } else {
                $tens = ((int) ($decimalPart / 10)) * 10;
                $units = $decimalPart % 10;
                $decimalString = $dictionary[$tens];
                if ($units) {
                    $decimalString .= $hyphen . $dictionary[$units];
                }
            }
            $string .= $decimal . $decimalString . ' FILS';
        }
    
        return $string;
    }

    public function create_task($data) {
        return $this->db->insert('tasks', $data);
    }

    public function get_task($id) {
        $query = $this->db->get_where('tasks', array('id' => $id));
        return $query->row_array();
    }

    public function get_task_assigned_agent1($id) {
    $this->db->select('t.*, u.username as agent_name'); // change 'name' if your column is different
    $this->db->from('tasks t');
    $this->db->join('users u', 'u.user_id = t.assigned_to', 'left');
    $this->db->where('t.id', $id);

    $query = $this->db->get();
    return $query->row_array();
}
    
    public function get_task_items($id) {
		$this->db->select('product_name, product_description, uom, quantity, service_charge');
		$this->db->where('id', $id);
		$this->db->where('product_name IS NOT NULL', null, false); // Ensure product_name exists
		$query = $this->db->get('tasks');
		return $query->result_array();
	}

    public function update_task($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tasks', $data);
    
        if ($this->db->affected_rows() === 0) {
            // Task ID was not found or no change was made
            return ['error' => 'Task not found or no changes made.'];
        }
    
        return true; // Task was found and updated
    }
    
    public function task_exists($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tasks');
        
        return $query->num_rows() > 0;
    }

    public function get_tasks_by_user($user_id) {
        $query = $this->db->get_where('tasks', ['user_id' => $user_id]);
        return $query->result_array();
    }
    
    public function insert_task($data) {
        return $this->db->insert('tasks', $data);
    }
    
    // Method to retrieve a lead by zoho_crm_id
    public function get_task_by_zoho_crm_id($zoho_crm_id) {
        return $this->db->get_where('tasks', ['zoho_crm_id' => $zoho_crm_id])->row_array();
    }
    
    public function delete_task_by_zoho_crm_id($dealId) {
        $this->db->where('zoho_crm_id', $dealId);
        return $this->db->delete('tasks');
    }
    
    public function get_assigned_to_id($crm_id) {
        $this->db->select('assigned_to');
        $this->db->from('tasks');
        $this->db->where('zoho_crm_id', $crm_id);
        $query = $this->db->get();
        $result = $query->row();

        return $result ? $result->assigned_to : null;
    }
    
    public function get_zoho_crm_id($task_id) {
        $this->db->select('zoho_crm_id');
        $this->db->from('tasks');
        $this->db->where('id', $task_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->zoho_crm_id;
        } else {
            return null;
        }
    }
    
    public function get_big_projects($user_id) {
		$this->db->select('tasks.*');
		$this->db->from('tasks');
		$this->db->where('status', 'Big Project');
		$this->db->where('assigned_to', $user_id);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	public function get_id_by_deal_id($deal_id) {
		$this->db->select('id');
		$this->db->from('tasks');
		$this->db->where('zoho_crm_id', $deal_id);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->id;
		} else {
			return null; // Return null if no record is found
		}
	}
	
	public function get_task_by_deal_id($deal_id) {
        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->where('zoho_crm_id', $deal_id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row(); // Return the full row instead of just the `id`
        } else {
            return null; // Return null if no record is found
        }
    }
	
	public function get_id_by_quote_id($quote_no) {
		$this->db->select('id');
		$this->db->from('tasks');
		$this->db->where('quote_id', $quote_no);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->id;
		} else {
			return null; // Return null if no record is found
		}
	}
	
/*	public function save_proposal_data($proposal_data, $id) {
        // Check if the proposal data already exists for the given task_id
        $this->db->where('id', $id);
        $query = $this->db->get('tasks');

        if ($query->num_rows() > 0) {
            // Update existing proposal data
            $this->db->where('id', $id);
            return $this->db->update('tasks', $proposal_data);
        } else {
            // Insert new proposal data
            return $this->db->insert('tasks', $proposal_data);
        }
    } */

    public function save_proposal_data($proposal_data, $id)
{
    $this->db->where('id', $id);
    return $this->db->update('tasks', $proposal_data);
}

public function delete_proposal_items($task_id)
{
    $this->db->where('task_id', $task_id);
    return $this->db->delete('proposal_items');
}

public function save_proposal_item($item_data)
{
    return $this->db->insert('proposal_items', $item_data);
}
    
    public function get_quote_by_number($quote_number, $user_id) {
        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->where('quote_number', $quote_number);
        $this->db->or_where('quote_deal_number', $quote_number);
		$this->db->where('assigned_to', $user_id);
        $query = $this->db->get();

        return $query->row_array(); // Return the first matching row as an associative array
    }
    
    public function search_tasks($user_id, $query = '') {
        // Select specific columns
		$this->db->select('id, deal_name, deal_number, complaint_info, status, qual_deal_number, qual_deal_date, site_deal_number, site_deal_date, quote_deal_number, quote_deal_date, job_deal_number, job_deal_date, lost_deal_number, lost_deal_date, account_name, service_charge, assign_notes, account_name, customer_email, customer_contact');
		$this->db->from('tasks');
        $this->db->where('assigned_to', $user_id); // Fetch only tasks assigned to this user
        $this->db->where('status IS NOT NULL'); // Exclude NULL status values
        $this->db->order_by('created_at', 'DESC'); // Order by creation date, newest first

        // Apply search filter if query is provided
        if (!empty($query)) {
            $this->db->group_start(); // Group LIKE conditions
            $this->db->like('deal_name', $query);
            $this->db->or_like('deal_number', $query);
            $this->db->or_like('quote_number', $query);
            $this->db->or_like('enq_number', $query);
            $this->db->or_like('qual_deal_number', $query);
            $this->db->or_like('site_deal_number', $query);
            $this->db->or_like('quote_deal_number', $query);
            $this->db->or_like('job_deal_number', $query);
            $this->db->or_like('lost_deal_number', $query);
            $this->db->or_like('account_name', $query);
			$this->db->or_like('customer_email', $query);
			$this->db->or_like('customer_contact', $query);
            $this->db->group_end();
        }

        // Execute query and get results
        $query = $this->db->get();

        // Log the query for debugging
        log_message('debug', 'Task_model::search_tasks Query: ' . $this->db->last_query());

        // Check if query was successful
        if ($query === FALSE) {
            log_message('error', 'Database error in search_tasks: ' . $this->db->error()['message']);
            return [];
        }

        return $query->result_array();
    }
    
    public function get_task_by_deal_number1($deal_number) {
        $this->db->where('deal_number', $deal_number);
		$this->db->or_where('qual_deal_number', $deal_number);
        $query = $this->db->get('tasks');
        return $query->row();
    }

    public function get_task_by_deal_number($deal_number) {
    $this->db->where('deal_number', $deal_number);
    $this->db->or_where('qual_deal_number', $deal_number);
    $query = $this->db->get('tasks');
    return $query->row_array(); // ✅ FIX HERE
}

    public function get_by_zoho_id($zohoId)
    {
        return $this->db
            ->where('zoho_crm_id', $zohoId)
            ->get('tasks')
            ->row();
    }

    public function update_by_zoho_id($zohoId, $data)
    {
        return $this->db
            ->where('zoho_crm_id', $zohoId)
            ->update('tasks', $data);
    }

    public function fetch_zoho_leads($page = 1, $perPage = 200)
    {
        $accessToken = $this->getValidZohoAccessToken(); // you already have this logic

        $url = "https://www.zohoapis.com/crm/v2/Leads?page={$page}&per_page={$perPage}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Zoho-oauthtoken ' . $accessToken
            ],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function get_user_by_username($username) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query->row_array(); // Returns user data as an array
	}

    public function get_task_assigned_agent($id) { 

        $this->db->select('u.*'); 
        $this->db->from('tasks t'); 
        $this->db->join('users u', 'u.user_id = t.assigned_to', 'left'); 
        $this->db->where('t.id', $id); 
        $query = $this->db->get(); 
        return $query->row_array(); 
        
    }

    public function get_proposal_items_by_quote_number($quote_number)
{
    return $this->db
        ->where('quote_number', $quote_number)
        ->order_by('id', 'ASC')
        ->get('proposal_items')
        ->result_array();
}

public function upsert_task_from_zoho_deal1($data, $session_user_id = null)
{
    if (empty($data['id'])) {
        return false;
    }

    $zoho_crm_id = $data['id'];

    $existing = $this->db->where('zoho_crm_id', $zoho_crm_id)->get('tasks')->row_array();

    $taskData = [
        'zoho_crm_id'    => $zoho_crm_id,
        'deal_name'      => $data['Deal_Name'] ?? null,
        'deal_number'    => $data['DealNumber'] ?? null,
        'qual_deal_number'    => $data['QualDealNumber'],
        'enq_number' => $data['EnquiryNumber'] ?? null,
        'account_name'        => $data['Account_Name']['name'] ?? null,
        'customer_name' => $data['Contact_Name']['name'] ?? null,
        'customer_email'          => $data['Email'] ?? null,
        'customer_contact'          => $data['Phone'] ?? null,
 //       'mobile'         => $data['Mobile'] ?? null,
        'address'        => $data['Address'] ?? null,
        'remark'    => $data['Description'] ?? null,
        'complaint_info'    => $data['Description'] ?? null,
        'status'         => ($data['Stage'] ?? '') == 'Qualification' ? 'Pending' : ($data['Stage'] ?? null),
 //       'Stage'          => $data['Stage'] ?? null,
        'assigned_to'    => $this->session->userdata('admin_id'),
        'deal_crm_created_by'    => $this->session->userdata('admin_id'),
        'owner_id'     => $data['Owner']['id'] ?? null,
        'updated_at'     => date('Y-m-d H:i:s'),

    ];

    if ($existing) {
        $this->db->where('zoho_crm_id', $zoho_crm_id);
        $this->db->update('tasks', $taskData);
        return $existing['id'];
    } else {
        $taskData['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('tasks', $taskData);
        return $this->db->insert_id();
    }
}

public function upsert_task_from_zoho_deal($data, $session_user_id = null)
{
    if (empty($data['id'])) {
        return false;
    }

    $zoho_crm_id = $data['id'];

    $existing = $this->db->where('zoho_crm_id', $zoho_crm_id)->get('tasks')->row_array();

    $taskData = [
        'zoho_crm_id'         => $zoho_crm_id,
        'deal_name'           => $data['Deal_Name'] ?? null,
        'deal_number'         => $data['DealNumber'] ?? null,
        'qual_deal_number'    => $data['QualDealNumber'] ?? null,
        'enq_number'          => $data['EnquiryNumber'] ?? null,
        'account_name'        => $data['Account_Name']['name'] ?? null,
        'customer_name'       => $data['Contact_Name']['name'] ?? null,
        'customer_email'      => $data['Email'] ?? null,
        'customer_contact'    => $data['Phone'] ?? null,
        // 'mobile'           => $data['Mobile'] ?? null,
        'address'             => $data['Address'] ?? null,
        'remark'              => $data['Description'] ?? null,
        'complaint_info'      => $data['Description'] ?? null,
        'status'              => (($data['Stage'] ?? '') === 'Qualification') ? 'Pending' : ($data['Stage'] ?? null),
        // 'Stage'            => $data['Stage'] ?? null,
        'assigned_to'         => $this->session->userdata('admin_id'),
        'deal_crm_created_by' => $this->session->userdata('admin_id'),
        'owner_id'            => $data['Owner']['id'] ?? null,
        'updated_at'          => date('Y-m-d H:i:s'),
    ];

    if ($existing) {
        $this->db->where('zoho_crm_id', $zoho_crm_id);
        $this->db->update('tasks', $taskData);
        return $existing['id'];
    } else {
        $taskData['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('tasks', $taskData);
        return $this->db->insert_id();
    }
}
 


}
