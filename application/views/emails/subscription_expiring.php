<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinatura Expirando - MembrosFlix</title>
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
        .expiry-alert {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .benefits-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }
        .stats {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .stat-item {
            text-align: center;
            padding: 10px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #e50914;
        }
        .stat-label {
            color: #666666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MembrosFlix</h1>
        </div>
        
        <div class="content">
            <h2>Sua Assinatura Está Expirando</h2>
            
            <p>Olá, <?php echo $name; ?>!</p>
            
            <div class="expiry-alert">
                <p>
                    <strong>Atenção:</strong> Sua assinatura expira em 
                    <strong><?php echo $days_remaining; ?> dias</strong> 
                    (<?php echo $expiry_date; ?>).
                </p>
            </div>
            
            <div class="stats">
                <h3>Seu Progresso até Agora</h3>
                <div style="display: flex; justify-content: space-around;">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $courses_watched; ?></div>
                        <div class="stat-label">Cursos Assistidos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $hours_watched; ?></div>
                        <div class="stat-label">Horas de Estudo</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $certificates_earned; ?></div>
                        <div class="stat-label">Certificados</div>
                    </div>
                </div>
            </div>
            
            <div class="benefits-box">
                <h3>Por Que Renovar?</h3>
                <ul>
                    <li>Continue seu progresso nos cursos em andamento</li>
                    <li>Acesso a novos cursos adicionados semanalmente</li>
                    <li>Mantenha seus certificados e histórico de aprendizado</li>
                    <li>Suporte prioritário e recursos exclusivos</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <p>
                    <strong>Oferta Especial de Renovação!</strong><br>
                    Renove agora e ganhe 1 mês extra grátis.
                </p>
                <a href="<?php echo site_url('subscription/renew'); ?>" class="button">
                    Renovar Assinatura
                </a>
            </div>
            
            <p>
                Se você já configurou a renovação automática, pode ignorar este email. 
                Sua assinatura será renovada automaticamente em <?php echo $expiry_date; ?>.
            </p>
            
            <p>
                Caso tenha alguma dúvida ou precise de ajuda, nossa equipe de suporte 
                está sempre à disposição para ajudar.
            </p>
        </div>
        
        <div class="footer">
            <p>
                Você recebeu este email porque sua assinatura no MembrosFlix está 
                próxima do vencimento.
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