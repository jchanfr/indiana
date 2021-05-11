<?php

$mail="";
$er_mail="";
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$valid = true;
	$mail = $_POST["mail"];
	$mail = trim($mail);
	if (empty($mail)) {
$valid = false;
$er_mail = "Il faut mettre un mail";
}

if ($valid){
$sql = "SELECT email, demande_mdp FROM users WHERE email = " . $mail;
$result = $link->query($sql);
if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if ($row['demande_mdp'] == 0){
				$new_pass = rand();
				$new_pass_crypt = password_hash($new_pass, PASSWORD_DEFAULT);
				$objet = 'Nouveau mot de passe';
				$to = $row['email'];
				$header = "From: INDIANAPRINT <no-reply@test.com> \n";
				$header .= "Reply-To: ".$to."\n";
				$header .= "MIME-version: 1.0\n";
				$header .= "Content-type: text/html; charset=utf-8\n";
				$header .= "Content-Transfer-Encoding: 8bit";
				$contenu = "<html>";
				$contenu .="<body>";
				$contenu .="<p style='text-align: center; font-size: 18px'><b>Bonjour. Votre email est : ".$to."</b>,</p><br/>";
				$contenu .="<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_pass."</p><br/>";
				$contenu .="</body>";
				$contenu .="</html>";
				mail($to, $objet, $contenu, $header);
				$email = $row['email'];
				$sql = "UPDATE users SET password = $new_pass_crypt, demande_mdp = 1 WHERE email = " . $email;
				if ($link->query($sql) === TRUE) {
						echo "Record updated successfully";
					} else {
						echo "Error updating record: " . $link->error;
					};
};
};
header('Location: index.php');
exit;
}; // valid
}; // serveur POST

 ?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Mot de passe oublié</title>
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
                <div class="background-image-holder"><img alt="background" src="img/inner-6.jpg"></div>
                <div class="container pos-vertical-center">
                    <div class="row">
                        <div class="col-lg-5 col-md-8">
                            <h2>Mot de passe oublié</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12"> <input placeholder="Email" type="text" name="mail" class="form-control <?php echo (!empty($er_mail)) ? 'is-invalid' : ''; ?>" value="<?php echo $mail; ?>">
                                    <span class="invalid-feedback"><?php echo $er_mail; ?></span></div>
                                    <div class="col-md-12"> <button class="btn btn--primary type--uppercase" type="submit" name="oublie" value="oublie">Envoyer</button></div>
                                </div>

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
