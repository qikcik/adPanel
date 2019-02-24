<?php

    function nextForm($pass1,$pass2,$mail)
    {
        global $ActiveDirectory;
        global $Session;

        if( $pass1 == "" ||  $pass2 == "" || $mail == "" )
            return "ale ty wiesz że... Musisz wypełnić wszystkie pola";

        if( $pass1 != $pass2 )
            return "Niestety, Hasła nie są identyczne";

        if( !Usefull::checkPassword($pass1) )
            return "Hasło nie spełnia wymagań";

        if( !Usefull::checkIsEmail($mail) )
            return "Ten email nie wygląda na prawdziwy ...";

        $ActiveDirectory->getUserAsAdmin()->setPassword($pass1);
        $ActiveDirectory->getUserasAdmin()->mail = $mail;
        
        if( !@$ActiveDirectory->getUserAsAdmin()->save() )
            return "O nie! Wystąpił nieoczekiwany bład, napewno wszystko dobrze wpisałeś ?";
        else 
        {
            $Session->updatePassword($pass1);
            Usefull::Refresh();
        }
    }

    if(isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['mail']) )
        $error = nextForm($_POST['pass1'],$_POST['pass2'],$_POST['mail']);

?>


<html>
    <head>
        <title>ADPanel - Witamy :)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v=0.2">
    </head>
    <body id="form">
        <main>
            <h1> Wygląda na to że logujesz się pierwszy raz </h1>

            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="post" class="login">
                <input name="pass1" type="password" placeholder="nowe hasło" autofocus require>
                <input name="pass2" type="password" placeholder="powtórz" require>
                <input name="mail" type="email" placeholder="e-mail" require>
                <span> Hasło musi mieć conajmniej 8 znaków i posiadać przynajmniej jedną cyfrę i znak specjalny, e-mail bedzię wykorzystywany przy odzyskiwaniu hasła</span>
                <input name="login" type="submit" value="Dalej" >
            </form>
            <div>
                <a href="?c=logout"> Wyloguj się </a>
            </div>
        </main>
        <footer>
            ADPanel - Dominik Rudnik (C) 2019
        </footer>
    </body>
</html>