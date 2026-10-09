<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Mpdf\Mpdf;
class Admincrm extends CI_Controller {
    
    public function __construct()
    {
                parent::__construct();

                $this->load->library(['session','rbac','form_validation']);
                $this->load->helper(['url','form']);
                $this->load->model('Admin');
                $this->load->model('Proposal_model');
                $this->load->model('Task_quote_model');
                $this->load->helper('zoho_helper');
                $this->load->model('Task_model');
                $this->load->model('Zoho_model');
                $this->load->helper('NumberToWords_helper');


                // Auth check
               if (!$this->session->userdata('admin_id')) {
               redirect('index.php/login');
        }
    }

    /* =========================
       RENDER METHOD
       ========================= */

    
    public function index()
    {
  
        $data = [];
        $user = $this->session->userdata('id');
        $zoho_user_id = $this->session->userdata('admin_id');

        $data['total_won_jobs_admin'] = $this->Admin->count_total_won_jobs_admin();
        $data['pending_jobs_assign_admin'] = $this->Admin->count_pending_jobs_assign_admin();
        $data['accounts_summary'] = $this->Admin->pending_accounts_summary();
        $data['completed_jobs_assign_departments_admin'] = $this->Admin->count_completed_jobs_with_departments();

        $data['close_to_won_percentage'] = $this->Admin->close_to_won_percentage();
        $data['ommitted_percentage'] = $this->Admin->ommitted_percentage();
        $data['pending_percentage'] = $this->Admin->pending_percentage();
        $data['proposal_percentage'] = $this->Admin->proposal_percentage();
        $data['site_visit_percentage'] = $this->Admin->site_visit_percentage();
        $data['big_project_percentage'] = $this->Admin->big_project_percentage();

        $data['count_todays_leads'] = $this->Admin->count_todays_leads();
        $data['count_monthly_leads'] = $this->Admin->count_monthly_leads();

        $data['count_total_electrical_department_assigned'] = $this->Admin->count_total_electrical_department_assigned();
        $data['count_total_electrical_department_status_assigned'] = $this->Admin->count_total_electrical_department_status_assigned();
        $data['count_total_electrical_department_status_progress'] = $this->Admin->count_total_electrical_department_status_progress();
        $data['count_total_electrical_department_status_completed'] = $this->Admin->count_total_electrical_department_status_completed();
        $data['count_total_electrical_department_status_hold'] = $this->Admin->count_total_electrical_department_status_hold();

        $data['count_total_civil_department_assigned'] = $this->Admin->count_total_civil_department_assigned();
        $data['count_total_civil_department_status_assigned'] = $this->Admin->count_total_civil_department_status_assigned();
        $data['count_total_civil_department_status_progress'] = $this->Admin->count_total_civil_department_status_progress();
        $data['count_total_civil_department_status_completed'] = $this->Admin->count_total_civil_department_status_completed();
        $data['count_total_civil_department_status_hold'] = $this->Admin->count_total_civil_department_status_hold();

        $data['count_total_pm_department_assigned'] = $this->Admin->count_total_pm_department_assigned();
        $data['count_total_pm_department_status_assigned'] = $this->Admin->count_total_pm_department_status_assigned();
        $data['count_total_pm_department_status_progress'] = $this->Admin->count_total_pm_department_status_progress();
        $data['count_total_pm_department_status_completed'] = $this->Admin->count_total_pm_department_status_completed();
        $data['count_total_pm_department_status_hold'] = $this->Admin->count_total_pm_department_status_hold();

        $data['total_pending_electrical_jobs_count'] = $this->Admin->total_pending_electrical_jobs_count($user);
        $data['total_process_electrical_jobs_count'] = $this->Admin->total_process_electrical_jobs_count($user);
        $data['total_completed_electrical_jobs_count'] = $this->Admin->total_completed_electrical_jobs_count($user);
        $data['total_hold_electrical_jobs_count'] = $this->Admin->total_hold_electrical_jobs_count($user);
        $data['total_assigned_today_electrical_jobs_count'] = $this->Admin->total_assigned_today_electrical_jobs_count($user);
        $data['total_completed_this_month_electrical_jobs_count'] = $this->Admin->total_completed_this_month_electrical_jobs_count($user);
        $data['total_electrical_jobs_assigned_to_user'] = $this->Admin->total_electrical_jobs_assigned_to_user($user);

        $data['total_pending_civil_jobs_count'] = $this->Admin->total_pending_civil_jobs_count($user);
        $data['total_process_civil_jobs_count'] = $this->Admin->total_process_civil_jobs_count($user);
        $data['total_completed_civil_jobs_count'] = $this->Admin->total_completed_civil_jobs_count($user);
        $data['total_hold_civil_jobs_count'] = $this->Admin->total_hold_civil_jobs_count($user);
        $data['total_assigned_today_civil_jobs_count'] = $this->Admin->total_assigned_today_civil_jobs_count($user);
        $data['total_completed_this_month_civil_jobs_count'] = $this->Admin->total_completed_this_month_civil_jobs_count($user);
        $data['total_civil_jobs_assigned_to_user'] = $this->Admin->total_civil_jobs_assigned_to_user($user);

        $data['total_pending_pm_jobs_count'] = $this->Admin->total_pending_pm_jobs_count($user);
        $data['total_process_pm_jobs_count'] = $this->Admin->total_process_pm_jobs_count($user);
        $data['total_completed_pm_jobs_count'] = $this->Admin->total_completed_pm_jobs_count($user);
        $data['total_hold_pm_jobs_count'] = $this->Admin->total_hold_pm_jobs_count($user);
        $data['total_assigned_today_pm_jobs_count'] = $this->Admin->total_assigned_today_pm_jobs_count($user);
        $data['total_completed_this_month_pm_jobs_count'] = $this->Admin->total_completed_this_month_pm_jobs_count($user);
        $data['total_pm_jobs_assigned_to_user'] = $this->Admin->total_pm_jobs_assigned_to_user($user);

        $data['pending_qualification_count'] = $this->Admin->pending_qualification_count_user($zoho_user_id);
        $data['pending_site_visit_count'] = $this->Admin->pending_site_visit_count_user($zoho_user_id);
        $data['pending_proposal_count'] = $this->Admin->pending_proposal_count_user($zoho_user_id);
        $data['pending_won_count'] = $this->Admin->pending_won_count_user($zoho_user_id);
        $data['pending_ommitted_count'] = $this->Admin->pending_ommitted_count_user($zoho_user_id);
        $data['tasks_assigned_leads_today'] = $this->Admin->tasks_assigned_leads_today_count_user($zoho_user_id);
        $data['tasks_assigned_leads_month'] = $this->Admin->tasks_assigned_this_month_count_user($zoho_user_id);
        $data['tasks_assigned_leads_count_user'] = $this->Admin->tasks_assigned_leads_count_user($zoho_user_id);

        $data['records'] = $this->Admin->get_all_users_won_department_counts();

        $data['title'] = "Dashboard";
	    $data['render'] = "Dashboard/dashboard";

        $data['breadcrumbs'] = [
            ['label' => 'Dashboard']
        ];
        
        $this->load->view('layout/layout', $data);
    }
    
    /***************************************************************/
    /*                    PipeLine Dashboard                       */
    /**************************************************************/
    
    public function Pipeline_Dashboard(){

        $zoho_user_id = $this->session->userdata('admin_id');
        $user = $this->session->userdata('id');

        if($this->rbac->can('leads.manage.agents')){
            $data['pending_qualification_count'] = $this->Admin->pending_qualification_count_user($zoho_user_id);
            $data['pending_site_visit_count'] = $this->Admin->pending_site_visit_count_user($zoho_user_id);
            $data['pending_proposal_count'] = $this->Admin->pending_proposal_count_user($zoho_user_id);
            $data['pending_won_count'] = $this->Admin->pending_won_count_user($zoho_user_id);
            $data['pending_ommitted_count'] = $this->Admin->pending_ommitted_count_user($zoho_user_id);

            $data['records'] = $this->Admin->view_pipeline_dashboard_agent($zoho_user_id);
        }
        else{
            $data['pending_qualification_count'] = $this->Admin->pending_qualification_count();
            $data['pending_site_visit_count'] = $this->Admin->pending_site_visit_count();
            $data['pending_proposal_count'] = $this->Admin->pending_proposal_count();
            $data['pending_won_count'] = $this->Admin->pending_won_count();
            $data['pending_ommitted_count'] = $this->Admin->pending_ommitted_count();

            $data['records'] = $this->Admin->view_pipeline_dashboard();
        }

        $data['title'] = "My Job Pipeline";
        
        $data['breadcrumbs'] = [
            ['label' => 'Leads Pipeline', 'url' => 'index.php/Admincrm/Pipeline_Dashboard'],
        ];
        
   
        $data['render'] = "Leads_Pipeline/Pipeline.php";
        $this->load->view('layout/layout', $data);
        
    }

    public function Admin_Pipeline_Dashboard(){

        $zoho_user_id = $this->session->userdata('admin_id');
        $user = $this->session->userdata('id');

            $data['pending_qualification_count'] = $this->Admin->pending_qualification_count_user($zoho_user_id);
            $data['pending_site_visit_count'] = $this->Admin->pending_site_visit_count_user($zoho_user_id);
            $data['pending_proposal_count'] = $this->Admin->pending_proposal_count_user($zoho_user_id);
            $data['pending_won_count'] = $this->Admin->pending_won_count_user($zoho_user_id);
            $data['pending_ommitted_count'] = $this->Admin->pending_ommitted_count_user($zoho_user_id);

            $data['records'] = $this->Admin->view_pipeline_dashboard_agent($zoho_user_id);

        $data['title'] = "My Job Pipeline";
        
        $data['breadcrumbs'] = [
            ['label' => 'Leads Pipeline', 'url' => 'index.php/Admincrm/Admin_Pipeline_Dashboard'],
        ];
        
   
        $data['render'] = "Leads_Pipeline/Pipeline.php";
        $this->load->view('layout/layout', $data);
        
    }
    
    public function lead_detail() {
    $id = $this->uri->segment(3);
    $lead = $this->Admin->get_lead_by_id($id);

    if (!$lead) {
        // Lead not found, handle gracefully
        show_error("Lead not found.", 404);
        return;
    }

    $attachments = $this->Admin->get_lead_attachments($lead['zoho_crm_id']);

    $notes_details = [];
        
    if (!empty($lead['zoho_crm_id'])) {
        $notes_details = $this->Admin->get_your_notes($lead['zoho_crm_id']);
        if (!$notes_details) {
        
            $notes_details = []; 
        }
    }

    if (!$attachments) {
        $attachments = []; // default to empty array
    }

    $data['title'] = "Lead Details";
    $data['breadcrumbs'] = [
        ['label' => 'Leads Pipeline', 'url' => 'index.php/Admincrm/Pipeline_Dashboard'],
        ['label' => 'Lead Details']
    ];

    $data['data'] = $lead;
    $data['attachments'] = $attachments;
    $data['notes_details'] = $notes_details;

    $data['render'] = "Leads_Pipeline/Lead_Details.php";
    $this->load->view('layout/layout', $data);
}
    
    
/**public function lead_detail1() {
    $id = $this->uri->segment(3);
    $lead = $this->Admin->get_lead_by_id($id);

    if (!$lead) {
        // No row found with that ID
        show_error("Lead not found.", 404);
        return;
    }

    // Check if zoho_crm_id exists before fetching attachments
    $attachments = [];
    if (!empty($lead['zoho_crm_id'])) {
        $attachments = $this->Admin->get_lead_attachments($lead['zoho_crm_id']);
        if (!$attachments) {
            $attachments = [];
        }
    }
        
    $notes_details = [];
        
    if (!empty($lead['zoho_crm_id'])) {
        $notes_details = $this->Admin->get_your_notes($lead['zoho_crm_id']);
        if (!$notes_details) {
        
            $notes_details = []; 
        }
    }
    
        
    $quotation_details = [];
        
    if (!empty($lead['quote_number'])) {
        $quotation = $this->Admin->get_lead_quotation($lead['quote_number']);
        if (!$quotation) {
        
            $quotation_details = $quotation; 
        }
    }

    $data['title'] = "Lead Details";
    $data['breadcrumbs'] = [
        ['label' => 'Leads Pipeline', 'url' => 'leads'],
        ['label' => 'Lead Details']
    ];

    $data['data'] = $lead;
    $data['attachments'] = $attachments;
    $data['notes_details'] = $notes_details;
    $data['quotation_details'] = $quotation ?? [];
    $data['render'] = "Leads_Pipeline/Lead_Details.php";

    $this->load->view('layout/layout', $data);
}**/
    
    public function update_leads_notes_details1()
    {
      
        if ($this->input->server('REQUEST_METHOD') == 'POST'){

            $notes_id = $this->input->post('notes_id');
            $leadid = $this->input->post('id');
            $note_content = $this->input->post('note_content');

            $data = array(

                'note_content' => $note_content

                );

            $update = $this->Admin->update_notes_details($data, $notes_id);


            if ($update) {
            redirect(base_url() . "index.php/Admincrm/lead_detail/" . $leadid);
            } else {
                $this->session->set_flashdata('error', 'Failed to update.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
        
    }

    public function update_leads_notes_details()
{
    if ($this->input->server('REQUEST_METHOD') == 'POST') {

        $notes_id      = $this->input->post('notes_id');
        $leadid        = $this->input->post('id'); // local lead/task id
        $note_content  = trim($this->input->post('note_content'));
        $note_title    = trim($this->input->post('note_title')); // optional if you have title field

        if (empty($notes_id) || empty($leadid) || empty($note_content)) {
            $this->session->set_flashdata('error', 'Required fields are missing.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $this->load->model('Admin');
        $this->load->model('Zoho_model');

        // 1) Get local note row first
        $note = $this->Admin->get_note_by_id($notes_id);

        if (!$note) {
            $this->session->set_flashdata('error', 'Note not found.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // If title is not posted, use old title or default
        if (empty($note_title)) {
            $note_title = !empty($note['note_title']) ? $note['note_title'] : 'Lead Note';
        }

        // 2) Get Zoho Lead ID from your local lead/task table
        // Adjust this function according to your table
        $lead = $this->Admin->get_lead_by_id($leadid);

        if (!$lead || empty($lead['zoho_crm_id'])) {
            $this->session->set_flashdata('error', 'Zoho Lead ID not found for this lead.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $zoho_lead_id = $lead['zoho_crm_id'];

        // 3) Get access token
        $access_token = $this->Zoho_model->get_access_token();
        if (!$access_token) {
            $this->session->set_flashdata('error', 'Failed to retrieve Zoho access token.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $zoho_note_id = !empty($note['zoho_note_id']) ? $note['zoho_note_id'] : null;

        // 4) If zoho_note_id exists -> update in Zoho, else create in Zoho
        if (!empty($zoho_note_id)) {
            $zoho_response = $this->Zoho_model->update_lead_note_in_zoho(
                $zoho_note_id,
                $note_title,
                $note_content,
                $access_token
            );
        } else {
            $zoho_response = $this->Zoho_model->add_lead_note_to_zoho(
                $zoho_lead_id,
                $note_title,
                $note_content,
                $access_token
            );

            if (!empty($zoho_response['success']) && !empty($zoho_response['note_id'])) {
                $zoho_note_id = $zoho_response['note_id'];
            }
        }

        if (empty($zoho_response['success'])) {
            $this->session->set_flashdata('error', $zoho_response['message'] ?? 'Failed to sync note with Zoho.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // 5) Update local DB also
        $data = array(
            'note_title'    => $note_title,
            'note_content'  => $note_content,
            'zoho_note_id'  => $zoho_note_id,
            'updated_at'    => date('Y-m-d H:i:s')
        );

        $update = $this->Admin->update_notes_details($data, $notes_id);

        if ($update) {
            $this->session->set_flashdata('success', 'Note updated successfully.');
            redirect(base_url() . "index.php/Admincrm/lead_detail/" . $leadid);
        } else {
            $this->session->set_flashdata('error', 'Zoho updated, but local database update failed.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

public function add_leads_notes_details1()
{
    if ($this->input->server('REQUEST_METHOD') == 'POST') {

        $leadid       = $this->input->post('id'); // local task
        $zoho_crm_id       = $this->input->post('zoho_crm_id'); // local task
        $note_title   = trim($this->input->post('note_title'));
        $note_content = trim($this->input->post('note_content'));

        if (empty($leadid) || empty($note_title) || empty($note_content)) {
            $this->session->set_flashdata('error', 'All fields are required.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $this->load->model('Admin');
        $this->load->model('Zoho_model');

        // Get local lead/task row
        $lead = $this->Admin->get_lead_by_id($leadid);

        if (!$lead) {
            $this->session->set_flashdata('error', 'Lead not found in local database.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        if (empty($lead['zoho_crm_id'])) {
            $this->session->set_flashdata('error', 'Zoho Lead ID not found.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $zoho_lead_id = $lead['zoho_crm_id'];

        // 1) Save locally first
        $noteData = [
            'deal_id'       => $zoho_crm_id, // local lead/task id
            'note_title'    => $note_title,
            'note_content'  => $note_content,
            'zoho_note_id'  => '90',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $local_note_id = $this->Admin->insert_lead_note($noteData);

        if (!$local_note_id) {
            $this->session->set_flashdata('error', 'Failed to save note in local database.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // 2) Get Zoho access token
        $access_token = $this->Zoho_model->get_access_token();

        if (!$access_token) {
            $this->session->set_flashdata('error', 'Note saved locally, but failed to get Zoho access token.');
            redirect(base_url() . "index.php/Admincrm/lead_detail/" . $leadid);
            return;
        }

        // 3) Send note to Zoho
        $zoho_response = $this->Zoho_model->add_lead_note_to_zoho(
            $zoho_crm_id,
            $note_title,
            $note_content,
            $access_token
        );

        if (!empty($zoho_response['success']) && !empty($zoho_response['note_id'])) {
            // 4) Update local note with zoho_note_id
            $this->Admin->update_lead_note_zoho_id($local_note_id, $zoho_response['note_id']);

            $this->session->set_flashdata('success', 'Note created successfully in local database and Zoho.');
            redirect(base_url() . "index.php/Admincrm/lead_detail/" . $leadid);
            return;
        } else {
            $this->session->set_flashdata(
                'error',
                'Note saved locally, but failed to sync to Zoho. ' . ($zoho_response['message'] ?? '')
            );
            redirect(base_url() . "index.php/Admincrm/lead_detail/" . $leadid);
            return;
        }
    }

    show_404();
}

public function add_leads_notes_details2()
{
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        show_404();
        return;
    }

    $leadid       = trim($this->input->post('id')); // local task id
    $note_title   = trim($this->input->post('note_title'));
    $note_content = trim($this->input->post('note_content'));

    echo '<pre>';
    echo "===== CONTROLLER DEBUG START =====\n\n";
    echo "POST DATA:\n";
    print_r($_POST);
    echo "\n";
    echo "leadid: " . $leadid . "\n";
    echo "note_title: " . $note_title . "\n";
    echo "note_content: " . $note_content . "\n\n";

    if ($leadid === '' || $note_title === '' || $note_content === '') {
        echo "ERROR: Required fields missing.\n";
        echo "===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    $this->load->model('Admin');
    $this->load->model('Zoho_model');

    // Get local task/lead row
    $lead = $this->Admin->get_lead_by_id($leadid);

    echo "LOCAL LEAD ROW:\n";
    print_r($lead);
    echo "\n";

    if (!$lead) {
        echo "ERROR: Lead not found in local database.\n";
        echo "===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    $zoho_lead_id = !empty($lead['zoho_crm_id']) ? trim($lead['zoho_crm_id']) : '';

    echo "ZOHO LEAD ID FROM DB: " . $zoho_lead_id . "\n\n";

    if ($zoho_lead_id === '') {
        echo "ERROR: zoho_crm_id is empty in local database.\n";
        echo "===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    // Get access token
    $access_token = $this->Zoho_model->get_access_token();

    echo "ACCESS TOKEN:\n";
    echo $access_token ? $access_token : 'NO TOKEN FOUND';
    echo "\n\n";

    if (!$access_token) {
        echo "ERROR: Failed to get Zoho access token.\n";
        echo "===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    // Send to Zoho first
    $zoho_response = $this->Zoho_model->add_lead_note_to_zoho(
        $zoho_lead_id,
        $note_title,
        $note_content,
        $access_token
    );

    echo "\nZOHO RESPONSE RETURNED TO CONTROLLER:\n";
    print_r($zoho_response);
    echo "\n";

    if (empty($zoho_response['success']) || empty($zoho_response['note_id'])) {
        echo "ERROR: Zoho note creation failed, so local DB insert is skipped.\n";
        echo "===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    $zoho_note_id = $zoho_response['note_id'];

    echo "ZOHO NOTE ID RECEIVED: " . $zoho_note_id . "\n\n";

    // Insert local DB only after Zoho success
    // IMPORTANT:
    // If your notes table uses 'lead_id' instead of 'deal_id', change this line accordingly.
    $noteData = [
        'deal_id'       => $zoho_lead_id,
        'note_title'    => $note_title,
        'note_content'  => $note_content,
        'zoho_note_id'  => $zoho_note_id,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s')
    ];

    echo "LOCAL INSERT DATA:\n";
    print_r($noteData);
    echo "\n";

    $local_note_id = $this->Admin->insert_lead_note($noteData);

    echo "LOCAL NOTE INSERT ID: ";
    print_r($local_note_id);
    echo "\n\n";

    if (!$local_note_id) {
        $db_error = $this->db->error();
        echo "ERROR: Local DB insert failed.\n";
        echo "DB ERROR:\n";
        print_r($db_error);
        echo "\n===== CONTROLLER DEBUG END =====";
        echo '</pre>';
        exit;
    }

    echo "SUCCESS: Note created in Zoho and inserted in local DB.\n";
    echo "===== CONTROLLER DEBUG END =====";
    echo '</pre>';
    exit;
}

public function add_leads_notes_details()
{
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        show_404();
        return;
    }

    $leadid       = trim($this->input->post('id')); // local task id
    $note_title   = trim($this->input->post('note_title'));
    $note_content = trim($this->input->post('note_content'));

    if ($leadid === '' || $note_title === '' || $note_content === '') {
        $this->session->set_flashdata('error', 'All fields are required.');
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    $this->load->model('Admin');
    $this->load->model('Zoho_model');

    // Get local task/lead
    $lead = $this->Admin->get_lead_by_id($leadid);

    if (!$lead || empty($lead['zoho_crm_id'])) {
        $this->session->set_flashdata('error', 'Zoho Lead ID not found.');
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    $zoho_lead_id = trim($lead['zoho_crm_id']);

    // Get access token
    $access_token = $this->Zoho_model->get_access_token();

    if (!$access_token) {
        $this->session->set_flashdata('error', 'Failed to get Zoho access token.');
        redirect(base_url("index.php/Admincrm/lead_detail/" . $leadid));
        return;
    }

    // 1) Create note in Zoho
    $zoho_response = $this->Zoho_model->add_lead_note_to_zoho(
        $zoho_lead_id,
        $note_title,
        $note_content,
        $access_token
    );

    if (empty($zoho_response['success']) || empty($zoho_response['note_id'])) {
        $this->session->set_flashdata(
            'error',
            'Failed to create note in Zoho. ' . ($zoho_response['message'] ?? '')
        );
        redirect(base_url("index.php/Admincrm/lead_detail/" . $leadid));
        return;
    }

    $zoho_note_id = $zoho_response['note_id'];

    // 2) Insert into local DB
    $noteData = [
        // ⚠️ Change to 'lead_id' if your table uses that instead of deal_id
        'deal_id'       => $zoho_lead_id,
        'note_title'    => $note_title,
        'note_content'  => $note_content,
        'zoho_note_id'  => $zoho_note_id,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s')
    ];

    $local_note_id = $this->Admin->insert_lead_note($noteData);

    if (!$local_note_id) {
        $this->session->set_flashdata(
            'error',
            'Zoho note created, but failed to save in local database.'
        );
        redirect(base_url("index.php/Admincrm/lead_detail/" . $leadid));
        return;
    }

    $this->session->set_flashdata('success', 'Note created successfully.');
    redirect(base_url("index.php/Admincrm/lead_detail/" . $leadid));
}

public function update_lead_note_zoho_id($local_note_id, $zoho_note_id)
{
    return $this->db
        ->where('id', $local_note_id)
        ->update('lead_notes', [
            'zoho_note_id' => $zoho_note_id,
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
}
    
    public function update_attachments_lead()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $ID = $this->input->post('id');
            date_default_timezone_set('Asia/Dubai');
            $date = date("Y-m-d h:i:sA");
            $note = $this->input->post('note');
            $file_name = null; // Initialize default value
    
            // Upload Image
            if (!empty($_FILES['image']['name'])) 
            {
                $new_filename = date("YmdGis");
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
                $config['upload_path']   = './uploads/delivery_proof/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                $config['max_size']      = 16000; // 16MB max
                $config['file_name']     = $new_filename . '.' . $ext;
                $config['overwrite']     = FALSE;
            
                $this->load->library('upload', $config);
            
                if (!$this->upload->do_upload('image')) 
                {
                    $error = $this->upload->display_errors();
                    die("Upload Error: " . $error);
                } 
                else 
                {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                    $file_path = $upload_data['full_path'];
            
                    // Image compression settings
                    $this->load->library('image_lib');
            
                    $resize_config = [
                        'image_library'  => 'gd2',
                        'source_image'   => $file_path,
                        'new_image'      => $file_path, // overwrite same file
                        'quality'        => '50',       // Aggressive compression (try 25-40)
                        'maintain_ratio' => TRUE,
                        'overwrite'      => TRUE,
                        'width'          => 1024,       // Optional max width
                        'height'         => 768         // Optional max height
                    ];
            
                    $this->image_lib->clear();
                    $this->image_lib->initialize($resize_config);
            
                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    }
                }
            }

    
            $edit = array(
                'Delivery_Image' => $file_name,
                'Delivery_Done_Date' => $date,
                'Delivery_Status' => 'Delivered',
                'Delivery_Person_Note' => $note
            );
    
            $update = $this->Admin->update_delivery_detail($edit, $ID);
            if ($update) {
                redirect(base_url() . "index.php/Delivery/delivery_detail/" . $ID);
            }
        }
    }
    
    public function create_deals()
    {
  
        $data = [];
		$data['render'] = "Deals/Create_Deal";

        $data['title'] = "Create Deal";
        $data['breadcrumbs'] = [
            ['label' => 'Deals'],
            ['label' => 'Create New Deal']
        ];
        
        $this->load->view('layout/layout', $data);
        
    }
    
    public function create_quotation()
    {


  
        $data = [];
		$data['render'] = "Deals/Create_Quotation";

        $data['title'] = "Create Quotation";
        $data['breadcrumbs'] = [
            ['label' => 'Quotations'],
            ['label' => 'Create New Quotation']
        ];
        
        $this->load->view('layout/layout', $data);
        
    }

    public function all_quotations()
    {

        $zoho_user_id = $this->session->userdata('admin_id');

        if($this->rbac->can('leads.manage.agents')){

            $data = [];
		    $data['records'] = $this->Admin->get_all_sales_quotations($zoho_user_id);
        
        }
        else{

            $data = [];
		    $data['records'] = $this->Admin->get_all_quotations();

        }

        $data['title'] = "All Quotations";
        $data['breadcrumbs'] = [
            ['label' => 'Quotations'],
            ['label' => 'View All Quotations']
        ];

        $data['render'] = "Deals/All_Quotations";
        $this->load->view('layout/layout', $data);
        
    }



    public function add_proposal1()
{
    header('Content-Type: application/json');

    $post = json_decode($this->input->raw_input_stream, true);

    if (!$post) {
        echo json_encode([
            'success' => false,
            'error'   => 'No data received.'
        ]);
        return;
    }

    if (empty($post['dealNumber']) || empty($post['subject'])) {
        echo json_encode([
            'success' => false,
            'error'   => 'Deal Number and Subject are required.'
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

    $this->db->trans_begin();

    try {
        $proposalData = [
            'deal_number'       => $post['dealNumber'],
            'subject'           => $post['subject'],
            'kind_attention'    => $post['kind_attention'] ?? null,
            'project_name'      => $post['project'] ?? null,
            'terms_of_payment'  => $post['termsOfPayment'] ?? null,
            'specification'     => $post['specification'] ?? null,
            'general_exclusion' => $post['generalExclusion'] ?? null,
            'brand'             => $post['brand'] ?? null,
            'warranty'          => $post['warranty'] ?? null,
            'delivery'          => $post['delivery'] ?? null,
            'notes'             => $post['notes'] ?? null,
            'valid_until'       => $post['validUntil'] ?? null,
            'sub_total'         => $post['subTotal'] ?? 0,
            'discount'          => $post['discount'] ?? 0,
            'adjustment'        => $post['adjustment'] ?? 0,
            'grand_total'       => $post['grandTotal'] ?? 0,
            'created_at'        => date('Y-m-d H:i:s')
        ];

        $this->db->insert('proposals', $proposalData);
        $proposalId = $this->db->insert_id();

        foreach ($post['items'] as $item) {
            $itemData = [
                'proposal_id'      => $proposalId,
                'product_id'       => $item['product_id'] ?? null,
                'product_name'     => $item['product_name'] ?? null,
                'item_name'        => $item['itemName'] ?? null,
                'item_description' => $item['itemDescription'] ?? null,
                'uom'              => $item['uom'] ?? null,
                'quantity'         => $item['quantity'] ?? 0,
                'unit_price'       => $item['unitPrice'] ?? 0,
                'item_discount'    => $item['itemDiscount'] ?? 0,
                'total'            => $item['total'] ?? 0,
                'created_at'       => date('Y-m-d H:i:s')
            ];

            $this->db->insert('proposal_items', $itemData);
        }

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Database error while saving proposal.');
        }

        $this->db->trans_commit();

        echo json_encode([
            'success' => true,
            'message' => 'Proposal created successfully.',
            'id'      => $proposalId
        ]);
    } catch (Exception $e) {
        $this->db->trans_rollback();

        echo json_encode([
            'success' => false,
            'error'   => $e->getMessage()
        ]);
    }
}

    public function add_proposal2()
{
    header('Content-Type: application/json');

    $raw = $this->input->raw_input_stream;
    $post = json_decode($raw, true);

    echo json_encode([
        'success' => true,
        'raw' => $raw,
        'decoded' => $post
    ]);
}


   

    private function create_zoho_quote_for_task($task, $quoteMaster, $quoteItems)
    {
        $accessToken = $this->Zoho_model->get_access_token();

        if (!$accessToken) {
            return ['success' => false, 'error' => 'Zoho access token not found.'];
        }

        $headers = [
            'Authorization: Zoho-oauthtoken ' . $accessToken,
            'Content-Type: application/json'
        ];

        // Optional: create / find contact for quote
        $contactId = $this->get_or_create_quote_contact($task, $quoteMaster, $headers);

        $lineItems = [];
        foreach ($quoteItems as $item) {
            if (empty($item['product_id'])) {
                return [
                    'success' => false,
                    'error'   => 'Each quote item must have a valid Zoho Product ID.'
                ];
            }

            $line = [
                // For many Zoho CRM inventory APIs, line items are passed with product ID + quantity + list price etc.
                'product'             => ['id' => (string)$item['product_id']],
                'quantity'            => (float)$item['quantity'],
                'list_price'          => (float)$item['unit_price'],
                'discount'            => (float)$item['item_discount'],
                'product_description' => $item['item_description'] ?? ''
            ];

            // Keep this only if U_O_M is an actual custom line-item API field in your org
            if (!empty($item['uom'])) {
                $line['U_O_M'] = $item['uom'];
            }

            $lineItems[] = $line;
        }

        $quoteData = [
            'Subject'            => $quoteMaster['subject'],
            'Deal_Name'          => ['id' => (string)$task['zoho_crm_id']],
            'Project'            => $quoteMaster['project_name'] ?: null,
            'Terms_of_Payment'   => $quoteMaster['terms_of_payment'] ?: null,
            'Specification'      => $quoteMaster['specification'] ?: null,
            'General_Exclusion'  => $quoteMaster['general_exclusion'] ?: null,
            'Brand'              => $quoteMaster['brand'] ?: null,
            'Warranty'           => $quoteMaster['warranty'] ?: null,
            'Delivery'           => $quoteMaster['delivery'] ?: null,
            'Valid_Till'         => !empty($quoteMaster['valid_until']) ? date('Y-m-d', strtotime($quoteMaster['valid_until'])) : null,
            'Terms_and_Conditions'=> $quoteMaster['notes'] ?: null,

            // Keep this key if your org accepts Quoted_Items.
            // If your org’s Quote create API expects Product_Details instead, change ONLY this key.
            'Quoted_Items'       => $lineItems
        ];

        if (!empty($contactId)) {
            $quoteData['Contact_Name'] = ['id' => (string)$contactId];
        }

        // remove nulls
        $quoteData = array_filter($quoteData, function ($v) {
            return $v !== null && $v !== '';
        });

        $payload = json_encode(['data' => [$quoteData]]);

        $response = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Quotes',
            $headers,
            $payload,
            'POST'
        );

        $body = json_decode($response['body'], true);

        if (($response['http_code'] == 200 || $response['http_code'] == 201) && !empty($body['data'][0]['details']['id'])) {
            $zohoQuoteId = $body['data'][0]['details']['id'];

            // Fetch full quote to get Quote_No
            $quoteView = $this->execute_curl_request(
                'https://www.zohoapis.com/crm/v2.1/Quotes/' . $zohoQuoteId,
                $headers,
                null,
                'GET'
            );

            $quoteViewBody = json_decode($quoteView['body'], true);

            return [
                'success'           => true,
                'zoho_quote_id'     => $zohoQuoteId,
                'zoho_quote_number' => $quoteViewBody['data'][0]['Quote_No'] ?? null
            ];
        }

        return [
            'success' => false,
            'error'   => !empty($body) ? json_encode($body) : 'Failed to create quote in Zoho.'
        ];
    }

    private function get_or_create_quote_contact($task, $quoteMaster, $headers)
    {
        $email = !empty($task['customer_email']) ? trim($task['customer_email']) : '';
        $name  = !empty($quoteMaster['kind_attention']) ? trim($quoteMaster['kind_attention']) : (!empty($task['customer_name']) ? trim($task['customer_name']) : '');

        // 1) Search by email first
        if ($email !== '') {
            $searchEmail = $this->execute_curl_request(
                'https://www.zohoapis.com/crm/v2.1/Contacts/search?email=' . rawurlencode($email),
                $headers,
                null,
                'GET'
            );

            $emailBody = json_decode($searchEmail['body'], true);
            if (!empty($emailBody['data'][0]['id'])) {
                return $emailBody['data'][0]['id'];
            }
        }

        // 2) Search by Last_Name
        if ($name !== '') {
            $searchName = $this->execute_curl_request(
                'https://www.zohoapis.com/crm/v2.1/Contacts/search?criteria=(Last_Name:equals:' . rawurlencode($name) . ')',
                $headers,
                null,
                'GET'
            );

            $nameBody = json_decode($searchName['body'], true);
            if (!empty($nameBody['data'][0]['id'])) {
                return $nameBody['data'][0]['id'];
            }
        }

        // 3) Create contact if still not found
        if ($name === '') {
            return null;
        }

        $contactPayload = json_encode([
            'data' => [[
                'Last_Name' => $name,
                'Email'     => $email ?: null,
                'Phone'     => $task['customer_contact'] ?? null
            ]]
        ]);

        $create = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Contacts',
            $headers,
            $contactPayload,
            'POST'
        );

        $createBody = json_decode($create['body'], true);

        if (($create['http_code'] == 200 || $create['http_code'] == 201) && !empty($createBody['data'][0]['details']['id'])) {
            return $createBody['data'][0]['details']['id'];
        }

        return null;
    }
    
    public function create_item()
    {
  
        $data = [];
		$data['render'] = "Deals/Create_Item";

        $data['title'] = "Create Item";
        $data['breadcrumbs'] = [
            ['label' => 'Items'],
            ['label' => 'Create New Item']
        ];
        
        $this->load->view('layout/layout', $data);
        
    }

public function test_custommodule7_fields()
	{
    	$this->load->model('Zoho_model');
    	$fields = $this->Zoho_model->get_module_fields('CustomModule7');

    	echo '<pre>';
    	print_r($fields);
    	exit;
	}

    public function update_status1()
    {
        if (!$this->input->post('submit_update')) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $status = trim($this->input->post('status'));
        $service_charge = trim($this->input->post('service_charge'));
        $zohoId = trim($this->input->post('zoho_id'));
        date_default_timezone_set('Asia/Dubai');
        $status_change_date = date('Y-m-d H:i:s');

        // 1️⃣ Prepare update data for ERP first
        $updateData = [
            'status'         => $status,
            'service_charge' => $service_charge
        ];

        // ✅ Only update the matching date column
        if ($status == 'Qualification') {
            $updateData['qual_deal_date'] = $status_change_date;
        }
        else if ($status == 'Site Visit') {
            $updateData['site_deal_date'] = $status_change_date;
        }
        else if ($status == 'Proposal/Price Quote') {
            $updateData['quote_deal_date'] = $status_change_date;
        }
        else if ($status == 'Closed Won') {
            $updateData['job_deal_date'] = $status_change_date;
        }
        else if ($status == 'Closed Lost' || $status == 'Omitted' || $status == 'Proposal Omitted') {
            $updateData['lost_deal_date'] = $status_change_date;
        }


        if (empty($status) || empty($zohoId)) {
            show_error('Invalid request', 400);
        }

        // ✅ Allowed Zoho values
        $allowedZohoStatuses = [
            'Qualification',
            'Site Visit',
            'Proposal/Price Quote',
            'Closed Won',
            'Closed Lost',
            'Omitted',
            'Proposal Omitted'
        ];

        // ✅ Map ERP-only values if ever added
        $statusMap = [
            'Big Project' => 'Proposal'
        ];

        $zohoStatus = $statusMap[$status] ?? $status;

        if (!in_array($zohoStatus, $allowedZohoStatuses, true)) {
            log_message('error', 'Invalid Zoho status blocked: ' . $zohoStatus);
            redirect($_SERVER['HTTP_REFERER']);
        }

        // 1️⃣ Update ERP first
        $this->db
            ->where('zoho_crm_id', $zohoId)
            ->update('tasks', $updateData);

        // 2️⃣ Update Zoho
        $this->load->model('Zoho_model');

        $resp = $this->Zoho_model->update_vz_app_status(
            $zohoId,
            $zohoStatus,
            $service_charge
        );

        log_message('info', 'Zoho status update response: ' . json_encode($resp));

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_status2()
{
    if (!$this->input->post('submit_update')) {
        redirect($_SERVER['HTTP_REFERER']);
    }

    $status = trim($this->input->post('status'));
    $service_charge = trim($this->input->post('service_charge'));
    $zohoId = trim($this->input->post('zoho_id'));

    if (empty($status) || empty($zohoId)) {
        show_error('Invalid request', 400);
    }

    date_default_timezone_set('Asia/Dubai');
    $status_change_date = date('Y-m-d H:i:s');

    // ✅ Allowed Zoho values
    $allowedZohoStatuses = [
        'Qualification',
        'Site Visit',
        'Proposal/Price Quote',
        'Closed Won',
        'Closed Lost',
        'Omitted',
        'Proposal Omitted'
    ];

    // ✅ Map ERP-only values if ever added
    $statusMap = [
        'Big Project' => 'Proposal/Price Quote'
    ];

    $zohoStatus = $statusMap[$status] ?? $status;

    if (!in_array($zohoStatus, $allowedZohoStatuses, true)) {
        log_message('error', 'Invalid Zoho status blocked: ' . $zohoStatus);
        redirect($_SERVER['HTTP_REFERER']);
    }

    // ✅ Base update data
    $updateData = [
        'status' => $status
    ];

    // ✅ Update service_charge only if sent
    if ($service_charge !== '') {
        $updateData['service_charge'] = $service_charge;
    }

    // ✅ Only update the matching date column
    if ($status == 'Qualification') {
        $updateData['qual_deal_date'] = $status_change_date;
    }
    else if ($status == 'Site Visit') {
        $updateData['site_deal_date'] = $status_change_date;
    }
    else if ($status == 'Proposal/Price Quote') {
        $updateData['quote_deal_date'] = $status_change_date;
    }
    else if ($status == 'Closed Won') {
        $updateData['job_deal_date'] = $status_change_date;
    }
    else if ($status == 'Closed Lost' || $status == 'Omitted' || $status == 'Proposal Omitted') {
        $updateData['lost_deal_date'] = $status_change_date;
    }

    // ✅ Update ERP first
    $this->db->where('zoho_crm_id', $zohoId);
    $this->db->update('tasks', $updateData);

    // ✅ Update Zoho
    $this->load->model('Zoho_model');

    $resp = $this->Zoho_model->update_vz_app_status(
        $zohoId,
        $zohoStatus,
        $service_charge
    );

    log_message('info', 'Zoho status update response: ' . json_encode($resp));

    redirect($_SERVER['HTTP_REFERER']);
}

public function update_status3()
{
    if (!$this->input->post('submit_update')) {
        redirect($_SERVER['HTTP_REFERER']);
    }

    $status = trim($this->input->post('status'));
    $service_charge = trim($this->input->post('service_charge'));
    $zohoId = trim($this->input->post('zoho_id'));

    if (empty($status) || empty($zohoId)) {
        show_error('Invalid request', 400);
    }

    date_default_timezone_set('Asia/Dubai');
    $status_change_date = date('Y-m-d H:i:s');

    $allowedZohoStatuses = [
        'Qualification',
        'Site Visit',
        'Proposal/Price Quote',
        'Closed Won',
        'Closed Lost',
        'Omitted',
        'Proposal Omitted'
    ];

    $statusMap = [
        'Big Project' => 'Proposal/Price Quote'
    ];

    $zohoStatus = $statusMap[$status] ?? $status;

    if (!in_array($zohoStatus, $allowedZohoStatuses, true)) {
        log_message('error', 'Invalid Zoho status blocked: ' . $zohoStatus);
        redirect($_SERVER['HTTP_REFERER']);
    }

    $updateData = [
        'status' => $status
    ];

    if ($service_charge !== '') {
        $updateData['service_charge'] = $service_charge;
    }

    if ($status == 'Qualification') {
        $updateData['qual_deal_date'] = $status_change_date;
    }
    else if ($status == 'Site Visit') {
        $updateData['site_deal_date'] = $status_change_date;
    }
    else if ($status == 'Proposal/Price Quote') {
        $updateData['quote_deal_date'] = $status_change_date;
    }
    else if ($status == 'Closed Won') {
        $updateData['job_deal_date'] = $status_change_date;
    }
    else if ($status == 'Closed Lost' || $status == 'Omitted' || $status == 'Proposal Omitted') {
        $updateData['lost_deal_date'] = $status_change_date;
    }

    log_message('info', 'Local status update data: ' . json_encode($updateData));

    $this->db->where('zoho_crm_id', $zohoId);
    $this->db->update('tasks', $updateData);

    $this->load->model('Zoho_model');

    $resp = $this->Zoho_model->update_vz_app_status(
        $zohoId,
        $zohoStatus,
        $service_charge
    );

    log_message('info', 'Zoho status update response: ' . json_encode($resp));

    redirect($_SERVER['HTTP_REFERER']);
}

public function update_status()
{
    if (!$this->input->post('submit_update')) {
        redirect($_SERVER['HTTP_REFERER']);
    }

    $status         = trim($this->input->post('status'));
    $service_charge = trim($this->input->post('service_charge'));
    $zohoId         = trim($this->input->post('zoho_id'));

    if (empty($status) || empty($zohoId)) {
        show_error('Invalid request', 400);
    }

    date_default_timezone_set('Asia/Dubai');
    $status_change_date = date('Y-m-d H:i:s');

    $allowedZohoStatuses = [
        'Qualification',
        'Site Visit',
        'Proposal/Price Quote',
        'Closed Won',
        'Closed Lost',
        'Omitted',
        'Proposal Omitted'
    ];

    $statusMap = [
        'Big Project' => 'Proposal/Price Quote'
    ];

    $zohoStatus = $statusMap[$status] ?? $status;

    if (!in_array($zohoStatus, $allowedZohoStatuses, true)) {
        log_message('error', 'Invalid Zoho status blocked: ' . $zohoStatus);
        redirect($_SERVER['HTTP_REFERER']);
    }

    $updateData = [
        'status'     => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($service_charge !== '') {
        $updateData['service_charge'] = $service_charge;
    }

    if ($status === 'Qualification') {
        $updateData['qual_deal_date'] = $status_change_date;
    } elseif ($status === 'Site Visit') {
        $updateData['site_deal_date'] = $status_change_date;
    } elseif ($status === 'Proposal/Price Quote' || $status === 'Big Project') {
        $updateData['quote_deal_date'] = $status_change_date;
    } elseif ($status === 'Closed Won') {
        $updateData['job_deal_date'] = $status_change_date;
    } elseif ($status === 'Closed Lost' || $status === 'Omitted' || $status === 'Proposal Omitted') {
        $updateData['lost_deal_date'] = $status_change_date;
    }

    log_message('info', 'Local status update data: ' . json_encode($updateData));

    $this->db->where('zoho_crm_id', $zohoId);
    $this->db->update('tasks', $updateData);



    $this->load->model('Zoho_model');

    $resp = $this->Zoho_model->update_vz_app_status(
        $zohoId,
        $zohoStatus,
        $service_charge
    );

    log_message('info', 'Zoho status update response: ' . json_encode($resp));

    $deal = [];
    $maxAttempts = 10;
    $waitSeconds = 2;

    for ($i = 1; $i <= $maxAttempts; $i++) {
        $dealResp = $this->Zoho_model->get_deal_by_id($zohoId);
        $deal = $dealResp['data'][0] ?? [];

        log_message('info', 'Zoho fetch attempt ' . $i . ': ' . json_encode($deal));

        if (!empty($deal)) {
            $currentStatusNumberReady = false;

            if ($zohoStatus === 'Qualification' && !empty($deal['QualDealNumber'])) {
                $currentStatusNumberReady = true;
            } elseif ($zohoStatus === 'Site Visit' && !empty($deal['SiteDealNumber'])) {
                $currentStatusNumberReady = true;
            } elseif ($zohoStatus === 'Proposal/Price Quote' && !empty($deal['QuoteDealNumber'])) {
                $currentStatusNumberReady = true;
            } elseif ($zohoStatus === 'Closed Won' && !empty($deal['JobDealNumber'])) {
                $currentStatusNumberReady = true;
            } elseif (
                !empty($deal['QualDealNumber']) ||
                !empty($deal['SiteDealNumber']) ||
                !empty($deal['QuoteDealNumber']) ||
                !empty($deal['JobDealNumber'])
            ) {
                $currentStatusNumberReady = true;
            }

            if ($currentStatusNumberReady) {
                break;
            }
        }

        sleep($waitSeconds);
    }

    if (!empty($deal)) {
        $syncData = [
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($deal['DealNumber'])) {
            $syncData['deal_number'] = $deal['DealNumber'];
        }

        if (!empty($deal['QualDealNumber'])) {
            $syncData['qual_deal_number'] = $deal['QualDealNumber'];
        }

        if (!empty($deal['SiteDealNumber'])) {
            $syncData['site_deal_number'] = $deal['SiteDealNumber'];
        }

        if (!empty($deal['QuoteDealNumber'])) {
            $syncData['quote_deal_number'] = $deal['QuoteDealNumber'];
        }

        if (!empty($deal['JobDealNumber'])) {
            $syncData['job_deal_number'] = $deal['JobDealNumber'];
        }

        if (!empty($deal['Qual_Deal_Date'])) {
            $syncData['qual_deal_date'] = $this->formatZohoTime($deal['Qual_Deal_Date']);
        }

        if (!empty($deal['Site_Deal_Date'])) {
            $syncData['site_deal_date'] = $this->formatZohoTime($deal['Site_Deal_Date']);
        }

        if (!empty($deal['Quote_Deal_Date'])) {
            $syncData['quote_deal_date'] = $this->formatZohoTime($deal['Quote_Deal_Date']);
        }

        if (!empty($deal['Job_Date'])) {
            $syncData['job_deal_date'] = $this->formatZohoTime($deal['Job_Date']);
        }

        log_message('info', 'Final Zoho sync data: ' . json_encode($syncData));

        if (count($syncData) > 1) {
            $this->db->where('zoho_crm_id', $zohoId);
            $this->db->update('tasks', $syncData);
        }
    } else {
        log_message('error', 'Failed to fetch updated Zoho deal after retries. Zoho ID: ' . $zohoId);
    }

    redirect($_SERVER['HTTP_REFERER']);
}

    public function lead_fields()
    {
        
        $this->load->model('Task_model');
        $fields = $this->Task_model->get_all_lead_fields();

        if (empty($fields)) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'No lead fields found in database'
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'data' => $fields
            ]));
    }

    /*** Download Quote PDF View Test ***/

    public function download_deal_pdf1($id) {
	//	$this->check_logged_in();
	
		$username = $this->session->userdata('username');
		$user = $this->User_model->get_user_by_username($username);
		if (!$user) {
			show_error('User not found', 404);
			return;
		}
		
		$sale_name = isset($user['sale_name']) ? $user['sale_name'] : null;
	
		$company = isset($user['company']) ? $user['company'] : null;
	
		$data['task'] = $this->Task_model->get_task($id);
		if (!$data['task']) {
			show_error('Task not found', 404);
			return;
		}
	
		$quote_number = $data['task']['quote_number'] ?? null;
        $task_id_tasks = $data['task']['id'] ?? null;
	
		// Initialize items array
		$data['items'] = [];
	
		// For VOLTRONIX CONTRACTING LLC, fetch from tasks first, then proposal_items
		if ($company === 'VOLTRONIX CONTRACTING LLC') {
			// Fetch single item from tasks table if product_name exists
			$task_items = $this->Task_model->get_task_items($id);
			if (!empty($task_items)) {
				$data['items'] = array_merge($data['items'], $task_items);
			}
	
			// Fetch additional items from proposal_items table
			$proposal_items = $this->Proposal_model->get_proposal_items($quote_number);
			if (!empty($proposal_items)) {
				$data['items'] = array_merge($data['items'], $proposal_items);
			}
		} else {
			// For other companies (e.g., VOLTRONIX SWITCHGEAR LLC), use only proposal_items
			$data['items'] = $this->Proposal_model->get_proposal_items($quote_number);
		}
	
		// Calculate totals
		$totalAmount = 0;
		$vatAmount = 0;
		$grandTotal = 0;
		foreach ($data['items'] as $item) {
			$serviceCharge = (float)($item['service_charge'] ?? 0);
			$quantity = (float)($item['quantity'] ?? 0);
			$itemDiscount = (float)($item['item_discount'] ?? 0);
			$itemTotal = $quantity * $serviceCharge * (1 - $itemDiscount / 100); // Apply discount if present
			$totalAmount += $itemTotal;
			$vatAmount += $itemTotal * 0.05; // 5% VAT
			$grandTotal += $itemTotal * 1.05; // Total including VAT
		}
		$data['totalAmount'] = $totalAmount;
		$data['vatAmount'] = $vatAmount;
		$data['grandTotal'] = $grandTotal;
	
		$data['username'] = $username;
		$data['sale_name'] = $sale_name;
	
		// Select view based on company
		$company_views = [
			'VOLTRONIX CONTRACTING LLC' => 'quotes/quote_contracting',
			'VOLTRONIX SWITCHGEAR LLC' => 'quotes/quote_switchgear',
		];
		$view = isset($company_views[$company]) ? $company_views[$company] : 'quotes/quote_contracting';
	
		// Configure mPDF based on company
		if ($company === 'VOLTRONIX CONTRACTING LLC') {
			$mpdf = new \Mpdf\Mpdf([
				'margin_top' => 35,
				'margin_bottom' => 20,
				'margin_left' => 4,
				'margin_right' => 4,
				'mode' => 'utf-8',
				'format' => 'A4',
				'autoPageBreak' => true,
			]);
			$backgroundImage = base_url('assets/photos/logo/databg.png');
			$mpdf->SetDefaultBodyCSS('background', "url('{$backgroundImage}')");
			$mpdf->SetDefaultBodyCSS('background-image-resize', 1);
			// Set PDF title
			$mpdf->SetTitle("Quotation - {$quote_number} - VOLTRONIX CONTRACTING LLC");
		} elseif ($company === 'VOLTRONIX SWITCHGEAR LLC') {
			$mpdf = new \Mpdf\Mpdf([
				'margin_top' => 35,
				'margin_bottom' => 35,
				'margin_left' => 2,
				'margin_right' => 2,
				'mode' => 'utf-8',
				'format' => [215, 280],
				'autoPageBreak' => false,
			]);
			$backgroundImage = base_url('assets/photos/logo/switchgear_bg4.png');
			log_message('info', "backgroundImage: {$backgroundImage}");
			$mpdf->SetDefaultBodyCSS('background', "url('{$backgroundImage}')");
			$mpdf->SetDefaultBodyCSS('background-image-resize', 1);
			// Set PDF title
			$mpdf->SetTitle("Quotation - {$quote_number} - VOLTRONIX SWITCHGEAR LLC");
		} else {
            // Default case: use settings similar to VOLTRONIX CONTRACTING LLC
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 35,
                'margin_bottom' => 20,
                'margin_left' => 4,
                'margin_right' => 4,
                'mode' => 'utf-8',
                'format' => 'A4',
                'autoPageBreak' => true,
            ]);
            $backgroundImage = base_url('assets/photos/logo/databg.png');
            $mpdf->SetDefaultBodyCSS('background', "url('{$backgroundImage}')");
            $mpdf->SetDefaultBodyCSS('background-image-resize', 1);
        }
	
		ob_start();
		$this->load->view($view, $data);
		$html = ob_get_contents();
		ob_end_clean();
	
		$mpdf->WriteHTML($html);
	
		$filename = 'quote_' . $data['task']['quote_number'] . '.pdf';
		$mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
	}

public function download_deal_pdf($id)
{
    // Optional login check
    // $this->check_logged_in();

    $username = $this->session->userdata('admin_name');
  //  $user = $this->Task_model->get_user_by_username($username);
    $user = $this->Task_model->get_task_assigned_agent($id);

    if (!$user) {
        show_error('User not found', 404);
        return;
    }

    $task = $this->Task_model->get_task($id);
    if (!$task) {
        show_error('Task not found', 404);
        return;
    }

    $quoteNumber = !empty($task['quote_number']) ? $task['quote_number'] : null;

    if (empty($quoteNumber)) {
        show_error('Quotation number not found for this task.', 404);
        return;
    }

    $company   = !empty($user['company']) ? trim($user['company']) : '';
    $saleName  = !empty($user['sale_name']) ? $user['sale_name'] : '';
    $items     = [];

    /**
     * Fetch quotation items
     * Priority:
     * 1. proposal_items by quote number
     * 2. fallback task item(s) if needed
     */
    $proposalItems = $this->Proposal_model->get_proposal_items($quoteNumber);

    if (!empty($proposalItems)) {
        $items = $proposalItems;
    } else {
        // Fallback in case old-style task item exists
        $taskItems = $this->Task_model->get_task_items($id);
        if (!empty($taskItems)) {
            $items = $taskItems;
        }
    }

    if (empty($items)) {
        show_error('No quotation items found for this quotation.', 404);
        return;
    }

    // Calculate totals
    $subTotal   = 0;
    $vatRate    = 5;
    $vatAmount  = 0;
    $grandTotal = 0;

    foreach ($items as &$item) {
        $qty          = isset($item['quantity']) ? (float)$item['quantity'] : 0;
        $unitPrice    = isset($item['service_charge']) ? (float)$item['service_charge'] : 0;
        $discount     = isset($item['item_discount']) ? (float)$item['item_discount'] : 0;

        $lineTotal = $qty * $unitPrice;

        if ($discount > 0) {
            $lineTotal = $lineTotal - (($lineTotal * $discount) / 100);
        }

        $item['line_total'] = $lineTotal;
        $subTotal += $lineTotal;
    }

    unset($item);

    $vatAmount  = ($subTotal * $vatRate) / 100;
    $grandTotal = $subTotal + $vatAmount;

    $data = [
        'task'        => $task,
        'items'       => $items,
        'username'    => $username,
        'sale_name'   => $saleName,
        'company'     => $company,
        'subTotal'    => $subTotal,
        'vatRate'     => $vatRate,
        'vatAmount'   => $vatAmount,
        'grandTotal'  => $grandTotal,
        'quoteNumber' => $quoteNumber,
    ];

    /**
     * Select quotation view by company
     */
    $companyViews = [
        'VOLTRONIX CONTRACTING LLC' => 'quotes/quote_contracting',
        'VOLTRONIX SWITCHGEAR LLC'  => 'quotes/quote_switchgear',
        // Add your new CRM company layouts here if needed
        // 'FORMONIX TRADING LLC' => 'quotes/quote_formonix',
    ];

    $view = isset($companyViews[$company]) ? $companyViews[$company] : 'quotes/quote_contracting';

    /**
     * mPDF configuration by company
     */
    $tempDir = FCPATH . 'uploads/mpdf_temp';  
    try {
        if ($company === 'VOLTRONIX SWITCHGEAR LLC') {
            $mpdf = new \Mpdf\Mpdf([
                'mode'            => 'utf-8',
                'format'          => [215, 280],
                'margin_top'      => 35,
                'margin_bottom'   => 35,
                'margin_left'     => 2,
                'margin_right'    => 2,
                'autoPageBreak'   => false,
                'tempDir' => $tempDir,
            ]);

            $backgroundImage = FCPATH . 'assets/photos/logo/switchgear_bg4.png';
            if (file_exists($backgroundImage)) {
                $mpdf->SetDefaultBodyCSS('background', "url('" . base_url('assets/photos/logo/switchgear_bg4.png') . "')");
                $mpdf->SetDefaultBodyCSS('background-image-resize', 1);
            }

            $mpdf->SetTitle("Quotation - {$quoteNumber} - {$company}");
        } else {
            // Default / Contracting / New CRM standard
            $mpdf = new \Mpdf\Mpdf([
                'mode'            => 'utf-8',
                'format'          => 'A4',
                'margin_top'      => 35,
                'margin_bottom'   => 20,
                'margin_left'     => 4,
                'margin_right'    => 4,
                'autoPageBreak'   => true,
                'tempDir' => $tempDir,
            ]);

            $backgroundImage = FCPATH . 'assets/photos/logo/databg.png';
            if (file_exists($backgroundImage)) {
                $mpdf->SetDefaultBodyCSS('background', "url('" . base_url('assets/photos/logo/databg.png') . "')");
                $mpdf->SetDefaultBodyCSS('background-image-resize', 1);
            }

            $mpdf->SetTitle("Quotation - {$quoteNumber} - {$company}");
        }

        $html = $this->load->view($view, $data, true);

        $mpdf->WriteHTML($html);

        $filename = 'quotation_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $quoteNumber) . '.pdf';

        // For force download use DOWNLOAD instead of INLINE
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);

    } catch (\Exception $e) {
        log_message('error', 'Quotation PDF generation failed: ' . $e->getMessage());
        show_error('Unable to generate quotation PDF at the moment.', 500);
    }
}

/*** End Deal Quote PDF ***/

/*** Proposal Test Creation ***/

public function get_products()
{
    header('Content-Type: application/json');

    $query = trim($this->input->get('q'));

    $access_token = $this->Zoho_model->get_access_token();

    if (!$access_token) {
        echo json_encode([
            'success' => false,
            'error'   => 'Zoho access token not found.'
        ]);
        return;
    }

    $headers = [
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/json'
    ];

    // IMPORTANT:
    // Try Products first because your quote creation uses product_id.
    // If your Zoho org really stores these in Items, I will give that version too below.
    $url = "https://www.zohoapis.com/crm/v2.1/Products?fields=Product_Name,Description,Unit_Price";

    $response = $this->execute_curl_request($url, $headers, null, 'GET');

    log_message('error', 'Zoho Products raw response: ' . print_r($response, true));

    $body = json_decode($response['body'], true);

    log_message('error', 'Zoho Products decoded body: ' . print_r($body, true));

    if (!isset($body['data'])) {
        echo json_encode([
            'success' => false,
            'error'   => 'Zoho response does not contain data.',
            'details' => $body
        ]);
        return;
    }

    $products = [];

    foreach ($body['data'] as $product) {
        $name = $product['Product_Name'] ?? '';
        $description = $product['Description'] ?? '';
        $unit_price = $product['Unit_Price'] ?? 0;
        $id = $product['id'] ?? '';

        if ($query !== '' && stripos($name, $query) === false) {
            continue;
        }

        $products[] = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'unit_price' => $unit_price
        ];
    }

    echo json_encode([
        'success' => true,
        'products' => $products,
        'more_records' => false,
        'count' => count($products)
    ]);
}

public function add_proposal()
{
    try {
        log_message('error', '=== add_proposal called ===');

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

        if (empty($post['dealNumber'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Deal Number is required.'
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

        $task = $this->Task_model->get_task_by_deal_number($post['dealNumber']);
        log_message('error', 'Task found: ' . print_r($task, true));

        if (!$task) {
            echo json_encode([
                'success' => false,
                'error'   => 'Deal not found in local CRM.'
            ]);
            return;
        }

        if (empty($task['zoho_crm_id'])) {
            echo json_encode([
                'success' => false,
                'error'   => 'Zoho CRM deal ID not found for this deal.'
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
            'sub_total'          => $post['subTotal'] ?? 0,
            'discount'           => $post['discount'] ?? 0,
            'adjustment'         => $post['adjustment'] ?? 0,
            'grand_total'        => $post['grandTotal'] ?? 0,
            'items'              => $post['items']
        ];

        log_message('error', 'Proposal data before Zoho: ' . print_r($proposal_data, true));

        $result = $this->add_proposal_to_zoho($task['zoho_crm_id'], $proposal_data, $task['id']);

        echo json_encode($result);
    } catch (Throwable $e) {
        log_message('error', 'add_proposal exception: ' . $e->getMessage());
        log_message('error', 'add_proposal trace: ' . $e->getTraceAsString());

        echo json_encode([
            'success' => false,
            'error'   => 'Server error: ' . $e->getMessage()
        ]);
    }
}

private function add_proposal_to_zoho($deal_id, $proposal_data, $id)
{
    try {
        log_message('error', '=== add_proposal_to_zoho called ===');
        log_message('error', 'Deal ID: ' . $deal_id);
        log_message('error', 'Task ID: ' . $id);
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
                log_message('error', 'Invalid date format for valid_until: ' . $proposal_data['valid_until']);
                return ['success' => false, 'error' => 'Invalid date format for valid_until.'];
            }
        }

        $headers = [
            'Content-Type: application/json',
            'Authorization: Zoho-oauthtoken ' . $this->access_token
        ];

        // ---------------------------
        // Step 1: Find or create contact
        // ---------------------------
        $last_name = trim($proposal_data['kind_attention'] ?? 'Default Last Name');

        $existing_contact_response = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Contacts/search?criteria=(Last_Name:equals:' . rawurlencode($last_name) . ')',
            $headers,
            null,
            'GET'
        );

        log_message('error', 'Existing contact response: ' . print_r($existing_contact_response, true));

        $existing_contact_data = json_decode($existing_contact_response['body'], true);

        if (!empty($existing_contact_data['data'][0]['id'])) {
            $contact_id = $existing_contact_data['data'][0]['id'];
            $contact_name = $existing_contact_data['data'][0]['Last_Name'];
        } else {
            $contact_data = json_encode([
                'data' => [[
                    'Last_Name' => $last_name ?: 'Default Last Name'
                ]]
            ]);

            $contact_response = $this->execute_curl_request(
                'https://www.zohoapis.com/crm/v2.1/Contacts',
                $headers,
                $contact_data,
                'POST'
            );

            log_message('error', 'Create contact response: ' . print_r($contact_response, true));

            $contact_response_body = json_decode($contact_response['body'], true);

            if (isset($contact_response_body['data'][0]['details']['id'])) {
                $contact_id = $contact_response_body['data'][0]['details']['id'];
                $contact_name = $last_name ?: 'Default Last Name';
            } else {
                log_message('error', 'Failed to create contact in Zoho CRM: ' . print_r($contact_response_body, true));
                return [
                    'success' => false,
                    'error'   => 'Failed to create contact.',
                    'details' => $contact_response_body
                ];
            }
        }

        // ---------------------------
        // Step 2: Build quote items
        // ---------------------------
        $quoted_items = [];
        $product_descriptions = [];

        foreach ($proposal_data['items'] as $item) {
            log_message('error', 'Processing item: ' . print_r($item, true));

            $product_id = $item['product_id'] ?? null;

            if (empty($product_id)) {
                return [
                    'success' => false,
                    'error'   => 'Product ID is missing for one of the items.',
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

                log_message('error', 'Product fetch response for ' . $product_id . ': ' . print_r($product_response, true));

                $product_data = json_decode($product_response['body'], true);

                if (isset($product_data['data'][0])) {
                    $product_description = $product_data['data'][0]['Description'] ?? '';
                }
            }

            $product_descriptions[$product_id] = $product_description;

            $quoted_items[] = [
                'Product_Name' => [
                    'id' => $product_id
                ],
                'Quantity'    => (float)($item['quantity'] ?? 0),
                'List_Price'  => (float)($item['unitPrice'] ?? 0),
                'ItemDiscount'       => $item['itemDiscount'] ?? 0,
                'U_O_M'       => $item['uom'] ?? '',
                'Description' => $product_description
            ];
        }

        log_message('error', 'Quoted items payload: ' . print_r($quoted_items, true));

        // ---------------------------
        // Step 3: Create quote in Zoho
        // ---------------------------
        $quote_payload = json_encode([
            'data' => [[
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

        log_message('error', 'Quote payload: ' . $quote_payload);

        $response = $this->execute_curl_request(
            'https://www.zohoapis.com/crm/v2.1/Quotes',
            $headers,
            $quote_payload,
            'POST'
        );

        log_message('error', 'Quote create response: ' . print_r($response, true));

        $response_body = json_decode($response['body'], true);

        if (!isset($response_body['data'][0]['details']['id'])) {
            log_message('error', 'Quote ID not found in Zoho CRM response: ' . print_r($response_body, true));
            return [
                'success' => false,
                'error'   => 'Quote creation failed in Zoho CRM.',
                'details' => $response_body
            ];
        }

        $quote_id = $response_body['data'][0]['details']['id'];

        // ---------------------------
        // Step 4: Fetch Quote_No
        // ---------------------------
        $quote_details_response = $this->execute_curl_request(
            "https://www.zohoapis.com/crm/v2.1/Quotes/{$quote_id}",
            $headers,
            null,
            'GET'
        );

        log_message('error', 'Quote details response: ' . print_r($quote_details_response, true));

        $quote_details = json_decode($quote_details_response['body'], true);

        $quote_number  = $quote_details['data'][0]['Quote_No'] ?? null;
        $modified_time = $quote_details['data'][0]['Modified_Time'] ?? date('Y-m-d H:i:s');

        if (!$quote_number) {
            log_message('error', 'Quote number missing from Zoho CRM response: ' . print_r($quote_details, true));
            return [
                'success' => false,
                'error'   => 'Quote number not found in Zoho CRM response.'
            ];
        }

        // ---------------------------
        // Step 5: Save quote header in tasks table
        // ---------------------------
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
            // optional first item summary in tasks table
            'product_id'          => $first_item['product_id'] ?? null,
            'product_name'        => $first_item['product_name'] ?? null,
            'product_description' => isset($first_item['product_id']) ? ($product_descriptions[$first_item['product_id']] ?? ($first_item['itemDescription'] ?? '')) : null,
            'uom'                 => $first_item['uom'] ?? null,
            'quantity'            => $first_item['quantity'] ?? null,
            'service_charge'      => $first_item['unitPrice'] ?? 0,
            'updated_at'          => $modified_time
        ];

        if (!$this->Task_model->save_proposal_data($task_update_data, $id)) {
            return [
                'success' => false,
                'error'   => 'Failed to save quote header in tasks table.'
            ];
        }

        // ---------------------------
        // Step 6: Save items in proposal_items table
        // ---------------------------
        $this->Task_model->delete_proposal_items($id);

        foreach ($proposal_data['items'] as $item) {
            $product_id = $item['product_id'] ?? null;

            $item_save_data = [
                'task_id'             => $id,
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

            if (!$this->Task_model->save_proposal_item($item_save_data)) {
                return [
                    'success' => false,
                    'error'   => 'Failed to save proposal items in local CRM.'
                ];
            }
        }

     

        echo json_encode([
    'success'      => true,
    'message'      => 'Task quote created successfully.',
    'quote_id'     => $quote_id,
    'quote_number' => $quote_number,
    'task_id'      => $id
]);
exit;
    } catch (Throwable $e) {
        log_message('error', 'add_proposal_to_zoho exception: ' . $e->getMessage());
        log_message('error', 'add_proposal_to_zoho trace: ' . $e->getTraceAsString());

        return [
            'success' => false,
            'error'   => 'Server error: ' . $e->getMessage()
        ];
    }
}

private function execute_curl_request($url, $headers = [], $data = null, $method = 'GET')
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Disable SSL (optional if server has issues)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    } elseif ($method === 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    } elseif ($method === 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        log_message('error', 'Curl Error: ' . curl_error($ch));
    }

    curl_close($ch);

    return [
        'status_code' => $http_code,
        'body'        => $response
    ];
}

public function edit_quotation($task_id)
{
    $data = [];
    $data['task'] = $this->Task_model->get_task($task_id);

    if (!$data['task']) {
        show_404();
    }

    if (empty($data['task']['quote_number'])) {
        show_error('Quotation not found for this task.');
    }

    $data['proposal_items'] = $this->Task_model->get_proposal_items_by_quote_number($data['task']['quote_number']);
    $data['edit_mode'] = true;

    
    $data['title']  = "Edit Quotation";
    $data['render'] = "Deals/Edit_Quotation";
    $this->load->view('layout/layout', $data);
  
}




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
$normalized_items = [];

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

    $item['resolved_description'] = $product_description;
    $normalized_items[] = $item;

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

    //    $first_item = $proposal_data['items'][0] ?? [];
    $first_item = $normalized_items[0] ?? [];

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
    'product_description' => $first_item['resolved_description'] ?? null,
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

        foreach ($normalized_items as $item) {
    $product_id = $item['product_id'] ?? null;

    $item_save_data = [
        'task_id'             => $task_id,
        'quote_number'        => $quote_number,
        'product_id'          => $product_id,
        'product_name'        => $item['product_name'] ?? null,
        'product_description' => $item['resolved_description'] ?? '',
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

public function create_deal_detail1()
{
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        show_404();
    }

    $this->load->model('Zoho_model');
    $this->load->model('Task_model');

    $session_user_id   = $this->session->userdata('id');        // local user id
    $session_zoho_user = $this->session->userdata('admin_id');  // Zoho VX App User id

    if (empty($session_user_id) || empty($session_zoho_user)) {
        $this->session->set_flashdata('error', 'Session expired. Please login again.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    $first_name        = trim($this->input->post('first_name'));
    $last_name         = trim($this->input->post('last_name'));
    $company_name      = trim($this->input->post('company_name'));
    $customer_email    = trim($this->input->post('customer_email'));
    $mobile_num        = trim($this->input->post('mobile_num'));
    $phone             = trim($this->input->post('phone'));
    $assign_department = trim($this->input->post('assign_department'));
    $p_box             = trim($this->input->post('p_box'));
    $trn               = trim($this->input->post('trn'));
    $address           = trim($this->input->post('address'));
    $description       = trim($this->input->post('description'));

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($company_name) ||
        empty($customer_email) ||
        empty($mobile_num)
    ) {
        $this->session->set_flashdata('error', 'Please fill all required fields.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    $enquiryNumber = $this->Zoho_model->generate_next_enquiry_number();

    // 1. Create / get account in Zoho
    $accountId = $this->Zoho_model->get_or_create_account([
        'company_name' => $company_name,
        'phone'        => $phone,
        'email'        => $customer_email,
        'address'      => $address,
        'p_box'        => $p_box,
        'trn'          => $trn,
        'department'   => $assign_department,
    ]);

    if (!$accountId) {
        $this->session->set_flashdata('error', 'Failed to create/find account in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 2. Create contact in Zoho
    $contactId = $this->Zoho_model->create_contact([
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'company_name' => $company_name,
        'email'        => $customer_email,
        'mobile'       => $mobile_num,
        'phone'        => $phone,
        'account_id'   => $accountId,
        'address'      => $address,
        'p_box'        => $p_box,
        'trn'          => $trn,
    ]);

    if (!$contactId) {
        $this->session->set_flashdata('error', 'Failed to create contact in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 3. Create deal in Zoho
    $dealId = $this->Zoho_model->create_deal([
        'deal_name'         => $company_name . ' - ' . $first_name . ' ' . $last_name,
        'company_name'      => $company_name,
        'description'       => $description,
        'email'             => $customer_email,
        'mobile'            => $mobile_num,
        'phone'             => $phone,
        'address'           => $address,
        'p_box'             => $p_box,
        'trn'               => $trn,
        'department'        => $assign_department,
        'account_id'        => $accountId,
        'contact_id'        => $contactId,
    //    'enq_number'    => $enquiryNumber,
        'session_zoho_user' => $session_zoho_user,
    ]);

    if (!$dealId) {
        $this->session->set_flashdata('error', 'Failed to create deal in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 4. Fetch full deal from Zoho
    $resp = $this->Zoho_model->get_deal_by_id($dealId);
    $deal = $resp['data'][0] ?? [];

    if (!$deal) {
        $this->session->set_flashdata('error', 'Deal created in Zoho but failed to fetch full details.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 5. Save full deal into local tasks table
    $localTaskId = $this->Task_model->upsert_task_from_zoho_deal($deal, $session_user_id);

    if (!$localTaskId) {
        $this->session->set_flashdata('error', 'Deal created in Zoho but failed to save in local CRM.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 6. Redirect to your existing lead detail page
    $this->session->set_flashdata('success', 'Deal created successfully.');
    redirect(base_url('index.php/Admincrm/lead_detail/' . $localTaskId));
}

public function create_deal_detail()
{
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
        show_404();
    }

    $this->load->model('Zoho_model');
    $this->load->model('Task_model');

    $isAjax = $this->input->is_ajax_request();

    $session_user_id   = $this->session->userdata('id');        // local user id
    $session_zoho_user = $this->session->userdata('admin_id');  // Zoho VX App User id

    if (empty($session_user_id) || empty($session_zoho_user)) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Session expired. Please login again.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Session expired. Please login again.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    $first_name        = trim($this->input->post('first_name'));
    $last_name         = trim($this->input->post('last_name'));
    $company_name      = trim($this->input->post('company_name'));
    $customer_email    = trim($this->input->post('customer_email'));
    $mobile_num        = trim($this->input->post('mobile_num'));
    $phone             = trim($this->input->post('phone'));
    $assign_department = trim($this->input->post('assign_department'));
    $p_box             = trim($this->input->post('p_box'));
    $trn               = trim($this->input->post('trn'));
    $address           = trim($this->input->post('address'));
    $description       = trim($this->input->post('description'));

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($company_name) ||
        empty($customer_email) ||
        empty($mobile_num)
    ) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Please fill all required fields.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Please fill all required fields.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    $enquiryNumber = $this->Zoho_model->generate_next_enquiry_number();

    // 1. Create / get account in Zoho
    $accountId = $this->Zoho_model->get_or_create_account([
        'company_name' => $company_name,
        'phone'        => $phone,
        'email'        => $customer_email,
        'address'      => $address,
        'p_box'        => $p_box,
        'trn'          => $trn,
        'department'   => $assign_department,
    ]);

    if (!$accountId) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to create/find account in Zoho.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Failed to create/find account in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 2. Create contact in Zoho
    $contactId = $this->Zoho_model->create_contact([
        'first_name'   => $first_name,
        'last_name'    => $last_name,
        'company_name' => $company_name,
        'email'        => $customer_email,
        'mobile'       => $mobile_num,
        'phone'        => $phone,
        'account_id'   => $accountId,
        'address'      => $address,
        'p_box'        => $p_box,
        'trn'          => $trn,
    ]);

    if (!$contactId) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to create contact in Zoho.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Failed to create contact in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 3. Create deal in Zoho
    $dealId = $this->Zoho_model->create_deal([
        'deal_name'         => $first_name . ' ' . $last_name,
        'company_name'      => $company_name,
        'description'       => $description,
        'email'             => $customer_email,
        'mobile'            => $mobile_num,
        'phone'             => $phone,
        'address'           => $address,
        'p_box'             => $p_box,
        'trn'               => $trn,
        'department'        => $assign_department,
        'account_id'        => $accountId,
        'contact_id'        => $contactId,
        // 'enq_number'      => $enquiryNumber,
        'session_zoho_user' => $session_zoho_user,
    ]);

    if (!$dealId) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to create deal in Zoho.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Failed to create deal in Zoho.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 4. Fetch full deal from Zoho
    $resp = $this->Zoho_model->get_deal_by_id($dealId);
    $deal = $resp['data'][0] ?? [];

    if (!$deal) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Deal created in Zoho but failed to fetch full details.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Deal created in Zoho but failed to fetch full details.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 5. Save full deal into local tasks table
    $localTaskId = $this->Task_model->upsert_task_from_zoho_deal($deal, $session_user_id);

    if (!$localTaskId) {
        if ($isAjax) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Deal created in Zoho but failed to save in local CRM.'
            ]);
            exit;
        }

        $this->session->set_flashdata('error', 'Deal created in Zoho but failed to save in local CRM.');
        redirect($_SERVER['HTTP_REFERER'] ?? base_url());
        return;
    }

    // 6. Success
    if ($isAjax) {
        echo json_encode([
            'status'        => 'success',
            'message'       => 'Deal created successfully.',
            'zoho_crm_id'   => $dealId,
            'local_task_id' => $localTaskId,
            'redirect_url'  => base_url('index.php/Admincrm/lead_detail/' . $localTaskId)
        ]);
        exit;
    }

    $this->session->set_flashdata('success', 'Deal created successfully.');
    redirect(base_url('index.php/Admincrm/lead_detail/' . $localTaskId));
}

    





    
    


    
    
    
    
}
?>