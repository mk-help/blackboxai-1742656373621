<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha - MembrosFlix</title>
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
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
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
            
            <p>Recebemos uma solicitação para redefinir a senha da sua conta no MembrosFlix. Para criar uma nova senha, clique no botão abaixo:</p>
            
            <div style="text-align: center;">
                <a href="<?php echo $reset_url; ?>" class="button">
                    Redefinir Senha
                </a>
            </div>
            
            <p>Se o botão não funcionar, você também pode copiar e colar o link abaixo no seu navegador:</p>
            
            <p style="word-break: break-all;">
                <?php echo $reset_url; ?>
            </p>
            
            <div class="warning">
                <strong>Importante:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Este link é válido por apenas 1 hora.</li>
                    <li>Se você não solicitou a redefinição de senha, ignore este email.</li>
                    <li>Se você recebe este email com frequência, considere alterar sua senha para uma mais segura.</li>
                </ul>
            </div>
            
            <p>Por questões de segurança, após redefinir sua senha, você será desconectado de todos os dispositivos e precisará fazer login novamente.</p>
            
            <p>Se você não solicitou a redefinição de senha, por favor, entre em contato com nosso suporte imediatamente.</p>
        </div>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>&copy; <?php echo date('Y'); ?> MembrosFlix. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>