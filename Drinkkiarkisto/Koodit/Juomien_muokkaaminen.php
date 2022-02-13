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
}	else	{
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

$sqlhaku = "SELECT * FROM juomat";
$tulokset = $yhteys->query($sqlhaku);
?>

<!--Reseptin haku HTML-->
<form action='Juomien_muokkaaminen.php' method='post'>
	<h2>Hae reseptejä</h2>
	<select name='juomat'>
	<option>Valitse juoma</option>
	<?php while ($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['nimi']?></option>
	<?php } ?>
	</select>
	<br><br>
	<input type='submit' name='nappi' value='Näytä juoman tiedot'/>
	<br>
	
<?php //Reseptin haku PHP
	if(isset($_POST['nappi']))	{
		if($_POST['juomat'] != 'Valitse juoma')	{
			$droppiid = $yhteys->real_escape_string($_POST['juomat']);	
			$sqlhaku = "SELECT * FROM juomat WHERE id = $droppiid";
			$tulokset = $yhteys->query($sqlhaku);
			while($rivi = $tulokset->fetch_assoc())	{
				echo '<br>';
				echo 'Nimi: ' . $rivi['nimi'] . "<br>";
				echo 'Juomalaji: ' . $rivi['juomalaji'] . "<br>";
				echo 'Ohje: ' . $rivi['ohje'] . "<br><br>";
				echo 'Ainesosat:' . '<br>';
					
				$sqlhaku = "SELECT ainesosat.ainesosa, maara FROM ainesosat, j_ainekset WHERE juomaID = $droppiid AND j_ainekset.ainesosa = ainesosat.id";
				$tulokset = $yhteys->query($sqlhaku);
				while($rivi = $tulokset->fetch_assoc())	{
					echo $rivi['ainesosa'] . " " . $rivi['maara'] . '<br>';
				}
			}
		}	else	{
			echo '<b>' . 'Valitse juoma' . '</b>';
		}
	}
?>
	<br><hr>
</form>

<!--Juomien muokkaaminen osuus alkaa tästä-->
<?php $sqlhaku = "SELECT * FROM juomat";
$tulokset = $yhteys->query($sqlhaku); ?>

<form action='Juomien_muokkaaminen.php' method='post'>
	<h2>Muokkaa reseptejä<h2>
	
	<!--Muokattavan juoman valitseminen-->
	<select name='reseptit'>
	<option>Valitse muokattava resepti</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['nimi']?></option>
	<?php	}	?>
	</select>
	<h3>Anna juoman uudet tiedot</h3>
	<input type='text' name='nimi' placeholder='Juoman nimi'/>
	<br>
	<input type='text' name='laji' placeholder='Juomalaji'/>
	<br>
	
	<!--Ainesosien haku alkaa tästä-->
	<?php
	$sqlhaku = "SELECT * FROM ainesosat";
	$tulokset = $yhteys->query($sqlhaku);
	?>
	
	<select name='ainekset1'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php	}	?>
	</select>
	<input type='text' name='maara1' placeholder='Määrä'/>
	<br>
	
	<?php $tulokset = $yhteys->query($sqlhaku); ?>
	
	<select name='ainekset2'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php	}	?>
	</select>
	<input type='text' name='maara2' placeholder='Määrä'/>
	<br>
	
	<?php $tulokset = $yhteys->query($sqlhaku); ?>
	
	<select name='ainekset3'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php	}	?>
	</select>
	<input type='text' name='maara3' placeholder='Määrä'/>
	<br>
	
	<h3>Ohje</h3>
	<textarea name='ohje' rows='6' cols='30'>
	</textarea>
	<input type='submit' name='nappi2' value='Muuta'/>
</form>

</body>
	
<?php //Reseptin muokkaus PHP
if(isset($_POST['nappi2']))	{
	$juomaid = $yhteys->real_escape_string($_POST['reseptit']);
	$nimi = $yhteys->real_escape_string($_POST['nimi']);
	$laji = $yhteys->real_escape_string($_POST['laji']);
	$ainekset1 = $yhteys->real_escape_string($_POST['ainekset1']);
	$maara1 = $yhteys->real_escape_string($_POST['maara1']);
	$ainekset2 = $yhteys->real_escape_string($_POST['ainekset2']);
	$maara2 = $yhteys->real_escape_string($_POST['maara2']);
	$ainekset3 = $yhteys->real_escape_string($_POST['ainekset3']);
	$maara3 = $yhteys->real_escape_string($_POST['maara3']);
	$ohje = $yhteys->real_escape_string($_POST['ohje']);
	
	//juomat taulun tiedot päivitetään
	$sqlmuutos = "UPDATE juomat 
	SET nimi = '$nimi', juomalaji = '$laji', ohje = '$ohje'
	WHERE id = '$juomaid'";
	$tulokset = $yhteys->query($sqlmuutos);
	if($tulokset === TRUE)	{
		
		//annetun juoman j_ainekset taulun tiedot poistetaan 
			$sql_poisto = "DELETE FROM j_ainekset
			WHERE juomaID = '$juomaid'";
			$tulokset = $yhteys->query($sql_poisto);
			if($tulokset === TRUE)	{
				
				//annetut j_ainekset taulun tiedot lisätään
				if(($maara1 != "") && ($maara2 != "") && ($maara3 != ""))	{
					$sql_lisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
					VALUES ('$juomaid', '$ainekset1', '$maara1'), 
					('$juomaid', '$ainekset2', '$maara2'),
					('$juomaid', $ainekset3, $maara3)";
					$tulokset = $yhteys->query($sql_lisays);
				
					if($tulokset === TRUE)	{
						echo '<b>' . 'Reseptin muokkaaminen onnistui!' . '</b>';
					}
				}
				//annetut j_ainekset taulun tiedot lisätään
				elseif(($maara1 != "") && ($maara2 != ""))	{
					$sql_lisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
					VALUES ('$juomaid', '$ainekset1', '$maara1'), 
					('$juomaid', '$ainekset2', '$maara2')";
					$tulokset = $yhteys->query($sql_lisays);
					
					if($tulokset === TRUE)	{
						echo '<b>' . 'Reseptin muokkaaminen onnistui!' . '</b>';
					}
				}
				//annetut j_ainekset taulun tiedot lisätään
				elseif($maara1 != "")	{
					$sql_poisto = "DELETE FROM j_ainekset
					WHERE juomaID = '$juomaid'";
					$tulokset = $yhteys->query($sql_poisto);
					
					//annetut j_ainekset taulun tiedot lisätään
					if($tulokset === TRUE)	{
					$sql_lisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
					VALUES ('$juomaid', '$ainekset1', '$maara1')";
					$tulokset = $yhteys->query($sql_lisays);
						
						if($tulokset === TRUE)	{
							echo '<b>' . 'Reseptin muokkaaminen onnistui!' . '</b>';
						}
					}
				}
			}
			else	{
				echo 'Deleten kanssa on ongelma';
			}
	}
	else	{
		echo 'Updaten kanssa on ongelma! :D';
	}
}
?>
		</div>
	</div>
</div>
</html>