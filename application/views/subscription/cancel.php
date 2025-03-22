<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto">
        <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                </div>

                <h2 class="text-3xl font-bold text-white">
                    Cancelar Assinatura
                </h2>
                <p class="mt-2 text-gray-300">
                    Tem certeza que deseja cancelar sua assinatura?
                </p>
            </div>

            <div class="bg-gray-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-white mb-4">
                    Detalhes da Assinatura
                </h3>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Plano:</dt>
                        <dd class="text-white font-medium">
                            <?php echo ucfirst($subscription->plan); ?>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Status:</dt>
                        <dd class="text-green-500 font-medium">Ativo</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Válido até:</dt>
                        <dd class="text-white font-medium">
                            <?php echo date('d/m/Y', strtotime($subscription->end_date)); ?>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-red-900 bg-opacity-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-white mb-4">
                    O que acontece ao cancelar?
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-red-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Você manterá acesso a todos os cursos até o fim do período atual
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-red-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Não haverá novas cobranças após o cancelamento
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-info-circle text-red-400 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Seu progresso nos cursos será mantido caso reative a assinatura
                        </span>
                    </li>
                </ul>
            </div>

            <?php echo form_open(current_url(), ['class' => 'space-y-4']); ?>
                <button type="submit" 
                        class="w-full bg-red-600 text-white hover:bg-red-700 flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-times mr-2"></i>
                    Confirmar Cancelamento
                </button>

                <a href="<?php echo site_url('dashboard'); ?>" 
                   class="w-full bg-gray-800 text-white hover:bg-gray-700 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar para Dashboard
                </a>
            <?php echo form_close(); ?>

            <div class="mt-8 text-center text-sm text-gray-400">
                <p>
                    Mudou de ideia? Veja nossos 
                    <a href="<?php echo site_url('subscription/choose_plan'); ?>" class="text-red-500 hover:text-red-400">
                        outros planos disponíveis
                    </a>
                </p>
                <p class="mt-2">
                    Ou entre em contato com nosso 
                    <a href="#" class="text-red-500 hover:text-red-400">
                        suporte
                    </a> 
                    para mais informações
                </p>
            </div>
        </div>
    </div>
</div>