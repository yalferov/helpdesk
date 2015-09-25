<?php

/**
 * @author DjJustin
 * @copyright 2015
 */
 


date_default_timezone_set("Asia/Tashkent");
setlocale(LC_TIME, 'ru_RU.CP1251');

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

 


event::addHandler('onAfterTicketAdd', function($args) 
{
  $param["chat_id"] = CHAT_ID;
  $param["text"] = 'Новая заявка №'.$args['id'].' в ауд. '.$args['aud']."(".$args['otdel'].")\n".$args['text'];
  $updates = apiRequest("sendMessage", $param);
});

event::addHandler('onAfterTicketWork', function($args) 
{
   $param["chat_id"] = CHAT_ID;
  $param["text"] = "Заявка №{$args['id']}\nСтатус: Взята в работу\nИнженер: {$args['fio']}";
  $updates = apiRequest("sendMessage", $param);
});

event::addHandler('onAfterTicketComplete', function($args) 
{
  $param["chat_id"] = CHAT_ID;
  $param["text"] = "Заявка №{$args['id']}\nСтатус: Выполнено\nИнженер: {$args['fio']}";
  $updates = apiRequest("sendMessage", $param);
});


?>