<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec tous les champs.
	2- Le champ photo devra afficher la photo du contact en 80px de large.

*/

$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 
			   'root', 
			   '',     
			   array(
			       PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
			       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
			   )); 


function debug($param) {
	echo '<pre>';
		var_dump($param);
	echo '</pre>';
}

$resultat = $pdo->query("SELECT prenom, nom, telephone, email, photo FROM contact");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Répertoire</title>
	<style>
		.photo {
			width: 80px;
		}
		table {
			border-collapse: collapse;
		}
		table, th, tr, td {
			border: 1px solid;
		}
	</style>
</head>
<body>
	<h1>Répertoire</h1>

	<table>
		<tr>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Téléphone</th>
			<th>Email</th>
			<th>Photo</th>
		</tr>

		<?php
		while ($contact = $resultat->fetch(PDO::FETCH_ASSOC)) {
				echo '<tr>';
				foreach ($contact as $indice => $value) {
					
					//debug($value);

					if ($indice == 'photo') {
						echo '<td><img src="'. $value .'" alt="'. $contact['nom'] .'" class="photo"></td>';
					} else {
						echo '<td>' . $value . '</td>';
					}
				}
				echo '</tr>';
		}


		?>
	</table>
</body>
</html>