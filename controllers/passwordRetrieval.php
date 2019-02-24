<?php

    function nextForm($pass1,$pass2,$token)
    {
        global $ActiveDirectory;
        global $Session;

        $user = @$ActiveDirectory->asAdmin()->search()->find($_GET['n']);
        if(!$user)
            return "O nie! Wystąpił nieoczekiwany bład";

        if( $pass1 == "" ||  $pass2 == ""  ||  $token == "" )
            return "ale ty wiesz że... Musisz wypełnić wszystkie pola";

        if( $token != $Session->getToken($_GET['n']) )
            return "zły kod dostępu, możliwe że już wygasł";

        if( $pass1 != $pass2 )
            return "Niestety, Hasła nie są identyczne";

        if( !Usefull::checkPassword($pass1) )
            return "Hasło nie spełnia wymagań";

        $user->setPassword($pass1);
        
        if( !@$user->save() )
            return "O nie! Wystąpił nieoczekiwany bład, napewno wszystko dobrze wpisałeś ?";
        else 
        {
            $Session->setToken($_GET['n'],'');
            Usefull::Refresh();
        }
    }

    if(isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['token']) )
        $error = nextForm($_POST['pass1'],$_POST['pass2'],$_POST['token']);

?>


<html>
    <head>
        <title>ADPanel - Ciąg dalszy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v=0.2">
    </head>
    <body id="form">
        <main>
            <h1> Ustaw Nowe Hasło dla: "<?php echo $_GET['n'] ?>" </h1>

            <?php if(isset($error)): ?>
                <div class="error">
                    <?php echo($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="post" class="login">
                <input name="token" type="text" placeholder="kod dostępu" autofocus require>
                <input name="pass1" type="password" placeholder="nowe hasło" require>
                <input name="pass2" type="password" placeholder="powtórz" require>
                <span>Kod dośtepu wygasa po 5minutach, Hasło musi mieć conajmniej 8 znaków i posiadać przynajmniej jedną cyfrę i znak specjalny</span>
                <input name="login" type="submit" value="Dalej" >
            </form>
            <div>
                <a href="?c=passwordForgot"> Wygeneruj nowy kod </a>
            </div>
        </main>
        <footer>
            ADPanel - Dominik Rudnik (C) 2019
        </footer>
    </body>
</html>