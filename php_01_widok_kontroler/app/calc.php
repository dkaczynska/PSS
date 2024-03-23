<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kwota = $_REQUEST ['kwota'];
$okres = $_REQUEST ['okres'];
$procent = $_REQUEST ['procent'];


// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kwota) && isset($okres) && isset($procent))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $kwota == "") {
	$messages [] = 'Nie podano kwoty kredytu';
}
if ( $okres == "") {
	$messages [] = 'Nie podano okresu kredytowania';
}
if ( $procent == "") {
	$messages [] = 'Nie podano wysokości oprocentowani';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	if (! is_numeric( $kwota ) || $kwota < 0) {
		$messages [] = 'Kwota kredytu nie jest liczbą całkowitą dodatnią';
	}
	
	if (! is_numeric( $okres ) || $okres < 0) {
		$messages [] = 'Okres kredytowania nie jest liczbą całkowitą dodatnią';
	}
        //założyłam, że oprocentowanie też będzie liczbą dodatnią całkowitą
        if ($procent < 0) {
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą dodatnią';
	}

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$kwota = intval($kwota);
	$okres = intval($okres);
        $procent = doubleval ($procent);
	
	//wykonanie operacji
	$result = ($kwota + ($kwota * ($procent/100))) / ($okres*12);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';