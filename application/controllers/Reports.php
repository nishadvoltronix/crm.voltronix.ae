<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

                $this->load->library(['session','rbac','form_validation']);
                $this->load->helper(['url','form']);
                $this->load->model('Admin');
                $this->load->model('Reports_model');
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

    public function employee_performance()
    {
        $date_from = $this->input->get('date_from');
        $date_to   = $this->input->get('date_to');

        if (empty($date_from)) {
            $date_from = date('Y-m-01');
        }

        if (empty($date_to)) {
            $date_to = date('Y-m-d');
        }

        $data['title'] = "Employee Performance Report";

        $data['date_from'] = $date_from;
        $data['date_to']   = $date_to;

        $data['summary'] = $this->Reports_model->get_employee_report_summary($date_from, $date_to);
        $data['records'] = $this->Reports_model->get_employee_performance_report($date_from, $date_to);
        $data['stage_chart'] = $this->Reports_model->get_deals_by_stage_chart($date_from, $date_to);
        $data['job_chart'] = $this->Reports_model->get_job_status_chart($date_from, $date_to);
        $data['monthly_amount_chart'] = $this->Reports_model->get_monthly_won_amount_chart();

        $data['breadcrumbs'] = [
            ['label' => 'Reports'],
            ['label' => 'Employees'],
            ['label' => 'Employee Performance']
        ];

        $data['render'] = "Reports/Employees/Employee_Performance.php";
        $this->load->view('layout/layout', $data);
    }
}