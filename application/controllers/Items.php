<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session','rbac','form_validation']);
        $this->load->config('zoho'); 
        $this->load->model('Task_model');
        $this->load->library('session');
        $this->load->model('Zoho_model'); // your model that handles Zoho API

     //   $this->load->library('zohocrm'); // your Zoho library
    }

    
    public function view_items()
    {
        $page     = (int) ($this->input->get('page') ?? 1);
        $per_page = 200; // Zoho max is 200
        if ($page < 1) $page = 1;

        $resp = $this->Zoho_model->list_items($page, $per_page);

        $items = [];
        $error = null;
        $more_records = false;
        $count = 0;

        if (($resp['status_code'] ?? 0) === 200) {
            $items = $resp['response']['data'] ?? [];
            $more_records = $resp['response']['info']['more_records'] ?? false;
            $count = $resp['response']['info']['count'] ?? count($items);
        } else {
            $error = $resp['response'] ?? $resp;
        }

        $data = [];
        $data['title']        = "Zoho Items";
        $data['render']       = "Deals/view_items"; // your view path
        $data['items']        = $items;
        $data['error']        = $error;

        // paging info
        $data['page']         = $page;
        $data['per_page']     = $per_page;
        $data['more_records'] = $more_records;
        $data['page_count']   = $count;

        $this->load->view('layout/layout', $data);
    }


    


}
