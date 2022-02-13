<?php
session_start();

//kirjautumisen tarkastus
if(isset($_SESSION['muuttuja']))	{ 
	if($_SESSION['muuttuja'] == 1) {
		include_once ('yhteys.php');
		include 'navi_admin.html';
	}	else	{
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

?>

<h2>Lisää aineksia</h2>
<form action='Aines.php' method='post'>
	<input type='text' name='a_nimi' placeholder='Aineksen nimi'/>
	<br><br>
	<input type='submit' name='nappula' value='Lisää'/>
</form>
</body>

<?php
//Aineksen lisäys
if(isset($_POST['nappula']))	{
	$nimi = $yhteys->real_escape_string($_POST['a_nimi']);
	
	if($nimi != "")	{
		$sqlhaku = "SELECT * FROM ainesosat WHERE ainesosa = '$nimi'";
		$tulokset = $yhteys->query($sqlhaku);
		
		if($tulokset->num_rows > 0)	{
			echo '<b>' . 'Ainesosa on jo lisätty' . '</b>';
		} else {
			$sqlinsert = "INSERT INTO ainesosat(ainesosa)
			VALUES ('$nimi')";
			
			$lisays = $yhteys->query($sqlinsert);
			if ($lisays === TRUE)	{
				echo '<b>' . 'Ainesosa lisätty.' . '</b>';
			}	else	{
				echo '<b>' . 'Ei onnistunut.' . '</b>'; 
			}
		}
	} else {
	echo '<b>' . 'Syötä aineksen nimi' . '</b>';
	}
}
//Aineksien listaus
echo '<br><br>' . '<h2>Ainesosat</h2>';
$sqlhaku = "SELECT * FROM ainesosat ORDER BY ainesosa";
$tulokset = $yhteys->query($sqlhaku);
while($rivi = $tulokset->fetch_assoc())	{
	echo $rivi['ainesosa'] . '<br>';
}
?>
		</div>
	</div>
</div>
</html>