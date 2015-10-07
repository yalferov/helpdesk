<?php

/**
 * @author DjJustin
 * @copyright 2015
 */
 


date_default_timezone_set("Asia/Tashkent");
setlocale(LC_TIME, 'ru_RU.CP1251');

//Вывод непрочитанных сообщений
$comments=CommentUnread::where('user_idkey', $app->Auth->userIDKey)->find_many();
$data=array();
foreach ($comments as $comment) {
    $data[]=$comment->ticket_id;
}
if($comments) {
    $data=array_unique($data);

    $arUnreadTickets = array();
    foreach ($data as $key=>$value){
        $arUnreadTickets[]='<a href="/ticket/'.$value.'">заявка №'.$value.'</a> ';
    }
    $strUnreadTickets=implode(', ',$arUnreadTickets);
    $params['InfoNotify'] = "У вас есть не прочитанные сообщения: ".$strUnreadTickets;
}
// Конец вывода непрочитанных сообщений

event::addHandler('onAfterTicketAdd', function($args) 
{

 // if($app_config["TELEGRAM_SEND"]=="YES") {
    $param["chat_id"] = CHAT_ID;
    $param["text"] = 'Новая заявка №' . $args['id'] . ' в ауд. ' . $args['aud'] . "(" . $args['otdel'] . ")\n" . $args['text'];
    $updates = apiRequest("sendMessage", $param);
 // }
});

event::addHandler('onAfterTicketWork', function($args) 
{
//  if($app_config['telegram_send']==1) {
    $param["chat_id"] = CHAT_ID;
    $param["text"] = "Заявка №{$args['id']}\nСтатус: Взята в работу\nИнженер: {$args['fio']}";
    $updates = apiRequest("sendMessage", $param);
//  }
});

event::addHandler('onAfterTicketComplete', function($args) 
{
 // if($app_config['telegram_send']==1) {
    $param["chat_id"] = CHAT_ID;
    $param["text"] = "Заявка №{$args['id']}\nСтатус: Выполнено\nИнженер: {$args['fio']}";
    $updates = apiRequest("sendMessage", $param);
 // }
});

event::addHandler('onAfterTicketCommentAdd', function($args)
{
});

?>