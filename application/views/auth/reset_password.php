<div class="auth-container flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-black bg-opacity-75 p-8 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">
                Redefinir Senha
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Digite sua nova senha abaixo.
            </p>
        </div>

        <?php echo form_open(current_url(), ['class' => 'space-y-6']); ?>
            
            <?php if (validation_errors()): ?>
                <div class="alert alert-error">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <div>
                <label for="password" class="sr-only">Nova Senha</label>
                <div class="relative">
                    <input id="password" 
                           name="password" 
                           type="password" 
                           class="netflix-input w-full pr-10" 
                           placeholder="Nova Senha"
                           required>
                    <button type="button" 
                            class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-400"
                            data-target="#password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="mt-1 text-sm text-gray-400">
                    Mínimo de 6 caracteres
                </p>
            </div>

            <div>
                <label for="password_confirm" class="sr-only">Confirmar Nova Senha</label>
                <div class="relative">
                    <input id="password_confirm" 
                           name="password_confirm" 
                           type="password" 
                           class="netflix-input w-full pr-10" 
                           placeholder="Confirmar Nova Senha"
                           required>
                    <button type="button" 
                            class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-400"
                            data-target="#password_confirm">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="netflix-button w-full flex justify-center">
                    Alterar Senha
                </button>
            </div>

            <div class="text-center">
                <a href="<?php echo site_url('auth/login'); ?>" 
                   class="text-sm text-red-600 hover:text-red-500">
                    Voltar para o Login
                </a>
            </div>

            <?php echo form_hidden($csrf['name'], $csrf['hash']); ?>
        <?php echo form_close(); ?>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-black text-gray-400">
                        Protegido por reCAPTCHA
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>