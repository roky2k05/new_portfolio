<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/header.php
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasindu Nawod | Web Developer & Graphic Designer</title>
    <meta name="description" content="Official portfolio of Rasindu Nawod, a Web Developer and Graphic Designer based in Matara, Sri Lanka. Specialized in HTML, CSS, JavaScript, PHP, MySQL, and Adobe Creative Suite.">
    <meta name="author" content="Rasindu Nawod">
    <meta name="keywords" content="Rasindu Nawod, Web Developer Sri Lanka, Graphic Designer Sri Lanka, Matara, Akuressa, PHP Developer, UI UX">
    
    <!-- Open Graph Meta -->
    <meta property="og:title" content="Rasindu Nawod | Web Developer & Graphic Designer">
    <meta property="og:description" content="Explore original web applications, responsive user interfaces, and graphic design collections by Rasindu Nawod.">
    <meta property="og:type" content="website">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for standalone PHP package) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-white dark:bg-[#0b0d13] text-neutral-900 dark:text-neutral-100 transition-colors duration-300 antialiased selection:bg-rose-500 selection:text-white">
