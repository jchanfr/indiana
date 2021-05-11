<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Veuillez saisir un e-mail.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Cet e-mail est déjà pris.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Un problème est survenu. Veuillez réessayer plus tard.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
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
        <title>Inscription</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/stack-interface.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700" rel="stylesheet">
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZK6TCE8FGH"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'G-ZK6TCE8FGH');
        </script>
    </head>
    <body data-smooth-scroll-offset="77">
        <div class="nav-container"> </div>
        <div class="main-container">
            <section class="height-100 imagebg text-center" data-overlay="4">
                <div class="background-image-holder"><img alt="background" src="img/inner-5.jpg"></div>
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-lg-5 col-md-8">
                            <h2>Inscription</h2>
                            <p class="lead">Remplissez vos informations !</p>

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12">  <input placeholder="Email" type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                      <span class="invalid-feedback"><?php echo $email_err; ?></span> </div>
                                    <div class="col-md-12"> <input placeholder="Mot de passe" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span> </div>
                                    <div class="col-md-12"> <input placeholder="Confirmez le mot de passe" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span> </div>
                                    <div class="col-md-12">
                                        <div class="input-checkbox input-checkbox--switch">
                                            <input type="checkbox" name="public-profile" />
                                            <label></label>
                                        </div>
                                        <span>Validez les conditions d'utilisations</span>
                                    </div>
                                  <div class="col-md-12"><button class="btn btn--primary type--uppercase" value="Submit"  type="submit"> Validez l'inscription </button></div>
                                </div>
                            </form>
                            <br/>
                            <a href="index.php"><span class="type--fine-print block">Retournez sur la page de connexion</span></a>

                    </div>
                </div>
            </section>


        </div>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/parallax.js"></script>
        <script src="js/granim.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/scripts.js"></script>

    </body>

</html>
