<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = array();
    protected $user = null;

    public function __construct() {
        parent::__construct();
        
        // Load common helpers and libraries
        $this->load->helper(['url', 'form', 'security']);
        $this->load->library(['session', 'form_validation']);

        // Check if user is logged in
        $this->_check_auth();

        // Set common view data
        $this->data['user'] = $this->user;
        $this->data['site_name'] = 'MembrosFlix';
        $this->data['page_title'] = 'MembrosFlix';
        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    protected function _check_auth() {
        // Get user data from session
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id) {
            $this->load->model('user_model');
            $this->user = $this->user_model->get_user($user_id);
            
            // If user was deleted or deactivated, destroy session
            if (!$this->user || $this->user->status !== 'active') {
                $this->session->sess_destroy();
                redirect('auth/login');
            }
        }
    }

    protected function _require_login($redirect_to = '') {
        if (!$this->user) {
            // Store intended URL in session
            if ($redirect_to) {
                $this->session->set_userdata('redirect_to', $redirect_to);
            }
            redirect('auth/login');
        }
    }

    protected function _require_role($roles = ['admin']) {
        $this->_require_login();
        
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        if (!in_array($this->user->role, $roles)) {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Negado');
        }
    }

    protected function _render_page($view, $data = array()) {
        // Merge data arrays
        $view_data = array_merge($this->data, $data);
        
        // Load views
        $this->load->view('templates/header', $view_data);
        $this->load->view($view, $view_data);
        $this->load->view('templates/footer', $view_data);
    }

    protected function _json_response($data, $status_code = 200) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }

    protected function _handle_ajax_error($message, $status_code = 400) {
        $this->_json_response([
            'success' => false,
            'message' => $message
        ], $status_code);
    }

    protected function _upload_file($field_name, $upload_path, $allowed_types = 'gif|jpg|jpeg|png') {
        // Create upload path if it doesn't exist
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Configure upload
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = 10240; // 10MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            return array(
                'success' => false,
                'error' => $this->upload->display_errors()
            );
        }

        return array(
            'success' => true,
            'data' => $this->upload->data()
        );
    }

    protected function _send_email($to, $subject, $message, $from = null) {
        $this->load->library('email');

        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        
        $this->email->initialize($config);
        
        $this->email->from($from ?? 'noreply@membrosflix.com', 'MembrosFlix');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        return $this->email->send();
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */