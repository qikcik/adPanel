<?php

    $pageName = isset($_GET['p']) ? $_GET['p'] : "main";
    $pages = array();

    $pages['main']['name'] = "Informacje o koncie";
    $pages['main']['func'] = function($name) 
    {
        return $name;
    };

    $pages['passwordChange']['name'] = "Edytuj konto";
    $pages['passwordChange']['func'] = function($name) 
    {
        return "passwordChange";
    };

    $break = false;
    while(!$break)
    {
        $is = false;
        foreach($pages as $key => &$value)
        {
            if($pageName == $key)
            {
                $is = true;
                $pageName = call_user_func($value['func'],$pageName);
                if($key == $pageName)
                    $break = true;
            }
        }
        if(!$is) 
            $pageName = "main";
    }


?>


<html>
    <head>
        <title>ADPanel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v=0.2">
    </head>
    <body id="main">
        <header>
            <div> ADPanel </div>
            <div> 
                Zalogowany jako: <b> <?php echo $ActiveDirectory->getUserAsUser()->getDisplayName(); ?> </b> 
                <a href="?c=logout"> Wyloguj </a> 
            </div>
        </header>
        <section>
            <nav>
                <?php 
                    foreach($pages as $key => &$value)
                    {
                        if($key == $pageName) 
                            echo('<a class="selected" href="?c=main&p='.$key.'" >'.$value['name'].'</a>');
                        else
                            echo('<a href="?c=main&p='.$key.'" >'.$value['name'].'</a>');
                    }
                ?>
            </nav>
            <section>
                <main>
                    <?php include("controllers/main/pages/".$pageName.".php"); ?>
                </main>
                <footer>
                    Dominik Rudnik (C) 2019
                </footer>
            </section>
        <section>

    </body>
</html>