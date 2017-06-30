<!DOCTYPE html>
<html lang="fr">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-pink.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/test.css">
</head>
<body>

	<!-- Simple header with scrollable tabs. -->
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
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
	      <a href="#scroll-tab-1" class="mdl-layout__tab is-active">Tous</a>
	      <a href="#scroll-tab-2" class="mdl-layout__tab">Internet</a>
	      <a href="#scroll-tab-3" class="mdl-layout__tab">Papier</a>
	    </div>
	  </header>
	  <div class="mdl-layout__drawer">
	    <span class="mdl-layout-title">UserName</span>
	    <nav class="mdl-navigation">
	      <a href="" class="mdl-navigation__link title"></a>
	      <a class="mdl-navigation__link" href=""><i class="material-icons">apps</i>Tableau de bord</a>
	      <a class="mdl-navigation__link" href="">File d'actualité</a>
	      <a class="mdl-navigation__link" href="">Semaine dernière</a>
	      <a class="mdl-navigation__link" href="">Mois dernier</a>
	      <a class="mdl-navigation__link" href="">Trois derniers mois</a>
	      <a class="mdl-navigation__link" href="" style="margin-top: 80px">Déconnexion</a>
	    </nav>
	  </div>
	  <main class="mdl-layout__content">
	    <section class="mdl-layout__tab-panel is-active" id="scroll-tab-1">
	      <div class="page-content">
	      	<!-- MDL Progress Bar with Indeterminate Progress -->
			<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
	      	<div class="mdl-grid">

	      		<div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--1-offset-desktop mdl-cell--8-col-tablet">

	      			<section class="section--center mdl-grid mdl-grid--no-spacing">
			            <header class="mdl-shadow--2dp mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
			            	<img class="section-img" src="/img/real.jpg">
			            </header>
			            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone">
			              <div class="mdl-card__supporting-text">
			                <h4><a href="">Real: Champion d'Europe 2017</a></h4>
			                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			                consequat.
			              </div>
			              <div class="mdl-card__actions">
			                <small>il y'a 17 heures</small><br><br>
			                <small><a href="">sourcename</a> / <a href="">authorname</a></small>
			              </div>
			            </div>
			        </section>

	      			<section class="section--center mdl-grid mdl-grid--no-spacing">
			            <header class="mdl-shadow--2dp mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--4-col-phone">
			            	<img class="section-img" src="/img/chelsea.jpg">
			            </header>
			            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--9-col-desktop mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			              <div class="mdl-card__supporting-text">
			                <h4><a href="">Chelsea champion de la Barclays Premier League</a></h4>
			                Dolore ex deserunt aute fugiat aute nulla ea sunt aliqua nisi cupidatat eu. Nostrud in laboris labore nisi amet do dolor eu fugiat consectetur elit cillum esse.
			              </div>
			              <div class="mdl-card__actions">
			                <small>il y'a 17 heures</small><br><br>
			                <small><a href="">sourcename</a> / <a href="">authorname</a></small>
			              </div>
			            </div>
			        </section>

			        <section class="section--center mdl-grid mdl-grid--no-spacing">
			            <header class="mdl-shadow--2dp mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--4-col-phone">
			            	<img class="section-img" src="/img/canne.jpg">
			            </header>
			            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--9-col-desktop mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			              <div class="mdl-card__supporting-text">
			                <h4><a href="">Festival de Canne</a></h4>
			                Dolore ex deserunt aute fugiat aute nulla ea sunt aliqua nisi cupidatat eu. Nostrud in laboris labore nisi amet do dolor eu fugiat consectetur elit cillum esse.
			              </div>
			              <div class="mdl-card__actions">
			                <small>il y'a 17 heures</small><br><br>
			                <small><a href="">SourceName</a> / <a href="">AuthorName</a></small>
			              </div>
			            </div>
			        </section>

			        <section class="section--center mdl-grid mdl-grid--no-spacing">
			            <header class="mdl-shadow--2dp mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--4-col-phone">
			            	<img class="section-img" src="/img/article.jpg">
			            </header>
			            <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--9-col-desktop mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			              <div class="mdl-card__supporting-text">
			                <h4><a href="">Festival de Canne</a></h4>
			                Dolore ex deserunt aute fugiat aute nulla ea sunt aliqua nisi cupidatat eu. Nostrud in laboris labore nisi amet do dolor eu fugiat consectetur elit cillum esse.
			              </div>
			              <div class="mdl-card__actions">
			                <small>il y'a 17 heures</small><br><br>
			                <small><a href="">SourceName</a> / <a href="">AuthorName</a></small>
			              </div>
			            </div>
			        </section>
	      		</div>
			  	
			  	<div class="aside mdl-cell mdl-cell--2-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
				  	<section class="section--center mdl-grid mdl-grid--no-spacing">
				  		<div class="mdl-card mdl-shadow--2dp mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
						  <div class="mdl-card__title mdl-card--border">
						    <h2 class="mdl-card__title-text">Articles récents</h2>
						  </div>
						  <div class="mdl-card__supporting-text">
						    <ul class="demo-list-item mdl-list">
							  <li class="mdl-list__item">
							    <span class="mdl-list__item-primary-content">
							      <a href="">Real: Champion d'Europe 2017</a>
							    </span>
							  </li>
							  <li class="mdl-list__item">
							    <span class="mdl-list__item-primary-content">
							      <a href="">Chelsea champion de la Barclays Premier League</a>
							    </span>
							  </li>
							  <li class="mdl-list__item">
							    <span class="mdl-list__item-primary-content">
							      <a href="">Festival de Canne</a>
							    </span>
							  </li>
							</ul>
						  </div>
						</div>
				  	</section>
			  	</div>
			</div>
	      </div>
	    </section>

	    <section class="mdl-layout__tab-panel" id="scroll-tab-2">
	      <div class="page-content"><!-- Your content goes here --></div>
	    </section>

	    <section class="mdl-layout__tab-panel" id="scroll-tab-3">
	      <div class="page-content"><!-- Your content goes here --></div>
	    </section>

	  </main>
	</div>

	<a href="" target="_blank" id="view-pdf" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast mdl-cell--hide-tablet mdl-cell--hide-phone">Télécharger pdf</a>

	<a href="" id="view-pdf" class="mdl-button mdl-js-button mdl-button--fab mdl-color--accent mdl-color-text--accent-contrast mdl-cell--hide-desktop"><i class="material-icons">file_download</i></a>

    <!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script>
		var overlay = document.getElementById('p2');
        window.addEventListener('load', function () {
            overlay.style.display = 'none';
        });
	</script>

</body>
</html>