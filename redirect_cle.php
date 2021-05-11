<?php
session_start();
require_once "config.php";
$cle=$_GET["c"];
$sql = "SELECT url FROM tracking WHERE serial1=" . "\"" . $cle . "\"";
if ($stmt = mysqli_prepare($link, $sql)) {
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$url);
mysqli_stmt_fetch($stmt);
echo "Redirection vers :" . $url;
header("location: " . $url);
exit;
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
