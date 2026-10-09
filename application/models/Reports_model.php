<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    private $users_table = 'users';
    private $tasks_table = 'tasks';
    private $departments_table = 'departments_assign';

    private function apply_task_date_filter($date_from, $date_to)
    {
        if (!empty($date_from)) {
            $this->db->where('DATE(t.created_at) >=', $date_from);
        }

        if (!empty($date_to)) {
            $this->db->where('DATE(t.created_at) <=', $date_to);
        }
    }

    public function get_employee_report_summary($date_from = null, $date_to = null)
    {
        $summary = [
            'total_employees'   => 0,
            'total_deals'       => 0,
            'won_jobs'          => 0,
            'total_won_amount'  => 0,
            'active_jobs'       => 0,
            'hold_jobs'         => 0,
            'closed_jobs'       => 0
        ];

        $summary['total_employees'] = (int) $this->db
            ->where('status', 'active')
            ->count_all_results($this->users_table);

        $this->db->select("
            COUNT(t.id) AS total_deals,

            SUM(CASE 
                WHEN t.status IN ('Close to Won', 'Closed Won') 
                THEN 1 ELSE 0 
            END) AS won_jobs,

            SUM(CASE 
                WHEN t.status IN ('Close to Won', 'Closed Won') 
                THEN IFNULL(t.service_charge, 0) ELSE 0 
            END) AS total_won_amount,

            SUM(CASE 
                WHEN t.Job_Status IS NULL OR t.Job_Status = '' OR t.Job_Status = 'Active' 
                THEN 1 ELSE 0 
            END) AS active_jobs,

            SUM(CASE 
                WHEN t.Job_Status = 'Hold' 
                THEN 1 ELSE 0 
            END) AS hold_jobs,

            SUM(CASE 
                WHEN t.Job_Status = 'Closed' 
                THEN 1 ELSE 0 
            END) AS closed_jobs
        ", false);

        $this->db->from($this->tasks_table . ' t');
        $this->apply_task_date_filter($date_from, $date_to);

        $row = $this->db->get()->row_array();

        if ($row) {
            $summary['total_deals']      = (int) $row['total_deals'];
            $summary['won_jobs']         = (int) $row['won_jobs'];
            $summary['total_won_amount'] = (float) $row['total_won_amount'];
            $summary['active_jobs']      = (int) $row['active_jobs'];
            $summary['hold_jobs']        = (int) $row['hold_jobs'];
            $summary['closed_jobs']      = (int) $row['closed_jobs'];
        }

        return $summary;
    }

    public function get_employee_performance_report($date_from = null, $date_to = null)
    {
        $date_condition = "";

        if (!empty($date_from)) {
            $date_condition .= " AND DATE(t.created_at) >= " . $this->db->escape($date_from);
        }

        if (!empty($date_to)) {
            $date_condition .= " AND DATE(t.created_at) <= " . $this->db->escape($date_to);
        }

        $latestAssign = "
            SELECT da1.*
            FROM departments_assign da1
            INNER JOIN (
                SELECT task_id, department, MAX(id) AS max_id
                FROM departments_assign
                GROUP BY task_id, department
            ) x ON x.max_id = da1.id
        ";

        $sql = "
            SELECT 
                u.id,
                u.user_id,
                u.username,
                u.department_role,
                u.status AS user_status,

                COUNT(DISTINCT t.id) AS total_deals,

                SUM(CASE WHEN t.status IN ('Pending', 'Qualification') THEN 1 ELSE 0 END) AS qualification_count,
                SUM(CASE WHEN t.status = 'Site Visit' THEN 1 ELSE 0 END) AS site_visit_count,
                SUM(CASE WHEN t.status IN ('Proposal', 'Proposal/Price Quote') THEN 1 ELSE 0 END) AS proposal_count,

                SUM(CASE WHEN t.status IN ('Close to Won', 'Closed Won') THEN 1 ELSE 0 END) AS closed_won_count,

                SUM(CASE WHEN t.status IN ('Close to Lost', 'Closed Lost') THEN 1 ELSE 0 END) AS closed_lost_count,

                SUM(CASE WHEN t.status = 'Omitted' THEN 1 ELSE 0 END) AS omitted_count,

                SUM(CASE WHEN t.status IN ('Proposal-Omitted', 'Proposal Omitted') THEN 1 ELSE 0 END) AS proposal_omitted_count,

                SUM(CASE 
                    WHEN t.status IN ('Close to Won', 'Closed Won') 
                    THEN IFNULL(t.service_charge, 0) ELSE 0 
                END) AS total_won_amount,

                COUNT(DISTINCT CASE 
                    WHEN da.department = 'Electrical' THEN da.task_id 
                END) AS electrical_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.department = 'Civil' THEN da.task_id 
                END) AS civil_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.department = 'PM' THEN da.task_id 
                END) AS pm_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.department = 'Accounts' THEN da.task_id 
                END) AS accounts_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.status = 'Assigned' THEN da.task_id 
                END) AS assigned_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.status = 'Process' THEN da.task_id 
                END) AS process_jobs,

                COUNT(DISTINCT CASE 
                    WHEN da.status = 'Completed' THEN da.task_id 
                END) AS completed_jobs,

                COUNT(DISTINCT CASE 
                    WHEN tj.Job_Status IS NULL OR tj.Job_Status = '' OR tj.Job_Status = 'Active' 
                    THEN tj.id 
                END) AS active_jobs,

                COUNT(DISTINCT CASE 
                    WHEN tj.Job_Status = 'Hold' 
                    THEN tj.id 
                END) AS hold_jobs,

                COUNT(DISTINCT CASE 
                    WHEN tj.Job_Status = 'Closed' 
                    THEN tj.id 
                END) AS closed_jobs

            FROM users u

            LEFT JOIN tasks t 
                ON t.assigned_to = u.user_id
                $date_condition

            LEFT JOIN ($latestAssign) da 
                ON da.user_id = u.id

            LEFT JOIN tasks tj 
                ON tj.id = da.task_id
                $date_condition

            WHERE u.status = 'active'

            GROUP BY 
                u.id, 
                u.user_id, 
                u.username, 
                u.department_role, 
                u.status

            ORDER BY u.username ASC
        ";

        return $this->db->query($sql)->result_array();
    }

    public function get_deals_by_stage_chart($date_from = null, $date_to = null)
    {
        $this->db->select("
            SUM(CASE WHEN t.status IN ('Pending', 'Qualification') THEN 1 ELSE 0 END) AS qualification,
            SUM(CASE WHEN t.status = 'Site Visit' THEN 1 ELSE 0 END) AS site_visit,
            SUM(CASE WHEN t.status IN ('Proposal', 'Proposal/Price Quote') THEN 1 ELSE 0 END) AS proposal,
            SUM(CASE WHEN t.status IN ('Close to Won', 'Closed Won') THEN 1 ELSE 0 END) AS closed_won,
            SUM(CASE WHEN t.status IN ('Close to Lost', 'Closed Lost') THEN 1 ELSE 0 END) AS closed_lost,
            SUM(CASE WHEN t.status IN ('Omitted', 'Proposal-Omitted', 'Proposal Omitted') THEN 1 ELSE 0 END) AS omitted
        ", false);

        $this->db->from($this->tasks_table . ' t');
        $this->apply_task_date_filter($date_from, $date_to);

        $row = $this->db->get()->row_array();

        return $row ?: [
            'qualification' => 0,
            'site_visit' => 0,
            'proposal' => 0,
            'closed_won' => 0,
            'closed_lost' => 0,
            'omitted' => 0
        ];
    }

    public function get_job_status_chart($date_from = null, $date_to = null)
    {
        $this->db->select("
            SUM(CASE 
                WHEN t.Job_Status IS NULL OR t.Job_Status = '' OR t.Job_Status = 'Active' 
                THEN 1 ELSE 0 
            END) AS active_jobs,

            SUM(CASE 
                WHEN t.Job_Status = 'Hold' 
                THEN 1 ELSE 0 
            END) AS hold_jobs,

            SUM(CASE 
                WHEN t.Job_Status = 'Closed' 
                THEN 1 ELSE 0 
            END) AS closed_jobs
        ", false);

        $this->db->from($this->tasks_table . ' t');

        $this->db->group_start();
            $this->db->where('t.status', 'Close to Won');
            $this->db->or_where('t.status', 'Closed Won');
        $this->db->group_end();

        $this->apply_task_date_filter($date_from, $date_to);

        $row = $this->db->get()->row_array();

        return $row ?: [
            'active_jobs' => 0,
            'hold_jobs' => 0,
            'closed_jobs' => 0
        ];
    }

    public function get_monthly_won_amount_chart()
{
    $sql = "
        SELECT 
            MIN(DATE_FORMAT(t.created_at, '%b %Y')) AS month_name,
            DATE_FORMAT(t.created_at, '%Y-%m') AS month_order,
            IFNULL(SUM(t.service_charge), 0) AS total_amount
        FROM tasks t
        WHERE t.status IN ('Close to Won', 'Closed Won')
        AND t.created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
        GROUP BY DATE_FORMAT(t.created_at, '%Y-%m')
        ORDER BY month_order ASC
    ";

    return $this->db->query($sql)->result_array();
}

    public function get_department_workload_summary($date_from = null, $date_to = null)
    {
        $date_condition = "";

        if (!empty($date_from)) {
            $date_condition .= " AND DATE(t.created_at) >= " . $this->db->escape($date_from);
        }

        if (!empty($date_to)) {
            $date_condition .= " AND DATE(t.created_at) <= " . $this->db->escape($date_to);
        }

        $latestAssign = "
            SELECT da1.*
            FROM departments_assign da1
            INNER JOIN (
                SELECT task_id, department, MAX(id) AS max_id
                FROM departments_assign
                GROUP BY task_id, department
            ) x ON x.max_id = da1.id
        ";

        $sql = "
            SELECT 
                da.department,
                COUNT(DISTINCT da.task_id) AS total_jobs,
                SUM(CASE WHEN da.status = 'Assigned' THEN 1 ELSE 0 END) AS assigned_count,
                SUM(CASE WHEN da.status = 'Process' THEN 1 ELSE 0 END) AS process_count,
                SUM(CASE WHEN da.status = 'Completed' THEN 1 ELSE 0 END) AS completed_count,
                SUM(CASE WHEN da.status = 'Hold' THEN 1 ELSE 0 END) AS hold_count
            FROM ($latestAssign) da
            INNER JOIN tasks t ON t.id = da.task_id $date_condition
            GROUP BY da.department
            ORDER BY da.department ASC
        ";

        return $this->db->query($sql)->result_array();
    }

    public function get_total_assigned_today_by_employee()
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

        $sql = "
            SELECT 
                u.id,
                u.username,
                COUNT(DISTINCT da.task_id) AS assigned_today
            FROM users u
            LEFT JOIN ($latestAssign) da 
                ON da.user_id = u.id
                AND DATE(da.assigned_date) = CURDATE()
            WHERE u.status = 'active'
            GROUP BY u.id, u.username
            ORDER BY u.username ASC
        ";

        return $this->db->query($sql)->result_array();
    }

    public function get_total_completed_this_month_by_employee()
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

        $sql = "
            SELECT 
                u.id,
                u.username,
                COUNT(DISTINCT da.task_id) AS completed_this_month
            FROM users u
            LEFT JOIN ($latestAssign) da 
                ON da.user_id = u.id
                AND da.status = 'Completed'
                AND da.assigned_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                AND da.assigned_date < DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
            WHERE u.status = 'active'
            GROUP BY u.id, u.username
            ORDER BY u.username ASC
        ";

        return $this->db->query($sql)->result_array();
    }

    public function get_employee_detail($employee_id)
    {
        return $this->db
            ->where('id', (int)$employee_id)
            ->get($this->users_table)
            ->row_array();
    }

    public function get_employee_sales_deals($employee_user_id, $date_from = null, $date_to = null)
    {
        $this->db->select('
            t.id,
            t.job_deal_number,
            t.job_deal_date,
            t.deal_number,
            t.account_name,
            t.status,
            t.Job_Status,
            t.service_charge,
            t.created_at
        ');

        $this->db->from($this->tasks_table . ' t');
        $this->db->where('t.assigned_to', $employee_user_id);
        $this->apply_task_date_filter($date_from, $date_to);
        $this->db->order_by('t.created_at', 'DESC');

        return $this->db->get()->result_array();
    }

    public function get_employee_department_jobs($employee_id, $date_from = null, $date_to = null)
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

        $date_condition = "";

        if (!empty($date_from)) {
            $date_condition .= " AND DATE(t.created_at) >= " . $this->db->escape($date_from);
        }

        if (!empty($date_to)) {
            $date_condition .= " AND DATE(t.created_at) <= " . $this->db->escape($date_to);
        }

        $sql = "
            SELECT 
                t.id,
                t.job_deal_number,
                t.job_deal_date,
                t.account_name,
                t.status AS deal_status,
                t.Job_Status,
                t.service_charge,
                da.department,
                da.status AS department_status,
                da.assigned_date
            FROM ($latestAssign) da
            INNER JOIN tasks t ON t.id = da.task_id $date_condition
            WHERE da.user_id = ?
            ORDER BY da.assigned_date DESC
        ";

        return $this->db->query($sql, [(int)$employee_id])->result_array();
    }
}