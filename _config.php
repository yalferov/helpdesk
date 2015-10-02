<?php

/**
 * @author DjJustin
 * @copyright 2015
 *
 * @todo Добавить настройки для LDAP
 */

$ticketCategory=array(
    0=>'',
    1=>'Заявка на обслуживание',
    2=>'Инцидент',
    3=>'Ремонт оборудования',
    4=>'Заправка картриджа'
);

$ticketStatus=array(
    0=>array("text"=>"Открыто", "style"=>"warning"),
    1=>array("text"=>"В работе", "style"=>""),
    2=>array("text"=>"Выполнено", "style"=>"success"),
    3=>array("text"=>"Закрыто", "style"=>"success"),
    4=>array("text"=>"Отменено", "style"=>"active")
);


/*
 * Статусы заявок
 */

define('TICKET_NEW', 0);
define('TICKET_WORK', 1);
define('TICKET_COMPLETE', 2);
define('TICKET_CLOSE', 3);
define('TICKET_CANCEL', 4);



/*
 * Настройки Telegram
 */
define('BOT_TOKEN', '116577505:AAHUONRv6TOyL6zBJqQtOvPCnd5YAlQcBdk');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('CHAT_ID', '-28513449');

/*
 * Настройки подключения к базе данных
 */
ORM::configure('mysql:host=localhost;dbname=helpdesk;charset=utf8');
ORM::configure('username', 'root');
ORM::configure('password', 'Fifkjr315');

/*
 * Настройки приложения
 */
$app_config=array(
    "APP_HEADER"=>"УЧЕБНЫЙ КОМПЛЕКС №2",
    "telegram_send"=>1
);

?>