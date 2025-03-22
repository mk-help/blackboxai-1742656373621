<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinatura Confirmada - MembrosFlix</title>
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
        .details {
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
            <h2>Assinatura Confirmada!</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <p>Sua assinatura foi confirmada com sucesso! Agora você tem acesso ilimitado a todos os nossos cursos.</p>
            
            <div class="details">
                <h3>Detalhes da Assinatura</h3>
                <p><strong>Plano:</strong> <?php echo $plan; ?></p>
                <p><strong>Valor:</strong> R$ <?php echo $amount; ?></p>
                <p><strong>Data:</strong> <?php echo $date; ?></p>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo site_url('dashboard'); ?>" class="button">
                    Acessar Plataforma
                </a>
            </div>
            
            <h3>Próximos Passos</h3>
            <ul>
                <li>Complete seu perfil para uma experiência personalizada</li>
                <li>Explore nosso catálogo de cursos</li>
                <li>Comece a assistir suas primeiras aulas</li>
                <li>Configure suas preferências de notificação</li>
            </ul>
            
            <p>
                Se tiver alguma dúvida ou precisar de ajuda, não hesite em entrar em contato com nossa equipe de suporte.
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