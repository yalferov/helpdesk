<?php
/**
 * Вывод главной страницы
 *
 * @todo Сделать вывод заявок поданных с текущего компьютера и заявок поданных под логином текущего пользователя ldap
 */
global $params, $ticketStatus, $ticketCategory;
$computername = $app->Auth->getUserIdKey();

if ($app->Auth->isEngineer()) {

    if (!is_null($app->request->get('myticket'))) { //Если выбран вывод "Мои заявки"
        /* Выводим только заявки взяты инженером в работу */
        $tickets = Ticket::where('user_id', $app->Auth->userID)->where_lte('status', 2)->order_by_desc('datetime_add')->find_many();
    } else {
        /* Выводим все не закрытие заявки  */
        $tickets = Ticket::where_lte('status', 2)->order_by_desc('datetime_add')->find_many();
    }

} else {
    $tickets = Ticket::where('computer_name', $computername)->where_lte('status', 2)->order_by_desc('datetime_add')->find_many();
}

foreach ($tickets as $ticket) {
    $ticket->status_text = $ticketStatus[$ticket->status]["text"];
    $ticket->status_style = $ticketStatus[$ticket->status]["style"];
    $ticket->category_text = $ticketCategory[$ticket->category];
    if (strlen($ticket->text) > 150) {
        $ticket->text = substr($ticket->text, 0, 150) . "...";
    }
}
$messages = Message::order_by_desc('datetime')->find_many();

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


$params['tickets'] = $tickets;
$params['messages'] = $messages;

$app->render('main.html', $params);

?>