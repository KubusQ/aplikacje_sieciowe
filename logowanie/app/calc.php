<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$amount = $_REQUEST ['amount'];
$interest = $_REQUEST ['interest'];
$years = $_REQUEST['years'];
// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($amount) && isset($interest) && isset($years))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $amount == "") {
	$messages [] = 'Nie podano kwoty kredytu';
}
if ( $interest == "") {
	$messages [] = 'Nie podano oprocentowania';
}
if ( $years == "") {
	$messages [] = 'Nie podano ilości lat';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $amount i $interest są liczbami całkowitymi
	if (! is_numeric( $amount )) {
		$messages [] = 'Kwota nie jest liczbą';
	}
	if (! is_numeric( $interest )) {
		$messages [] = 'Oprocentowanie nie jest liczbą';
	}	
	if (! is_numeric( $interest )) {
		$messages [] = 'Ilość lat nie jest liczbą';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$amount = floatval($amount);
	$interest = floatval($interest);
	$years = intval($years);
	if($role == 'admin'){
	$sum = $amount*($interest/100)+$amount;
}else{
	$messages [] = 'Tylko admin może zobaczyć kwotę kredytu';
}
	if ($role == 'user' || $role == 'admin'){
	$result = ($amount*(1+($interest/100)))/($years*12);
}else{
	$messages [] = 'Zaloguj się aby zobaczyć kwotę raty miesięcznej';
}
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$amount,$interest,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';