<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->model('Admin');
        $this->load->library('rbac');

        // Auth check
        if (!$this->session->userdata('admin_id')) {
            redirect('index.php/login');
        }
        
    }

    public function view_all_jobs(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "All Confirmed Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs Pipeline'],
            ['label' => 'All Jobs']
        ];
        
   
     //   $data['render'] = "Jobs/test.php";
     //   $this->load->view('test_datatable', $data);

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Pending_Assigning(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs_without_department();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "Pending Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs'],
            ['label' => 'Pending Assigning']
        ];

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Under_Process_Won_Jobs(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs_under_process();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "Under Process Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs'],
            ['label' => 'Under Process']
        ];

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Completed_Won_Jobs(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs_completed();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "Completed Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs'],
            ['label' => 'Completed']
        ];

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function Hold_Won_Jobs(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs_hold();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "All Confirmed Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs'],
            ['label' => 'Hold']
        ];

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    }
    
    public function Closed_Won_Jobs(){
          
        
        $data['records'] = $this->Admin->view_all_won_jobs_closed();
        $data['users'] = $this->Admin->get_admin_users();
        $data['e_users'] = $this->Admin->get_electrical_users();
        $data['c_users'] = $this->Admin->get_civil_users();
        $data['pm_users'] = $this->Admin->get_pm_users();
        $data['swg_users'] = $this->Admin->get_swg_users();
        $data['mtn_users'] = $this->Admin->get_mtn_users();

        $data['title'] = "All Confirmed Jobs";
        
        $data['breadcrumbs'] = [
            ['label' => 'Jobs'],
            ['label' => 'Closed']
        ];

      $data['render'] = "Jobs/View_Jobs.php";
      $this->load->view('layout/layout', $data);
        
        
    } 

    public function lead_detail() {

        $id = $this->uri->segment(3);
        $task_id = $id;
        $lead = $this->Admin->get_job_detail_by_id($id);
        $electric_recent_data = $this->Admin->get_latest_electric_log_by_task($task_id);
        $electric_logs = $this->Admin->get_electric_logs_by_task($id);
        $civil = $this->Admin->get_job_detail_civil_by_id($id);
        $civil_logs = $this->Admin->get_civil_logs_by_task($id);
        $pm_recent_data = $this->Admin->get_latest_pm_log_by_task($id);
        $pm_logs = $this->Admin->get_pm_logs_by_task($id);
        $swt_recent_data = $this->Admin->get_latest_swt_log_by_task($id);
        $swt_logs = $this->Admin->get_swt_logs_by_task($id);
        $mtn_recent_data = $this->Admin->get_latest_mtn_log_by_task($id);
        $mtn_logs = $this->Admin->get_mtn_logs_by_task($id);

          // PM department status
        $pm_department_status = $this->Admin->get_department_status($id,'PM');

        $electrical_department_status = $this->Admin->get_department_status($id, 'Electrical');

        $civil_department_status = $this->Admin->get_department_status($id,'Civil');

        $swt_department_status = $this->Admin->get_department_status($id,'Switchgear');

        $mtn_department_status = $this->Admin->get_department_status($id,'Maintenance');

        if (!$lead) {
            // Lead not found, handle gracefully
            show_error("Lead not found.", 404);
            return;
        }

        $attachments = $this->Admin->get_lead_attachments($lead['zoho_crm_id']);

        if (!$attachments) {
            $attachments = []; // default to empty array
        }

        $data['title'] = "Lead Details";
        $data['breadcrumbs'] = [
            ['label' => 'Leads Pipeline', 'url' => 'leads'],
            ['label' => 'Lead Details']
        ];

        $data['data'] = $lead;
        $data['electric_recent_data'] = $electric_recent_data;
        $data['electric_logs'] = $electric_logs;
        $data['attachments'] = $attachments;
        $data['civil'] = $civil;
        $data['civil_logs'] = $civil_logs;
        $data['pm_recent_data'] = $pm_recent_data;
        $data['pm_logs'] = $pm_logs;
        $data['swt_recent_data'] = $swt_recent_data;
        $data['swt_logs'] = $swt_logs;
        $data['mtn_recent_data'] = $mtn_recent_data;
        $data['mtn_logs'] = $mtn_logs;

        $data['pm_department_status']         = $pm_department_status;
        $data['electrical_department_status'] = $electrical_department_status;
        $data['civil_department_status']      = $civil_department_status;
        $data['swt_department_status']        = $swt_department_status;
        $data['mtn_department_status']        = $mtn_department_status;

        $data['render'] = "Jobs/Job_Details.php";
        $this->load->view('layout/layout', $data);

    }

    public function assign_job_departments(){

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $task_id     = $this->input->post('ID');
            $assigned_by = $this->session->userdata('admin_id');
            date_default_timezone_set('Asia/Dubai');
            $assigned_on = date('Y-m-d H:i:s');

            // Department → POST field mapping
            $departments = [
                'Electrical' => $this->input->post('electrical_user'),
                'Civil'      => $this->input->post('civil_user'),
                'PM'         => $this->input->post('pm_user'),
                'Switchgear' => $this->input->post('swg_user'),
                'Maintenance'=> $this->input->post('mtn_user')
            ];

            foreach ($departments as $department => $user_id) {

                // Insert ONLY if a user is selected
                if (!empty($user_id)) {

                    $data = [
                        'task_id'       => $task_id,
                        'department'    => $department,
                        'user_id'       => $user_id,
                        'assigned_by'   => $assigned_by,
                        'assigned_date' => $assigned_on,
                        'status' => 'Assigned'
                    ];

                    $this->Admin->update_assign_department($data, $task_id);
                }
            }

            redirect(base_url("index.php/Jobs/view_all_jobs/" . $task_id));
        }
    }

    public function assign_accounts_department(){

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $task_id     = $this->input->post('ID');
            $assigned_by = $this->session->userdata('admin_id');
            $user_id     = $this->input->post('accounts_user');
            date_default_timezone_set('Asia/Dubai');
            $assigned_on = date('Y-m-d H:i:s');


                    $data = [
                        'task_id'       => $task_id,
                        'user_id'       => $user_id,
                        'assigned_by_id'   => $assigned_by,
                        'assigned_time' => $assigned_on,
                        'payment_status' => 'Assigned'
                    ];

                    $this->Admin->update_assign_accounts($data, $task_id);

            redirect(base_url("index.php/Jobs/view_all_jobs/" . $task_id));
        }
    }

    public function hold_full_job(){

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $task_id     = $this->input->post('ID');
            $hold_by = $this->session->userdata('admin_id');
            $Job_Status = $this->input->post('Job_Status');
        //    $user_id     = $this->input->post('accounts_user');
        //    date_default_timezone_set('Asia/Dubai');
        //    $assigned_on = date('Y-m-d H:i:s');


                    $data = [
                        'hold_by'       => $hold_by,
                        'Job_Status' => $Job_Status
                    ];

                    $this->Admin->update_tasks($data, $task_id);

            redirect(base_url("index.php/Jobs/view_all_jobs/" . $task_id));
        }
    }



public function test_excel()
    {
        new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        echo 'Excel library working';
    }

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

public function unassign_department()
{
    $this->output->set_content_type('application/json');

    if ($this->input->server('REQUEST_METHOD') !== 'POST') {

        return $this->output->set_output(
            json_encode([
                'success' => false,
                'message' => 'Invalid request method.'
            ])
        );
    }

    $task_id = (int) $this->input->post('job_id');

    $department_key = trim(
        (string) $this->input->post('department', true)
    );

    if ($task_id <= 0) {

        return $this->output->set_output(
            json_encode([
                'success' => false,
                'message' => 'Invalid job ID.'
            ])
        );
    }

    /*
     * Frontend department value
     * mapped to your actual stored department name.
     */
    $department_map = [
        'electrical' => 'Electrical',
        'civil'      => 'Civil',
        'pm'         => 'PM',
        'swg'        => 'Switchgear',
        'mtn'        => 'Maintenance'
    ];

    if (!isset($department_map[$department_key])) {

        return $this->output->set_output(
            json_encode([
                'success' => false,
                'message' => 'Invalid department.'
            ])
        );
    }

    $department = $department_map[$department_key];

    /*
     * Call model method.
     */
    $result = $this->Admin->unassign_department(
        $task_id,
        $department
    );

    if ($result) {

        return $this->output->set_output(
            json_encode([
                'success' => true,
                'message' =>
                    $department .
                    ' user unassigned successfully.',
                'job_id' => $task_id
            ])
        );
    }

    return $this->output->set_output(
        json_encode([
            'success' => false,
            'message' =>
                'Unable to unassign the user.'
        ])
    );
}

public function save_admin_remarks()
{
    $task_id = $this->input->post('task_id');

    $remarks = trim(
        $this->input->post('remarks')
    );

    if (empty($task_id)) {

        echo json_encode([
            'status' => false,
            'message' => 'Task ID is required.'
        ]);

        return;
    }

    $result = $this->Admin
        ->save_admin_remarks(
            $task_id,
            $remarks
        );

    echo json_encode([
        'status' => $result ? true : false,
        'message' => $result
            ? 'Remarks updated successfully.'
            : 'Unable to update remarks.'
    ]);
}

    




    
}
?>