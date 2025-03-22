<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_require_login();
        
        $this->load->model('subscription_model');
        $this->load->library('mercadopago');
    }

    /**
     * Choose subscription plan page
     */
    public function choose_plan() {
        // Get subscription plans
        $this->data['plans'] = $this->subscription_model->get_subscription_plans();
        
        // Get current active subscription if exists
        $this->data['current_subscription'] = $this->subscription_model->get_active_subscription($this->user->id);
        
        $this->data['page_title'] = 'Escolha seu Plano - ' . $this->data['site_name'];
        $this->_render_page('subscription/choose_plan');
    }

    /**
     * Process subscription
     */
    public function process() {
        // Validate plan
        $plan = $this->input->post('plan');
        $plans = $this->subscription_model->get_subscription_plans();
        
        if (!isset($plans[$plan])) {
            $this->session->set_flashdata('error', 'Plano inválido.');
            redirect('subscription/choose_plan');
        }

        // Get plan details
        $plan_details = $plans[$plan];

        try {
            // Create MercadoPago preference
            $preference_data = [
                'description' => $plan_details['name'] . ' - MembrosFlix',
                'amount' => $plan_details['price'],
                'currency' => $this->config->item('mercadopago_currency', 'mercadopago'),
                'payer_email' => $this->user->email,
                'external_reference' => 'user_' . $this->user->id . '_plan_' . $plan,
                'payment_methods' => [
                    'installments' => 12,
                    'excluded_payment_types' => []
                ]
            ];

            $preference = $this->mercadopago->create_preference($preference_data);

            $this->data['page_title'] = 'Pagamento - ' . $this->data['site_name'];
            $this->data['plan'] = $plan_details;
            $this->data['preference_id'] = $preference->id;
            $this->data['mercadopago_public_key'] = $this->config->item('mercadopago_public_key', 'mercadopago');
            
            $this->_render_page('subscription/payment');

        } catch (Exception $e) {
            log_message('error', 'MercadoPago error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Erro ao processar pagamento. Por favor, tente novamente.');
            redirect('subscription/choose_plan');
        }
    }

    /**
     * Payment webhook
     */
    public function webhook() {
        try {
            $data = $this->input->post();
            
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }

            if (empty($data)) {
                throw new Exception('No webhook data received');
            }

            log_message('info', 'MercadoPago webhook received: ' . json_encode($data));

            // Process webhook notification
            $notification = $this->mercadopago->process_webhook($data);

            if ($notification) {
                if ($notification instanceof \MercadoPago\Payment) {
                    $this->_handle_payment_notification($notification);
                } elseif ($notification instanceof \MercadoPago\Subscription) {
                    $this->_handle_subscription_notification($notification);
                }
            }

            http_response_code(200);
            
        } catch (Exception $e) {
            log_message('error', 'Webhook error: ' . $e->getMessage());
            http_response_code(400);
        }
    }

    /**
     * Handle payment notification
     */
    private function _handle_payment_notification($payment) {
        // Extract user_id and plan from external_reference
        preg_match('/user_(\d+)_plan_(\w+)/', $payment->external_reference, $matches);
        $user_id = $matches[1];
        $plan = $matches[2];

        switch ($payment->status) {
            case 'approved':
                // Create subscription
                $subscription_id = $this->subscription_model->create_subscription([
                    'user_id' => $user_id,
                    'plan' => $plan,
                    'status' => 'active',
                    'start_date' => date('Y-m-d H:i:s'),
                    'mercadopago_id' => $payment->id
                ]);

                // Create payment record
                $this->subscription_model->create_payment([
                    'subscription_id' => $subscription_id,
                    'amount' => $payment->transaction_amount,
                    'currency' => $payment->currency_id,
                    'payment_method' => $payment->payment_type_id,
                    'transaction_id' => $payment->id,
                    'status' => 'completed'
                ]);

                // Send confirmation email
                $this->_send_confirmation_email($user_id, $plan);
                break;

            case 'pending':
                // Handle pending payment (e.g., waiting for PIX or Boleto payment)
                $this->subscription_model->create_payment([
                    'subscription_id' => null,
                    'amount' => $payment->transaction_amount,
                    'currency' => $payment->currency_id,
                    'payment_method' => $payment->payment_type_id,
                    'transaction_id' => $payment->id,
                    'status' => 'pending'
                ]);

                if ($payment->payment_type_id === 'bank_transfer') {
                    // Send PIX instructions email
                    $this->_send_pix_instructions_email($user_id, $payment);
                } elseif ($payment->payment_type_id === 'ticket') {
                    // Send boleto instructions email
                    $this->_send_boleto_instructions_email($user_id, $payment);
                }
                break;

            case 'rejected':
            case 'cancelled':
                // Create failed payment record
                $this->subscription_model->create_payment([
                    'subscription_id' => null,
                    'amount' => $payment->transaction_amount,
                    'currency' => $payment->currency_id,
                    'payment_method' => $payment->payment_type_id,
                    'transaction_id' => $payment->id,
                    'status' => 'failed'
                ]);
                break;
        }
    }

    /**
     * Send confirmation email
     */
    private function _send_confirmation_email($user_id, $plan) {
        $user = $this->user_model->get_user($user_id);
        $plan_details = $this->subscription_model->get_subscription_plans()[$plan];
        
        $email_data = [
            'name' => $user->name,
            'plan' => $plan_details['name'],
            'amount' => number_format($plan_details['price'], 2, ',', '.'),
            'date' => date('d/m/Y H:i:s')
        ];
        
        $message = $this->load->view('emails/subscription_confirmation', $email_data, true);
        $this->_send_email($user->email, 'Confirmação de Assinatura - ' . $this->data['site_name'], $message);
    }

    /**
     * Send PIX instructions email
     */
    private function _send_pix_instructions_email($user_id, $payment) {
        $user = $this->user_model->get_user($user_id);
        
        $email_data = [
            'name' => $user->name,
            'amount' => number_format($payment->transaction_amount, 2, ',', '.'),
            'pix_qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
            'pix_code' => $payment->point_of_interaction->transaction_data->qr_code_base64,
            'expiration_date' => date('d/m/Y H:i', strtotime('+1 day'))
        ];
        
        $message = $this->load->view('emails/pix_instructions', $email_data, true);
        $this->_send_email($user->email, 'Instruções de Pagamento PIX - ' . $this->data['site_name'], $message);
    }

    /**
     * Send boleto instructions email
     */
    private function _send_boleto_instructions_email($user_id, $payment) {
        $user = $this->user_model->get_user($user_id);
        
        $email_data = [
            'name' => $user->name,
            'amount' => number_format($payment->transaction_amount, 2, ',', '.'),
            'boleto_url' => $payment->transaction_details->external_resource_url,
            'expiration_date' => date('d/m/Y', strtotime('+3 days'))
        ];
        
        $message = $this->load->view('emails/boleto_instructions', $email_data, true);
        $this->_send_email($user->email, 'Instruções de Pagamento Boleto - ' . $this->data['site_name'], $message);
    }

    /**
     * Handle subscription notification
     */
    private function _handle_subscription_notification($subscription) {
        // Update subscription status based on MercadoPago subscription status
        switch ($subscription->status) {
            case 'authorized':
            case 'active':
                $status = 'active';
                break;
            case 'cancelled':
                $status = 'cancelled';
                break;
            case 'paused':
                $status = 'suspended';
                break;
            default:
                $status = 'inactive';
        }

        $this->subscription_model->update_subscription($subscription->id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Payment success page
     */
    public function success() {
        $this->data['page_title'] = 'Pagamento Confirmado - ' . $this->data['site_name'];
        $this->_render_page('subscription/success');
    }

    /**
     * Payment failure page
     */
    public function failed() {
        $this->data['page_title'] = 'Falha no Pagamento - ' . $this->data['site_name'];
        $this->_render_page('subscription/failed');
    }

    /**
     * Payment pending page
     */
    public function pending() {
        $payment_id = $this->input->get('payment_id');
        
        if ($payment_id) {
            try {
                $payment = $this->mercadopago->get_payment($payment_id);
                $this->data['payment_method'] = $payment->payment_type_id;
                
                if ($payment->payment_type_id === 'ticket') {
                    $this->data['boleto_url'] = $payment->transaction_details->external_resource_url;
                } elseif ($payment->payment_type_id === 'bank_transfer') {
                    $this->data['pix_qr_code'] = $payment->point_of_interaction->transaction_data->qr_code;
                    $this->data['pix_code'] = $payment->point_of_interaction->transaction_data->qr_code_base64;
                }
            } catch (Exception $e) {
                log_message('error', 'Error getting payment details: ' . $e->getMessage());
            }
        }

        $this->data['page_title'] = 'Pagamento Pendente - ' . $this->data['site_name'];
        $this->_render_page('subscription/pending');
    }

    /**
     * Cancel subscription
     */
    public function cancel() {
        $subscription = $this->subscription_model->get_active_subscription($this->user->id);
        
        if (!$subscription) {
            $this->session->set_flashdata('error', 'Nenhuma assinatura ativa encontrada.');
            redirect('dashboard');
        }

        if ($this->input->post()) {
            try {
                // Cancel subscription in MercadoPago if it exists
                if (!empty($subscription->mercadopago_id)) {
                    $this->mercadopago->cancel_subscription($subscription->mercadopago_id);
                }

                // Update local subscription status
                if ($this->subscription_model->cancel_subscription($subscription->id)) {
                    // Send cancellation email
                    $email_data = [
                        'name' => $this->user->name,
                        'end_date' => date('d/m/Y', strtotime($subscription->end_date))
                    ];
                    
                    $message = $this->load->view('emails/subscription_cancelled', $email_data, true);
                    $this->_send_email($this->user->email, 'Assinatura Cancelada - ' . $this->data['site_name'], $message);

                    $this->session->set_flashdata('success', 'Assinatura cancelada com sucesso.');
                    redirect('dashboard');
                }
            } catch (Exception $e) {
                log_message('error', 'Error cancelling subscription: ' . $e->getMessage());
                $this->session->set_flashdata('error', 'Erro ao cancelar assinatura. Tente novamente.');
            }
        }

        $this->data['page_title'] = 'Cancelar Assinatura - ' . $this->data['site_name'];
        $this->data['subscription'] = $subscription;
        $this->_render_page('subscription/cancel');
    }

    /**
     * Subscription history
     */
    public function history() {
        $this->data['page_title'] = 'Histórico de Assinaturas - ' . $this->data['site_name'];
        $this->data['history'] = $this->subscription_model->get_subscription_history($this->user->id);
        $this->_render_page('subscription/history');
    }
}

/* End of file Subscription.php */
/* Location: ./application/controllers/Subscription.php */