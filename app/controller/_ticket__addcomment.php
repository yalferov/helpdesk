<?php
global $params;

$comment=Comment::create();
$comment->ticket_id=$id;
$comment->text=$app->request->post('inputComment');
if($app->Auth->isLogged()){
$comment->user='�������';
} else {
$comment->user='������������';
}
$comment->comment_time=date("Y-m-d H:i:s");
$comment->save();
$app->redirect("/ticket/{$id}");
?>