<?php
session_start();
include_once ('yhteys.php');
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/css.css">
	<title>Kirjautumislomake</title>
</head>

<style>
</style>

<body>
<div class='ylapalkki'>
	<h1>Drinkkiarkisto</h1>
	<a href='rekisteröintilomake.php'>Rekisteröidy tästä</a>
</div>

<div class='tausta'>
	<div class='sisalto_tausta'>
		<div class='sisalto'>
			<h2>Kirjautumislomake</h2>
			<form action='kirjautumislomake.php' method='post'/>
				<input type='text' name='kayttis' placeholder='Käyttäjänimi'/>
				<br>
				<input type='password' name='salis' placeholder='Salasana'/>
				<br><br>
				<input type='submit' name='nappi' value='Kirjaudu'/>
			</form>
</body>

<?php
if(isset($_POST['nappi']))	{
	$kayttis = $yhteys->real_escape_string(strip_tags($_POST['kayttis']));
	$salasana = $yhteys->real_escape_string($_POST['salis']);
	
	if(($kayttis != "") && ($salasana != "")) {
		
		$sqlhaku = "SELECT * FROM kayttajat
		WHERE tunnus = '$kayttis' AND salasana = '$salasana'";
		$tulokset = $yhteys->query($sqlhaku);
			
		if($tulokset->num_rows > 0)	{
			echo 'Kirjaudutaan sisään';
			$fetch = $tulokset->fetch_assoc();
			$_SESSION['muuttuja'] = $fetch['admin']; 
			if($fetch['admin'] == 0)	{
			header('Location: reseptihaku.php');
			}	
			else if($fetch['admin'] == 1)	{
			header('Location: reseptiehdotukset.php');
			}
			else	{
			header('Location: kirjautumislomake.php');
			} 
		}		
		else {
			echo 'Meni väärin.';
		}
	} else {
		echo "Täytä molemmat kentät.";
	}
}
?>
		</div>
	</div>
</div>
</html>