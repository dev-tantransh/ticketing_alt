<?php
/**
 * Created by PhpStorm.
 * User: veena
 * Date: 26/11/18
 * Time: 2:48 PM
 */

namespace response_handler;



class ResponseDispatcher
{
    private static $success = 200;
    private static $created = 201;
    private static $no_data = 204;
    private static $bad_request = 400;
//    private static $unauthorized = 401;
    private static $server_error = 500;
//    private static $resource_not_found = 404;
//
//
    public static $db_error = "DATABASE CONNECTION ERROR";
    public static $unprocessed_request = "UN PROCESSED REQUEST";
    public static $invalid_request = "INVALID REQUEST";
//
    public static function sendSuccessMessage(){
        $result = array("result"=>self::$success,"msg"=>"OK");
        http_response_code(self::$success);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public static function sendSuccessResponse($response){
        $result = array("result"=>self::$success,"data"=>$response);
        header('Content-Type: application/json');
        http_response_code(self::$success);
        echo json_encode($result);
    }


    public static function sendClientError($msg){
        header($msg,true,self::$bad_request);
        header('Content-Type: application/json');
        echo json_encode(array(
            "result"=> self::$bad_request,
            "msg"=>$msg
        ));
    }
//

    public static function sendServerError($msg){
        header($msg,true,self::$server_error);
        header('Content-Type: application/json');

        echo json_encode(array(
            "result"=>self::$server_error,
            "msg"=>$msg
        ));
    }

    public static function sendNoContent(){
        header("NO CONTENT",true,self::$no_data);
        echo json_encode(array(
            "result"=>self::$no_data,
            "msg"=>"NO CONTENT"
        ));
    }

    public static function sendInvalidRequestMethod(){
        header("IN VALID REQUEST METHOD",true,self::$bad_request);
        header('Content-Type: application/json');
        echo json_encode(array(
            "result"=>self::$bad_request,
            "msg"=>"IN VALID REQUEST METHOD"
        ));
    }

    public static function sendCreatedResponse($response){
        http_response_code(self::$created);
        header('Content-Type: application/json');
        $result = array("result"=>self::$created, "data"=>$response);
        echo json_encode($result);
    }

    public static function sendResponse($response){
        if(count($response)>0){
            self::sendSuccessResponse($response);
        }
        else
            self::sendNoContent();
    }

    public static function sendDBError($error){
        if(strpos($error,"Duplicate entry")==0){
            ResponseDispatcher::sendClientError("Duplicate Entry");
            return;
        }
        ResponseDispatcher::sendClientError(ResponseDispatcher::$unprocessed_request);
    }

}