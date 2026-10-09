<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Switchgear extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->model('Admin');
        $this->load->library('rbac');

        // Auth check
        if (!$this->session->userdata('admin_id')) {
            redirect('index.php/login');
        }
        
    }

    public function view_all(){
          
        $id = $this->session->userdata('id');
        $department = "Switchgear";
        $status = ['Assigned', 'Process', 'Completed', 'Hold'];
        $data['records'] = $this->Admin->view_all_won_jobs_user($id, $department, $status);
        $data['users'] = $this->Admin->get_admin_users();

        $data['title'] = "All Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Switchgear'],
            ['label' => 'All Jobs']
        ];

      $data['render'] = "Jobs/View_User_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    }
    
    public function Pending_Switchgear_Jobs(){
          
        $id = $this->session->userdata('id');
        $department = "Switchgear";
        $status = "Assigned";
        $data['records'] = $this->Admin->view_all_won_jobs_user($id, $department, $status);
        $data['users'] = $this->Admin->get_admin_users();

        $data['title'] = "Pending Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Switchgear'],
            ['label' => 'Pending Jobs']
        ];

      $data['render'] = "Jobs/View_User_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 
    
    public function Process_Switchgear_Jobs(){
          
        
        $id = $this->session->userdata('id');
        $department = "Switchgear";
        $status = "Process";
        $data['records'] = $this->Admin->view_all_won_jobs_user($id, $department, $status);
        $data['users'] = $this->Admin->get_admin_users();

        $data['title'] = "Process Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Switchgear'],
            ['label' => 'Process Jobs']
        ];

      $data['render'] = "Jobs/View_User_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Completed_Switchgear_Jobs(){
          
        
        $id = $this->session->userdata('id');
        $department = "Switchgear";
        $status = "Completed";
        $data['records'] = $this->Admin->view_all_won_jobs_user($id, $department, $status);
        $data['users'] = $this->Admin->get_admin_users();

        $data['title'] = "Completed Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Switchgear'],
            ['label' => 'Completed Jobs']
        ];

      $data['render'] = "Jobs/View_User_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Hold_Switchgear_Jobs(){
          
        
        $id = $this->session->userdata('id');
        $department = "Switchgear";
        $status = "Hold";
        $data['records'] = $this->Admin->view_all_won_hold_jobs_user($id, $department, $status);
        $data['users'] = $this->Admin->get_admin_users();

        $data['title'] = "Hold Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Switchgear'],
            ['label' => 'Hold Jobs']
        ];

      $data['render'] = "Jobs/View_User_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function lead_detail() {

        $task_id = $this->uri->segment(3);
        $user_id = $this->session->userdata('id');

        $lead = $this->Admin->get_user_task_detail($task_id, $user_id);
        $electric_logs = $this->Admin->get_electric_logs_by_task($task_id);
        $electric_recent_data = $this->Admin->get_latest_electric_log_by_task($task_id);
        $civil_recent_data = $this->Admin->get_latest_civil_log_by_task($task_id);
        $civil_logs = $this->Admin->get_civil_logs_by_task($task_id);
        $pm_recent_data = $this->Admin->get_latest_pm_log_by_task($task_id);
        $pm_logs = $this->Admin->get_pm_logs_by_task($task_id);
        $swt_recent_data = $this->Admin->get_latest_swt_log_by_task($task_id);
        $swt_logs = $this->Admin->get_swt_logs_by_task($task_id);
        $mtn_recent_data = $this->Admin->get_latest_mtn_log_by_task($task_id);
        $mtn_logs = $this->Admin->get_mtn_logs_by_task($task_id);


        if (!$lead) {
            // Lead not found, handle gracefully
            show_error("Lead not found.", 404);
            return;
        }

        $attachments = $this->Admin->get_lead_attachments($lead['zoho_crm_id']);

        if (!$attachments) {
            $attachments = []; // default to empty array
        }

        $data['title'] = "Job Details";
        $data['breadcrumbs'] = [
            ['label' => 'Job'],
            ['label' => 'Job Details']
        ];

        $data['data'] = $lead;
        $data['attachments'] = $attachments;
        $data['electric_logs'] = $electric_logs;
        $data['electric_recent_data'] = $electric_recent_data;
        $data['civil_recent_data'] = $civil_recent_data;
        $data['civil_logs'] = $civil_logs;
        $data['pm_recent_data'] = $pm_recent_data;
        $data['pm_logs'] = $pm_logs;
        $data['swt_recent_data'] = $swt_recent_data;
        $data['swt_logs'] = $swt_logs;
        $data['mtn_recent_data'] = $mtn_recent_data;
        $data['mtn_logs'] = $mtn_logs;
        

        $data['render'] = "Jobs/Job_Details_User.php";
        $this->load->view('layout/layout', $data);

    }

    public function update_swt_job(){

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $task_id     = $this->input->post('task_id');
            $User_ID     = $this->input->post('User_ID');
            $departments_assign_id = $this->input->post('departments_assign_id');
            $Switchgear_Scope_of_Work = $this->input->post('Switchgear_Scope_of_Work');
            $Switchgear_Status = $this->input->post('Switchgear_Status');
            $Switchgear_Notes = $this->input->post('Switchgear_Notes');
            date_default_timezone_set('Asia/Dubai');
            $Switchgear_Created_At = date('Y-m-d H:i:s');
            $file_name = null;

            // Upload Image
            if (!empty($_FILES['image']['name'])) 
            {
                $new_filename = date("YmdGis");
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
                $config['upload_path']   = 'uploads/Switchgear/'; 
                $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|xls|xlsx|csv';
                $config['max_size']      = 51200; // 50MB (KB)
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
            


                    $data = [
                        'task_id'       => $task_id,
                        'User_ID'       => $User_ID,
                        'departments_assign_id' => $departments_assign_id,
                        'Switchgear_Scope_of_Work' => $Switchgear_Scope_of_Work,
                        'Switchgear_Status' => $Switchgear_Status,
                        'Switchgear_Notes' => $Switchgear_Notes,
                        'Switchgear_Created_At' => $Switchgear_Created_At,
                        'Switchgear_File' => $file_name
                    ];

                    $this->Admin->insert_switchgear($data);

            redirect(base_url("index.php/Switchgear/lead_detail/" . $task_id));
        }
    }

    public function update_swt_status_job(){

       if($this->input->server('REQUEST_METHOD') === 'POST'){

       $ID = $this->input->post('ID');
       $task_id = $this->input->post('task_id');
       $Status = $this->input->post('Status');

       $data = [
            'Status'  => $Status
       ];

       $this->Admin->update_departments_assign($ID, $data);

       redirect(base_url("index.php/Switchgear/lead_detail/" . $task_id));

       }

    }


/********************************************/
/*                Export File               */
/********************************************/
public function export_all_jobs_excel()
{
    $this->load->model('Admin');
    $records = $this->Admin->view_all_won_jobs();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // headers
    $sheet->fromArray([
        'Created At',
        'Job Deal Number',
        'Job Deal Date',
        'Account Name',
        'Status',
        'Electrical Status',
        'Civil Status',
        'PM Status',
        'Accounts Status',
        'Service Charge'
    ], null, 'A1');

    $row = 2;
    foreach ($records as $r) {
        $sheet->fromArray([
            $r['created_at'],
            $r['job_deal_number'],
            $r['job_deal_date'],
            $r['account_name'],
            $r['status'],
            $r['electrical_status'] ?? 'Not Assigned',
            $r['civil_status'] ?? 'Not Assigned',
            $r['pm_status'] ?? 'Not Assigned',
            'Pending',
            number_format($r['service_charge'], 2, '.', '')
        ], null, 'A' . $row);

        $row++;
    }

    foreach (range('A', 'J') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $filename = 'All_Jobs_' . date('Y-m-d') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}




    
}
?>