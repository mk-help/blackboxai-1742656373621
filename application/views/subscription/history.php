<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">
                Histórico de Assinaturas
            </h2>
            <p class="mt-2 text-gray-300">
                Visualize todas as suas assinaturas e pagamentos
            </p>
        </div>

        <?php if (empty($history)): ?>
            <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-8 text-center">
                <div class="mb-4">
                    <i class="fas fa-history text-4xl text-gray-500"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">
                    Nenhum histórico encontrado
                </h3>
                <p class="text-gray-400 mb-6">
                    Você ainda não possui histórico de assinaturas.
                </p>
                <a href="<?php echo site_url('subscription/choose_plan'); ?>" 
                   class="netflix-button inline-flex items-center justify-center">
                    <i class="fas fa-tag mr-2"></i>
                    Ver Planos Disponíveis
                </a>
            </div>
        <?php else: ?>
            <div class="bg-black bg-opacity-50 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">
                        Assinaturas e Pagamentos
                    </h3>
                </div>

                <div class="divide-y divide-gray-700">
                    <?php foreach ($history as $item): ?>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-medium text-white">
                                        Plano <?php echo ucfirst($item->plan); ?>
                                    </h4>
                                    <p class="text-sm text-gray-400">
                                        Iniciado em <?php echo date('d/m/Y', strtotime($item->start_date)); ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        <?php echo $item->status === 'active' ? 'bg-green-900 text-green-400' : 'bg-red-900 text-red-400'; ?>">
                                        <?php echo $item->status === 'active' ? 'Ativo' : 'Cancelado'; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-800 bg-opacity-50 rounded-lg p-4">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm text-gray-400">Período</dt>
                                        <dd class="mt-1 text-sm text-white">
                                            <?php echo date('d/m/Y', strtotime($item->start_date)); ?> - 
                                            <?php echo $item->end_date ? date('d/m/Y', strtotime($item->end_date)) : 'Vitalício'; ?>
                                        </dd>
                                    </div>
                                    <?php if ($item->payment_status): ?>
                                        <div>
                                            <dt class="text-sm text-gray-400">Pagamento</dt>
                                            <dd class="mt-1 text-sm">
                                                <span class="inline-flex items-center">
                                                    <?php if ($item->payment_status === 'completed'): ?>
                                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                        <span class="text-green-400">Confirmado</span>
                                                    <?php else: ?>
                                                        <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                                        <span class="text-red-400">Falhou</span>
                                                    <?php endif; ?>
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-400">Valor</dt>
                                            <dd class="mt-1 text-sm text-white">
                                                R$ <?php echo number_format($item->amount, 2, ',', '.'); ?>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-400">Método</dt>
                                            <dd class="mt-1 text-sm text-white">
                                                <?php 
                                                    switch ($item->payment_method) {
                                                        case 'stripe':
                                                            echo '<i class="fab fa-cc-stripe mr-1"></i> Cartão de Crédito';
                                                            break;
                                                        case 'paypal':
                                                            echo '<i class="fab fa-paypal mr-1"></i> PayPal';
                                                            break;
                                                        default:
                                                            echo ucfirst($item->payment_method);
                                                    }
                                                ?>
                                            </dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                            </div>

                            <?php if ($item->status === 'active'): ?>
                                <div class="mt-4 flex justify-end">
                                    <a href="<?php echo site_url('subscription/cancel'); ?>" 
                                       class="text-sm text-red-500 hover:text-red-400">
                                        Cancelar Assinatura
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-8 bg-gray-800 bg-opacity-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-white mb-4">
                    Informações Importantes
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Os pagamentos são processados de forma segura através de gateway de pagamento criptografado.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Em caso de cancelamento, o acesso permanece até o final do período pago.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Para questões relacionadas a pagamentos, entre em contato com nosso suporte.
                        </span>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>