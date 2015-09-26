<?php
/**
 * @todo �������� �������� �� ������ � ������
 */
global $params;

$ticket=Ticket::find_one($id);
/*
if(!$ticket->computer_name!=$app->Auth->getUserIDKey() or !$app->Auth->isLogged()) {
    $app->flash('info', '�� �� ������ ������� � ���� ������.');
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
    //��������� ������������ ������
} else {
    //��������� ��������(��)
}
$app->redirect("/ticket/{$id}");
?>