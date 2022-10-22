<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>
<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php">Wyloguj</a>
</div>
<form action="<?php print(_APP_URL);?>/app/calc.php" method="post" style="margin: 30px;line-height: 2;">
	<label for="id_x">Podaj kwotę: </label>
	<input id="id_x" type="text" name="amount" value="<?php if (isset($amount)) print($amount); ?>" /><br />
	<label for="id_y">Podaj oprocentowanie: </label>
	<input id="id_y" type="text" name="interest" value="<?php if (isset($interest)) print($interest);; ?>" /><br />
	<label for="id_z">Podaj liczbę lat: </label>
	<input id="id_z" type="text" name="years" value="<?php if (isset($years)) print($years); ?>" /><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php if(!empty($sum)){ echo 'Suma kredytu: '.$sum; } ?><br/>
<?php echo 'Kwota raty miesięcznej: '.$result; ?>
</div>
<?php } ?>

</body>
</html>