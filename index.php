<?php

    require_once("core/ActiveDirectory.php");
    require_once("core/Session.php");
    require_once("core/usefull.php");
    require_once("core/Mailer.php");

    
    $ActiveDirectory = new ActiveDirectory();
    $Session = new Session($ActiveDirectory);

    $controllerName = isset($_GET['c']) ? $_GET['c'] : "main";

    if( !$ActiveDirectory->isConnect() )
        $controllerName = "error";

    while(true)
    {
        if($controllerName == "main")
        {
            if( !$Session->isLoginUser() ) // nie zalogowany
                $controllerName = "login";
            else if($ActiveDirectory->getUserAsUser()->getEmail() == "") // nie posiada email'a
                $controllerName = "firstLogin";
            else break;
        }

        else if($controllerName == "login")
        {
            if( $Session->isLoginUser() ) // zalogowany 
                $controllerName = "main";
            else break;
        }

        else if($controllerName == "error")
        {
            break;
        }

        else if($controllerName == "firstLogin")
        {
            if( !$Session->isLoginUser() ) // nie zalogowany
                $controllerName = "login";
            else if($ActiveDirectory->getUserAsUser()->getEmail() != "") // posiada już email
                $controllerName = "main";
            else break;
        }

        else if($controllerName == "passwordForgot")
        {
            if( $Session->isLoginUser() ) // zalogowany 
                $controllerName = "main";
            else break;
        }

        else if($controllerName == "passwordRetrieval")
        {
            if( $Session->isLoginUser() ) // zalogowany 
                $controllerName = "main";
            else if( !isset($_GET['n']) ) // nie ma nazwy
                $controllerName = "main";
            else if( !@$ActiveDirectory->asAdmin()->search()->find($_GET['n']) ) // zła nazwa
                $controllerName = "main";
            else if( $Session->getToken($_GET['n']) == "" ) // nie ma tokenu token
                $controllerName = "main";
            else break;

        }

        else if($controllerName == "logout")
        {
            $Session->logout();
            $controllerName = "login";
        }

        else
        {
            $controllerName = "main";
        }
    }

    include("controllers/".$controllerName.".php");

?>