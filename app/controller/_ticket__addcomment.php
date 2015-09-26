<?php
/**
 * @todo Доделать проверку на доступ к заявке
 */
global $params;

$ticket=Ticket::find_one($id);
/*
if(!$ticket->computer_name!=$app->Auth->getUserIDKey() or !$app->Auth->isLogged()) {
    $app->flash('info', 'Вы не имеете доступа к этой заявке.');
    $app->redirect("/");
}
*/
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

if( in_array($app->Auth->role,array("engineer","admin")) ){
    //Сообщение пользователю заявки
} else {
    //Сообщение инженеру(ам)
}
$app->redirect("/ticket/{$id}");
?>