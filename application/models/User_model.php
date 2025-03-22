<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'users';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get user by ID
     */
    public function get_user($user_id) {
        return $this->db->get_where($this->table, ['id' => $user_id])->row();
    }

    /**
     * Get user by email
     */
    public function get_user_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Create new user
     */
    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update user
     */
    public function update_user($user_id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $user_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Verify user password
     */
    public function verify_password($user_id, $password) {
        $user = $this->get_user($user_id);
        return $user && password_verify($password, $user->password);
    }

    /**
     * Verify user credentials
     */
    public function verify_credentials($email, $password) {
        $user = $this->get_user_by_email($email);
        return $user && password_verify($password, $user->password) ? $user : false;
    }

    /**
     * Update user's email verification status
     */
    public function verify_email($user_id) {
        return $this->update_user($user_id, [
            'status' => 'active',
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update user's remember token
     */
    public function update_remember_token($user_id, $token) {
        return $this->update_user($user_id, ['remember_token' => $token]);
    }

    /**
     * Get user by remember token
     */
    public function get_user_by_remember_token($token) {
        return $this->db->get_where($this->table, ['remember_token' => $token])->row();
    }

    /**
     * Get users list with pagination
     */
    public function get_users($limit = 10, $offset = 0, $filters = array()) {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($value !== '') {
                    $this->db->where($key, $value);
                }
            }
        }

        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    /**
     * Count total users
     */
    public function count_users($filters = array()) {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($value !== '') {
                    $this->db->where($key, $value);
                }
            }
        }

        return $this->db->count_all_results($this->table);
    }

    /**
     * Delete user
     */
    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if email exists
     */
    public function email_exists($email, $exclude_user_id = null) {
        if ($exclude_user_id) {
            $this->db->where('id !=', $exclude_user_id);
        }
        return $this->db->get_where($this->table, ['email' => $email])->num_rows() > 0;
    }
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */