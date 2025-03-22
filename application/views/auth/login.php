<div class="auth-container flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-black bg-opacity-75 p-8 rounded-lg">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">
                Entrar
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Novo por aqui? 
                <a href="<?php echo site_url('auth/register'); ?>" class="text-red-600 hover:text-red-500">
                    Assine agora
                </a>
            </p>
        </div>

        <?php echo form_open('auth/login', ['class' => 'space-y-6']); ?>
            
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
                <label for="password" class="sr-only">Senha</label>
                <div class="relative">
                    <input id="password" 
                           name="password" 
                           type="password" 
                           class="netflix-input w-full pr-10" 
                           placeholder="Senha"
                           required>
                    <button type="button" 
                            class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-400"
                            data-target="#password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" 
                           name="remember" 
                           type="checkbox"
                           class="h-4 w-4 bg-gray-700 border-gray-600 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-400">
                        Lembrar-me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="<?php echo site_url('auth/forgot_password'); ?>" 
                       class="text-red-600 hover:text-red-500">
                        Esqueceu a senha?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="netflix-button w-full flex justify-center">
                    Entrar
                </button>
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