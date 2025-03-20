<?php
// src/functions.php
session_start();

function detectUserLocale() {
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'es'])) {
        $_SESSION['lang'] = $_GET['lang'];
    }
    
    if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        return in_array($lang, ['en', 'es']) ? $lang : 'en';
    }
}

function configureLocale() {
    $locale = detectUserLocale();
    $locale_code = $locale === 'es' ? 'es_ES.UTF-8' : 'en_US.UTF-8';

    putenv("LC_MESSAGES=$locale_code");
    setlocale(LC_MESSAGES, $locale_code);
    bindtextdomain("messages", __DIR__ . "/../locales");
    textdomain("messages");
}
?>
