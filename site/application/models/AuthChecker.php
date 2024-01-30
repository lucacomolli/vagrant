<?php

class AuthChecker
{
    public static function checkUserLogged(){
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if(!(isset($_SESSION[S_IS_LOGGED]) && ($_SESSION[S_IS_LOGGED] == 1 || $_SESSION[S_IS_LOGGED]))){
            header('location:' . URL . 'account/login');
        }
    }
}