<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto text-center">
        <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <div class="mx-auto w-16 h-16 bg-red-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-2xl text-white"></i>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">
                Falha no Pagamento
            </h2>

            <p class="text-gray-300 mb-8">
                Infelizmente não foi possível processar seu pagamento. 
                Por favor, verifique os dados do cartão e tente novamente.
            </p>

            <div class="bg-gray-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-white mb-4">
                    Possíveis Motivos
                </h3>
                <ul class="space-y-3 text-left">
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Cartão com saldo insuficiente
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Dados do cartão incorretos
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Cartão não habilitado para compras online
                        </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-2"></i>
                        <span class="text-gray-300">
                            Problemas temporários com a operadora
                        </span>
                    </li>
                </ul>
            </div>

            <div class="space-y-4">
                <a href="<?php echo site_url('subscription/choose_plan'); ?>" 
                   class="netflix-button w-full inline-flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i>
                    Tentar Novamente
                </a>

                <a href="<?php echo site_url('dashboard'); ?>" 
                   class="bg-gray-800 text-white hover:bg-gray-700 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar para Dashboard
                </a>
            </div>

            <div class="mt-8 text-sm text-gray-400">
                <p>
                    Precisa de ajuda? Entre em contato com nosso 
                    <a href="#" class="text-red-500 hover:text-red-400">suporte</a>
                </p>
                <p class="mt-2">
                    Você também pode tentar usar outro cartão ou 
                    <a href="#" class="text-red-500 hover:text-red-400">
                        escolher outra forma de pagamento
                    </a>
                </p>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-6">
                <div class="flex items-center justify-center text-sm text-gray-400">
                    <i class="fas fa-lock mr-2"></i>
                    <span>
                        Nenhuma cobrança foi realizada no seu cartão
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>