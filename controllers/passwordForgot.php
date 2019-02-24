<?php

    function nextForm($username,$mail)
    {
        global $ActiveDirectory;
        global $Session;

        if( $username == "" ||  $mail == "" )
            return "ale ty wiesz że... Musisz wypełnić wszystkie pola";

        if( !Usefull::checkIsEmail($mail) )
            return "Ten email nie wygląda na prawdziwy ...";


        $user = @$ActiveDirectory->asAdmin()->search()->find($username);
        if(!$user)
            return "Nie ma takiego użytkonika";

        if($user->getEmail() != $mail)
            return "do tego konta przypisany jest inny adres e-mail";

        $hash = uniqid();
        
        $mailSucces = Mailer::send($mail,"ADPanel: ZS1 bochnia - Odzyskiwanie Hasła",'Twój kod dostępu: "'.$hash.'" (działa tylko przez ok. 5min)');
        if(!$mailSucces)
        {
            return "O nie! Wystąpił nieoczekiwany bład, przy wysyłaniu mail'a";
        }

        $Session->setToken($username,$hash);
        header("Location: ?c=passwordRetrieval&n=".$username);

    }

    if(isset($_POST['username']) && isset($_POST['mail'])  )
        $error = nextForm($_POST['username'], $_POST['mail']);

?>


<html>
    <head>
        <title>ADPanel - O nie !!!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v=0.2">
    </head>
    <body id="form">
        <main>
            <h1> Co teraz ? </h1>

            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo($error) ?>
                </div>
            <?php endif; ?>

            
            
            <form method="post" class="login">
                <input name="username" type="text" placeholder="login" autofocus require>
                <input name="mail" type="email" placeholder="e-mail" require>
                <span>Podaj login, i e-mail, który masz przypisany do konta a my wyślemy ci mail'a z linkiem do odzyskania hasła</span>
                <input name="next" type="submit" value="Dalej" >
            </form>
            <div>
                <a href="?c=login"> a jednak sobie przypomniałem :) </a>
            </div>
        </main>
        <footer>
            ADPanel - Dominik Rudnik (C) 2019
        </footer>
    </body>
</html>