<?php

    if(isset($_POST['username']) && isset($_POST['password']) )
    {
        if($_POST['username'] != "" && $_POST['password'] != "" )
        {
            if( $Session->setUser($_POST['username'],$_POST['password']) )
                Usefull::Refresh();
            else $error = "Zły login lub hasło !!!";
        }
        else
            $error = "Podaj hasło i login !!!";
    }

?>


<html>
    <head>
        <title>ADPanel - Logowanie</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v=0.2">
    </head>
    <body id="form">
        <main>
            <h1> Zaloguj Się </h1>

            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" class="login">
                <input name="username" type="text" placeholder="login" autofocus require>
                <input name="password" type="password" placeholder="hasło" require>
                <input name="login" type="submit" value="Zaloguj" >
            </form>
            <div>
                <a href="?c=passwordForgot"> Zapomniałem hasła </a>
            </div>
        </main>
        <footer>
            ADPanel - Dominik Rudnik (C) 2019
        </footer>
    </body>
</html>