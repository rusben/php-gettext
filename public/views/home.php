<!-- views/home.php -->
<!DOCTYPE html>
<html lang="<?php echo detectUserLocale(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo _("Home"); ?></title>
    <link rel="stylesheet" href="/css/style.css"> 
</head>
<body>
    <h1><?php echo _("Hello, World!"); ?></h1>
    <p><?php echo _("This is a sample page with multilingual support."); ?></p>
    <a href="?lang=en">English</a> | <a href="?lang=es">Español</a>
</body>
</html>
