<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ZohoAttachments_model extends CI_Model
{
    /**
     * Insert attachment record only if attachment_id not already stored.
     * Returns inserted id (or existing id).
     */
    public function store_file($deal_id, $file_name, $file_size, $file_type, $file_path, $attachment_id)
    {
        $existing = $this->db
            ->get_where('job_attachments', ['attachment_id' => $attachment_id])
            ->row_array();

        if ($existing) {
            return (int)$existing['id'];
        }

        $data = [
            'deal_id'        => $deal_id,
            'attachment_id'  => $attachment_id,
            'file_name'      => $file_name,
            'file_size'      => $file_size,
            'file_type'      => $file_type,
            'file_path'      => $file_path,
        ];

        $this->db->insert('job_attachments', $data);
        return (int)$this->db->insert_id();
    }

public function attachment_exists($attachment_id)
{
    return $this->db->where('attachment_id', $attachment_id)->limit(1)->get('job_attachments')->num_rows() > 0;
}

public function update_file_path($attachment_id, $file_path, $file_size = null, $file_type = null)
{
    $data = ['file_path' => $file_path];
    if ($file_size !== null) $data['file_size'] = $file_size;
    if ($file_type !== null) $data['file_type'] = $file_type;

    $this->db->where('attachment_id', $attachment_id)->update('job_attachments', $data);
    return $this->db->affected_rows() >= 0;
}


/********* Samia New Testing on 11th March ***********/
public function store_meta($deal_id, $attachment_id, $file_name = '', $file_size = null, $file_type = null)
{
    // skip if already exists
    $existing = $this->db->get_where('job_attachments', ['attachment_id' => $attachment_id])->row_array();
    if ($existing) return (int)$existing['id'];

    $data = [
        'deal_id'       => $deal_id,
        'attachment_id' => $attachment_id,
        'file_name'     => $file_name,
        'file_size'     => $file_size,
        'file_type'     => $file_type,
        'file_path'     => 'uploads/deal_attachments/'.$file_name, // keep empty for now
    ];

    $this->db->insert('job_attachments', $data);
    return (int)$this->db->insert_id();
}

}