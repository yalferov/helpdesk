   <?php
   /**
    * @todo Сделать вывод заявок поданных с текущего компьютера и заявок поданных под логином текущего пользователя ldap
    */
   global $params, $ticketStatus, $ticketCategory;
        $computername=$app->Auth->getUserIdKey();
        if($app->Auth->isLogged()){

            if(!is_null($app->request->get('myticket'))){ //Если выбран вывод "Мои заявки"
                /* Выводим только заявки взяты инженером в работу */
                $tickets=Ticket::where('user_id',$app->Auth->userID)->where_lte('status', 2)->order_by_desc('datetime_add')->find_many();
            } else {
                /* Выводим все не закрытие заявки  */
                $tickets=Ticket::where_lte('status', 2)->order_by_desc('datetime_add')->find_many();    
            }
            
        } else {
            $tickets=Ticket::where('computer_name',$computername)->where_lte('status', 2)->order_by_desc('datetime_add')->find_many();    
        }
        
        foreach($tickets as $ticket){
            $ticket->status_text=$ticketStatus[$ticket->status]["text"];
            $ticket->status_style=$ticketStatus[$ticket->status]["style"];
            $ticket->category_text=$ticketCategory[$ticket->category];
           if(strlen($ticket->text)>150){
                $ticket->text=substr($ticket->text,0,150)."...";
            }
        }
        $messages=Message::order_by_desc('datetime')->find_many();
    
        $params['tickets']=$tickets;
        $params['messages']=$messages;
        
        $app->render('main.html',$params);
    
     ?>