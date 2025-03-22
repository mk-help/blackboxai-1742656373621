<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruções de Pagamento PIX - MembrosFlix</title>
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
        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .pix-code {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            word-break: break-all;
            margin: 20px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
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
            <h2>Instruções de Pagamento PIX</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <p>
                Para concluir sua assinatura, realize o pagamento via PIX usando uma das 
                opções abaixo:
            </p>
            
            <div class="qr-code">
                <h3>Opção 1: QR Code PIX</h3>
                <p>Abra o app do seu banco e escaneie o QR Code:</p>
                <img src="data:image/png;base64,<?php echo $pix_code; ?>" 
                     alt="QR Code PIX" 
                     style="max-width: 200px;">
            </div>
            
            <div>
                <h3>Opção 2: Código PIX Copia e Cola</h3>
                <p>Copie o código abaixo e cole no app do seu banco:</p>
                <div class="pix-code">
                    <?php echo $pix_qr_code; ?>
                </div>
            </div>
            
            <div class="warning">
                <strong>Importante:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Valor do pagamento: R$ <?php echo $amount; ?></li>
                    <li>O código PIX expira em: <?php echo $expiration_date; ?></li>
                    <li>Após o pagamento, a confirmação pode levar alguns minutos</li>
                </ul>
            </div>
            
            <p>
                Assim que recebermos a confirmação do pagamento, sua assinatura será 
                ativada automaticamente e você receberá um email de confirmação.
            </p>
            
            <p>
                Se precisar de ajuda, entre em contato com nosso suporte.
            </p>
        </div>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>&copy; <?php echo date('Y'); ?> MembrosFlix. Todos os direitos reservados.</p>
            <p>
                <a href="<?php echo site_url('terms'); ?>">Termos de Uso</a> | 
                <a href="<?php echo site_url('privacy'); ?>">Política de Privacidade</a>
            </p>
        </div>
    </div>
</body>
</html>