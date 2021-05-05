<?php
// Initialise la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<?php
/* Tentative de connexion au serveur MySQL. En supposant que vous exécutez MySQL
serveur avec paramètre par défaut (utilisateur 'root' sans mot de passe) */
$campagne = '';
$err_campagne = '';
$document = '';
$err_document = '';
$quantite = '';
$err_quantite = '';
$action_url = '';
$err_action_url = '';
$serial1 = '';
$err_serial1 = '';
$url = '';
$err_url = '';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
if (1==0)
$link = mysqli_connect("indianapbpmetric.mysql.db", "indianapbpmetric", "Indiana01", "indianapbpmetric");
else {
  $link = mysqli_connect("localhost", "root", "", "indiana");
  // code...
}
// Check connection
if($link === false){
    die("ERREUR: impossible de se connecter. " . mysqli_connect_error());
}

// Escape les entrées utilisateur pour la sécurité
if (empty($_POST['campagne'])) {
   $err_campagne = "Champ obligatoire";
  }
else {
   $campagne = mysqli_real_escape_string($link, $_POST['campagne']);
 };
 if (empty($_POST['url'])) {
    $err_url = "Champ obligatoire";
  }
 else {
    $url = $_POST['url'];
  };


 if (empty($_POST['document'])) {
    $err_document = "Champ obligatoire";
   }
 else {
   $document = mysqli_real_escape_string($link, $_POST['document']);
  };
if (empty($_POST['quantite'])) {
  $err_quantite = "Champ obligatoire";
  }
else {
    if (!is_numeric($_POST['quantite'])) {
    $err_quantite = "Merci de saisir un nombre.";
    }
    else {
    $quantite = mysqli_real_escape_string($link, $_POST['quantite']);
    }
 };

 if (empty($_POST['action_url'])) {
   $err_action_url = "Champ obligatoire";
   }
 else {
   $action_url = mysqli_real_escape_string($link, $_POST['action_url']);
  };
  if (empty($_POST['serial1'])) {
    $err_serial1 = "Champ obligatoire";
    }
  else {
    $serial1 = mysqli_real_escape_string($link, $_POST['serial1']);
   };


// Tentative d'exécution de la requête d'insertion
if (empty($err_campagne) && empty($err_document) && empty($err_quantite) && empty($err_action_url) && empty($err_serial1) && empty($err_url))
{
$id_user = $_SESSION["id"];
$sql = "INSERT INTO tracking (campagne, document, quantite, action_url, serial1,id_user,url) VALUES ('$campagne', '$document', '$quantite', '$action_url', '$serial1','$id_user','$url')";
if(mysqli_query($link, $sql)){
  header('Location: campagne_generee.php');
  exit();
    } else {
    echo "ERREUR: impossible d'exécuter $sql. " . mysqli_error($link);
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
        <title>Créer votre tracking digital métrics</title>
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
                            <h2>Créer votre tracking</h2>
                            <p class="lead">Information sur votre future campagne</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row">

                                  <div class="col-md-12">  <input placeholder="Nom de la campagne" type="text" name="campagne" class="form-control <?php echo (empty($campagne)) ? 'is-invalid' : ''; ?>" value="<?php echo $campagne; ?>">
                                    <span class="invalid-feedback"><?php echo $err_campagne ?></span> </div>

                                    <div class="col-md-12">  <input placeholder="Type de document" type="text" name="document" class="form-control <?php echo (empty($document)) ? 'is-invalid' : ''; ?>" value="<?php echo $document; ?>">
                                    <span class="invalid-feedback"><?php echo $err_document ?></span> </div>

                                    <div class="col-md-12">  <input placeholder="quantité" type="text" name="quantite" class="form-control <?php echo (empty($quantite)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantite; ?>">
                                    <span class="invalid-feedback"><?php echo $err_quantite ?></span> </div>

                                    <div class="col-md-12">  <input placeholder="Type d'action" type="text" name="action_url" class="form-control <?php echo (empty($action_url)) ? 'is-invalid' : ''; ?>" value="<?php echo $action_url; ?>">
                                    <span class="invalid-feedback"><?php echo $err_action_url ?></span> </div>

                                    <div class="col-md-12">  <input placeholder="URL de votre site" type="text" name="url" class="form-control <?php echo (empty($url)) ? 'is-invalid' : ''; ?>" value="<?php echo $url; ?>">
                                    <span class="invalid-feedback"><?php echo $err_url ?></span> </div>

                                    <div class="col-md-12">  <input placeholder="Votre clé de tracking" aria-label="Recipient's serial1" aria-describedby="button-addon2" id="input1" type="text" name="serial1" class="form-control <?php echo (!empty($serial1)) ? 'is-invalid' : ''; ?>" value="<?php echo $serial1; ?>">
                                    <span class="invalid-feedback"><?php echo $err_serial1 ?></span> </div>

                                    <div class="col-md-4"><button class="btn btn--primary type--uppercase" onclick="generate()" type="button" id="button-addon2">&nbsp;&nbsp;&nbsp;Générez &nbsp;&nbsp;&nbsp;</button></div>

                                    <div class="col-md-12"> <button class="btn btn--primary type--uppercase" type="submit">Générez votre campagne</button></div>
                                    <div class="col-md-12"> <a href="dashboard.php">Passez cette étape et consultez le Dashboard >> </a></div>
                                </div>
                            </form>
                    </div>
                </div>
            </section>

        </div>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/parallax.js"></script>
        <script src="js/granim.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/keygenerator.js"></script>

    </body>

</html>
