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
        <title>Informations</title>
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
                    <a class="btn block type--uppercase" href="#">
                        <span class="btn__text">Nouvelle campagne</span>
                    </a>
                    <a class="btn block btn--primary type--uppercase" href="#">
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
                                <h1>Informations sur votre campagne</h1>
                                <p class="lead">
                                    Votre clé URL à copier dans vos documents connectés.
                                </p>
                                <hr class="short">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            $id = $_GET["i"];
            if (isset($_POST['submit'])) // ds le POST
            {
                if (isset($_POST['active']))
                {
                  $sql = "update tracking set Active=1 WHERE id=" . $id;
                }
                else
                {
                $sql = "update tracking set Active=0 WHERE id=" . $id;
                }
                if ($link->query($sql) === TRUE) {} else {
                  echo "Error updating record: " . $link->error;
                }
            }


              $sql = "SELECT serial1, url, id, campagne, document, quantite,Active FROM tracking WHERE id = " . $id;


              if ($stmt = mysqli_prepare($link, $sql)) {

                /* Exécution de la requête */
                mysqli_stmt_execute($stmt);

                /* Association des variables de résultat */
                mysqli_stmt_bind_result($stmt, $serial1, $url, $idu, $campagne, $document, $quantite,$Active);

                /* Lecture des valeurs */
                while (mysqli_stmt_fetch($stmt)) {
            ?>

            <div class="main-container">
             <section class="text-left">
                 <div class="container ">
                     <div class="row ">
                         <div class="col-md-10">
                          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?i=" . $id; ?>" method="post">
                          <div class="input-checkbox input-checkbox--switch">
                        	<input id="checkbox-switch" type="checkbox" name="active" <?php if ($Active == 1) echo "checked" ?>>
                        	<label for="checkbox-switch"></label>
                          </div>
                          <span>Campagne Inactive/Active</span>

                          <input class="form-control" type="text" value="ID: <?php echo " $idu " ?>" placeholder="Disabled input" aria-label="Disabled input example" disabled><br />
                          <input class="form-control" type="text" value="Nom de la campagne: <?php echo " $campagne " ?>" placeholder="Disabled input" aria-label="Disabled input example" disabled><br />
                          <input class="form-control" type="text" value="Type de document: <?php echo " $document " ?>" placeholder="Disabled input" aria-label="Disabled input example" disabled><br />
                          <input class="form-control" type="text" value="Nombre de Flyer: <?php echo " $quantite " ?>" placeholder="Disabled input" aria-label="Disabled input example" disabled><br />
                            <input class="form-control" type="text" value="Type d'action: <?php echo " $url" ?>" placeholder="Disabled input" aria-label="Disabled input example" disabled><br />
                          <!-- COPIE URL-->
                          <input type="text" value="https://marketing-metrics.indianaprint.fr/<?php echo "$serial1" ?>" id="myInput"><br/><br/>
                          <a class="btn block btn--primary type--uppercase" onclick="myFunction()">
                              <span class="btn__text">Copiez l'url</span>
                          </a>
                         </div>
                         <div class="col-md-10"> <button class="btn btn--primary type--uppercase" name="submit" type="submit">Enregistrez les modifications</button></div>
                         </form>
                     </div>
                 </div>
             </section>
            </div>

            <?php
                }

                /* Fermeture de la commande */
                mysqli_stmt_close($stmt);
              }
              /* Fermeture de la connexion */
              mysqli_close($link);

            ?>


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

        /* script de copie de l'url */
        <script>
              function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("Copiez");

        /* Alert the copied text */
        alert("Enregistrez cette URL dans votre puce NFC: " + copyText.value);
        }
        </script>

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
