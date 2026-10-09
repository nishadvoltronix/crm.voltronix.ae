<?php

Class Admin extends CI_Model{
    
    
    public function view_pipeline_dashboard(){
        
        $this->db->select('tasks.*, assigneduser.username AS assigned_username');
        $this->db->from('tasks');
        
        $this->db->join('users as assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');
        
        $this->db->order_by('tasks.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function view_pipeline_dashboard_agent($zoho_user_id){
        
        $this->db->select('tasks.*, assigneduser.username AS assigned_username');
        $this->db->from('tasks');
        
        $this->db->join('users as assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');
        $this->db->where('tasks.assigned_to', $zoho_user_id);
        
        $this->db->order_by('tasks.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function view_all_self_created_deals(){
        
        $this->db->select('tasks.*, assigneduser.username AS assigned_username');
        $this->db->from('tasks');
        
        $this->db->join('users as assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');
        $this->db->where('tasks.deal_crm_created_by IS NOT NULL', null, false);
        
        $this->db->order_by('tasks.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
    public function get_lead_by_id1($id)
{
    $this->db->select('
        tasks.*, assigneduser.username AS assigned_to,
        job_attachments.id AS attachment_id,
        job_attachments.file_name,
        job_attachments.file_path
    ');

    $this->db->from('tasks');

    $this->db->join(
        'users AS assigneduser',
        'assigneduser.user_id = tasks.assigned_to',
        'inner'
    );

    $this->db->join(
        'job_attachments',
        'job_attachments.deal_id = tasks.zoho_crm_id',
        'left'
    );

    $this->db->where('tasks.id', $id);
    $this->db->order_by('tasks.updated_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
}
    
    // get task
    public function get_lead_by_id($id)
    {
        $this->db->select('tasks.*, assigneduser.username AS assigned_to_name');
        $this->db->from('tasks');
        $this->db->join('users AS assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');
        $this->db->where('tasks.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_job_detail_by_id1($id)
    {
        $this->db->select('tasks.*, assigneduser.username AS assigned_to');
        $this->db->from('tasks');
        $this->db->join('users AS assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');
        $this->db->where('tasks.id', $id);
        return $this->db->get()->row_array();
    }

public function get_job_detail_by_id($task_id)
{
    // 🔹 Latest assignment for Electrical (per task)
    $latestElectricalAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, MAX(id) AS max_id
            FROM departments_assign
            WHERE department = 'Electrical'
            GROUP BY task_id
        ) x ON x.max_id = da1.id
    ";

    // 🔹 Latest electric submission per task
    $latestElectric = "
        SELECT e1.*
        FROM electric e1
        INNER JOIN (
            SELECT task_id, MAX(E_ID) AS max_id
            FROM electric
            GROUP BY task_id
        ) y ON y.max_id = e1.E_ID
    ";

    $this->db->select("
        t.*, assigneduser.username AS assigned_to,

        da.id AS department_assign_id,
        da.department,
        da.status AS department_status,
        da.assigned_date,
        du.username AS electrical_assigned_to,

        ed.E_ID AS electric_detail_id,
        ed.DEWA_Authority,
        ed.Electric_Status,
        ed.Authority_Comments,
        ed.Electrician_Notes,
        ed.File,
        ed.created_at AS electric_submitted_at
    ", false);

    $this->db->from('tasks t');

    $this->db->join('users AS assigneduser', 'assigneduser.user_id = t.assigned_to', 'left');

    // ✅ Latest Electrical assignment
    $this->db->join("($latestElectricalAssign) da", 'da.task_id = t.id', 'left', false);
    $this->db->join('users du', 'du.id = da.user_id', 'left');

    // ✅ Latest Electric submission ONLY
    $this->db->join("($latestElectric) ed", 'ed.task_id = t.id', 'left', false);

    $this->db->where('t.id', (int)$task_id);

    return $this->db->get()->row_array();
}

public function get_job_detail_civil_by_id($task_id)
{
    // 🔹 Latest assignment for Electrical (per task)
    $latestCivilAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, MAX(id) AS max_id
            FROM departments_assign
            WHERE department = 'Civil'
            GROUP BY task_id
        ) x ON x.max_id = da1.id
    ";

    // 🔹 Latest electric submission per task
    $latestCivil = "
        SELECT e1.*
        FROM civil e1
        INNER JOIN (
            SELECT task_id, MAX(C_ID) AS max_id
            FROM civil
            GROUP BY task_id
        ) y ON y.max_id = e1.C_ID
    ";

    $this->db->select("
        t.*,

        da.id AS department_assign_id,
        da.department,
        da.status AS department_status,
        da.assigned_date,
        du.username AS civil_assigned_to,

        ed.C_ID AS civil_detail_id,
        ed.Civil_Authority,
        ed.Civil_Status AS Civil_Status,
        ed.Civil_Authority_Comments,
        ed.Civil_Notes,
        ed.Civil_File,
        ed.Civil_Created_At AS Civil_Created_At
    ", false);

    $this->db->from('tasks t');

    // ✅ Latest Civil assignment
    $this->db->join("($latestCivilAssign) da", 'da.task_id = t.id', 'left', false);
    $this->db->join('users du', 'du.id = da.user_id', 'left');

    // ✅ Latest Civil submission ONLY
    $this->db->join("($latestCivil) ed", 'ed.task_id = t.id', 'left', false);

    $this->db->where('t.id', (int)$task_id);

    return $this->db->get()->row_array();
}

public function get_electric_logs_by_task($task_id)
{
    return $this->db
        ->select('electric.*, users.username AS electric_user_name')
        ->from('electric')
        ->join('users', 'users.id = electric.User_ID', 'left')
        ->where('task_id', (int)$task_id)
        ->order_by('created_at', 'DESC')
        ->get()
        ->result_array();
}

public function get_civil_logs_by_task($task_id)
{
    return $this->db
        ->select('civil.*, users.username AS civil_user_name')
        ->from('civil')
        ->join('users', 'users.id = civil.User_ID', 'left')
        ->where('task_id', (int)$task_id)
        ->order_by('Civil_Created_At', 'DESC')
        ->get()
        ->result_array();
}

public function get_pm_logs_by_task($task_id)
{
    return $this->db
        ->select('pm.*, users.username AS pm_user_name')
        ->from('pm')
        ->join('users', 'users.id = pm.User_ID', 'left')
        ->where('task_id', (int)$task_id)
        ->order_by('PM_Created_At', 'DESC')
        ->get()
        ->result_array();
}

public function get_swt_logs_by_task($task_id)
{
    return $this->db
        ->select('switchgear.*, users.username AS swt_user_name')
        ->from('switchgear')
        ->join('users', 'users.id = switchgear.User_ID', 'left')
        ->where('task_id', (int)$task_id)
        ->order_by('Switchgear_Created_At', 'DESC')
        ->get()
        ->result_array();
}

public function get_mtn_logs_by_task($task_id)
{
    return $this->db
        ->select('maintenance.*, users.username AS mtn_user_name')
        ->from('maintenance')
        ->join('users', 'users.id = maintenance.User_ID', 'left')
        ->where('task_id', (int)$task_id)
        ->order_by('Maintenance_Created_At', 'DESC')
        ->get()
        ->result_array();
}

public function get_latest_electric_log_by_task($task_id)
{
    return $this->db
        ->select('electric.*, departments_assign.status AS electric_status')
        ->from('electric')
        ->join('departments_assign', 'departments_assign.ID = electric.departments_assign_id', 'left')
        ->where('electric.task_id', (int)$task_id)
        ->order_by('E_ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();
}

public function get_latest_civil_log_by_task($task_id)
{
    return $this->db
        ->select('civil.*, departments_assign.status AS civil_status')
        ->from('civil')
        ->join('departments_assign', 'departments_assign.ID = civil.departments_assign_id', 'left')
        ->where('civil.task_id', (int)$task_id)
        ->order_by('civil.C_ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();
}


public function get_latest_pm_log_by_task($task_id)
{
    return $this->db
        ->select('pm.*, departments_assign.status AS pm_status_dep')
        ->from('pm')
        ->join('departments_assign', 'departments_assign.ID = pm.departments_assign_id', 'left')
        ->where('pm.task_id', (int)$task_id)
        ->order_by('P_ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();
}

public function get_pm_department_status($task_id, $department)
{
    $row = $this->db
        ->select('status')
        ->from('departments_assign')
        ->where('task_id', (int)$task_id)
        ->where('department', $department)
        ->order_by('ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();

    return $row ? $row['status'] : null;
}


public function get_department_status($task_id, $department)
{
    $row = $this->db
        ->select('status')
        ->from('departments_assign')
        ->where('task_id', (int)$task_id)
        ->where('department', $department)
        ->order_by('ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();

    return $row ? $row['status'] : null;
}

public function get_latest_swt_log_by_task($task_id)
{
    return $this->db
        ->select('switchgear.*, departments_assign.status AS swt_status')
        ->from('switchgear')
        ->join('departments_assign', 'departments_assign.ID = switchgear.departments_assign_id', 'left')
        ->where('switchgear.task_id', (int)$task_id)
        ->order_by('S_ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();
}

public function get_latest_mtn_log_by_task($task_id)
{
    return $this->db
        ->select('maintenance.*, departments_assign.status AS mtn_status')
        ->from('maintenance')
        ->join('departments_assign', 'departments_assign.ID = maintenance.departments_assign_id', 'left')
        ->where('maintenance.task_id', (int)$task_id)
        ->order_by('M_ID', 'DESC')
        ->limit(1)
        ->get()
        ->row_array();
}

public function get_user_task_detail($task_id, $user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select("
        t.*,
        assigneduser.username AS agent_assigned_name,

        da.id AS department_assign_id,
        da.department AS department,
        da.status AS department_status,
        da.assigned_date,
        da.user_id AS logged_in_user_id,
        
        du.username AS assigned_to
    ", false);

    $this->db->from('tasks t');

    // 🔑 latest assignment only
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->join('users du', 'du.id = da.user_id', 'inner');

    $this->db->join(
        'users AS assigneduser',
        'assigneduser.user_id = t.assigned_to',
        'left'
    );

    // 🔐 SECURITY FILTERS
    $this->db->where('t.id', (int)$task_id);
    $this->db->where('da.user_id', (int)$user_id);

    // Only won jobs
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    return $this->db->get()->row_array();
}

public function get_note_by_id($notes_id)
{
    return $this->db
        ->where('id', $notes_id)
        ->get('job_notes') // ⚠️ change table name if different
        ->row_array();
}

public function insert_lead_note($data)
{
    $this->db->insert('job_notes', $data);
    return $this->db->insert_id();
}


    // get attachments for task
    public function get_lead_attachments($zoho_crm_id)
    {
        return $this->db
            ->select('*')
            ->where('deal_id', $zoho_crm_id)
            ->order_by('created_at', 'DESC')
            ->get('job_attachments')
            ->result_array();
    }

    public function get_task_attachments($id)
    {
        return $this->db
            ->select('*')
            ->where('task_id', $id)
            ->order_by('created_at', 'DESC')
            ->get('task_attachment')
            ->result_array();
    }
    
    public function get_lead_quotation($quote_number){
        
        $this->db->select('proposal_items.*');
        $this->db->from('proposal_items');
        
        $this->db->where('quote_number', $quote_number);
        
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    public function get_your_notes($zoho_crm_id){
        
        $this->db->select('job_notes.*');
        $this->db->from('job_notes');
        
        $this->db->where('deal_id', $zoho_crm_id);
        
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    public function update_notes_details($data, $notes_id){
        
        $this->db->where('id', $notes_id);
        return $this->db->update('job_notes', $data);
     
    }

    public function add_task_attachments($edit, $ID){

        return $this->db->insert('task_attachment', $edit);

    }

    public function update_departments_assign($ID, $data){
        
        $this->db->where('ID', $ID);
        return $this->db->update('departments_assign', $data);
        
        
    }
    
/********** Admin Login Permissions ***************/

    public function get_admin_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->where('status', 'active')
            ->get('users')
            ->row();
    }

    public function get_employees_for_user_link($id)
    {
        return $this->db
            ->where('id', $id)
            ->where('status', 'active')
            ->get('users')
            ->row();
    }

    /* =========================
       ADMIN USERS
       ========================= */

    public function get_admin_users()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_electrical_users()
    {
        return $this->db
            ->where('department_role', 'Electrical')
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_civil_users()
    {
        return $this->db
            ->where('department_role', 'Civil')
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_pm_users()
    {
        return $this->db
            ->where('department_role', 'PM')
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_swg_users()
    {
        return $this->db
            ->where('department_role', 'Switchgear')
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_mtn_users()
    {
        return $this->db
            ->where('department_role', 'Maintenance')
            ->order_by('id', 'ASC')
            ->get('users')
            ->result();
    }

    public function get_admin_user_by_id($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->get('users')
            ->row();
    }

    public function create_admin_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function update_admin_user($id, $data)
    {
        return $this->db
            ->where('id', (int)$id)
            ->update('users', $data);
    }

    public function update_users($ID, $data)
    {
        return $this->db
            ->where('id', $ID)
            ->update('users', $data);
    }

    public function toggle_admin_user_status($id)
    {
        $user = $this->get_admin_user_by_id($id);
        if (!$user) {
            return false;
        }

        $new_status = ($user->status === 'active') ? 'inactive' : 'active';

        return $this->db
            ->where('id', (int)$id)
            ->update('users', ['status' => $new_status]);
    }

    /* =========================
   PERMISSIONS
   ========================= */

    public function get_permission_groups()
    {
        return $this->db
            ->order_by('sort_order','ASC')
            ->get('permission_groups')
            ->result();
    }

    public function get_permissions()
    {
        return $this->db->get('permissions')->result();
    }

    public function get_assigned_permission_ids($admin_id)
    {
        return array_column(
            $this->db
                ->select('permission_id')
                ->where('admin_user_id', (int)$admin_id)
                ->get('admin_user_permissions')
                ->result_array(),
            'permission_id'
        );
    }

    public function save_admin_permissions($admin_id, $permissions)
    {
        // Remove existing
        $this->db
            ->where('admin_user_id', (int)$admin_id)
            ->delete('admin_user_permissions');

        // Insert new
        foreach ($permissions as $pid) {
            $this->db->insert('admin_user_permissions', [
                'admin_user_id' => $admin_id,
                'permission_id' => $pid
            ]);
        }
    }

    /* =========================
    PERMISSION GROUPS
    ========================= */

    public function get_permission_group_by_id($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->get('permission_groups')
            ->row();
    }

    public function create_permission_group($data)
    {
        return $this->db->insert('permission_groups', $data);
    }

    public function update_permission_group($id, $data)
    {
        return $this->db
            ->where('id', (int)$id)
            ->update('permission_groups', $data);
    }

    /* =========================
    PERMISSIONS MASTER
    ========================= */

    public function get_permissions_with_group()
    {
        return $this->db
            ->select('p.*, g.label as group_label')
            ->from('permissions p')
            ->join('permission_groups g', 'g.id = p.group_id')
            ->order_by('g.sort_order','ASC')
            ->get()
            ->result();
    }

    public function get_permission_by_id($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->get('permissions')
            ->row();
    }

    public function create_permission($data)
    {
        return $this->db->insert('permissions', $data);
    }

    public function update_permission($id, $data)
    {
        return $this->db
            ->where('id', (int)$id)
            ->update('permissions', $data);
    }

    public function lead_assinged_agent()
    {
        $this->db->select("
            tasks.*,
            assigneduser.username AS agent_assigned_name
        ");

        $this->db->from('tasks');

        $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = tasks.assigned_to',
            'left'
        );

        return $this->db->get()->result_array();
    }
    
    public function view_all_won_jobs()
    {
        $this->db->select("
            t.*,

            assigneduser.username AS agent_assigned_name,

            elec_user.username AS electrical_assigned_to,
            civ_user.username  AS civil_assigned_to,
            pm_user.username   AS pm_assigned_to,
            swg_user.username  AS swg_assigned_to,
            mtn_user.username  AS mtn_assigned_to,

            elec.status AS electrical_status,
            civ.status  AS civil_status,
            pm.status   AS pm_status,
            swg.status  AS swg_status,
            mtn.status  AS mtn_status
        ");

        $this->db->from('tasks t');

        $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = t.assigned_to',
            'left'
        );

        /* Electrical */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Electrical'
                ) x WHERE rn = 1
            ) elec
        ", 'elec.task_id = t.id', 'left');

        $this->db->join('users elec_user', 'elec_user.id = elec.user_id', 'left');

        /* Civil */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Civil'
                ) x WHERE rn = 1
            ) civ
        ", 'civ.task_id = t.id', 'left');

        $this->db->join('users civ_user', 'civ_user.id = civ.user_id', 'left');

        /* PM */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'PM'
                ) x WHERE rn = 1
            ) pm
        ", 'pm.task_id = t.id', 'left');

        $this->db->join('users pm_user', 'pm_user.id = pm.user_id', 'left');

        /* SWG */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Switchgear'
            ) x WHERE rn = 1
        ) swg
    ", 'swg.task_id = t.id', 'left');
    $this->db->join('users swg_user', 'swg_user.id = swg.user_id', 'left');

    /* MTN */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Maintenance'
            ) x WHERE rn = 1
        ) mtn
    ", 'mtn.task_id = t.id', 'left');
    $this->db->join('users mtn_user', 'mtn_user.id = mtn.user_id', 'left');

        // Only Close to Won jobs
        $this->db->group_start();
            $this->db->where('t.status', 'Close to Won');
            $this->db->or_where('t.status', 'Closed Won');
        $this->db->group_end();
        $this->db->order_by('t.job_deal_number', 'DESC');

        return $this->db->get()->result_array();
    }


    public function view_all_won_jobs_user($user_id, $department, $status){
        
        $latestAssign = "
            SELECT da1.*
            FROM departments_assign da1
            INNER JOIN (
                SELECT task_id, department, MAX(id) AS max_id
                FROM departments_assign
                GROUP BY task_id, department
            ) x ON x.max_id = da1.id
        ";

        $this->db->select("
            t.*,

            da.department AS my_department,
            da.status     AS my_status,
            da.assigned_date,

            u.username  AS agent_assigned_to,
            du.username AS job_assigned_to,

            MAX(CASE WHEN da_all.department = 'Electrical' THEN da_all.status END) AS electrical_status,
            MAX(CASE WHEN da_all.department = 'Civil'      THEN da_all.status END) AS civil_status,
            MAX(CASE WHEN da_all.department = 'PM'         THEN da_all.status END) AS pm_status,
            MAX(CASE WHEN da_all.department = 'Accounts'   THEN da_all.status END) AS accounts_status
        ", false);

        // 🔹 Start from tasks (base table)
        $this->db->from('tasks t');

        // 🔹 Latest assignment ONLY
        $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

        // 🔹 Agent assigned on task
        $this->db->join('users u', 'u.id = t.assigned_to', 'left');

        // 🔹 Latest assignments for all departments (badges)
        $this->db->join("($latestAssign) da_all", 'da_all.task_id = t.id', 'left', false);

        // 🔹 Department user (latest only)
        $this->db->join('users du', 'du.id = da.user_id', 'inner');

        // ✅ CRITICAL FILTER
        // Only show if THIS USER is the LATEST assignee
        $this->db->where('da.user_id', (int)$user_id);
        $this->db->where('da.department', $department);
        $this->db->where_in('da.status', $status);

    //    $this->db->where('t.Job_Status' IS NULL OR LOWER(TRIM(t.Job_Status)) != 'hold')", null, false);

        if($status == 'Assigned' || $status == 'Process' || $status == 'Completed'){
        
        $this->db->group_start();
            $this->db->where('t.Job_Status', 'Active');
            $this->db->or_where('t.Job_Status IS NULL', null, false);
        $this->db->group_end();

        }

        // Only won jobs
        $this->db->group_start();
            $this->db->where('t.status', 'Close to Won');
            $this->db->or_where('t.status', 'Closed Won');
        $this->db->group_end();
        

        $this->db->group_by([
            't.id',
            'da.department',
            'da.status',
            'da.assigned_date',
            'u.username',
            'du.username'
        ]);

        $this->db->order_by('t.created_at', 'DESC');

        return $this->db->get()->result_array();
    }

    public function view_all_won_hold_jobs_user($user_id, $department, $status){
        
        $latestAssign = "
            SELECT da1.*
            FROM departments_assign da1
            INNER JOIN (
                SELECT task_id, department, MAX(id) AS max_id
                FROM departments_assign
                GROUP BY task_id, department
            ) x ON x.max_id = da1.id
        ";

        $this->db->select("
            t.*,

            da.department AS my_department,
            da.status     AS my_status,
            da.assigned_date,

            u.username  AS agent_assigned_to,
            du.username AS job_assigned_to,

            MAX(CASE WHEN da_all.department = 'Electrical' THEN da_all.status END) AS electrical_status,
            MAX(CASE WHEN da_all.department = 'Civil'      THEN da_all.status END) AS civil_status,
            MAX(CASE WHEN da_all.department = 'PM'         THEN da_all.status END) AS pm_status,
            MAX(CASE WHEN da_all.department = 'Accounts'   THEN da_all.status END) AS accounts_status
        ", false);

        // 🔹 Start from tasks (base table)
        $this->db->from('tasks t');

        // 🔹 Latest assignment ONLY
        $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

        // 🔹 Agent assigned on task
        $this->db->join('users u', 'u.id = t.assigned_to', 'left');

        // 🔹 Latest assignments for all departments (badges)
        $this->db->join("($latestAssign) da_all", 'da_all.task_id = t.id', 'left', false);

        // 🔹 Department user (latest only)
        $this->db->join('users du', 'du.id = da.user_id', 'inner');

        // ✅ CRITICAL FILTER
        // Only show if THIS USER is the LATEST assignee
        $this->db->where('da.user_id', (int)$user_id);
        $this->db->where('da.department', $department);
        $this->db->where_in('t.Job_Status', $status);

        // Only won jobs
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

        $this->db->group_by([
            't.id',
            'da.department',
            'da.status',
            'da.assigned_date',
            'u.username',
            'du.username'
        ]);

        $this->db->order_by('t.created_at', 'DESC');

        return $this->db->get()->result_array();
    }


    public function view_all_won_jobs_without_department()
    {
        $this->db->select("
            tasks.*,
            MAX(assigneduser.username) AS agent_assigned_name,

            MAX(CASE WHEN da.department = 'Electrical' THEN da.status END) AS electrical_status,
            MAX(CASE WHEN da.department = 'Civil' THEN da.status END) AS civil_status,
            MAX(CASE WHEN da.department = 'PM' THEN da.status END) AS pm_status,
            MAX(CASE WHEN da.department = 'Switchgear' THEN da.status END) AS swg_status,
            MAX(CASE WHEN da.department = 'Maintenance' THEN da.status END) AS mtn_status
        ");

        $this->db->from('tasks');

        $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = tasks.assigned_to',
            'left'
        );

        $this->db->join(
            'departments_assign AS da',
            'da.task_id = tasks.id',
            'left'
        );

        $this->db->group_start();
        $this->db->where('tasks.status', 'Close to Won');
        $this->db->or_where('tasks.status', 'Closed Won');
        $this->db->group_end();

        // only tasks with ZERO department assignment
        $this->db->where('da.task_id IS NULL', null, false);
      //    $this->db->where('tasks.Job_Status !=', 'Closed');
        $this->db->where("(tasks.Job_Status != 'Closed' OR tasks.Job_Status IS NULL OR tasks.Job_Status = '')", NULL, FALSE);

        $this->db->group_by('tasks.id');

        $this->db->order_by('tasks.job_deal_number', 'DESC');

        return $this->db->get()->result_array();
    }

    public function view_all_won_jobs_under_process()
{
    $this->db->select("
        t.*,

        assigneduser.username AS agent_assigned_name,

        elec_user.username AS electrical_assigned_to,
        civ_user.username  AS civil_assigned_to,
        pm_user.username   AS pm_assigned_to,
        swg_user.username  AS swg_assigned_to,
        mtn_user.username  AS mtn_assigned_to,

        elec.status AS electrical_status,
        civ.status  AS civil_status,
        pm.status   AS pm_status,
        swg.status  AS swg_status,
        mtn.status  AS mtn_status
    ");

    $this->db->from('tasks t');

    $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = t.assigned_to',
            'left'
        );

    /* Electrical */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Electrical'
            ) x WHERE rn = 1
        ) elec
    ", 'elec.task_id = t.id', 'left');
    $this->db->join('users elec_user', 'elec_user.id = elec.user_id', 'left');

    /* Civil */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Civil'
            ) x WHERE rn = 1
        ) civ
    ", 'civ.task_id = t.id', 'left');
    $this->db->join('users civ_user', 'civ_user.id = civ.user_id', 'left');

    /* PM */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'PM'
            ) x WHERE rn = 1
        ) pm
    ", 'pm.task_id = t.id', 'left');
    $this->db->join('users pm_user', 'pm_user.id = pm.user_id', 'left');

    /* SWG */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Switchgear'
            ) x WHERE rn = 1
        ) swg
    ", 'swg.task_id = t.id', 'left');
    $this->db->join('users swg_user', 'swg_user.id = swg.user_id', 'left');

    /* MTN */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Maintenance'
            ) x WHERE rn = 1
        ) mtn
    ", 'mtn.task_id = t.id', 'left');
    $this->db->join('users mtn_user', 'mtn_user.id = mtn.user_id', 'left');

    // Only Close to Won jobs
    $this->db->group_start();
        $this->db->where('t.status', 'Close to Won');
        $this->db->or_where('t.status', 'Closed Won');
    $this->db->group_end();

    // 🔥 ANY department is in Process
    $this->db->where("
        (
            elec.status = 'Process'
            OR civ.status = 'Process'
            OR pm.status = 'Process'
            OR swg.status = 'Process'
            OR mtn.status = 'Process'
            OR elec.status = 'Assigned'
            OR civ.status = 'Assigned'
            OR pm.status = 'Assigned'
            OR swg.status = 'Assigned'
            OR mtn.status = 'Assigned'
        )
    ");

    $this->db->order_by('t.job_deal_number', 'DESC');

    return $this->db->get()->result_array();
}


    public function view_all_won_jobs_completed()
    {
       
    $this->db->select("
        t.*,

        assigneduser.username AS agent_assigned_name,

        elec_user.username AS electrical_assigned_to,
        civ_user.username  AS civil_assigned_to,
        pm_user.username   AS pm_assigned_to,
        swg_user.username  AS swg_assigned_to,
        mtn_user.username  AS mtn_assigned_to,

        elec.status AS electrical_status,
        civ.status  AS civil_status,
        pm.status   AS pm_status,
        swg.status  AS swg_status,
        mtn.status  AS mtn_status
    ");

    $this->db->from('tasks t');

    $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = t.assigned_to',
            'left'
        );

    /* Electrical */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Electrical'
            ) x WHERE rn = 1
        ) elec
    ", 'elec.task_id = t.id', 'left');
    $this->db->join('users elec_user', 'elec_user.id = elec.user_id', 'left');

    /* Civil */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Civil'
            ) x WHERE rn = 1
        ) civ
    ", 'civ.task_id = t.id', 'left');
    $this->db->join('users civ_user', 'civ_user.id = civ.user_id', 'left');

    /* PM */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'PM'
            ) x WHERE rn = 1
        ) pm
    ", 'pm.task_id = t.id', 'left');
    $this->db->join('users pm_user', 'pm_user.id = pm.user_id', 'left');

    /* SWG */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Switchgear'
            ) x WHERE rn = 1
        ) swg
    ", 'swg.task_id = t.id', 'left');
    $this->db->join('users swg_user', 'swg_user.id = swg.user_id', 'left');

    /* MTN */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Maintenance'
            ) x WHERE rn = 1
        ) mtn
    ", 'mtn.task_id = t.id', 'left');
    $this->db->join('users mtn_user', 'mtn_user.id = mtn.user_id', 'left');

    // Only Close to Won jobs
    $this->db->group_start();
        $this->db->where('t.status', 'Close to Won');
        $this->db->or_where('t.status', 'Closed Won');
    $this->db->group_end();

    // 🔥 ANY department is in Process
    $this->db->where("
        (
            elec.status   = 'Completed'
            OR civ.status = 'Completed'
            OR pm.status  = 'Completed'
            OR swg.status = 'Completed'
            OR mtn.status = 'Completed'
        )
    ");

    $this->db->order_by('t.job_deal_number', 'DESC');

    return $this->db->get()->result_array();
    }

    public function view_all_won_jobs_hold()
    {
       
        $this->db->select("
            t.*,

            assigneduser.username AS agent_assigned_name,

            elec_user.username AS electrical_assigned_to,
            civ_user.username  AS civil_assigned_to,
            pm_user.username   AS pm_assigned_to,
            swg_user.username  AS swg_assigned_to,
            mtn_user.username  AS mtn_assigned_to,

            elec.status AS electrical_status,
            civ.status  AS civil_status,
            pm.status   AS pm_status,
            swg.status  AS swg_status,
            mtn.status  AS mtn_status
        ");

        $this->db->from('tasks t');

        $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = t.assigned_to',
            'left'
        );

        /* Electrical */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Electrical'
                ) x WHERE rn = 1
            ) elec
        ", 'elec.task_id = t.id', 'left');
        $this->db->join('users elec_user', 'elec_user.id = elec.user_id', 'left');

        /* Civil */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Civil'
                ) x WHERE rn = 1
            ) civ
        ", 'civ.task_id = t.id', 'left');
        $this->db->join('users civ_user', 'civ_user.id = civ.user_id', 'left');

        /* PM */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'PM'
                ) x WHERE rn = 1
            ) pm
        ", 'pm.task_id = t.id', 'left');
        $this->db->join('users pm_user', 'pm_user.id = pm.user_id', 'left');

        /* SWG */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Switchgear'
            ) x WHERE rn = 1
        ) swg
    ", 'swg.task_id = t.id', 'left');
    $this->db->join('users swg_user', 'swg_user.id = swg.user_id', 'left');

    /* MTN */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Maintenance'
            ) x WHERE rn = 1
        ) mtn
    ", 'mtn.task_id = t.id', 'left');
    $this->db->join('users mtn_user', 'mtn_user.id = mtn.user_id', 'left');

        // Only Close to Won jobs
        $this->db->group_start();
            $this->db->where('t.status', 'Close to Won');
            $this->db->or_where('t.status', 'Closed Won');
        $this->db->group_end();
        $this->db->where('t.Job_Status', 'Hold');

    

        $this->db->order_by('t.job_deal_number', 'DESC');

        return $this->db->get()->result_array();
    }

    public function view_all_won_jobs_closed()
    {
       
        $this->db->select("
            t.*,
            assigneduser.username AS agent_assigned_name,

            elec_user.username AS electrical_assigned_to,
            civ_user.username  AS civil_assigned_to,
            pm_user.username   AS pm_assigned_to,
            swg_user.username  AS swg_assigned_to,
            mtn_user.username  AS mtn_assigned_to,

            elec.status AS electrical_status,
            civ.status  AS civil_status,
            pm.status   AS pm_status,
            swg.status  AS swg_status,
            mtn.status  AS mtn_status
        ");

        $this->db->from('tasks t');

        $this->db->join(
            'users AS assigneduser',
            'assigneduser.user_id = t.assigned_to',
            'left'
        );

        /* Electrical */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Electrical'
                ) x WHERE rn = 1
            ) elec
        ", 'elec.task_id = t.id', 'left');
        $this->db->join('users elec_user', 'elec_user.id = elec.user_id', 'left');

        /* Civil */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'Civil'
                ) x WHERE rn = 1
            ) civ
        ", 'civ.task_id = t.id', 'left');
        $this->db->join('users civ_user', 'civ_user.id = civ.user_id', 'left');

        /* PM */
        $this->db->join("
            (
                SELECT *
                FROM (
                    SELECT da.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY da.task_id, da.department
                            ORDER BY da.id DESC
                        ) rn
                    FROM departments_assign da
                    WHERE da.department = 'PM'
                ) x WHERE rn = 1
            ) pm
        ", 'pm.task_id = t.id', 'left');
        $this->db->join('users pm_user', 'pm_user.id = pm.user_id', 'left');

        /* SWG */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Switchgear'
            ) x WHERE rn = 1
        ) swg
    ", 'swg.task_id = t.id', 'left');
    $this->db->join('users swg_user', 'swg_user.id = swg.user_id', 'left');

    /* MTN */
    $this->db->join("
        (
            SELECT *
            FROM (
                SELECT da.*,
                       ROW_NUMBER() OVER (
                           PARTITION BY da.task_id, da.department
                           ORDER BY da.id DESC
                       ) rn
                FROM departments_assign da
                WHERE da.department = 'Maintenance'
            ) x WHERE rn = 1
        ) mtn
    ", 'mtn.task_id = t.id', 'left');
    $this->db->join('users mtn_user', 'mtn_user.id = mtn.user_id', 'left');

        // Only Close to Won jobs
        $this->db->group_start();
            $this->db->where('t.status', 'Close to Won');
            $this->db->or_where('t.status', 'Closed Won');
        $this->db->group_end();
        $this->db->where('t.Job_Status', 'Closed');

    

        $this->db->order_by('t.job_deal_number', 'DESC');

        return $this->db->get()->result_array();
    }







    public function update_assign_department($data){
        
        return $this->db->insert('departments_assign', $data);
        return $query;
    
    }

    public function update_assign_accounts($data){
        
        return $this->db->insert('accounts', $data);
        return $query;
    
    }

    public function update_tasks($data, $task_id){
        
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', $data);
        
    }

    public function insert_electrical($data){
        
        return $this->db->insert('electric', $data);
        return $query;
    
    }

    public function insert_civil($data){
        
        return $this->db->insert('civil', $data);
        return $query;
    
    }

    public function insert_switchgear($data){
        
        return $this->db->insert('switchgear', $data);
        return $query;
    
    }

    public function insert_maintenance($data){
        
        return $this->db->insert('maintenance', $data);
        return $query;
    
    }

    public function insert_pm($data){
        
        return $this->db->insert('pm', $data);
        return $query;
    
    }

    public function count_total_won_jobs_admin(){

        $this->db->select('COUNT(*) as count_total_won_jobs_admin');
        $this->db->from('tasks');

        $this->db->group_start();
        $this->db->where('tasks.status', 'Close to Won');
        $this->db->or_where('tasks.status', 'Closed Won');
        $this->db->group_end();

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row()->count_total_won_jobs_admin;
        }
        return 0;

    }

    public function count_pending_jobs_assign_admin(){

        $this->db->select('tasks.id');

        $this->db->from('tasks');

        $this->db->join(
            'departments_assign AS da',
            'da.task_id = tasks.id',
            'left'
        );

        $this->db->where('da.task_id IS NULL', null, false);

        $this->db->group_start();
        $this->db->where('tasks.status', 'Close to Won');
        $this->db->or_where('tasks.status', 'Closed Won');
        $this->db->group_end();

        return $this->db->count_all_results();

    }

    public function count_completed_jobs_with_departments(){

        $this->db->select("
            tasks.id,
            COUNT(da.id) AS total_assigned,
            SUM(CASE WHEN da.status = 'Completed' THEN 1 ELSE 0 END) AS completed_count
        ");

        $this->db->from('tasks');

        $this->db->join(
            'departments_assign AS da',
            'da.task_id = tasks.id',
            'inner'
        );

        // Optional: exclude cancelled / omitted jobs
        // $this->db->where_not_in('tasks.status', ['Omitted', 'Close to Lost']);

        $this->db->group_by('tasks.id');

        // 🔑 ALL assigned departments must be completed
        $this->db->having('total_assigned = completed_count');

        return $this->db->count_all_results();
        
    }

    public function pending_accounts_summary(){

        $subquery = "
            SELECT 
                t.id AS task_id,
                (t.service_charge - IFNULL(SUM(a.received_amount), 0)) AS pending_amount
            FROM tasks t
            LEFT JOIN accounts a ON a.task_id = t.id
            WHERE t.status = 'Close to Won'
            GROUP BY t.id
            HAVING pending_amount > 0
        ";

        $query = $this->db->query("
            SELECT 
                COUNT(*) AS pending_jobs,
                IFNULL(SUM(p.pending_amount), 0) AS total_pending
            FROM ($subquery) p
        ");

        return $query->row_array();

    }

    public function close_to_won_percentage(){

        $query = $this->db->query("
            SELECT 
                ROUND(
                    (
                        SUM(
                            CASE 
                                WHEN status IN ('Close to Won', 'Closed Won')
                                THEN 1 
                                ELSE 0 
                            END
                        ) / COUNT(*)
                    ) * 100,
                    2
                ) AS won_percentage
            FROM tasks
        ");

        return (float) ($query->row()->won_percentage ?? 0);

    }

    public function ommitted_percentage(){
    
        $query = $this->db->query("
            SELECT 
                ROUND(
                    (
                        SUM(
                            CASE 
                                WHEN status IN ('Close to Lost', 'Closed Lost', 'Omitted', 'Proposal-Omitted')
                                THEN 1 
                                ELSE 0 
                            END
                        ) / COUNT(*)
                    ) * 100,
                    2
                ) AS omitted_percentage
            FROM tasks
        ");

        return (float) ($query->row()->omitted_percentage ?? 0);
    }

    public function pending_percentage(){

        $query = $this->db->query("
            SELECT 
                ROUND(
                    (
                        SUM(
                            CASE 
                                WHEN status IN ('Pending', 'Qualification')
                                THEN 1 
                                ELSE 0 
                            END
                        ) / COUNT(*)
                    ) * 100,
                    2
                ) AS pending_percentage
            FROM tasks
        ");

        return (float) ($query->row()->pending_percentage ?? 0);

    }

    public function proposal_percentage(){

        $query = $this->db->query("
            SELECT 
                ROUND(
                    (
                        SUM(
                            CASE 
                                WHEN status IN ('Proposal', 'Proposal/Price Quote')
                                THEN 1 
                                ELSE 0 
                            END
                        ) / COUNT(*)
                    ) * 100,
                    2
                ) AS proposal_percentage
            FROM tasks
        ");

        return (float) ($query->row()->proposal_percentage ?? 0);

    }

    public function site_visit_percentage(){

        $query = $this->db->query("
            SELECT 
                ROUND(
                    (SUM(CASE WHEN status = 'Site Visit' THEN 1 ELSE 0 END) / COUNT(*)) * 100,
                    2
                ) AS site_visit_percentage
            FROM tasks
        ");

        return (float) ($query->row()->site_visit_percentage ?? 0);

    }

    public function big_project_percentage()
{
    $query = $this->db->query("
        SELECT 
            ROUND(
                (
                    SUM(
                        CASE 
                            WHEN status = 'Big Project' 
                                 OR status IS NULL 
                                 OR status = '' 
                            THEN 1 
                            ELSE 0 
                        END
                    ) / COUNT(*)
                ) * 100,
                2
            ) AS big_project_percentage
        FROM tasks
    ");

    return (float) ($query->row()->big_project_percentage ?? 0);
   }

    public function get_all_users_won_department_counts()
{
    $sql = "
        SELECT 
            u.id,
            u.username AS name,

            SUM(CASE WHEN da.department = 'Electrical' THEN 1 ELSE 0 END) AS electrical_count,
            SUM(CASE WHEN da.department = 'Civil' THEN 1 ELSE 0 END) AS civil_count,
            SUM(CASE WHEN da.department = 'PM' THEN 1 ELSE 0 END) AS pm_count,
            SUM(CASE WHEN da.department = 'Accounts' THEN 1 ELSE 0 END) AS accounts_count

        FROM users u
        LEFT JOIN departments_assign da 
            ON da.user_id = u.id
        LEFT JOIN tasks t 
            ON t.id = da.task_id
           AND LOWER(TRIM(t.status)) IN ('close to won', 'closed won')

     
        GROUP BY u.id, u.username
        ORDER BY u.username ASC
    ";

    return $this->db->query($sql)->result_array();
}

/***************************************/
/*      Counts of Leads Pipelines     */
/***************************************/

public function pending_qualification_count()
{
    return $this->db
        ->where_in('status', ['Pending', 'Qualification'])
        ->count_all_results('tasks');
}

public function pending_qualification_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('status', ['Pending', 'Qualification'])
        ->where_in('assigned_to', $zoho_user_id)
        ->count_all_results('tasks');
}

public function pending_site_visit_count()
{
    return $this->db
        ->where_in('status', ['Site Visit'])
        ->count_all_results('tasks');
}

public function pending_site_visit_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('status', ['Site Visit'])
        ->where_in('assigned_to', $zoho_user_id)
        ->count_all_results('tasks');
}

public function pending_proposal_count()
{
    return $this->db
        ->where_in('status', ['Proposal', 'Proposal/Price Quote'])
        ->count_all_results('tasks');
}

public function pending_proposal_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('status', ['Proposal', 'Proposal/Price Quote'])
        ->where_in('assigned_to', $zoho_user_id)
        ->count_all_results('tasks');
}

public function pending_won_count()
{
    return $this->db
        ->where_in('status', ['Close to Won', 'Closed Won'])
        ->count_all_results('tasks');
}

public function pending_won_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('status', ['Close to Won', 'Closed Won'])
        ->where_in('assigned_to', $zoho_user_id)
        ->count_all_results('tasks');
}

public function pending_ommitted_count()
{
    return $this->db
        ->where_in('status', ['Close to Lost', 'Closed Lost', 'Omitted', 'Proposal-Omitted'])
        ->count_all_results('tasks');
}

public function pending_ommitted_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('status', ['Close to Lost', 'Closed Lost', 'Omitted', 'Proposal-Omitted'])
        ->where_in('assigned_to', $zoho_user_id)
        ->count_all_results('tasks');
}

public function tasks_assigned_leads_today_count_user($zoho_user_id)
{
    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    return $this->db
        ->where('created_at >=', $start)
        ->where('created_at <=', $end)
        ->where_in('assigned_to', (array)$zoho_user_id)
        ->count_all_results('tasks');
}

public function tasks_assigned_this_month_count_user($zoho_user_id)
{
    $start = date('Y-m-01 00:00:00'); // first day of month
    $end   = date('Y-m-t 23:59:59');  // last day of month

    return $this->db
        ->where('created_at >=', $start)
        ->where('created_at <=', $end)
        ->where_in('assigned_to', (array)$zoho_user_id)
        ->count_all_results('tasks');
}

public function tasks_assigned_leads_count_user($zoho_user_id)
{
    return $this->db
        ->where_in('assigned_to', (array)$zoho_user_id)
        ->count_all_results('tasks');
}

public function count_todays_leads()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM tasks
        WHERE DATE(created_at) = CURDATE()
    ");

    return (int) $query->row()->total;
}

public function count_monthly_leads()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM tasks
        WHERE created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
        AND created_at <  DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
    ");

    return (int) $query->row()->total;
}

public function count_total_electrical_department_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(DISTINCT task_id) AS total
        FROM departments_assign
        WHERE department = 'Electrical'
    ");

    return (int) $query->row()->total;
}

public function count_total_civil_department_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(DISTINCT task_id) AS total
        FROM departments_assign
        WHERE department = 'Civil'
    ");

    return (int) $query->row()->total;
}

public function count_total_pm_department_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(DISTINCT task_id) AS total
        FROM departments_assign
        WHERE department = 'PM'
    ");

    return (int) $query->row()->total;
}

public function count_total_electrical_department_status_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Electrical'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Electrical'
        AND da.status = 'Assigned'
    ");

    return (int) $query->row()->total;
}


public function count_total_electrical_department_status_progress()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Electrical'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Electrical'
        AND da.status = 'Process'
    ");

    return (int) $query->row()->total;
}

public function count_total_electrical_department_status_completed()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Electrical'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Electrical'
        AND da.status = 'Completed'
    ");

    return (int) $query->row()->total;
}

public function count_total_electrical_department_status_hold()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Electrical'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Electrical'
        AND da.status = 'Hold'
    ");

    return (int) $query->row()->total;
}

public function count_total_civil_department_status_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Civil'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Civil'
        AND da.status = 'Assigned'
    ");

    return (int) $query->row()->total;
}


public function count_total_civil_department_status_progress()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Civil'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Civil'
        AND da.status = 'Process'
    ");

    return (int) $query->row()->total;
}

public function count_total_civil_department_status_completed()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Civil'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Civil'
        AND da.status = 'Completed'
    ");

    return (int) $query->row()->total;
}

public function count_total_civil_department_status_hold()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'Civil'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'Civil'
        AND da.status = 'Hold'
    ");

    return (int) $query->row()->total;
}

public function count_total_pm_department_status_assigned()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da

        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'PM'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest

        INNER JOIN tasks t ON t.id = da.task_id

        WHERE da.department = 'PM'
        AND da.status = 'Assigned'
        AND (t.Job_Status IS NULL OR t.Job_Status = 'Active')
    ");

    return (int) $query->row()->total;
}


public function count_total_pm_department_status_progress()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'PM'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'PM'
        AND da.status = 'Process'
    ");

    return (int) $query->row()->total;
}

public function count_total_pm_department_status_completed()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'PM'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'PM'
        AND da.status = 'Completed'
    ");

    return (int) $query->row()->total;
}

public function count_total_pm_department_status_hold()
{
    $query = $this->db->query("
        SELECT COUNT(*) AS total
        FROM departments_assign da
        INNER JOIN (
            SELECT task_id, MAX(assigned_date) AS latest
            FROM departments_assign
            WHERE department = 'PM'
            GROUP BY task_id
        ) latest_assign
        ON da.task_id = latest_assign.task_id
        AND da.assigned_date = latest_assign.latest
        WHERE da.department = 'PM'
        AND da.status = 'Hold'
    ");

    return (int) $query->row()->total;
}

/*********************************************/

/*            Electric Counts               */

/*******************************************/

public function total_pending_electrical_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pending_electrical_jobs');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Electrical');
    $this->db->where('da.status', 'Assigned');
    //$this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();


    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_pending_electrical_jobs;
    }

    return 0;
}

public function total_process_electrical_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_electrical_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Electrical');
    $this->db->where('da.status', 'Process');
    //$this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();


    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_electrical_jobs_count;
    }

    return 0;
}

public function total_completed_electrical_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_electrical_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Electrical');
    $this->db->where('da.status', 'Completed');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_electrical_jobs_count;
    }

    return 0;
}

public function total_hold_electrical_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_hold_electrical_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ SAME filters as your hold listing
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Electrical');
    $this->db->where('t.Job_Status', 'Hold');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_hold_electrical_jobs_count;
    }

    return 0;
}

public function total_assigned_today_electrical_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_assigned_today_electrical', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Electrical');

    // ✅ Assigned today (datetime range)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if you only want won jobs
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_assigned_today_electrical : 0;
}

public function total_completed_this_month_electrical_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    // 🔹 current month range
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_this_month_electrical', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ filters
    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Electrical');
    $this->db->where('da.status', 'Completed');

    // ✅ completed this month (based on assignment date)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if same business rule
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0)
        ? (int)$q->row()->total_completed_this_month_electrical
        : 0;
}

public function total_electrical_jobs_assigned_to_user($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_electrical_jobs', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Electrical');

    // keep this only if your dashboards are for won jobs only
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_electrical_jobs : 0;
}

/*********************************************/

/*            Civil Counts               */

/*******************************************/

public function total_pending_civil_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pending_civil_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Civil');
    $this->db->where('da.status', 'Assigned');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();


    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_pending_civil_jobs_count;
    }

    return 0;
}

public function total_process_civil_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_civil_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Civil');
    $this->db->where('da.status', 'Process');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();


    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_civil_jobs_count;
    }

    return 0;
}

public function total_completed_civil_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_civil_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Civil');
    $this->db->where('da.status', 'Completed');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_completed_civil_jobs_count;
    }

    return 0;
}

public function total_hold_civil_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_hold_civil_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ SAME filters as your hold listing
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Civil');
    $this->db->where('t.Job_Status', 'Hold');
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_hold_civil_jobs_count;
    }

    return 0;
}

public function total_assigned_today_civil_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_assigned_today_civil_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Civil');

    // ✅ Assigned today (datetime range)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if you only want won jobs
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_assigned_today_civil_jobs_count : 0;
}

public function total_completed_this_month_civil_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    // 🔹 current month range
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_this_month_civil_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ filters
    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Civil');
    $this->db->where('da.status', 'Completed');

    // ✅ completed this month (based on assignment date)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if same business rule
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0)
        ? (int)$q->row()->total_completed_this_month_civil_jobs_count
        : 0;
}

public function total_civil_jobs_assigned_to_user($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_civil_jobs_assigned_to_user', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Civil');

    // keep this only if your dashboards are for won jobs only
//    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_civil_jobs_assigned_to_user : 0;
}

/*********************************************/

/*                SWT Counts                 */

/*******************************************/

public function total_pending_swt_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pending_swt_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Switchgear');
    $this->db->where('da.status', 'Assigned');

  

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_pending_swt_jobs_count;
    }

    return 0;
}

public function total_process_swt_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_swt_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Switchgear');
    $this->db->where('da.status', 'Process');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_swt_jobs_count;
    }

    return 0;
}

public function total_completed_swt_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_swt_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Switchgear');
    $this->db->where('da.status', 'Completed');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_completed_swt_jobs_count;
    }

    return 0;
}

public function total_hold_swt_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_hold_swt_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ SAME filters as your hold listing
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Switchgear');
    $this->db->where('t.Job_Status', 'Hold');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_hold_swt_jobs_count;
    }

    return 0;
}

public function total_assigned_today_swt_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_assigned_today_swt_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Switchgear');

    // ✅ Assigned today (datetime range)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if you only want won jobs
  //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_assigned_today_swt_jobs_count : 0;
}

public function total_completed_this_month_swt_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    // 🔹 current month range
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_this_month_swt_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ filters
    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Switchgear');
    $this->db->where('da.status', 'Completed');

    // ✅ completed this month (based on assignment date)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if same business rule
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0)
        ? (int)$q->row()->total_completed_this_month_swt_jobs_count
        : 0;
}

public function total_swt_jobs_assigned_to_user($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_swt_jobs_assigned_to_user', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Switchgear');

    // keep this only if your dashboards are for won jobs only
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_swt_jobs_assigned_to_user : 0;
}

/*********************************************/

/*                MTN Counts                 */

/*******************************************/

public function total_pending_mtn_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pending_mtn_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Maintenance');
    $this->db->where('da.status', 'Assigned');

  

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_pending_mtn_jobs_count;
    }

    return 0;
}

public function total_process_mtn_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_mtn_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Maintenance');
    $this->db->where('da.status', 'Process');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_mtn_jobs_count;
    }

    return 0;
}

public function total_completed_mtn_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_mtn_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Maintenance');
    $this->db->where('da.status', 'Completed');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_completed_mtn_jobs_count;
    }

    return 0;
}

public function total_hold_mtn_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_hold_mtn_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ SAME filters as your hold listing
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'Maintenance');
    $this->db->where('t.Job_Status', 'Hold');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_hold_mtn_jobs_count;
    }

    return 0;
}

public function total_assigned_today_mtn_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_assigned_today_swt_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Maintenance');

    // ✅ Assigned today (datetime range)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if you only want won jobs
  //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_assigned_today_swt_jobs_count : 0;
}

public function total_completed_this_month_mtn_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    // 🔹 current month range
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_this_month_mtn_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ filters
    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Maintenance');
    $this->db->where('da.status', 'Completed');

    // ✅ completed this month (based on assignment date)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if same business rule
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0)
        ? (int)$q->row()->total_completed_this_month_mtn_jobs_count
        : 0;
}

public function total_mtn_jobs_assigned_to_user($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_mtn_jobs_assigned_to_user', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'Maintenance');

    // keep this only if your dashboards are for won jobs only
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_mtn_jobs_assigned_to_user : 0;
}

/*********************************************/

/*                PM Counts                 */

/*******************************************/

public function total_pending_pm_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pending_pm_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'PM');
    $this->db->where('da.status', 'Assigned');

  

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_pending_pm_jobs_count;
    }

    return 0;
}

public function total_process_pm_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_process_pm_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'PM');
    $this->db->where('da.status', 'Process');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $this->db->group_start();
    $this->db->where('t.Job_Status', 'Active');
    $this->db->or_where('t.Job_Status IS NULL', null, false);
    $this->db->group_end();

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_process_pm_jobs_count;
    }

    return 0;
}

public function total_completed_pm_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_pm_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ Filters (same logic as your listing)
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'PM');
    $this->db->where('da.status', 'Completed');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_completed_pm_jobs_count;
    }

    return 0;
}

public function total_hold_pm_jobs_count($user)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_hold_pm_jobs_count');
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ SAME filters as your hold listing
    $this->db->where('da.user_id', (int)$user);
    $this->db->where('da.department', 'PM');
    $this->db->where('t.Job_Status', 'Hold');
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->total_hold_pm_jobs_count;
    }

    return 0;
}

public function total_assigned_today_pm_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_assigned_today_pm_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'PM');

    // ✅ Assigned today (datetime range)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if you only want won jobs
  //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_assigned_today_pm_jobs_count : 0;
}

public function total_completed_this_month_pm_jobs_count($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    // 🔹 current month range
    $start = date('Y-m-01 00:00:00');
    $end   = date('Y-m-t 23:59:59');

    $this->db->select('COUNT(DISTINCT t.id) as total_completed_this_month_pm_jobs_count', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    // ✅ filters
    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'PM');
    $this->db->where('da.status', 'Completed');

    // ✅ completed this month (based on assignment date)
    $this->db->where('da.assigned_date >=', $start);
    $this->db->where('da.assigned_date <=', $end);

    // keep if same business rule
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0)
        ? (int)$q->row()->total_completed_this_month_pm_jobs_count
        : 0;
}

public function total_pm_jobs_assigned_to_user($user_id)
{
    $latestAssign = "
        SELECT da1.*
        FROM departments_assign da1
        INNER JOIN (
            SELECT task_id, department, MAX(id) AS max_id
            FROM departments_assign
            GROUP BY task_id, department
        ) x ON x.max_id = da1.id
    ";

    $this->db->select('COUNT(DISTINCT t.id) as total_pm_jobs_assigned_to_user', false);
    $this->db->from('tasks t');
    $this->db->join("($latestAssign) da", 'da.task_id = t.id', 'inner', false);

    $this->db->where('da.user_id', (int)$user_id);
    $this->db->where('da.department', 'PM');

    // keep this only if your dashboards are for won jobs only
    //    $this->db->where("LOWER(TRIM(t.status))", 'close to won');

    $q = $this->db->get();

    return ($q->num_rows() > 0) ? (int)$q->row()->total_pm_jobs_assigned_to_user : 0;
}

public function get_all_quotations()
    {
        $this->db->select('
        tasks.created_at AS quote_created_time,
        tasks.quote_number,
        tasks.deal_number,
        tasks.account_name,
        tasks.status,
        tasks.service_charge,
        tasks.id,
        assigneduser.username AS assigned_username
    ');

    $this->db->from('tasks');

    $this->db->join('users as assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');

    $this->db->where('tasks.quote_number IS NOT NULL');

    $this->db->order_by('tasks.created_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();

    }

public function get_all_sales_quotations($zoho_user_id)
{
    $this->db->select('
        tasks.created_at AS quote_created_time,
        tasks.quote_number,
        tasks.deal_number,
        tasks.account_name,
        tasks.status,
        tasks.service_charge,
        tasks.id,
        assigneduser.username AS assigned_username
    ');

    $this->db->from('tasks');

    $this->db->join('users as assigneduser', 'assigneduser.user_id = tasks.assigned_to', 'left');

    $this->db->where('tasks.assigned_to', $zoho_user_id);
    $this->db->where('tasks.quote_number IS NOT NULL');

    $this->db->order_by('tasks.created_at', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
}

    public function get_user_by_user_id($userId)
{
    return $this->db->get_where('users', array('user_id' => $userId))->row_array();
}

public function update_user($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('users', $data);
}

public function create_user($data)
{
    $this->db->insert('users', $data);
    return $this->db->insert_id();
}

public function unassign_department($task_id, $department)
{
    $this->db->where('task_id', $task_id);
    $this->db->where('department', $department);

    return $this->db->update(
        'departments_assign',
        [
            'user_id' => null,
            'status'  => 'Unassigned'
        ]
    );
}

public function save_admin_remarks($task_id, $remarks)
{
    $this->db->where('id', $task_id);

    return $this->db->update(
        'tasks',
        [
            'Admin_Remarks' => $remarks
        ]
    );
}

    













    
    
    
    
}











?>