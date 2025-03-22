<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model {
    protected $table = 'subscriptions';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get active subscription for user
     */
    public function get_active_subscription($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        $this->db->where('end_date >', date('Y-m-d H:i:s'));
        return $this->db->get($this->table)->row();
    }

    /**
     * Create new subscription
     */
    public function create_subscription($data) {
        // Cancel any active subscriptions first
        $this->cancel_active_subscriptions($data['user_id']);

        $data['created_at'] = date('Y-m-d H:i:s');
        
        // Calculate end date based on plan
        switch ($data['plan']) {
            case 'monthly':
                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+1 month'));
                break;
            case 'annual':
                $data['end_date'] = date('Y-m-d H:i:s', strtotime('+1 year'));
                break;
            case 'lifetime':
                $data['end_date'] = null;
                break;
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Cancel active subscriptions for user
     */
    private function cancel_active_subscriptions($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        $this->db->update($this->table, [
            'status' => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Update subscription
     */
    public function update_subscription($subscription_id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $subscription_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Cancel subscription
     */
    public function cancel_subscription($subscription_id) {
        return $this->update_subscription($subscription_id, [
            'status' => 'cancelled'
        ]);
    }

    /**
     * Get subscription by ID
     */
    public function get_subscription($subscription_id) {
        return $this->db->get_where($this->table, ['id' => $subscription_id])->row();
    }

    /**
     * Get user's subscription history
     */
    public function get_subscription_history($user_id) {
        $this->db->select('subscriptions.*, payments.amount, payments.payment_method, payments.status as payment_status');
        $this->db->from($this->table);
        $this->db->join('payments', 'payments.subscription_id = subscriptions.id', 'left');
        $this->db->where('subscriptions.user_id', $user_id);
        $this->db->order_by('subscriptions.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Create payment record
     */
    public function create_payment($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }

    /**
     * Update payment status
     */
    public function update_payment_status($payment_id, $status) {
        $this->db->where('id', $payment_id);
        return $this->db->update('payments', [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get payment by transaction ID
     */
    public function get_payment_by_transaction($transaction_id) {
        return $this->db->get_where('payments', ['transaction_id' => $transaction_id])->row();
    }

    /**
     * Check if subscription is active
     */
    public function is_subscription_active($user_id) {
        return (bool) $this->get_active_subscription($user_id);
    }

    /**
     * Get subscription plans
     */
    public function get_subscription_plans() {
        return [
            'monthly' => [
                'name' => 'Mensal',
                'price' => 49.90,
                'description' => 'Acesso a todos os cursos por 1 mês',
                'features' => [
                    'Acesso ilimitado a todos os cursos',
                    'Certificados de conclusão',
                    'Suporte prioritário',
                    'Download de materiais'
                ]
            ],
            'annual' => [
                'name' => 'Anual',
                'price' => 499.90,
                'original_price' => 598.80,
                'description' => 'Acesso a todos os cursos por 1 ano',
                'features' => [
                    'Economia de 17%',
                    'Acesso ilimitado a todos os cursos',
                    'Certificados de conclusão',
                    'Suporte prioritário',
                    'Download de materiais',
                    'Acesso antecipado a novos cursos'
                ]
            ],
            'lifetime' => [
                'name' => 'Vitalício',
                'price' => 1499.90,
                'description' => 'Acesso vitalício a todos os cursos',
                'features' => [
                    'Pagamento único',
                    'Acesso vitalício a todos os cursos',
                    'Certificados de conclusão',
                    'Suporte prioritário VIP',
                    'Download de materiais',
                    'Acesso antecipado a novos cursos',
                    'Mentoria mensal exclusiva'
                ]
            ]
        ];
    }

    /**
     * Get expiring subscriptions
     */
    public function get_expiring_subscriptions($days = 7) {
        $expiry_date = date('Y-m-d H:i:s', strtotime("+{$days} days"));
        
        $this->db->select('subscriptions.*, users.email, users.name');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = subscriptions.user_id');
        $this->db->where('subscriptions.status', 'active');
        $this->db->where('subscriptions.end_date <=', $expiry_date);
        $this->db->where('subscriptions.end_date >', date('Y-m-d H:i:s'));
        
        return $this->db->get()->result();
    }

    /**
     * Get subscription metrics
     */
    public function get_subscription_metrics($start_date = null, $end_date = null) {
        if (!$start_date) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (!$end_date) {
            $end_date = date('Y-m-d');
        }

        // Active subscriptions
        $active = $this->db->where('status', 'active')
                          ->where('created_at >=', $start_date)
                          ->where('created_at <=', $end_date)
                          ->count_all_results($this->table);

        // Cancelled subscriptions
        $cancelled = $this->db->where('status', 'cancelled')
                             ->where('updated_at >=', $start_date)
                             ->where('updated_at <=', $end_date)
                             ->count_all_results($this->table);

        // Revenue
        $this->db->select_sum('amount');
        $this->db->from('payments');
        $this->db->where('status', 'completed');
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $revenue = $this->db->get()->row()->amount;

        return [
            'active_subscriptions' => $active,
            'cancelled_subscriptions' => $cancelled,
            'revenue' => $revenue ?: 0,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
    }
}

/* End of file Subscription_model.php */
/* Location: ./application/models/Subscription_model.php */