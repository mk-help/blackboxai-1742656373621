</main>

    <footer class="bg-black bg-opacity-90 mt-8">
        <div class="container mx-auto px-4 py-6">
            <div class="text-gray-400 text-sm text-center">
                &copy; <?php echo date('Y'); ?> MembrosFlix. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Flash messages auto-hide
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // Form validation highlight
        $('.netflix-input').on('invalid', function() {
            $(this).addClass('border-red-500');
        });

        $('.netflix-input').on('input', function() {
            $(this).removeClass('border-red-500');
        });

        // Password visibility toggle
        $('.toggle-password').click(function() {
            const input = $($(this).data('target'));
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
</body>
</html>