<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white">
                Pagamento
            </h2>
            <p class="mt-2 text-gray-300">
                Plano <?php echo $plan['name']; ?>
            </p>
        </div>

        <div class="bg-black bg-opacity-50 rounded-lg shadow-lg p-6">
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-white">Total:</span>
                    <span class="text-2xl font-bold text-white">
                        R$ <?php echo number_format($plan['price'], 2, ',', '.'); ?>
                    </span>
                </div>
                <?php if (isset($plan['original_price'])): ?>
                    <div class="text-right">
                        <span class="text-sm text-green-500">
                            Economia de R$ <?php echo number_format($plan['original_price'] - $plan['price'], 2, ',', '.'); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Payment Methods Tabs -->
            <div class="mb-6">
                <div class="flex border-b border-gray-700">
                    <button class="flex-1 py-3 px-4 text-center text-white font-medium border-b-2 border-red-600 focus:outline-none" 
                            id="tab-credit-card">
                        <i class="fas fa-credit-card mr-2"></i>
                        Cartão
                    </button>
                    <button class="flex-1 py-3 px-4 text-center text-gray-400 hover:text-white focus:outline-none" 
                            id="tab-pix">
                        <i class="fas fa-qrcode mr-2"></i>
                        PIX
                    </button>
                    <button class="flex-1 py-3 px-4 text-center text-gray-400 hover:text-white focus:outline-none" 
                            id="tab-boleto">
                        <i class="fas fa-barcode mr-2"></i>
                        Boleto
                    </button>
                </div>
            </div>

            <!-- Payment Methods Content -->
            <div>
                <!-- Credit Card Form -->
                <div id="content-credit-card" class="payment-content">
                    <div id="cardPaymentBrick_container"></div>
                </div>

                <!-- PIX -->
                <div id="content-pix" class="payment-content hidden">
                    <div id="pixPaymentBrick_container"></div>
                </div>

                <!-- Boleto -->
                <div id="content-boleto" class="payment-content hidden">
                    <div id="boletoPaymentBrick_container"></div>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-center">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <span class="text-sm text-gray-400">
                        Pagamento seguro processado pelo MercadoPago
                    </span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-gray-400 mr-2"></i>
                    <span class="text-sm text-gray-400">
                        Seus dados estão protegidos com criptografia SSL
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-gray-800 bg-opacity-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-white mb-4">
                Resumo do Plano
            </h3>
            <ul class="space-y-3">
                <?php foreach ($plan['features'] as $feature): ?>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <?php echo $feature; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- MercadoPago JavaScript SDK -->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    // Initialize MercadoPago
    const mp = new MercadoPago('<?php echo $mercadopago_public_key; ?>', {
        locale: 'pt-BR'
    });

    // Initialize payment bricks
    const bricks = mp.bricks();

    // Card Payment Brick
    const renderCardPaymentBrick = async () => {
        const settings = {
            initialization: {
                amount: <?php echo $plan['price']; ?>,
                payer: {
                    email: '<?php echo $this->user->email; ?>'
                }
            },
            callbacks: {
                onReady: () => {
                    // Handle brick ready
                },
                onSubmit: (cardFormData) => {
                    // Handle form submission
                },
                onError: (error) => {
                    // Handle error
                }
            },
            locale: 'pt-BR',
            customization: {
                visual: {
                    style: {
                        theme: 'dark'
                    }
                }
            }
        };

        await bricks.create('cardPayment', 'cardPaymentBrick_container', settings);
    };

    // PIX Payment Brick
    const renderPixPaymentBrick = async () => {
        const settings = {
            initialization: {
                amount: <?php echo $plan['price']; ?>,
                payer: {
                    email: '<?php echo $this->user->email; ?>'
                }
            },
            callbacks: {
                onReady: () => {
                    // Handle brick ready
                },
                onSubmit: (pixData) => {
                    // Handle PIX submission
                },
                onError: (error) => {
                    // Handle error
                }
            },
            locale: 'pt-BR',
            customization: {
                visual: {
                    style: {
                        theme: 'dark'
                    }
                }
            }
        };

        await bricks.create('pix', 'pixPaymentBrick_container', settings);
    };

    // Boleto Payment Brick
    const renderBoletoPaymentBrick = async () => {
        const settings = {
            initialization: {
                amount: <?php echo $plan['price']; ?>,
                payer: {
                    email: '<?php echo $this->user->email; ?>'
                }
            },
            callbacks: {
                onReady: () => {
                    // Handle brick ready
                },
                onSubmit: (boletoData) => {
                    // Handle boleto submission
                },
                onError: (error) => {
                    // Handle error
                }
            },
            locale: 'pt-BR',
            customization: {
                visual: {
                    style: {
                        theme: 'dark'
                    }
                }
            }
        };

        await bricks.create('boleto', 'boletoPaymentBrick_container', settings);
    };

    // Initialize all payment methods
    renderCardPaymentBrick();
    renderPixPaymentBrick();
    renderBoletoPaymentBrick();

    // Tab switching functionality
    const tabs = ['credit-card', 'pix', 'boleto'];
    tabs.forEach(tab => {
        document.getElementById(`tab-${tab}`).addEventListener('click', function() {
            // Update tab styles
            tabs.forEach(t => {
                const tabElement = document.getElementById(`tab-${t}`);
                const contentElement = document.getElementById(`content-${t}`);
                
                if (t === tab) {
                    tabElement.classList.add('text-white', 'border-red-600', 'border-b-2');
                    tabElement.classList.remove('text-gray-400');
                    contentElement.classList.remove('hidden');
                } else {
                    tabElement.classList.remove('text-white', 'border-red-600', 'border-b-2');
                    tabElement.classList.add('text-gray-400');
                    contentElement.classList.add('hidden');
                }
            });
        });
    });
</script>