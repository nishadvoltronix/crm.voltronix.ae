<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['session','rbac','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->model('Admin');
        // Auth check
        if (!$this->session->userdata('admin_id')) {
            redirect('index.php/login');
        }
    }

    /* =========================
       ADMIN USERS
       ========================= */
    public function users()
    {
        $this->rbac->require('users.write');
        $data['title'] = 'Users';
        $data['users'] = $this->Admin->get_admin_users();
        $data['render'] = "Permissions/users";
        $this->load->view('layout/layout', $data);

    }

    public function permission_assign_departments()
    {
        $this->rbac->require('users.write');
        $data['title'] = 'Assign Departments';
        $data['users'] = $this->Admin->get_admin_users();
        $data['render'] = "Permissions/permission_assign_department";
        $this->load->view('layout/layout', $data);

    }

    public function user_create()
    {
        $this->rbac->require('users.write');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('employee', 'employee', 'required');

        if ($this->form_validation->run() === FALSE) {
            show_error(validation_errors(), 422);
        }

        $this->Admin->create_admin_user([
            'username'     => $this->input->post('name', true),
            'email'    => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'status'   => 'active'
        ]);

        echo json_encode(['status' => 'success']);
    }

    public function users_edit($id)
    {
        $this->rbac->require('users.write');

        $user = $this->Admin->get_admin_user_by_id($id);

        $data['user'] = $user;
        $data['employees'] = $this->Admin->get_employees_for_user_link($user->id);



        $edit_user = $this->Admin->get_admin_user_by_id($id);
        if (!$edit_user) {
            show_404();
        }

        $selected_employee_id = $this->Admin->get_employees_for_user_link($user->id);
        $data['selected_employee_id'] = $selected_employee_id;

        $data['page_title'] = 'Edit Admin User';
        $data['users'] = $this->Admin->get_admin_users();
        $data['edit_user'] = $edit_user;

        $data['render'] = "Permissions/users";
        $this->load->view('layout/layout', $data);
    }

    public function user_toggle_status($id)
    {
        $this->rbac->require('users.write');

        if (!$this->Admin->toggle_admin_user_status($id)) {
            show_404();
        }

        redirect('index.php/Permissions/users');
    }

    public function user_save()
    {
        $this->rbac->require('permissions.manage');

        $id = $this->input->post('id');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if (!$id) {
            $this->form_validation->set_rules(
                'password',
                'Password',
                'required|min_length[6]'
            );
        }

        if ($this->form_validation->run() === FALSE) {
            show_error(validation_errors(), 422);
        }

        $data = [
            'username'   => $this->input->post('name', true),
            'email'  => $this->input->post('email', true),
            'status' => $this->input->post('status', true)
        ];

        // Password only if provided
        if ($this->input->post('password')) {
            $data['password'] = password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            );
        }

        if ($id) {
            // UPDATE
            $this->Admin->update_admin_user($id, $data);
        } else {
            // CREATE
            $this->Admin->create_admin_user($data);
        }

        redirect('index.php/Permissions/users');
    }
    /* =========================
       ADMIN USERS
       ========================= */
    public function permissions_assign()
    {
        $this->rbac->require('permissions.manage');

        $admin_id = $this->input->get('admin_id');

        $data['page_title'] = 'Assign Permissions';
        $data['admins'] = $this->Admin->get_admin_users();
        $data['permission_groups'] = $this->Admin->get_permission_groups();
        $data['permissions'] = $this->Admin->get_permissions();
        $data['selected_admin_id'] = $admin_id;

        $data['assigned_permission_ids'] = $admin_id
            ? $this->Admin->get_assigned_permission_ids($admin_id)
            : [];

        $data['title'] = "Assign Permissions";
        $data['render'] = "Permissions/permissions_assign";
        $this->load->view('layout/layout', $data);
    }

    public function save_permissions()
    {
        $this->rbac->require('permissions.manage');

        $admin_id = $this->input->post('admin_id');
        $permissions = $this->input->post('permissions') ?? [];

        $this->Admin->save_admin_permissions($admin_id, $permissions);

        redirect('index.php/Permissions/permissions_assign?admin_id='.$admin_id);
    }

    public function permission_groups()
    {
        $this->rbac->require('permissions.manage');

        $data['page_title'] = 'Permission Groups';
        $data['groups'] = $this->Admin->get_permission_groups();

        $data['title'] = "Permission Groups";
        $data['render'] = "Permissions/permission_groups";
        $this->load->view('layout/layout', $data);
    }

    public function permission_groups_edit($id)
    {
        $this->rbac->require('permissions.manage');

        $edit = $this->Admin->get_permission_group_by_id($id);
        if (!$edit) show_404();

        $data['page_title'] = 'Edit Permission Group';
        $data['groups'] = $this->Admin->get_permission_groups();
        $data['edit_group'] = $edit;

        $data['render'] = "Permissions/permission_groups";
        $this->load->view('layout/layout', $data);
    }

    public function permission_group_save()
    {
        $this->rbac->require('permissions.manage');

        $id = $this->input->post('id');

        $this->form_validation->set_rules('label','Label','required');

        if (!$id) {
            $this->form_validation->set_rules('key','Key','required|alpha_dash|is_unique[permission_groups.key]');
        }

        if ($this->form_validation->run() === FALSE) {
            show_error(validation_errors(), 422);
        }

        $data = [
            'label'      => $this->input->post('label', true),
            'sort_order' => (int)$this->input->post('sort_order')
        ];

        if ($id) {
            $this->Admin->update_permission_group($id, $data);
        } else {
            $data['key'] = $this->input->post('key', true);
            $this->Admin->create_permission_group($data);
        }

        redirect('index.php/Permissions/permission_groups');
    }

    public function permissions_master()
    {
        $this->rbac->require('permissions.manage');

        $data['page_title'] = 'Permissions';
        $data['permissions'] = $this->Admin->get_permissions_with_group();
        $data['permission_groups'] = $this->Admin->get_permission_groups();

        $data['title'] = "Permissions Master";
        $data['render'] = "Permissions/permissions_master";
        $this->load->view('layout/layout', $data);
    }

    public function permissions_master_edit($id)
    {
        $this->rbac->require('permissions.manage');

        $edit = $this->Admin->get_permission_by_id($id);
        if (!$edit) show_404();

        $data['page_title'] = 'Edit Permission';
        $data['permissions'] = $this->Admin->get_permissions_with_group();
        $data['permission_groups'] = $this->Admin->get_permission_groups();
        $data['edit_permission'] = $edit;

        $data['render'] = "Permissions/permissions_master";
        $this->load->view('layout/layout', $data);
    }

    public function permission_save()
    {
        $this->rbac->require('permissions.manage');

        $id = $this->input->post('id');

        $this->form_validation->set_rules('label','Label','required');
        $this->form_validation->set_rules('group_id','Group','required');

        if (!$id) {
            $this->form_validation->set_rules(
            'key',
            'Key',
            'required|regex_match[/^[a-z0-9._-]+$/]|is_unique[permissions.key]'
        );
        }

        if ($this->form_validation->run() === FALSE) {
            show_error(validation_errors(), 422);
        }

        $data = [
            'label'    => $this->input->post('label', true),
            'group_id' => (int)$this->input->post('group_id')
        ];

        if ($id) {
            $this->Admin->update_permission($id, $data);
        } else {
            $data['key'] = $this->input->post('key', true);
            $this->Admin->create_permission($data);
        }

        redirect('index.php/Permissions/permissions_master');
    }

    public function assign_departments_role(){

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $ID     = $this->input->post('ID');
            $department_assigned_by = $this->session->userdata('admin_id');
            date_default_timezone_set('Asia/Dubai');
            $department_assigned_date = date('Y-m-d H:i:s');
            $department_role = $this->input->post('department_role');

                    $data = [
                        'department_assigned_by'       => $department_assigned_by,
                        'department_assigned_date'    => $department_assigned_date,
                        'department_role'       => $department_role
                    ];

                    $this->Admin->update_users($ID, $data);
                
            }

            redirect(base_url("index.php/Permissions/permission_assign_departments/"));
        }

       
}
