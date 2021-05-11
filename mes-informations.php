<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Veuillez saisir le nouveau mot de passe.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Un problème est survenu. Veuillez réessayer plus tard.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Mes informations</title>
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
                                <h1>Mes informations</h1>
                                <p class="lead">
                                    Mes paramètres.
                                </p>
                                <hr class="short">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

           <section class="text-left">
                 <div class="container">
                     <div class="row ">

                <div class="wrapper">
                    <p>Veuillez remplir ce formulaire pour réinitialiser votre mot de passe. </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirmez mot de passe</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn--primary type--uppercase" value="Envoyez">
                        </div>
                    </form>
                </div>
              </div>
            </div>
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
