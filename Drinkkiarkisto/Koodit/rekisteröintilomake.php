<?php
include_once ('yhteys.php');
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/css.css">
	<title>Rekisteröintilomake</title>
</head>

<style>
</style>

<body>
<div class='ylapalkki'>
	<h1>Drinkkiarkisto</h1>
	<a href='kirjautumislomake.php'>Kirjaudu</a> 
</div>

<div class='tausta'>
	<div class='sisalto_tausta'>
		<div class='sisalto'>
			<form action='rekisteröintilomake.php' method='post'>
				<h3>Käyttäjätunnus</h3>
				<input type='text' name='kayttajatunnus'/>
				<br>
				<h3>Salasana</h3>
				<input type='password' name='salasana'/>
				<br>
				<h3>Sähköposti</h3>
				<input type='text' name='sahkoposti'/>
				<br><br>
				<input type='submit' name='nappi' value='Rekisteröidy'/>
			</form>
</body>

<?php
if(isset($_POST['nappi']))	{
	
	$kayttis = $yhteys->real_escape_string($_POST['kayttajatunnus']);
	$salis = $yhteys->real_escape_string($_POST['salasana']);
	$sahkoposti = $yhteys->real_escape_string($_POST['sahkoposti']);
	
	if(($kayttis != "") && ($salis != "") && ($sahkoposti != ""))	{
		
		$hakusql = "SELECT * FROM kayttajat WHERE tunnus = '$kayttis'";
		$tulokset = $yhteys->query($hakusql);
		
			if($tulokset->num_rows > 0)	{
				echo 'Käyttäjätunnus on jo käytössä';
			}	else	{
					$sql_lisays = "INSERT INTO kayttajat
					(tunnus, salasana, sahkoposti, admin)
					VALUES ('$kayttis', '$salis', '$sahkoposti', 0)";
					$tulokset = $yhteys->query($sql_lisays);	
					if ($tulokset === TRUE)	{
						echo 'Tiedot lisätty.';
					}	else	{
						echo 'Ei onnistunut.';	
					}
				}
	} else { 
	echo 'Täytä kaikki kentät'; 
	}
}
?>
		</div>
	</div>
</div>
</html>