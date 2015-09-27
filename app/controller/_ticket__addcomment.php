<?php
/**
 * @todo Доделать проверку на доступ к заявке
 */
global $params;

$ticket=Ticket::find_one($id);

if($ticket->computer_name!=$app->Auth->getUserIDKey() && !$app->Auth->isEngineer()) {
    $app->flash('info', 'У вас нет прав оставлять комментарии к этой заявке'.$ticket->computer_name.' '.$app->Auth->getUserIDKey());
    $app->redirect("/");
}

/* Сообщение под заявкой */
$comment = Comment::create();
$comment->ticket_id = $id;
$comment->text = $app->request->post('inputComment');

if ($app->Auth->isLogged()) {
    $comment->user = $app->Auth->userFIO;

} else {
    $comment->user = $ticket->fio;

}

$comment->comment_time = date("Y-m-d H:i:s");
$comment->save();

/* Уведомление о непрочитанном сообщении */
$notify=CommentUnread::create();
$notify->ticket_id=$id;
$notify->comment_id=$comment->id();
$notify->notify_time=date("Y-m-d H:i:s");

if( in_array($app->Auth->userRole,array("engineer","admin")) ){
    $notify->user_idkey=$ticket->computer_name; //Пользователю
    $notify->save();
}

if($app->Auth->userRole=="guest"){
    $user=$ticket->user()->find_one();
    if ($user instanceof User){
        $notify->user_idkey=$user->type."__".$user->name; //Инженеру по заявке
        $notify->save();
    }
}

$app->redirect("/ticket/{$id}");
?>