<?php
/**
 * Created by PhpStorm.
 * User: DjJustin
 * Date: 27.09.2015
 * Time: 0:28
 */
global $params;
$comments=CommentUnread::where('user_idkey', $app->Auth->userIDKey)->find_many();
$params['comments']=$comments;
$app->render('comments.html',$params);
?>