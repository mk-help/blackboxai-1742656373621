<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto text-center">
        <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <div class="mx-auto w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-white"></i>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">
                Pagamento em Processamento
            </h2>

            <p class="text-gray-300 mb-8">
                Seu pagamento está sendo processado. Assim que confirmado, 
                sua assinatura será ativada automaticamente.
            </p>

            <div class="bg-gray-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-white mb-4">
                    Próximos Passos
                </h3>
                <ul class="space-y-3 text-left">
                    <?php if (isset($payment_method) && $payment_method === 'boleto'): ?>
                        <li class="flex items-start">
                            <i class="fas fa-file-invoice text-yellow-500 mt-1 mr-2"></i>
                            <span class="text-gray-300">
                                Imprima ou salve seu boleto bancário
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-money-bill text-yellow-500 mt-1 mr-2"></i>
                            <span class="text-gray-300">
                                Efetue o pagamento em qualquer casa lotérica ou banco
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock text-yellow-500 mt-1 mr-2"></i>
                            <span class="text-gray-300">
                                O processamento pode levar até 3 dias úteis
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="flex items-start">
                            <i class="fas fa-sync text-yellow-500 mt-1 mr-2"></i>
                            <span class="text-gray-300">
                                Aguarde enquanto processamos seu pagamento
                            </span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-yellow-500 mt-1 mr-2"></i>
                            <span class="text-gray-300">
                                Você receberá um email assim que o pagamento for confirmado
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <?php if (isset($payment_method) && $payment_method === 'boleto' && isset($boleto_url)): ?>
                <div class="mb-8">
                    <a href="<?php echo $boleto_url; ?>" 
                       target="_blank"
                       class="netflix-button w-full inline-flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>
                        Baixar Boleto
                    </a>
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <a href="<?php echo site_url('dashboard'); ?>" 
                   class="bg-gray-800 text-white hover:bg-gray-700 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-home mr-2"></i>
                    Voltar para Dashboard
                </a>
            </div>

            <div class="mt-8 text-sm text-gray-400">
                <p>
                    Precisa de ajuda? Entre em contato com nosso 
                    <a href="#" class="text-red-500 hover:text-red-400">suporte</a>
                </p>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-6">
                <div class="flex items-center justify-center text-sm text-gray-400">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <span>
                        Pagamento processado com segurança pelo MercadoPago
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>