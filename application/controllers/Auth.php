<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * Login page
     */
    public function login() {
        // Redirect if already logged in
        if ($this->user) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Senha', 'required');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember') ? true : false;

                $user = $this->user_model->verify_credentials($email, $password);

                if ($user) {
                    if ($user->status === 'pending') {
                        $this->session->set_flashdata('error', 'Por favor, verifique seu email para ativar sua conta.');
                    } elseif ($user->status === 'inactive') {
                        $this->session->set_flashdata('error', 'Sua conta está inativa. Entre em contato com o suporte.');
                    } else {
                        // Set session data
                        $this->session->set_userdata('user_id', $user->id);

                        // Set remember token if requested
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            $this->user_model->update_remember_token($user->id, $token);
                            set_cookie('remember_token', $token, 30*24*60*60); // 30 days
                        }

                        // Redirect to intended page or dashboard
                        $redirect_to = $this->session->userdata('redirect_to');
                        $this->session->unset_userdata('redirect_to');
                        redirect($redirect_to ?: 'dashboard');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Email ou senha inválidos.');
                }
            }
        }

        $this->data['page_title'] = 'Login - ' . $this->data['site_name'];
        $this->_render_page('auth/login');
    }

    /**
     * Registration page
     */
    public function register() {
        // Redirect if already logged in
        if ($this->user) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nome', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Confirmar Senha', 'required|matches[password]');

            if ($this->form_validation->run()) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => 'student',
                    'status' => 'pending'
                );

                $user_id = $this->user_model->create_user($data);

                if ($user_id) {
                    // Send verification email
                    $verification_token = bin2hex(random_bytes(32));
                    $this->user_model->update_remember_token($user_id, $verification_token);

                    $verify_url = site_url("auth/verify_email/{$user_id}/{$verification_token}");
                    $email_message = $this->load->view('emails/verify_email', [
                        'name' => $data['name'],
                        'verify_url' => $verify_url
                    ], true);

                    if ($this->_send_email($data['email'], 'Verifique seu email - ' . $this->data['site_name'], $email_message)) {
                        $this->session->set_flashdata('success', 'Cadastro realizado com sucesso! Por favor, verifique seu email para ativar sua conta.');
                        redirect('auth/login');
                    } else {
                        $this->session->set_flashdata('error', 'Erro ao enviar email de verificação. Por favor, tente novamente.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Erro ao criar conta. Por favor, tente novamente.');
                }
            }
        }

        $this->data['page_title'] = 'Cadastro - ' . $this->data['site_name'];
        $this->_render_page('auth/register');
    }

    /**
     * Email verification
     */
    public function verify_email($user_id, $token) {
        $user = $this->user_model->get_user($user_id);

        if ($user && $user->remember_token === $token) {
            if ($this->user_model->verify_email($user_id)) {
                $this->user_model->update_remember_token($user_id, null);
                $this->session->set_flashdata('success', 'Email verificado com sucesso! Você já pode fazer login.');
            } else {
                $this->session->set_flashdata('error', 'Erro ao verificar email. Por favor, tente novamente.');
            }
        } else {
            $this->session->set_flashdata('error', 'Link de verificação inválido ou expirado.');
        }

        redirect('auth/login');
    }

    /**
     * Forgot password page
     */
    public function forgot_password() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $user = $this->user_model->get_user_by_email($email);

                if ($user) {
                    // Generate reset token
                    $reset_token = bin2hex(random_bytes(32));
                    $this->user_model->update_remember_token($user->id, $reset_token);

                    $reset_url = site_url("auth/reset_password/{$user->id}/{$reset_token}");
                    $email_message = $this->load->view('emails/reset_password', [
                        'name' => $user->name,
                        'reset_url' => $reset_url
                    ], true);

                    if ($this->_send_email($email, 'Recuperação de Senha - ' . $this->data['site_name'], $email_message)) {
                        $this->session->set_flashdata('success', 'Email de recuperação enviado! Por favor, verifique sua caixa de entrada.');
                        redirect('auth/login');
                    }
                }

                // Always show success to prevent email enumeration
                $this->session->set_flashdata('success', 'Se o email existir em nossa base, você receberá as instruções para recuperação.');
                redirect('auth/login');
            }
        }

        $this->data['page_title'] = 'Esqueci a Senha - ' . $this->data['site_name'];
        $this->_render_page('auth/forgot_password');
    }

    /**
     * Reset password page
     */
    public function reset_password($user_id, $token) {
        $user = $this->user_model->get_user($user_id);

        if (!$user || $user->remember_token !== $token) {
            $this->session->set_flashdata('error', 'Link de recuperação inválido ou expirado.');
            redirect('auth/login');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('password', 'Nova Senha', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Confirmar Senha', 'required|matches[password]');

            if ($this->form_validation->run()) {
                if ($this->user_model->update_user($user_id, [
                    'password' => $this->input->post('password'),
                    'remember_token' => null
                ])) {
                    $this->session->set_flashdata('success', 'Senha alterada com sucesso! Você já pode fazer login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Erro ao alterar senha. Por favor, tente novamente.');
                }
            }
        }

        $this->data['page_title'] = 'Redefinir Senha - ' . $this->data['site_name'];
        $this->_render_page('auth/reset_password');
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        delete_cookie('remember_token');
        redirect('auth/login');
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */