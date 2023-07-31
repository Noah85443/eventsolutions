<?php $subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2)) ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>EventSolutions</title>
        
        <link href="<?php print STYLE_CSS_BOOTSTRAP; ?>" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Symbols+Outlined" rel="stylesheet">
        
        <link href="<?php print STYLE_CSS; ?>/dashboard.css" rel="stylesheet">
    </head>
    <body>
        <header class="navbar bg-light sticky-top flex-md-nowrap p-3">
            <a class="col-md-3 col-lg-2 me-0 px-3" href="/"><img src="<?php print STYLE_IMAGES; ?>/logo.png" style="height:20px;width:auto;margin-top:-8px;"></a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3 icon-link" href="<?php print BASE_ACCOUNTS; ?>">
						<span class="material-symbols-outlined icon float-start me-2" role="img">manage_accounts</span>&nbsp;
						<?php print $userData->account_name; ?>
					</a>
                </div>
            </div>
        </header>
        
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-white">
                    <div class="position-sticky pt-3 sidebar-sticky bg-white">
                        <?php require_once 'core/nav.php'; ?>
                    </div>
                </nav>
                
                <main class="col-md-9 ms-sm-auto col-lg-10 pt-4 px-md-5">