<?php
// Initialise la session
session_start();

// Vérifier si l'utilisateur est déjà connecté, si oui alors le rediriger vers la page d'accueil
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: creez-un-tracking.php");
    exit;
}

// Inclure le fichier de configuration
require_once "config.php";

// Définit les variables et initialise avec des valeurs vides
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Traitement des données du formulaire lors de la soumission du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Vérifie si l'e-mail est vide
    if(empty(trim($_POST["email"]))){
        $email_err = "Veuillez saisir votre e-mail.";
    } else{
        $email = trim($_POST["email"]);
    }

  // Vérifie si le mot de passe est vide
    if(empty(trim($_POST["password"]))){
        $password_err = "S'il vous plait entrez votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Valider les identifiants
    if(empty($email_err) && empty($password_err)){
        // Préparer une instruction select
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Lier les variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Définir les paramètres
            $param_email = $email;

            // Tentative d'exécuter l'instruction préparée
            if(mysqli_stmt_execute($stmt)){
                // Stocker le résultat
                mysqli_stmt_store_result($stmt);

              // Vérifiez si l'e-mail existe, si oui, vérifiez le mot de passe
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Lier les variables de résultat
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Le mot de passe est correct, alors démarrez une nouvelle session
                            session_start();

                            // Stocker les données dans des variables de session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirige l'utilisateur vers la page d'accueil
                            header("location: index.php");
                            // Validate e-mail
                        } else{
                            // Le mot de passe n'est pas valide, affiche un message d'erreur générique
                            $login_err = "Email ou mot de passe invalide.";
                        }
                    }
                } else{
                    // l'email n'existe pas, affiche un message d'erreur générique
                    $login_err = "Email ou mot de passe invalide.";
                }
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
        <title>Trackez vos campagnes d'impressions connectées</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/stack-interface.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700" rel="stylesheet">

    </head>
    <body data-smooth-scroll-offset="77">
        <div class="nav-container"> </div>
        <div class="main-container">
            <section class="height-100 imagebg text-center" data-overlay="4">
                <div class="background-image-holder"><img alt="background" src="img/inner-6.jpg"></div>
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-lg-5 col-md-8">
                            <h2>Connectez-vous</h2>
                            <p class="lead">Trackez vos campagnes d'impressions connectées</p>
                            <?php
                            if(!empty($login_err)){
                                echo '<p>' . $login_err . '</p>';
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12"> <input placeholder="Email" type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                    <span class="invalid-feedback"><?php echo $email_err; ?></span> </div>
                                    <div class="col-md-12"> <input placeholder="Mot de passe" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span> </div>
                                    <div class="col-md-12"> <button class="btn btn--primary type--uppercase" type="submit" value="Login">Connectez-vous</button> </div>
                                </div>
                            </form> <span class="type--fine-print block">  Vous n'avez pas encore de compte ?&nbsp;<a href="inscription.php">Créer un compte</a></span> <span class="type--fine-print block">Votre mot de passe oublié ?&nbsp;<a href="#">Récupérer le compte</a></span> </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/parallax.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/scripts.js"></script>

    </body>

</html>
