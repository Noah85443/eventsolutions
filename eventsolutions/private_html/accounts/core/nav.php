<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/">
            <span data-feather="home" class="align-text-bottom"></span>
            Overzicht
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?php print BASE_ACCOUNTS.'/bewerken'; ?>">
            <span data-feather="home" class="align-text-bottom"></span>
            Gegevens bewerken
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?php print BASE_ACCOUNTS.'/wachtwoord-bewerken'; ?>">
            <span data-feather="home" class="align-text-bottom"></span>
            Wachtwoord wijzigen
        </a>
    </li>
    
    <?php if(in_array("admin", $userType)) { ?>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?php print BASE_ACCOUNTS.'/nieuw'; ?>">
            <span data-feather="home" class="align-text-bottom"></span>
            Nieuwe gebruiker
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="<?php print BASE_ACCOUNTS.'/alle-gebruikers'; ?>">
            <span data-feather="home" class="align-text-bottom"></span>
            Alle gebruikers
        </a>
    </li>
    <?php } ?>
    
</ul>