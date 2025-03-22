<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">
                Escolha seu Plano
            </h2>
            <p class="mt-3 text-xl text-gray-300">
                Acesso ilimitado a todos os cursos. Cancele quando quiser.
            </p>
        </div>

        <?php if ($current_subscription): ?>
            <div class="max-w-3xl mx-auto mb-12">
                <div class="bg-blue-900 bg-opacity-50 rounded-lg p-6 border border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-white">
                                Assinatura Atual: <?php echo ucfirst($current_subscription->plan); ?>
                            </h3>
                            <p class="mt-1 text-gray-300">
                                Válida até: <?php echo date('d/m/Y', strtotime($current_subscription->end_date)); ?>
                            </p>
                        </div>
                        <a href="<?php echo site_url('subscription/cancel'); ?>" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Cancelar Assinatura
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
            <?php foreach ($plans as $plan_id => $plan): ?>
                <div class="bg-black bg-opacity-50 rounded-lg shadow-lg divide-y divide-gray-700">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-white">
                            <?php echo $plan['name']; ?>
                        </h2>
                        
                        <?php if (isset($plan['original_price'])): ?>
                            <p class="mt-2">
                                <span class="line-through text-gray-400">
                                    R$ <?php echo number_format($plan['original_price'], 2, ',', '.'); ?>
                                </span>
                            </p>
                        <?php endif; ?>

                        <p class="mt-2">
                            <span class="text-4xl font-extrabold text-white">
                                R$ <?php echo number_format($plan['price'], 2, ',', '.'); ?>
                            </span>
                            <?php if ($plan_id === 'monthly'): ?>
                                <span class="text-gray-400">/mês</span>
                            <?php elseif ($plan_id === 'annual'): ?>
                                <span class="text-gray-400">/ano</span>
                            <?php endif; ?>
                        </p>
                        
                        <p class="mt-4 text-gray-300">
                            <?php echo $plan['description']; ?>
                        </p>

                        <?php echo form_open('subscription/process', ['class' => 'mt-8']); ?>
                            <?php echo form_hidden('plan', $plan_id); ?>
                            <button type="submit" 
                                    class="w-full netflix-button flex items-center justify-center">
                                <?php if ($current_subscription && $current_subscription->plan === $plan_id): ?>
                                    Plano Atual
                                <?php else: ?>
                                    Assinar Agora
                                <?php endif; ?>
                            </button>
                        <?php echo form_close(); ?>
                    </div>
                    
                    <div class="px-6 pt-6 pb-8">
                        <h3 class="text-xs font-semibold text-white uppercase tracking-wide">
                            O que está incluído
                        </h3>
                        <ul class="mt-6 space-y-4">
                            <?php foreach ($plan['features'] as $feature): ?>
                                <li class="flex space-x-3">
                                    <i class="fas fa-check text-green-500 flex-shrink-0"></i>
                                    <span class="text-gray-300"><?php echo $feature; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 max-w-3xl mx-auto">
            <div class="bg-gray-800 bg-opacity-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-white">
                    Garantia de 7 dias
                </h3>
                <p class="mt-2 text-gray-300">
                    Se você não estiver satisfeito com sua assinatura nos primeiros 7 dias, 
                    devolveremos 100% do seu dinheiro. Sem perguntas.
                </p>
            </div>

            <div class="mt-6 bg-gray-800 bg-opacity-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-white">
                    Perguntas Frequentes
                </h3>
                <dl class="mt-4 space-y-6">
                    <div>
                        <dt class="text-white">Posso cancelar a qualquer momento?</dt>
                        <dd class="mt-2 text-gray-300">
                            Sim, você pode cancelar sua assinatura a qualquer momento. 
                            O acesso permanece até o final do período pago.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-white">Como funciona o acesso aos cursos?</dt>
                        <dd class="mt-2 text-gray-300">
                            Após a confirmação do pagamento, você terá acesso imediato a 
                            todos os cursos da plataforma, de acordo com seu plano.
                        </dd>
                    </div>
                    <div>
                        <dt class="text-white">Os certificados são incluídos?</dt>
                        <dd class="mt-2 text-gray-300">
                            Sim, você receberá certificados para todos os cursos que completar 
                            durante sua assinatura ativa.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>