<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deals extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session','rbac','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->config('zoho'); 
        $this->load->model('Task_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Zoho_model'); // your model that handles Zoho API
        $this->load->model('Admin');

     //   $this->load->library('zohocrm'); // your Zoho library

        // Auth check
        if (!$this->session->userdata('admin_id')) {
            redirect('index.php/login');
        }
        
    }

    public function submit()
    {
        /* =========================
        0️⃣ POST ONLY
        ========================= */
        if ($this->input->method() !== 'post') {
            show_error('Invalid request method', 405);
        }

        $data = $this->input->post();

        /* =========================
        1️⃣ VALIDATION
        ========================= */
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        /* =========================
        2️⃣ CREATE LEAD (FULL)
        ========================= */
        $leadPayload = [
            'First_Name'   => $data['first_name'],
            'Last_Name'    => $data['last_name'],
            'Company'      => $data['company_name'],
            'Email'        => $data['customer_email'] ?? null,
            'Phone'        => $data['phone'] ?? null,
            'Mobile'       => $data['mobile_num'] ?? null,
            'Description'  => $data['complaint_info'] ?? null,

            // 🔐 REQUIRED SYSTEM FIELDS
            'Owner' => [
                'id' => '5653678000000401001'
            ],

            // 🔗 Custom lookup (Zoho user)
            'VZ_app_user' => [
                'id' => $this->session->userdata('admin_id')
            ],

            // 🔢 Custom fields
            'EnquiryNumber' => 'ENQ-' . time(),
            'P_BOX'         => $data['pBox'] ?? null,
            'TRN'           => $data['trn'] ?? null
        ];

        $leadResp = $this->Zoho_model->create_lead($leadPayload);
        log_message('error', 'LEAD CREATE RESPONSE: ' . json_encode($leadResp));

        if (($leadResp['status_code'] ?? 0) !== 201) {
            show_error('Zoho Lead creation failed. Check logs.', 500);
        }

        $leadId = $leadResp['response']['data'][0]['details']['id'] ?? null;

        if (!$leadId) {
            show_error('Lead ID missing from Zoho response', 500);
        }
 
        /* =========================
        3️⃣ CONVERT LEAD → DEAL
        ========================= */
        $dealPayload = [
            'Deal_Name'     => $data['first_name'] . ' ' . $data['last_name'],
            'Pipeline'      => 'Standard (Standard)',   // EXACT pipeline name
            'Stage'         => 'Qualification',
            'Probability'   => 10,
            'Closing_Date'  => date('Y-m-d', strtotime('+30 days')),
            'VZ_App_Status' => 'Pending',
            'Assign_Department1' => 'VOLTRONIX CONTRACTING LLC',

            // Optional but SAFE
            'Description'   => $data['complaint_info'] ?? null,
            'Email'         => $data['customer_email'] ?? null,
            'Phone'         => $data['phone'] ?? null,
            'Mobile'        => $data['mobile_num'] ?? null,
            'TRN'           => $data['trn'] ?? null,
            'P_BOX'         => $data['pBox'] ?? null
        ];

        $convertResp = $this->Zoho_model->convert_lead_to_deal($leadId, $dealPayload);
        log_message('error', 'LEAD CONVERT RESPONSE: ' . json_encode($convertResp));

        if (!in_array(($convertResp['status_code'] ?? 0), [200, 201])) {
            show_error('Lead conversion failed. Check logs.', 500);
        }

        $dealId =
        $convertResp['response']['data'][0]['id']
        ?? $convertResp['response']['data'][0]['Deals']['id']
        ?? null;
        
        
        /* =========================
        6️⃣ DONE
        ========================= */
        $this->session->set_flashdata('success', 'Deal created successfully');
        redirect('Deals/view/' . $dealId);
    }

public function view_deals(){
          
        
        $data['records'] = $this->Admin->view_all_self_created_deals();
        $data['users'] = $this->Admin->get_admin_users();
        
        $data['breadcrumbs'] = [
            ['label' => 'Deals'],
            ['label' => 'All Deals']
        ];

      $data['title']         = "Self Created Deals";
      $data['render']        = "Deals/view_self_deals";
      $this->load->view('layout/layout', $data);
        
        
    } 


}
