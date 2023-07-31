<ul class="nav flex-column">
    	<li class="nav-item">
             <a class="nav-link" href="/">
                 <span class="material-icons-outlined icon">dashboard</span>
                 Dashboard
             </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/projecten/dashboard">
                <span class="material-icons-outlined icon">fact_check</span>
                Projecten
            </a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="/locaties/dashboard">
               <span class="material-icons-outlined icon">place</span>
               Locaties
           </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/relaties/dashboard">
                <span class="material-icons-outlined icon">business</span>
                Relaties
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/facturatie/dashboard">
                <span class="material-icons-outlined icon">payments</span>
                Facturatie
            </a>
        </li>
        <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#verhuur-collapse" aria-expanded="faslse" href="#">
                        <span class="material-icons-outlined icon">category</span>
                        Verhuur
                    </a>
            <div class="collapse show" id="verhuur-collapse">  
            <ul class="nav flex-column ps-3">
                <li class="nav-item"><a class="nav-link" href="/verhuur/projecten">Aanvragen</a></li>
                <li class="nav-item"><a class="nav-link" href="/verhuur/artikelen">Artikelen</a></li>
                <li class="nav-item"><a class="nav-link" href="/verhuur/artikelgroepen">Artikelgroepen</a></li>
                <li class="nav-item"><a class="nav-link" href="/verhuur/emballage">Emballage</a></li>
              </ul>
            </div>
      </li>
      <li class="nav-item">
            <a class="nav-link" href="<?php print BASE_ACCOUNTS.'/alle-gebruikers'; ?>" target="_blank">
                <span class="material-icons-outlined icon">people</span>
                Gebruikers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/crew/dashboard">
                <span class="material-icons-outlined icon">emoji_emotions</span>
                Medewerkers
            </a>
        </li>
	</ul>