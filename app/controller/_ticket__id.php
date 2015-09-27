<?php
/**
 * Просмотр детальной страницы по заявке
 */

global $params, $ticketStatus, $ticketCategory;
$ticket = Ticket::find_one($id);

if (!$ticket instanceof Ticket) {
    $app->flash('error', 'Заявка с таким номером не существует');
    $app->redirect('/');
}

if ($ticket->computer_name != $app->Auth->getUserIdKey() && !$app->Auth->isEngineer()) {
    $app->flash('error', 'Вы не имеете доступа к этой заявке.'.$ticket->computer_name.' '.$app->Auth->getUserIdKey());
    $app->redirect('/');
}

$user = $ticket->user()->find_one();
$comments = $ticket->comment()->order_by_desc('comment_time')->find_many();
$extras = $ticket->extras()->find_many();

$commentUnread=CommentUnread::
    where(array(
        'ticket_id'=>$id,
        'user_idkey'=>$app->Auth->getUserIdKey()
    ))
    ->find_many();

$arCommentsUnread=array();
foreach($commentUnread as $item){
    $arCommentsUnread[]=$item->comment_id;
}

foreach($comments as $comment){
    if(in_array($comment->id, $arCommentsUnread)){
        $comment->unread="1";
    } else {
        $comment->unread="0";
    }

}

$ticket->engineer = $user->fio;
$ticket->status_text = $ticketStatus[$ticket->status];
$ticket->category_text = $ticketCategory[$ticket->category];

/*
 * Параметры
 */
$params['ticket'] = $ticket;
$params['id'] = $id;
$params['comments'] = $comments;
foreach ($extras as $prop) {
    $params['prop_' . $prop->code] = $prop->value;
}

switch ($ticket->category) {
    case '4':
        if ($print == "print") {
            $app->render('viewticketcartridgeprint.html', $params);
        } else {
            $app->render('viewticketcartridge.html', $params);
        }

        break;

    default:
        $app->render('viewticket.html', $params);
        break;
}


?>