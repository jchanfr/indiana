<?php
// Initialise la session
session_start();

// Include config file
require_once "config.php";

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Historique des campagnes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Site Description Here">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/stack-interface.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/socicon.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/lightbox.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/flickity.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/iconsmind.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/jquery.steps.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZK6TCE8FGH"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-ZK6TCE8FGH');
        </script>

    </head>
    <body class=" ">
        <a id="start"></a>
        <div class="nav-container nav-container--sidebar">
            <div class="nav-sidebar-column bg--dark">
                <div class="text-center text-block">
                    <a href="#">
                        <img alt="logo" class="logo" src="img/logo-light.png" />
                    </a>
                    <p>
                        Marketing Digital
                        <em>Metrics</em>
                    </p>
                </div>
                <hr>
                <div class="text-block">
                  <ul class="menu-vertical">
                      <a href="dashboard.php">
                      <li class="dropdown">
                          <span class="dropdown__trigger">Dashboard</span>
                      </li>
                      </a>
                      <a href="mes-informations.php">
                      <li class="dropdown">
                          <span class="dropdown__trigger">Mes informations</span>
                      </li>
                      </a>
                      <a href="historique-des-campagnes.php">
                      <li class="dropdown">
                          <span class="dropdown__trigger">Historique des campagnes</span>
                      </li>
                      </a>
                      <a href="reglages.php">
                      <li class="dropdown">
                          <span class="dropdown__trigger">Réglages</span>
                      </li>
                      </a>
                  </ul>
                </div>
                <div class="text-block">
                    <a class="btn block type--uppercase" href="creez-un-tracking.php">
                        <span class="btn__text">Nouvelle campagne</span>
                    </a>
                    <a class="btn block btn--primary type--uppercase" href="logout.php">
                        <span class="btn__text">Déconnexion</span>
                    </a>
                </div>
                <hr>
                <div>
                    <div>
                        <span class="type--fine-print type--fade">
                            &copy;
                            <span class="update-year"></span> Indiana Studio®
                        </span>
                    </div>
                </div>
            </div>
            <div class="nav-sidebar-column-toggle visible-xs visible-sm" data-toggle-class=".nav-sidebar-column;active">
                <i class="stack-menu"></i>
            </div>
        </div>

        <div class="main-container">

            <section class="imagebg image--light cover cover-blocks bg--secondary">
                <div class="background-image-holder hidden-xs">
                    <img alt="background" src="img/promo-1.jpg" />
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-5 ">
                            <div>
                                <h1>Historique des campagnes</h1>
                                <p class="lead">
                                    La liste de vos anciennes campagnes.
                                </p>
                                <hr class="short">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">

                        <div class="row mt--2">

                            <div class="col-md-12">

                                <div class="boxed boxed--border cart-total">

                                  <div class="row">
                                              <div class="col-1">
                                                  <span class="h5">ID:</span>
                                              </div>
                                              <div class="col-2">
                                                  <span class="h5">Campagne:</span>
                                              </div>
                                              <div class="col-2">
                                                  <span class="h5">Document:</span>
                                              </div>
                                              <div class="col-1">
                                                  <span class="h5">Qté:</span>
                                              </div>
                                              <div class="col-2">
                                                  <span class="h5">Action:</span>
                                              </div>
                                              <div class="col-2">
                                                  <span class="h5">Sanne:</span>
                                              </div>

                                              <div class="col-2 text-right">
                                              </div>
                                    </div>

                  <?php
                    $sql = "SELECT serial1, url, id, campagne, document, quantite FROM tracking WHERE Active=0 and id_user = " . $_SESSION["id"];

                    if ($stmt = mysqli_prepare($link, $sql)) {

                      /* Exécution de la requête */
                      mysqli_stmt_execute($stmt);

                      /* Association des variables de résultat */
                      mysqli_stmt_bind_result($stmt, $serial1, $url, $idu, $campagne, $document, $quantite);

                      /* Lecture des valeurs */
                      while (mysqli_stmt_fetch($stmt)) {
                  ?>
                        <hr />
                        <div class="row">
                          <div class="col-1">
                            <span class="h5"><?php echo " $idu " ?></span>
                          </div>
                          <div class="col-2">
                            <span class=""><?php echo " $campagne " ?></span>
                          </div>
                          <div class="col-2">
                            <span class=""><?php echo " $document " ?></span>
                          </div>
                          <div class="col-1">
                            <span class=""><?php echo " $quantite " ?></span>
                          </div>
                          <div class="col-2">
                            <span class=""><?php echo "<a href='/redirect.php?c=". $serial1 ."&l=".$url ."'> URL</a><br />"; ?></span>
                          </div>
                          <div class="col-1">
                            <span><font color="#e82083">##</font></span>
                          </div>
                          <a href='key.php?i=<?php echo "$idu";?>'>
                          <div class="col-1">
                              <i class="icon-Gear text-decoration-none" style="color:#0062cc; font-size: 1.5em;"></i>
                          </div></a>
                          <div class="col-2 text-right">
                            <a class="btn-sm btn-primary btn-warning  type--uppercase" href="#">
                              <span class="btn__text btn-warning text-decoration-none">Terminée</span>
                            </a>
                          </div>
                          </div>
                  <?php
                      }

                      /* Fermeture de la commande */
                      mysqli_stmt_close($stmt);
                    }
                    /* Fermeture de la connexion */
                    mysqli_close($link);

                  ?>


                                </div>
                            </div>
                        </div>
                        <!--end of row-->
                        <div class="row justify-content-end">
                            <div class="col-lg-2 text-right text-center-xs">

                            </div>
                    <!--end cart form-->
                </div>
                <!--end of container-->
            </section>

            <footer class="text-center space--sm footer-5  ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <span class="type--fine-print">&copy;
                                    <span class="update-year"></span> Indiana Studio®</span>
                                <a class="type--fine-print" href="#">Politique de confidentialité</a>
                                <a class="type--fine-print" href="#">Mentions Légales</a>
                            </div>
                        </div>
                    </div>
                    <!--end of row-->
                </div>
                <!--end of container-->
            </footer>
        </div>
        <!--<div class="loader"></div>-->
        <a class="back-to-top inner-link" href="#start" data-scroll-class="100vh:active">
            <i class="stack-interface stack-up-open-big"></i>
        </a>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/flickity.min.js"></script>
        <script src="js/easypiechart.min.js"></script>
        <script src="js/parallax.js"></script>
        <script src="js/typed.min.js"></script>
        <script src="js/datepicker.js"></script>
        <script src="js/isotope.min.js"></script>
        <script src="js/ytplayer.min.js"></script>
        <script src="js/lightbox.min.js"></script>
        <script src="js/granim.min.js"></script>
        <script src="js/jquery.steps.min.js"></script>
        <script src="js/countdown.min.js"></script>
        <script src="js/twitterfetcher.min.js"></script>
        <script src="js/spectragram.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
