<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin');
        $this->load->library(['form_validation','rbac']);
        $this->load->helper(['url','form']);
    }

    public function index()
    {
        // already logged in
        if ($this->session->userdata('admin_id')) {
            redirect('index.php/Admincrm/index');
        }

        $this->load->view('auth/login');
    }

    public function authenticate()
    {
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Password','required');

        if ($this->form_validation->run() === FALSE) {
            return $this->load->view('auth/login');
        }

        $email    = $this->input->post('email', true);
        $password = $this->input->post('password');

        $admin = $this->Admin->get_admin_by_email($email);

        if (!$admin || !password_verify($password, $admin->password)) {
            $data['error'] = 'Invalid email or password';
            return $this->load->view('auth/login', $data);
        }

        if ($admin->status !== 'active') {
            $data['error'] = 'Account is inactive';
            return $this->load->view('auth/login', $data);
        }

        /* ============================
        GET LINKED EMPLOYEE (IF ANY)
        ============================ */
   //     $employee = $this->Admin->get_admin_by_email($id);

        /*============================
        SESSION DATA
        ============================ */
        $this->session->set_userdata([
            'admin_id'     => $admin->user_id,
            'id'           => $admin->id,
            'admin_name'   => $admin->username,
            'admin_email'  => $admin->email,
            'logged_in'    => true
        ]);

        // load RBAC permissions
        $this->rbac->load_permissions($admin->id);

        redirect('index.php/Admincrm/index');
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect('index.php/login');
    }
}
