<?php

session_cache_limiter(false);
session_start();

//
/*
Подключаем Slim 
*/
require 'Slim/Slim.php';
Slim\Slim::registerAutoloader();
use Slim\Slim;

require 'Slim/Extras/Views/Twig.php';
use Slim\Views\Twig;

$app = new Slim(array('view' => new Twig()));


//$app->view()->parserOptions=array('charset'=>'windows-1251');


require 'app/lib/idiorm.php';
require 'app/lib/paris.php';

require 'config.php';
require 'app/function.php';

// Models
require 'app/models/Models.php';

require 'app/auth.php';
$app->Auth = new Auth;

//Передача глобальных объектов
$params = array(
    'Auth' => $app->Auth,
    'AppHeader' => $app_config["APP_HEADER"],
    'InfoMessage' => $_SESSION['slim.flash']['info'],
    'ErrorMessage' => $_SESSION['slim.flash']['error']
);

require 'app/event.php';
require 'app/init.php';

require 'app/lib/telegram.php';
require 'app/lib/pagination.class.php';
/*
Роутинг
*/
// Главная


$app->get('/', function () use ($app) {
    include("app/controller/default.php");
});

//Авторизация

$app->get('/login', function () use ($app) {
    global $params;
    if ($app->Auth->isLogged()) {

        $app->redirect('/');
    } else {
        $app->render('loginform.html', $params);
    }

}
);

$app->post('/login', function () use ($app) {


    $inputUserName = $app->request->post('inputUserName');
    $inputPassword = $app->request->post('inputPassword');


    if ($app->Auth->login($inputUserName, $inputPassword)) {
        $app->redirect('/');
    } else {
        $app->redirect('/login');

    }


}
);

$app->get('/logout', function () use ($app) {
    $app->Auth->logout();
    $app->flash('info', 'Вы вышли из системы.');
    $app->redirect('/');

}
);


// Форма добавления заявки
$app->get('/ticket/add(/:type)', function ($type = 'default') use ($app) {
    global $params;

    $params['compname'] = $app->Auth->getUserIdKey();

    switch ($type) {
        case 'cartridge':
            $params['inputCategory'] = 4;
            $app->render('ticketaddform_cartridge.html', $params);
            break;
        case 'remont':
            $params['inputCategory'] = 3;
            $app->render('ticketaddform.html', $params);
            break;
        default:
            $params['inputCategory'] = 1;
            $app->render('ticketaddform.html', $params);
            break;
    }


});

// Добавление заявки в базу
$app->post('/ticket/add', function () use ($app) {
    include("app/controller/_ticket_add.php");
});


$app->get('/ticket/edit/:id', function ($id) use ($app) {
    global $params;
    $islogged = $app->Auth->isLogged();

    $ticket = Ticket::find_one($id);
    if (!$ticket instanceof Ticket) {
        $app->notFound();
    }

    //  $app->render('header.php', array('username'=>Auth->userFIO, 'islogged'=>$islogged)); ;
    //   echo "<h1>Редактирование заявки {$id}</h1>";
    $params[''] = '';
    $app->render('ticketeditform.html', $params);
    //$app->render('footer.php');
}
);

$app->post('/ticket/edit/:id', function ($id) use ($app) {
    $islogged = $app->Auth->isLogged();
    $app->render('header.php', array('username' => $app->Auth->userFIO, 'islogged' => $islogged));
    echo "<h1>Сохранение заявки {$id}</h1>";
    $app->render('footer.php');
}
);


$app->get('/ticket/cancel/(:id)', function ($id) use ($app) {
    global $params;
    $ticket = Ticket::find_one($id);
    if ($ticket->status == 0) $ticket->status = 4;
    $ticket->save();
    $app->flash('info', 'Заявка отменена. ');
    $app->redirect('/');
}
);
// Взять заявку в работу
$app->get('/ticket/work/(:id)', function ($id) use ($app) {
    global $params;
    $ticket = Ticket::find_one($id);
    if ($ticket->status == 0) { //в работу можно взять только не отменнную заявку
        $ticket->status = 1;
        $ticket->user_id = $app->Auth->userID;
        $ticket->save();
        //onAfterTicketWork
        $eventArgs = array(
            'id' => $ticket->id(),
            'fio' => $app->Auth->userFIO,
            'aud' => $ticket->aud,
            'otdel' => $ticket->otdel);
        event::run('onAfterTicketWork', $eventArgs);
    }

    $app->redirect('/ticket/'.$id);
}
);
// Завершить заявку
$app->post('/ticket/complete/:id', function ($id) use ($app) {
    global $params;
    $ticket = Ticket::find_one($id);
    if ($ticket->status == 1) { // Завершить можно только из статуса в работе
        $ticket->status = 2;
        $ticket->complete_text = $app->request->post('inputCompleteText');
        $ticket->datetime_end = date("Y-m-d H:i:s");
        $ticket->save();
        /*
         * Вызов onAfterTicketComplete
         */
        $eventArgs = array(
            'id' => $ticket->id(),
            'fio' => $app->Auth->userFIO,
            'aud' => $ticket->aud,
            'otdel' => $ticket->otdel);
        event::run('onAfterTicketComplete', $eventArgs);
    }
    $app->redirect('/');
}
);
// Закрыть заявку
$app->get('/ticket/close/(:id)', function ($id) use ($app) {
    global $params;
    $ticket = Ticket::find_one($id);
    if ($ticket->status == 2) $ticket->status = 3; // Завершить можно только из статуса в работе
    $ticket->save();
    $app->redirect('/');
}
);

$app->get('/ticket', function () use ($app) {
    include("app/controller/_ticket.php");
});

$app->get('/ticket/:id(/:print)', function ($id, $print = "") use ($app) {
    include("app/controller/_ticket__id.php");
});


$app->post('/ticket/:id/addcomment', function ($id) use ($app) {
    include("app/controller/_ticket__addcomment.php");
});

$app->get('/readcomment/:idcomment', function ($idcomment) use ($app) {
    include("app/controller/_ticket__readcomment.php");
});

$app->post('/message/add', function () use ($app) {
    global $params;

    $comment = Message::create();
    $comment->text = $app->request->post('inputMessage');
    $comment->datetime = date("Y-m-d H:i:s");
    $comment->save();
    $app->redirect("/");
});
/* Сообщения в заявках */
$app->get('/comments', function () use ($app) {
    include("app/controller/_comments.php");
});

//Дополнительная информация
$app->get('/engineerzone', function () use ($app) {
    $app->render('engineerzone.html', array('Auth' => $app->Auth));
});

// Отчеты
$app->get('/report', function () use ($app) {
    global $params;
    $app->render('report.html', $params);
});

$app->get('/report/:id', function () use ($app) {
    global $params;
    $app->render('report.html', $params);
});


$app->run();
