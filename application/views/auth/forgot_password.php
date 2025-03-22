<div class="auth-container flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-black bg-opacity-75 p-8 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">
                Esqueceu a Senha?
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Digite seu email para receber as instruções de recuperação.
            </p>
        </div>

        <?php echo form_open('auth/forgot_password', ['class' => 'space-y-6']); ?>
            
            <?php if (validation_errors()): ?>
                <div class="alert alert-error">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <div>
                <label for="email" class="sr-only">Email</label>
                <input id="email" 
                       name="email" 
                       type="email" 
                       value="<?php echo set_value('email'); ?>"
                       class="netflix-input w-full" 
                       placeholder="Email"
                       required>
            </div>

            <div>
                <button type="submit" 
                        class="netflix-button w-full flex justify-center">
                    Enviar Instruções
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