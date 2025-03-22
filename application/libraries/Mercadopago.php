<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/mercadopago/vendor/autoload.php';

class Mercadopago {
    protected $ci;
    protected $mp;

    public function __construct() {
        $this->ci =& get_instance();
        
        // Load config
        $this->ci->config->load('mercadopago', TRUE);
        
        // Initialize MercadoPago SDK
        MercadoPago\SDK::setAccessToken($this->ci->config->item('mercadopago_access_token', 'mercadopago'));
    }

    /**
     * Create preference for payment
     */
    public function create_preference($data) {
        try {
            $preference = new MercadoPago\Preference();

            // Create item
            $item = new MercadoPago\Item();
            $item->title = $data['description'];
            $item->quantity = 1;
            $item->unit_price = $data['amount'];
            $item->currency_id = $data['currency'] ?? "BRL";

            $preference->items = array($item);

            // Set payer information
            $payer = new MercadoPago\Payer();
            $payer->email = $data['payer_email'];
            $preference->payer = $payer;

            // Set URLs
            $preference->back_urls = array(
                "success" => site_url('subscription/success'),
                "failure" => site_url('subscription/failed'),
                "pending" => site_url('subscription/pending')
            );
            $preference->auto_return = "approved";

            // Set additional info
            $preference->external_reference = $data['external_reference'] ?? '';
            $preference->notification_url = site_url('subscription/webhook');

            // Save preference
            $preference->save();

            return $preference;
        } catch (Exception $e) {
            log_message('error', 'MercadoPago API Error: ' . $e->getMessage());
            throw new Exception('Erro ao criar pagamento: ' . $e->getMessage());
        }
    }

    /**
     * Create subscription
     */
    public function create_subscription($data) {
        try {
            $subscription = new MercadoPago\Subscription();

            $subscription->plan_id = $data['plan_id'];
            $subscription->payer = array(
                "email" => $data['payer_email']
            );
            $subscription->auto_recurring = array(
                "frequency" => $data['frequency'] ?? 1,
                "frequency_type" => $data['frequency_type'] ?? "months",
                "transaction_amount" => $data['amount'],
                "currency_id" => $data['currency'] ?? "BRL"
            );
            $subscription->metadata = $data['metadata'] ?? array();

            $subscription->save();

            return $subscription;
        } catch (Exception $e) {
            log_message('error', 'MercadoPago API Error: ' . $e->getMessage());
            throw new Exception('Erro ao criar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Cancel subscription
     */
    public function cancel_subscription($subscription_id) {
        try {
            $subscription = MercadoPago\Subscription::find_by_id($subscription_id);
            $subscription->status = "cancelled";
            $subscription->update();

            return $subscription;
        } catch (Exception $e) {
            log_message('error', 'MercadoPago API Error: ' . $e->getMessage());
            throw new Exception('Erro ao cancelar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Get subscription
     */
    public function get_subscription($subscription_id) {
        try {
            return MercadoPago\Subscription::find_by_id($subscription_id);
        } catch (Exception $e) {
            log_message('error', 'MercadoPago API Error: ' . $e->getMessage());
            throw new Exception('Erro ao buscar assinatura: ' . $e->getMessage());
        }
    }

    /**
     * Process webhook notification
     */
    public function process_webhook($data) {
        try {
            if ($data['type'] === 'payment') {
                $payment = MercadoPago\Payment::find_by_id($data['data']['id']);
                return $payment;
            } elseif ($data['type'] === 'subscription') {
                $subscription = MercadoPago\Subscription::find_by_id($data['data']['id']);
                return $subscription;
            }
            return null;
        } catch (Exception $e) {
            log_message('error', 'MercadoPago Webhook Error: ' . $e->getMessage());
            throw new Exception('Erro ao processar webhook: ' . $e->getMessage());
        }
    }

    /**
     * Create refund
     */
    public function create_refund($payment_id) {
        try {
            $refund = new MercadoPago\Refund();
            $refund->payment_id = $payment_id;
            $refund->save();

            return $refund;
        } catch (Exception $e) {
            log_message('error', 'MercadoPago API Error: ' . $e->getMessage());
            throw new Exception('Erro ao criar reembolso: ' . $e->getMessage());
        }
    }
}

/* End of file Mercadopago.php */
/* Location: ./application/libraries/Mercadopago.php */