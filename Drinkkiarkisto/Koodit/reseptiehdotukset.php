<?php
session_start();

//kirjautumisen tarkastus
if(isset($_SESSION['muuttuja']))	{ 
	if($_SESSION['muuttuja'] == 1) {
		include_once ('yhteys.php');
		include 'navi_admin.html';
	}	 
	else	{
		header('Location: kirjautumislomake.php');
		session_unset();
		session_destroy('Kirjautuminen vaaditaan');
	}
}
else	{
	header('Location: kirjautumislomake.php');
	session_unset();
	session_destroy('Kirjautuminen vaaditaan');
}

//kirjautuminen ulos
if(isset($_POST['logout']))	{
header("Location: kirjautumislomake.php");
session_unset();
session_destroy();
echo 'Kirjauduit ulos';
} 

$sqlhaku = "SELECT * FROM juomat WHERE lisatty = 0";
$tulokset = $yhteys->query($sqlhaku);
?>

<h2>Reseptiehdotukset</h2>
<form action='reseptiehdotukset.php' method='post'>

<?php  
	while($rivi = $tulokset->fetch_assoc())	{
		echo 'Nimi: ' . $rivi['nimi']
		. '<br><br>' 
		. ' Juomalaji: ' . $rivi['juomalaji'] 
		. '<br><br>' 
		. ' Ohje: ' . $rivi['ohje'] 
		. '<br><br>';
		?>
		<button type='submit' name='acc' value="<?=$rivi['id']?>">Hyväksy
		</button>
		<button type='submit' name='del' value="<?=$rivi['id']?>">Hylkää
		</button>
		<hr>
<?php } ?>
</form>
</body>

<?php
//reseptien hyvaksyminen
if(isset($_POST['acc']))	{
	$nappulaid = $_POST['acc'];
	$sqlmuutos = "UPDATE juomat 
	SET lisatty = 1
	WHERE id = $nappulaid";
	$tulokset = $yhteys->query($sqlmuutos);
	if($tulokset === TRUE)	{
		echo 'Juoma hyväksytty';
	}
}
//reseptien hylkaaminen
elseif(isset($_POST['del']))	{
	$nappulaid = $_POST['del'];
	$sqldeletus = "DELETE FROM juomat
	WHERE id = $nappulaid";
	$tulokset = $yhteys->query($sqldeletus);
	if($tulokset === TRUE)	{
		echo 'Juoma hylätty';
	}
}
?>
		</div>
	</div>
</div>
</html>