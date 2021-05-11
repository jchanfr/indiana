<?php

//phpinfo();

require_once 'vendor/autoload.php';
//
$analytics = initializeAnalytics(); // Initialisera l'API
$profile = getFirstProfileId($analytics); // Récupère le profil Google Analytics


// Fonction d'initialisation et d'authentification
function initializeAnalytics()
{
	// Précise où trouver la clé du compte de service
	$KEY_FILE_LOCATION = 'indiana-26-11bce386f3a1.json';

	// Crée et configure le client
	$client = new Google_Client();
	$client->setApplicationName("indianaprint.fr");
	$client->setAuthConfig($KEY_FILE_LOCATION);
	$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
	$analytics = new Google_Service_Analytics($client);
	return $analytics;
}

// Récupère le profil Google Analytics
function getFirstProfileId($analytics) {
  // Récupère la liste des comptes
  $accounts = $analytics->management_accounts->listManagementAccounts();
	// trace
	$count = count($accounts->getItems());
	echo "count : $count";

	if (count($accounts->getItems()) > 0) {
    $items = $accounts->getItems();
    $firstAccountId = $items[0]->getId();

    // Récupère la liste des propriétés
    $properties = $analytics->management_webproperties
        ->listManagementWebproperties($firstAccountId);


    if (count($properties->getItems()) > 0) {
      $items = $properties->getItems();
      $firstPropertyId = $items[0]->getId();

      // Récupère la liste des vues
      $profiles = $analytics->management_profiles
          ->listManagementProfiles($firstAccountId, $firstPropertyId);

      if (count($profiles->getItems()) > 0) {
        $items = $profiles->getItems();

        // Retourne l'ID de la première vue
        return $items[0]->getId();

      } else {
        throw new Exception('No views (profiles) found for this user.');
      }
    } else {
      throw new Exception('No properties found for this user.');
    }
  } else {
    throw new Exception('No accounts found for this user.');
  }
}

function getResults($analytics, $profileId, $metric) {
   return $analytics->data_ga->get(
	'ga:' . $profileId, // Précise le profil Google Analytics à utiliser
	'30daysAgo', // Précise la date de début
	'today', // Précise la date de fin
	'ga:'.$metric // Précise le métrique utilisé (session, users...)
   );
}

function printResults($results) {
    if (count($results->getRows()) > 0) {
    	$rows = $results->getRows();
	$valeur = $rows[0][0];
	return $valeur;
  } else {
	return "Pas de résultat.\n";
  }
}

$results = getResults($analytics, $profile, 'users'); // Récupère le nombre d'utilisateurs des 30 derniers jours
echo printResults($results); // Affiche l'information
?>

<div id="visites" style="height: 400px; padding:0;">
</div>

<?php
// Cette ligne fait appel à la fonction ci-dessous et demande à récupérer les pages vues, les utilisateurs et les sessions
$results = getChartResults($analytics, $profile, 'ga:pageviews,ga:users,ga:sessions');

// Fonction qui récupère les informations nécessaires pour le graphique
function getChartResults($analytics, $profileId, $metric) {
	return $analytics->data_ga->get(
		'ga:' . $profileId,
		'30daysAgo',
		'today',
		$metric,
		array(
			'dimensions'=>'ga:Date'
		)
	);
}

// Cette fonction crée le tableau (json) qui pourra être lu par le javascript
function buildChartArray($results){
	if (count($results->getRows()) > 0) {
		$rows = $results->getRows(); // On compte les lignes
		$array=[["Date","Pages Vues","Visiteurs","Visites"]]; // Initialisation du tableau avec les nomn des "colonnes"
		foreach($rows as $date){ // Parcours des dates
			$datejour = substr($date[0],-2,2)."/".substr($date[0],-4,2)."/".substr($date[0],0,4); // On formatte la date (pour être joli à l'affichage)
			array_push($array,[$datejour,(int)$date[1],(int)$date[2],(int)$date[3]]); // On ajoute la date et les données du jour au tableau
		}
		$js_array=json_encode($array); // On encode le tout en json
		return $js_array; // On le retourne
	} else {
		return "Pas de résultat.\n";
	}
}
?>

// Chargement de Google Charts
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		// Sur la ligne ci-dessous, nous faisons un echo en php (code court) du json retourné par la fonction php buildChartArray
		let data = google.visualization.arrayToDataTable(<?= buildChartArray($results); ?>);
		// Ci-dessous les options du graphique
		let options = {
			curveType: 'function',
			series: {
				0: {targetAxisIndex:0},
				1:{targetAxisIndex:1},
				2:{targetAxisIndex:1}
			},
			hAxis : {
				textStyle : {
					fontSize: 10, // or the number you want
					fontName: 'Nunito'
				}
			},
			vAxes: {
				0: {
					gridlines: {color: 'transparent'},
					textStyle : {
						fontSize: 10, // or the number you want
						fontName: 'Nunito'
					}
				},
				1: {
					gridlines: {color: 'transparent'},
					textStyle : {
						fontSize: 10, // or the number you want
						fontName: 'Nunito'
					}
				},
			},
			legend: {
				position: 'bottom',
				textStyle : {
					fontSize: 10, // or the number you want
					fontName: 'Nunito'
				}
			}
		};
		// Nous précisons où le graphique doit être "injecté"
		let chart = new google.visualization.LineChart(document.getElementById('visites'));
		// Nous dessinons le graphique
		chart.draw(data, options);
	}
</script>
