<article>   
    <h1>Nazwa Użytkownika:</h1>
    <section>
        <?php echo $ActiveDirectory->getUserAsUser()->getDisplayName() ;?>
    </section>
</article>

<article>   
    <h1>Email:</h1>
    <section>
    <?php echo $ActiveDirectory->getUserAsUser()->getEmail() ;?> 
    </section>
</article>

<article>   
    <h1>Ostatnia Zmiana Hasła:</h1>
    <section>
        <?php echo $ActiveDirectory->getUserAsUser()->getPasswordLastSetDate() ;?>
    </section>
</article>