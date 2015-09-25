<?php
global $params, $ticketStatus, $ticketCategory;
        $ticket = Ticket::find_one($id); 
        if (!$ticket instanceof Ticket)
        {
            $app->flash('error', 'Заявка с таким номером не существует');
            $app->redirect('/');
        }
        
        $user = $ticket->user()->find_one();
        $comments=$ticket->comment()->order_by_desc('comment_time')->find_many();
        $extras=$ticket->extras()->find_many();
        
        
        if($ticket->computer_name==computer_name() or $app->Auth->isLogged()){
            $ticket->engineer=$user->fio;
            $ticket->status_text=$ticketStatus[$ticket->status];
            $ticket->category_text=$ticketCategory[$ticket->category];
        
            $params['ticket']=$ticket;
            $params['id']=$id;
            $params['comments']=$comments;
            foreach($extras as $prop){
                $params['prop_'.$prop->code]=$prop->value;
            }

            switch ($ticket->category) {
                case '4':
                if ($print=="print") {
                    $app->render('viewticketcartridgeprint.html',$params);    
                } else
                {
                    $app->render('viewticketcartridge.html',$params);    
                }
                    
                break;
                
                default:
                    $app->render('viewticket.html',$params);
                break;
            }
            
            
        } else {
            $app->flash('error', 'Вы не имеете доступа к этой заявке.');
        $app->redirect('/');
        }
         
     
?>