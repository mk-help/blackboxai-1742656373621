<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto text-center">
        <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <div class="mx-auto w-16 h-16 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-2xl text-white"></i>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">
                Pagamento Confirmado!
            </h2>

            <p class="text-gray-300 mb-8">
                Sua assinatura foi ativada com sucesso. Você já pode começar a assistir todos os cursos disponíveis na plataforma.
            </p>

            <div class="space-y-4">
                <a href="<?php echo site_url('dashboard'); ?>" 
                   class="netflix-button w-full inline-flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>
                    Ir para Dashboard
                </a>

                <a href="<?php echo site_url('courses'); ?>" 
                   class="bg-gray-800 text-white hover:bg-gray-700 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-play-circle mr-2"></i>
                    Explorar Cursos
                </a>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-white mb-4">
                    Próximos Passos
                </h3>
                <ul class="space-y-4 text-left">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Complete seu perfil para uma experiência personalizada
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Explore nosso catálogo de cursos e comece a aprender
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Configure suas preferências de notificação para não perder nenhuma novidade
                        </span>
                    </li>
                </ul>
            </div>

            <div class="mt-8 text-sm text-gray-400">
                <p>
                    Um email de confirmação foi enviado para <?php echo $this->user->email; ?>
                </p>
                <p class="mt-2">
                    Se precisar de ajuda, entre em contato com nosso 
                    <a href="#" class="text-red-500 hover:text-red-400">suporte</a>.
                </p>
            </div>
        </div>
    </div>
</div>