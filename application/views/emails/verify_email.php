<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu Email - MembrosFlix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #e50914;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #ffffff;
            padding: 30px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #e50914;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MembrosFlix</h1>
        </div>
        
        <div class="content">
            <h2>Olá, <?php echo $name; ?>!</h2>
            
            <p>Bem-vindo(a) ao MembrosFlix! Para começar a acessar nossos cursos, por favor, verifique seu endereço de email clicando no botão abaixo:</p>
            
            <div style="text-align: center;">
                <a href="<?php echo $verify_url; ?>" class="button">
                    Verificar Email
                </a>
            </div>
            
            <p>Se o botão não funcionar, você também pode copiar e colar o link abaixo no seu navegador:</p>
            
            <p style="word-break: break-all;">
                <?php echo $verify_url; ?>
            </p>
            
            <p>Este link é válido por 24 horas. Após este período, você precisará solicitar um novo link de verificação.</p>
            
            <p>Se você não criou uma conta no MembrosFlix, por favor, ignore este email.</p>
        </div>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>&copy; <?php echo date('Y'); ?> MembrosFlix. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>