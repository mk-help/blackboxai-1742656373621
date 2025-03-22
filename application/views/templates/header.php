<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #141414;
            color: #ffffff;
        }
        
        .auth-container {
            min-height: calc(100vh - 80px);
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('https://assets.nflxext.com/ffe/siteui/vlv3/9737377e-a430-4d13-ad6c-874c54837c49/7d5f4c1a-d6f4-4f41-b697-78d067421931/BR-pt-20220111-popsignuptwoweeks-perspective_alpha_website_small.jpg');
            background-size: cover;
            background-position: center;
        }

        .netflix-button {
            background-color: #e50914;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .netflix-button:hover {
            background-color: #f40612;
        }

        .netflix-input {
            background-color: #333333;
            border: none;
            color: white;
            padding: 1rem;
            border-radius: 4px;
        }

        .netflix-input:focus {
            background-color: #454545;
            outline: none;
            box-shadow: 0 0 0 2px rgba(229, 9, 20, 0.5);
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgb(34, 197, 94);
            color: rgb(34, 197, 94);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgb(239, 68, 68);
            color: rgb(239, 68, 68);
        }
    </style>
</head>
<body>
    <header class="bg-black bg-opacity-90">
        <nav class="container mx-auto px-4 py-6">
            <a href="<?php echo site_url(); ?>" class="text-red-600 text-3xl font-bold">
                MembrosFlix
            </a>
        </nav>
    </header>

    <main>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="container mx-auto px-4 mt-4">
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="container mx-auto px-4 mt-4">
                <div class="alert alert-error">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            </div>
        <?php endif; ?>