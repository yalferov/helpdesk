<?php
	global $params;

    $ticket = Ticket::create();
    $ticket->category=$app->request->post('inputCategory');
    $ticket->address =$app->request->post('inputAddress'); 
    $ticket->aud=$app->request->post('inputAud');
    $ticket->otdel=$app->request->post('inputOtdel'); 
    $ticket->fio=$app->request->post('inputFIO');
    $ticket->phone=$app->request->post('inputPhone'); 
    $ticket->inv_number=$app->request->post('inputInvNumber'); 
    $ticket->text=$app->request->post('inputTicketText');
    $ticket->computer_name=$app->request->post('inputComputerName');  
    $ticket->status=0;
    $ticket->datetime_add=date("Y-m-d H:i:s");
        
	

    //onBeforeTicketAdd
    event::run('onBeforeTicketAdd', $ticket);
      
	if($ticket->save()) {
        if($ticket->category==4){
            $ticket_extra=TicketExtra::create();
            $ticket_extra->code='printermodel';
            $ticket_extra->value=$app->request->post('inputPrinterModel');
            $ticket_extra->ticket_id=$ticket->id();
            $ticket_extra->save();
        }

        //onAfterTicketAdd
      	$eventArgs=array(
            'id'=>$ticket->id(), 
            'text'=>$ticket->text,
            'aud'=>$ticket->aud,
            'otdel'=>$ticket->otdel);
        event::run('onAfterTicketAdd', $eventArgs);
          
        $app->flash('info', 'Заявка добавлена. ');
        $app->redirect('/');
      
      } else {

        $app->flash('error', 'Ошибка добавления заявки');
        $app->redirect('/');

      }
?>