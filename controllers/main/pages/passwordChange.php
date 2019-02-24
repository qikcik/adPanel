<?php

    function passwordForm($pass1,$pass2)
    {
        global $ActiveDirectory;
        global $Session;

        if( $pass1 == "" ||  $pass2 == "" )
            return "ale ty wiesz że... Musisz wypełnić wszystkie pola";

        if( $pass1 != $pass2 )
            return "Niestety, Hasła nie są identyczne";

        if( !Usefull::checkPassword($pass1) )
            return "Hasło nie spełnia wymagań";

        $ActiveDirectory->getUserAsAdmin()->setPassword($pass1);
        
        if( !@$ActiveDirectory->getUserAsAdmin()->save() )
            return "O nie! Wystąpił nieoczekiwany bład, napewno wszystko dobrze wpisałeś ?";
        else 
        {
            $Session->updatePassword($pass1);
            Usefull::Refresh();
        }
    }

    function mailForm($mail)
    {
        global $ActiveDirectory;

        if( $mail == "" )
        return "ale ty wiesz że... Musisz wypełnić wszystkie pola";

        if( !Usefull::checkIsEmail($mail) )
            return "Ten email nie wygląda na prawdziwy ...";

        $ActiveDirectory->getUserasAdmin()->mail = $mail;
        
        if( !@$ActiveDirectory->getUserAsAdmin()->save() )
            return "O nie! Wystąpił nieoczekiwany bład, napewno wszystko dobrze wpisałeś ?";
        else 
        {
            Usefull::Refresh();
        }
    }

    if( isset($_POST['pass1']) && isset($_POST['pass2'])  )
        $errorPasswordForm = passwordForm($_POST['pass1'],$_POST['pass2'] );

    if( isset($_POST['mail'])  )
        $errorMailForm = mailForm( $_POST['mail'] );

?>

<article>   
    <h1> Zmień hasło </h1>
    <?php if(isset($errorPasswordForm)): ?>
        <div class="error">
            <?php echo($errorPasswordForm) ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <input name="pass1" type="password" placeholder="nowe hasło" autofocus require>
        <input name="pass2" type="password" placeholder="powtórz" require>
        <span> Hasło musi mieć conajmniej 8 znaków i posiadać przynajmniej <br/> jedną cyfrę i znak specjalny,  e-mail bedzię wykorzystywany <br/> przy odzyskiwaniu hasła</span>
                
        <input name="f1" type="submit" value="Zmień" >
    </form>
</article>

<article>   
    <h1> Zmień E-mail </h1>
    <?php if(isset($errorMailForm)): ?>
        <div class="error">
            <?php echo($errorMailForm) ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <input name="mail" type="email" placeholder="nowy mail"  require>  
        <input name="f2" type="submit" value="Zmień" >
    </form>
</article>