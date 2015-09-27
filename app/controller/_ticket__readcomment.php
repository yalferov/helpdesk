<?php
/**
 * Created by PhpStorm.
 * User: DjJustin
 * Date: 27.09.2015
 * Time: 21:48
 */
$commentUnread = CommentUnread::
    where(array(
        'comment_id'=>$idcomment,
        'user_idkey'=>$app->Auth->getUserIdKey()
    ))
    ->find_one();
$ticketId=$commentUnread->ticket_id;
$commentUnread->delete();
$app->redirect('/ticket/'.$ticketId);
?>