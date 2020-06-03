<?php


namespace api_lib;


class AppLib
{
    static  function isPostRequest(){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            return true;
        }
        return false;
    }

    static function isGetMethod(){
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            return true;
        }
        return false;
    }
}