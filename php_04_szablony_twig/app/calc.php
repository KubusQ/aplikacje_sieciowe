<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

//załaduj Twig
require_once _ROOT_PATH.'/lib/Twig/Autoloader.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$x = isset($_REQUEST['x']) ? $_REQUEST['x'] : '';
$y = isset($_REQUEST['y']) ? $_REQUEST['y'] : '';
$z = isset($_REQUEST['z']) ? $_REQUEST['z'] : '';
// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($x) && isset($y) && isset($z))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $x == "") {
	$messages [] = 'Nie podano kwoty kredytu';
}
if ( $y == "") {
	$messages [] = 'Nie podano oprocentowania';
}
if ( $z == "") {
	$messages [] = 'Nie podano ilości lat';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $x )) {
		$messages [] = 'Kwota nie jest liczbą';
	}
	if (! is_numeric( $y )) {
		$messages [] = 'Oprocentowanie nie jest liczbą';
	}	
	if (! is_numeric( $y )) {
		$messages [] = 'Ilość lat nie jest liczbą';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$x = floatval($x);
	$y = floatval($y);
	$z = intval($z);

	$sum = $x*($y/100)+$x;

	$result = ($x*(1+($y/100)))/($z*12);

}

// 4. Przygotowanie szablonu i zmiennych

//start Twig
Twig_Autoloader::register();
//załaduj szablony (wskazanie folderów z potrzebnymi szablonami)
$loader = new Twig_Loader_Filesystem(_ROOT_PATH.'/templates'); //szablon ogólny
$loader->addPath(_ROOT_PATH.'/app'); //szablon strony kalkulatora
//skonfiguruj folder cache
$twig = new Twig_Environment($loader, array(
    'cache' => _ROOT_PATH.'/twig_cache',
));

//przygotowanie zmiennych dla szablonu
$variables = array(
	'app_url' => _APP_URL,
	'root_path' => _ROOT_PATH,
	'page_title' => 'Przykład 04',
	'page_description' => 'Profesjonalne szablonowanie oparte na bibliotece Twig',
);
if (isset($x)) $variables ['x'] =  $x;
if (isset($y)) $variables ['y'] = $y;
if (isset($y)) $variables ['z'] = $z;
if (isset($result)) $variables ['result'] = $result;
if (isset($sum)) $variables ['sum'] = $sum;
if (isset($messages)) $variables ['messages'] = $messages;

// 5. Wywołanie szablonu (wygenerowanie widoku)
echo $twig->render('calc.html', $variables);