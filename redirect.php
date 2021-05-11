<?php
	// Include config file
	require_once "config.php";
	
	if(isset($_GET["c"])){
		$sql = "SELECT url FROM tracking WHERE serial1 = '" . $_GET["c"] . "' LIMIT 1";
		
		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $url);
			while (mysqli_stmt_fetch($stmt)) {
				header("location: ". $url);
				exit;
			}
			/* Fermeture de la commande */
			mysqli_stmt_close($stmt);
		}
		/* Fermeture de la connexion */
		mysqli_close($link);
	}
?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZK6TCE8FGH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZK6TCE8FGH');
</script>
