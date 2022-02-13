<?php
session_start();

//kirjautumisen tarkastus
if(isset($_SESSION['muuttuja']))	{ 
	if($_SESSION['muuttuja'] == 1) {
		include_once ('yhteys.php');
		include 'navi_admin.html';
	}	
	else if($_SESSION['muuttuja'] == 0) {
		include_once ('yhteys.php');
		include 'navi_user.html';
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
?>

<h2>Hae reseptiä nimen, tai aineksen mukaan.</h2>
<form action='reseptihaku.php' method='post'>
	<input type='text' name='hakuboxi'/>
	<br><br>
	<input type='radio' name="valinta" value='nimi' checked />
	Nimi
	<br><br>
	<input type='radio' name="valinta" value='aines'/>
	Aines
	<br><br>
	<input type='submit' name='nappi' value='Hae'/>
	<br><br>
</form>	
</body>

<?php

//reseptin hakeminen
if(isset($_POST['nappi']))	{
	$hakuboxi = $yhteys->real_escape_string($_POST['hakuboxi']);
		
	//nimella haku
	if($_POST['valinta'] == 'nimi')	{
		
		$sqlhaku = "SELECT * FROM juomat WHERE nimi LIKE '$hakuboxi%' ORDER BY juomat.nimi";
		$tulokset = $yhteys->query($sqlhaku);
			
		while($rivi = $tulokset->fetch_assoc())	{
			echo '<b>' . 'Juoman nimi: ' . '</b>' . $rivi['nimi'] . "<br>";
			echo '<b>' . 'Juomalaji: ' . '</b>' . $rivi['juomalaji'] . "<br>";
			echo '<b>' . 'Ohje: ' . '</b>'  . $rivi['ohje'] . "<br><br>";
			$muuttuja = $rivi['id'];
			
			$sqlhaku = "SELECT ainesosat.ainesosa, maara 
			FROM j_ainekset, ainesosat 
			WHERE juomaID = $muuttuja 
			AND j_ainekset.ainesosa = ainesosat.id";
				
			$tulokset2 = $yhteys->query($sqlhaku);
			while($rivi = $tulokset2->fetch_assoc())	{
				echo '<b>' . 'Ainesosat: ' . '</b>' . $rivi['ainesosa'] . '.' 
				. '<b>' . ' Määrä: ' . '</b>' . $rivi['maara'] . '<br>';
			}
			echo "<hr>";
		}
	//ainesosalla haku
	}	else	{
		$sqlhaku = "select distinct juomat.id, juomat.nimi, juomat.kuvaus, juomat.juomalaji, juomat.ohje 
		from ainesosat, j_ainekset, juomat
		where ainesosat.ainesosa like '$hakuboxi%' 
		and j_ainekset.ainesosa = ainesosat.id 
		and j_ainekset.juomaID = juomat.id ORDER BY juomat.nimi";
		$tulokset = $yhteys->query($sqlhaku);
		
		while($rivi = $tulokset->fetch_assoc())	{
			echo '<b>' . 'Juoman nimi: ' . '</b>' . $rivi['nimi'] . "<br>";
			echo '<b>' . 'Juomalaji: ' . '</b>' . $rivi['juomalaji'] . "<br>";
			echo '<b>' . 'Ohje: ' . '</b>'  . $rivi['ohje'] . "<br><br>";
			$muuttuja = $rivi['id'];
			
			$sqlhaku = "SELECT ainesosat.ainesosa, maara 
			FROM j_ainekset, ainesosat 
			WHERE juomaID = $muuttuja 
			AND j_ainekset.ainesosa = ainesosat.id";
			
			$tulokset2 = $yhteys->query($sqlhaku);
			while($rivi = $tulokset2->fetch_assoc())	{
				echo '<b>' . 'Ainesosat: ' . '</b>' . $rivi['ainesosa'] . '.' 
				. '<b>' . ' Määrä: ' . '</b>' . $rivi['maara'] . '<br>';
			}
			echo "<hr>";
		}
	}
}
?>
		</div>
	</div>
</div>
</html>