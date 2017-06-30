<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Material Design Lite</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-pink.min.css" />
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="/css/test.css">
    
  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">I-MEDIA</span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                    mdl-textfield--floating-label mdl-textfield--align-right">
            <label class="mdl-button mdl-js-button mdl-button--icon"
                   for="fixed-header-drawer-exp">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" name="data"
                     id="fixed-header-drawer-exp">
            </div>
          </div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <a class="mdl-navigation__link" href=""><i class="material-icons mdl-badge mdl-badge--overlap" data-badge="1">notifications</i></a>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right">
          <li class="mdl-menu__item">Déconnexion</li>
        </ul>
            <button id="demo-menu-lower-right" class="mdl-navigation__link mdl-button mdl-js-button mdl-button--icon">
          <i class="material-icons">more_vert</i>
        </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right">
          <li class="mdl-menu__item">Déconnexion</li>
        </ul>
          </nav>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a href="#scroll-tab-1" class="mdl-layout__tab is-active">Tous les articles</a>
          <a href="#scroll-tab-2" class="mdl-layout__tab">Articles numériques</a>
          <a href="#scroll-tab-3" class="mdl-layout__tab">Articles papiers</a>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">UserName</span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="">Tableau de bord</a>
          <a class="mdl-navigation__link" href="">Accuei</a>
          <a class="mdl-navigation__link" href="">Ajourd'hui</a>
          <a class="mdl-navigation__link" href="">Dans la semaine</a>
          <a class="mdl-navigation__link" href="">Dans le mois</a>
          <a class="mdl-navigation__link" href="">Dans les trois dernier mois</a>
          <a class="mdl-navigation__link" href="">Aide</a>
        </nav>
      </div>
      <div class="demo-ribbon"></div>
      <main class="demo-main mdl-layout__content">
        <div class="demo-container mdl-grid">
          <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
          <div class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
            <img src="/img/real.jpg">
            <h4>Article title</h4>
              <p>
                Cillum dolor esse sit incididunt velit eiusmod magna ad nostrud officia aute dolor dolor. Magna esse ullamco pariatur adipisicing consectetur eu commodo officia. Ex cillum consequat mollit minim elit est deserunt occaecat nisi amet. Quis aliqua nostrud Lorem occaecat sunt. Eiusmod quis amet ullamco aliquip dolore ut incididunt duis adipisicing. Elit consequat nisi eiusmod aute ipsum sunt veniam do est. Occaecat mollit aliquip ut proident consectetur amet ex dolore consectetur aliqua elit.
              </p>
              <p>
                Commodo nisi non consectetur voluptate incididunt mollit duis dolore amet amet tempor exercitation. Qui amet aute ea aute id ad aliquip proident. Irure duis qui labore deserunt enim in quis nisi sint consequat aliqua. Ex proident labore et laborum tempor fugiat sint magna veniam minim. Nulla dolor labore adipisicing in enim mollit laboris fugiat eu. Aliquip minim cillum ullamco voluptate non dolore non ex duis fugiat duis ad. Deserunt cillum ad et nisi amet non voluptate culpa qui do. Labore ullamco et minim proident est laborum mollit ad labore deserunt ut irure dolore. Reprehenderit ad ad irure ut irure qui est eu velit eu excepteur adipisicing culpa. Laborum cupidatat ullamco eu duis anim reprehenderit proident aute ad consectetur eiusmod.
              </p>
              <p>
                Tempor tempor aliqua in commodo cillum Lorem magna dolore proident Lorem. Esse ad consequat est excepteur irure eu irure quis aliqua qui. Do mollit esse veniam excepteur ut veniam anim minim dolore sit commodo consequat duis commodo. Sunt dolor reprehenderit ipsum minim eiusmod eu consectetur anim excepteur eiusmod. Duis excepteur anim dolor sit enim veniam deserunt anim adipisicing Lorem elit. Cillum sunt do consequat elit laboris nisi consectetur.
              </p>

              <small>il y'a 17 heures</small><br>
              <small><a href="">sourcename</a> / <a href="">authorname</a></small><br><br>

              <a href="#" type="button" class="mdl-chip mdl-color--accent mdl-color-text--accent-contrast">
                  <span class="mdl-chip__text">Politique</span>
              </a>
              <a href="#" type="button" class="mdl-chip mdl-color--accent mdl-color-text--accent-contrast">
                  <span class="mdl-chip__text">Sport</span>
              </a>
              <a href="#" type="button" class="mdl-chip mdl-color--accent mdl-color-text--accent-contrast">
                  <span class="mdl-chip__text">People</span>
              </a>
              <a href="#" type="button" class="mdl-chip mdl-color--accent mdl-color-text--accent-contrast">
                  <span class="mdl-chip__text">Science</span>
              </a>
          </div>
        </div>
        <footer class="demo-footer mdl-mini-footer">
          <div class="mdl-mini-footer--left-section">
            <ul class="mdl-mini-footer--link-list">
              <li><a href="#">Help</a></li>
              <li><a href="#">Privacy and Terms</a></li>
              <li><a href="#">User Agreement</a></li>
            </ul>
          </div>
        </footer>
      </main>
    </div>

    <a href="" target="_blank" id="view-pdf" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast mdl-cell--hide-tablet mdl-cell--hide-phone">Voir le pdf</a>

    <a href="" id="view-pdf" class="mdl-button mdl-js-button mdl-button--fab mdl-color--accent mdl-color-text--accent-contrast mdl-cell--hide-desktop"><i class="material-icons">insert_drive_file</i></a>

    <script src="$$hosted_libs_prefix$$/$$version$$/material.min.js"></script>
  </body>
</html>