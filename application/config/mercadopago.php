<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MercadoPago Configuration
|--------------------------------------------------------------------------
|
| Este arquivo contém as configurações para integração com o MercadoPago.
| Certifique-se de substituir os valores de placeholder com suas chaves
| reais do MercadoPago antes de implantar em produção.
|
*/

// Credenciais da API
$config['mercadopago_public_key'] = 'TEST-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$config['mercadopago_access_token'] = 'TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// IDs dos Produtos/Planos (criar estes no painel do MercadoPago)
$config['mercadopago_plans'] = [
    'monthly' => [
        'plan_id' => 'plan_monthly_id',
        'amount' => 49.90,
        'description' => 'Assinatura Mensal MembrosFlix',
    ],
    'annual' => [
        'plan_id' => 'plan_annual_id',
        'amount' => 499.90,
        'description' => 'Assinatura Anual MembrosFlix',
    ],
    'lifetime' => [
        'plan_id' => 'plan_lifetime_id',
        'amount' => 1499.90,
        'description' => 'Assinatura Vitalícia MembrosFlix',
    ]
];

// Configurações de Webhook
$config['mercadopago_webhook_events'] = [
    'payment',
    'subscription',
    'invoice',
    'plan'
];

// Moeda
$config['mercadopago_currency'] = 'BRL';
$config['mercadopago_currency_symbol'] = 'R$';

// Configurações de Pagamento
$config['mercadopago_statement_descriptor'] = 'MEMBROSFLIX';

// Configurações de Assinatura
$config['mercadopago_trial_days'] = 7; // Dias de teste para novas assinaturas
$config['mercadopago_grace_period_days'] = 3; // Dias de carência após falha no pagamento

// Configurações de UI do Checkout
$config['mercadopago_theme'] = [
    'elements_color' => '#E50914',
    'header_color' => '#E50914'
];

// Mensagens de Erro
$config['mercadopago_error_messages'] = [
    'cc_rejected_bad_filled_card_number' => 'Verifique o número do cartão.',
    'cc_rejected_bad_filled_date' => 'Verifique a data de validade.',
    'cc_rejected_bad_filled_security_code' => 'Verifique o código de segurança.',
    'cc_rejected_bad_filled_other' => 'Verifique os dados do cartão.',
    'cc_rejected_call_for_authorize' => 'Você deve autorizar o pagamento com seu banco.',
    'cc_rejected_card_disabled' => 'Cartão inativo. Ative com seu banco.',
    'cc_rejected_duplicated_payment' => 'Você já fez um pagamento com esse valor.',
    'cc_rejected_high_risk' => 'Pagamento recusado. Escolha outro meio de pagamento.',
    'cc_rejected_insufficient_amount' => 'Saldo insuficiente.',
    'cc_rejected_invalid_installments' => 'Cartão não processa parcelas.',
    'cc_rejected_max_attempts' => 'Você atingiu o limite de tentativas.',
    'cc_rejected_other_reason' => 'Cartão não processou o pagamento.'
];

// Configurações de Integração
$config['mercadopago_sandbox'] = TRUE; // Mudar para FALSE em produção
$config['mercadopago_timeout'] = 30; // Timeout em segundos

// Configurações de Notificação
$config['mercadopago_notification_url'] = site_url('subscription/webhook');
$config['mercadopago_return_url'] = site_url('subscription/process');

// Configurações de Log
$config['mercadopago_log_webhooks'] = TRUE;
$config['mercadopago_log_api_requests'] = TRUE;

/* End of file mercadopago.php */
/* Location: ./application/config/mercadopago.php */