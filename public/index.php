<?php
// public/index.php

require_once __DIR__ . '/../src/functions.php';

// Configurar locale e idioma
configureLocale();

// Incluir la vista
include __DIR__ . '/views/home.php';
?>
