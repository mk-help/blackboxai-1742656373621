<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinatura Cancelada - MembrosFlix</title>
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
        .info-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #e50914;
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
            <h2>Assinatura Cancelada</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <p>
                Confirmamos o cancelamento da sua assinatura no MembrosFlix. 
                Sentiremos sua falta!
            </p>
            
            <div class="info-box">
                <h3>Informações Importantes</h3>
                <p>
                    Você ainda terá acesso a todos os cursos até 
                    <strong><?php echo $end_date; ?></strong>.
                </p>
                <p>
                    Após esta data, seu acesso será limitado até que você reative 
                    sua assinatura.
                </p>
            </div>
            
            <h3>O que acontece agora?</h3>
            <ul>
                <li>Seu acesso continua ativo até o final do período pago</li>
                <li>Não haverá novas cobranças</li>
                <li>Seu progresso nos cursos será mantido</li>
                <li>Você pode reativar sua assinatura a qualquer momento</li>
            </ul>
            
            <p>
                Esperamos que você tenha aproveitado sua experiência conosco. 
                Se quiser compartilhar o motivo do cancelamento ou dar algum feedback, 
                ficaremos felizes em ouvir.
            </p>
            
            <div style="text-align: center;">
                <p>Mudou de ideia?</p>
                <a href="<?php echo site_url('subscription/choose_plan'); ?>" class="button">
                    Reativar Assinatura
                </a>
            </div>
            
            <p>
                Se o cancelamento foi um engano ou se você tiver alguma dúvida, 
                entre em contato com nossa equipe de suporte. Estamos sempre à disposição 
                para ajudar.
            </p>
        </div>
        
        <div class="footer">
            <p>
                Você recebeu este email porque cancelou sua assinatura no MembrosFlix.
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