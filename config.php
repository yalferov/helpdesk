<?php

/**
 * @author DjJustin
 * @copyright 2015
 *
 * @todo Добавить настройки для LDAP
 */

/*
 * Настройки Telegram
 */
define('BOT_TOKEN', '116577505:AAHUONRv6TOyL6zBJqQtOvPCnd5YAlQcBdk');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('CHAT_ID', '129874991');

/*
 * Настройки подключения к базе данных
 */
ORM::configure('mysql:host=localhost;dbname=helpdesk;charset=utf8');
ORM::configure('username', 'root');
ORM::configure('password', '');

/*
 * Настройки приложения
 */
$app_config=array(
"APP_HEADER"=>"УЧЕБНЫЙ КОМПЛЕКС №2"
);

?>