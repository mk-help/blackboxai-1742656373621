<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruções de Pagamento Boleto - MembrosFlix</title>
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
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .payment-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .steps {
            margin: 20px 0;
            padding-left: 0;
        }
        .steps li {
            list-style: none;
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
        }
        .steps li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
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
            <h2>Instruções de Pagamento Boleto</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <p>
                Para concluir sua assinatura, realize o pagamento do boleto usando as 
                instruções abaixo:
            </p>
            
            <div class="payment-info">
                <h3>Informações do Pagamento</h3>
                <p><strong>Valor:</strong> R$ <?php echo $amount; ?></p>
                <p><strong>Vencimento:</strong> <?php echo $expiration_date; ?></p>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo $boleto_url; ?>" 
                   class="button" 
                   target="_blank">
                    Visualizar/Imprimir Boleto
                </a>
            </div>
            
            <h3>Como pagar seu boleto:</h3>
            <ul class="steps">
                <li>
                    Imprima o boleto ou salve em seu dispositivo
                </li>
                <li>
                    Pague em qualquer banco, casa lotérica ou através do 
                    internet banking
                </li>
                <li>
                    Guarde o comprovante de pagamento
                </li>
            </ul>
            
            <div class="warning">
                <strong>Importante:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>O boleto vence em <?php echo $expiration_date; ?></li>
                    <li>Após o pagamento, a compensação pode levar até 3 dias úteis</li>
                    <li>Sua assinatura será ativada automaticamente após a confirmação do pagamento</li>
                </ul>
            </div>
            
            <p>
                Você receberá um email de confirmação assim que o pagamento for 
                processado e sua assinatura estiver ativa.
            </p>
            
            <p>
                Se tiver alguma dúvida ou precisar de ajuda, não hesite em entrar 
                em contato com nossa equipe de suporte.
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