<?php


namespace tickets;
use response_handler\ResponseDispatcher;
require_once "/var/www/html/ticketing_alt/model/TicketsModel.php";
require_once "/var/www/html/ticketing_alt/controller/reponse_processor/ResponseDispatcher.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class TicketsController
{

    public function get_ticket_pool($req_data){
        if(isset($req_data->agent_id)){
            $ticket = new TicketsModel();
            $pool_tickets = $ticket->getTicketPool($req_data);
            $pool_ticket_count = count($pool_tickets);
            $result = array("pool_count"=> $pool_ticket_count, "tickets"=> $pool_tickets);
            ResponseDispatcher::sendResponse($result);
        }
    }

}