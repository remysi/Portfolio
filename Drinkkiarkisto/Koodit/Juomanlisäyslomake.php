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

$hakusql = 'SELECT * FROM ainesosat';
$tulokset = $yhteys->query($hakusql);
?>

<h2>Lisää juoma</h2>
<form action='Juomanlisäyslomake.php' method='post'>
	<input type='text' name='juomanimi' placeholder='Juomanimi'/>
	<br><br>
	<input type='text' name='juomalaji' placeholder='Juoman laji'/>
	<br><br>
	
	<select name='ainekset1'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php } ?>
	</select>
	<input type='text' name='maara1' placeholder='Anna määrä'/>
	<br><br>
	
	<?php $tulokset = $yhteys->query($hakusql); ?>
	
	<select name='ainekset2'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php } ?>
	</select>
	<input type='text' name='maara2' placeholder='Anna määrä'/>
	<br><br>
	
	<?php $tulokset = $yhteys->query($hakusql); ?>
	
	<select name='ainekset3'>
	<option>Valitse ainesosa</option>
	<?php while($rivi = $tulokset->fetch_assoc())	{	?>
	<option value='<?=$rivi['id']?>'><?=$rivi['ainesosa']?></option>
	<?php } ?>
	</select>
	<input type='text' name='maara3' placeholder='Anna määrä'/>
	<br><br>
	
	<h3>Ohje</h3>
	<textarea name='ohje' rows='6' cols='30'>
	</textarea>
	<br><br>
	
	<input type='submit' name='nappi' value='Lisää resepti'/>
</form>

</body>

<?php
if(isset($_POST['nappi']))	{	
	$juomanimi = $yhteys->real_escape_string($_POST['juomanimi']); 
	$juomalaji = $yhteys->real_escape_string($_POST['juomalaji']);
	$ainekset1 = $yhteys->real_escape_string($_POST['ainekset1']);
	$maara1 = $yhteys->real_escape_string($_POST['maara1']);
	$ainekset2 = $yhteys->real_escape_string($_POST['ainekset2']);
	$maara2 = $yhteys->real_escape_string($_POST['maara2']);
	$ainekset3 = $yhteys->real_escape_string($_POST['ainekset3']);
	$maara3 = $yhteys->real_escape_string($_POST['maara3']);
	$ohje = $yhteys->real_escape_string($_POST['ohje']);
	$lisatty = 0;
	
	//adminin reseptinlisäys
	if($_SESSION['muuttuja'] == 1)	{
		$admin_lisays = 1;
		$sqlLisays = "INSERT INTO juomat(nimi, juomalaji, ohje, lisatty)
		VALUES('$juomanimi', '$juomalaji', '$ohje', '$admin_lisays')";
		
		$tulokset = $yhteys->query($sqlLisays);	
		
		$last_id = $yhteys->insert_id;
		
		if(($maara1 != "") && ($maara2 != "") && ($maara3 != ""))	{
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1'),
			($last_id, $ainekset2, '$maara2'),
			($last_id, $ainekset3, '$maara3')";
		
			$tulokset = $yhteys->query($sqlLisays);
		}
		else if(($maara1 != "") && ($maara2 != ""))	{
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1'),
			($last_id, $ainekset2, '$maara2')";
			
			$tulokset = $yhteys->query($sqlLisays);
		}
		else if($maara1 != "")	{
			
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1')";
			
			$tulokset = $yhteys->query($sqlLisays);
		}
	}
	//tavallisen kayttajan reseptiehdotus
	else if($_SESSION['muuttuja'] == 0)	{
	$sqlLisays = "INSERT INTO juomat(nimi, juomalaji, ohje, lisatty)
		VALUES('$juomanimi', '$juomalaji', '$ohje', '$lisatty')";
		
		$tulokset = $yhteys->query($sqlLisays);	
		
		$last_id = $yhteys->insert_id;
		
		if(($maara1 != "") && ($maara2 != "") && ($maara3 != ""))	{
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1'),
			($last_id, $ainekset2, '$maara2'),
			($last_id, $ainekset3, '$maara3')";
		
			$tulokset = $yhteys->query($sqlLisays);
		}
		else if(($maara1 != "") && ($maara2 != ""))	{
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1'),
			($last_id, $ainekset2, '$maara2')";
			
			$tulokset = $yhteys->query($sqlLisays);
		}
		else if($maara1 != "")	{
			
			$sqlLisays = "INSERT INTO j_ainekset(juomaID, ainesosa, maara)
			VALUES($last_id, $ainekset1, '$maara1')";
			
			$tulokset = $yhteys->query($sqlLisays);
		}
	}
	else	{
	echo 'heck';	
	}
}
?>
		</div>
	</div>
</div>
</html>