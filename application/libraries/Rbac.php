<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rbac
{
    /** @var CI_Controller */
    protected $CI;

    /** @var array */
    protected $permissions = [];

    public function __construct()
    {
        $this->CI = &get_instance();

        // Make sure session + db are available
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->helper('url');

        $this->permissions = $this->CI->session->userdata('permissions') ?? [];
        if (!is_array($this->permissions)) {
            $this->permissions = [];
        }
    }

    /**
     * Load permissions from DB into session (call after successful login)
     */
    public function load_permissions(int $admin_id): array
    {
        $rows = $this->CI->db
            ->select('p.`key` AS perm_key')
            ->from('permissions p')
            ->join('admin_user_permissions aup', 'aup.permission_id = p.id', 'inner')
            ->where('aup.admin_user_id', $admin_id)
            ->get()
            ->result_array();

        $perms = [];
        foreach ($rows as $r) {
            $perms[] = $r['perm_key'];
        }

        // Store in session
        $this->CI->session->set_userdata('permissions', $perms);

        // Update local cache too
        $this->permissions = $perms;

        return $perms;
    }

    /**
     * True/False permission check
     */
    public function can(string $key): bool
    {
        return in_array($key, $this->permissions, true);
    }

    /**
     * Check if user has ANY of the permissions
     */
    public function can_any(array $keys): bool
    {
        foreach ($keys as $k) {
            if ($this->can($k)) return true;
        }
        return false;
    }

    /**
     * Enforce permission in controller actions
     */
    public function require(string $key): void
    {
        if (!$this->can($key)) {
            show_error('Access Denied', 403);
        }
    }

    /**
     * Enforce ANY of permissions
     */
    public function require_any(array $keys): void
    {
        if (!$this->can_any($keys)) {
            show_error('Access Denied', 403);
        }
    }

    /**
     * Helper to get current permissions array
     */
    public function all(): array
    {
        return $this->permissions;
    }

    /**
     * Audit log for permission changes (grant/revoke)
     * Call this when you save checkbox changes in Permission Management UI.
     */
    public function log_permission_change(int $changed_by, int $target_user_id, string $permission_key, string $action): bool
    {
        if (!in_array($action, ['granted','revoked'], true)) {
            return false;
        }

        return (bool) $this->CI->db->insert('permission_audit_logs', [
            'changed_by'     => $changed_by,
            'target_user_id' => $target_user_id,
            'permission_key' => $permission_key,
            'action'         => $action,
            'ip_address'     => $this->CI->input->ip_address(),
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
