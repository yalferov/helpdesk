<?php
global $params, $ticketStatus, $ticketCategory;
$itemsOnPage=20;// Количество элементов на странице
$computername=$app->Auth->getUserIdKey();

if($app->Auth->isEngineer()){

    $total_rows=Ticket::
        where_any_is(array(
            array('status'=>TICKET_CLOSE),
            array('status'=>TICKET_CANCEL)
        ))->order_by_desc('datetime_add')->count();
    if($total_rows>0){
        $obPagination = new Pagination($total_rows,$itemsOnPage);
        $offset=$obPagination->getOffset(); // Получаем сдвиг
        $limit=$obPagination->getLimit(); // Получаем лимит
        $arNav=$obPagination->getLinksArray(); //Получаем массив ссылок
        $tickets=Ticket::
            where_any_is(array(
                array('status'=>TICKET_CLOSE),
                array('status'=>TICKET_CANCEL)
            ))->order_by_desc('datetime_add')->limit($limit)->offset($offset)->find_many();
    }
} else {
    $tickets=Ticket::where('computer_name',$computername)->order_by_desc('datetime_add')->limit(10)->find_many();
}

if($tickets) {
    foreach ($tickets as $ticket) {
        $ticket->status_text = $ticketStatus[$ticket->status]["text"];
        $ticket->status_style = $ticketStatus[$ticket->status]["style"];
        $ticket->category_text = $ticketCategory[$ticket->category];
        if (strlen($ticket->text) > 150) {
            $ticket->text = substr($ticket->text, 0, 150) . "...";
        }
    }
}
$params['tickets']=$tickets;
$params['arnav']=$arNav;
$app->render('ticketlist.html',$params);
?>