<?php

/**
 * @author DjJustin
 * @copyright 2015
 */
 


date_default_timezone_set("Asia/Tashkent");
setlocale(LC_TIME, 'ru_RU.CP1251');

$comments=CommentUnread::where('user_idkey', $app->Auth->userIDKey)->find_many();
$data=array();
foreach ($comments as $comment) {
    $data[]=$comment->ticket_id;
}
if($comments) {
    $data=array_unique($data);

    $listTickets = "";
    foreach ($data as $key=>$value){
        $listTickets.='<a href="/ticket/'.$value.'">'.$value.'</a> ';
    }
    $params['InfoNotify'] = "У вас есть не прочитанные сообщения в заявках ".$listTickets;
}


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