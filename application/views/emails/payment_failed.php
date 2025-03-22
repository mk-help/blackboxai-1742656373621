<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falha no Pagamento - MembrosFlix</title>
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
        .alert-box {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .reasons-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
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
            <h2>Falha no Pagamento</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <p>
                Infelizmente, não conseguimos processar o pagamento da sua assinatura. 
                Para evitar a interrupção do seu acesso, por favor, atualize suas 
                informações de pagamento.
            </p>
            
            <div class="alert-box">
                <h3 style="margin-top: 0;">Ação Necessária</h3>
                <p>
                    Para manter seu acesso aos cursos, por favor, atualize suas 
                    informações de pagamento o mais breve possível.
                </p>
            </div>
            
            <div class="reasons-box">
                <h3 style="margin-top: 0;">Possíveis Motivos</h3>
                <ul>
                    <li>Cartão expirado ou cancelado</li>
                    <li>Saldo insuficiente</li>
                    <li>Limite excedido</li>
                    <li>Dados do cartão incorretos</li>
                    <li>Cartão não habilitado para compras online</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo site_url('subscription/update_payment'); ?>" class="button">
                    Atualizar Forma de Pagamento
                </a>
            </div>
            
            <p>
                Se precisar de ajuda ou tiver alguma dúvida, nossa equipe de suporte 
                está à disposição através do email 
                <a href="mailto:<?php echo $support_email; ?>"><?php echo $support_email; ?></a>.
            </p>
            
            <p>
                <strong>Importante:</strong> Se o pagamento não for regularizado em até 
                3 dias, sua assinatura poderá ser suspensa automaticamente.
            </p>
        </div>
        
        <div class="footer">
            <p>
                Você recebeu este email porque houve uma falha no processamento do 
                pagamento da sua assinatura no MembrosFlix.
            </p>
            <p>&copy; <?php echo date('Y'); ?> MembrosFlix. Todos os direitos reservados.</p>
            <p>
                <a href="<?php echo site_url('terms'); ?>">Termos de Uso</a> | 
                <a href="<?php echo site_url('privacy'); ?>">Política de Privacidade</a>
            </p>
        </div>
    </div>
</body>
</html>