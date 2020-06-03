<?php
header('Access-Control-Allow-Origin: *');
require_once "AppLib.php";
require_once "../controller/tickets/TicketsController.php";
require_once "../controller/reponse_processor/ResponseDispatcher.php";
use api_lib\AppLib as app_lib;
use response_handler\ResponseDispatcher as response_dispatcher;
use tickets\TicketsController as tickets_controller;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json = file_get_contents("php://input");
$data = json_decode($json);

if(app_lib::isGetMethod()){
//    echo $_COOKIE["user_id"];
    response_dispatcher::sendInvalidRequestMethod();
}

if (app_lib::isPostRequest()){
    $request = $data->request;
    switch ($request){
        case "update_pool":
            $tickets = new tickets_controller();
            $tickets->get_ticket_pool($data);
    }

}
