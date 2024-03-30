<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// 1. pobranie parametrów
function getParams(&$kwota,&$okres,&$procent){
    $kwota = isset($_REQUEST ['kwota']) ? $_REQUEST['kwota'] : null;
    $okres = isset($_REQUEST ['okres']) ? $_REQUEST['okres'] : null;
    $procent = isset($_REQUEST ['procent']) ? $_REQUEST['procent'] : null;
}

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
function validate(&$kwota,&$okres,&$procent,&$messages){
    if ( ! (isset($kwota) && isset($okres) && isset($procent))) {
            //sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
            return false;
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
    if (count ($messages) !=0)return false;
    
    //sprawdzamy, czy podane liczby są liczbami całkowitymi
    if (! is_numeric( $kwota ) || $kwota < 0) {
	$messages [] = 'Kwota kredytu nie jest liczbą całkowitą dodatnią';
    }
	
    if (! is_numeric( $okres ) || $okres < 0) {
	$messages [] = 'Okres kredytowania nie jest liczbą całkowitą dodatnią';
    }
        //założyłam, że oprocentowanie też będzie liczbą dodatnią całkowitą
    if (!is_numeric( $procent ) || $procent < 0) {
	$messages [] = 'Oprocentowanie nie jest liczbą całkowitą dodatnią';
	}
    
    if (count ($messages) !=0)return false;
    else return true;
}

// 3. wykonaj zadanie jeśli wszystko w porządku

Function process(&$kwota,&$okres,&$procent,&$messages,&$result){
    global $role;
	//konwersja parametrów na int
	$kwota = intval($kwota);
	$okres = intval($okres);
        $procent = doubleval ($procent);
	
	//wykonanie operacji
        if ($role == 'admin'){
            $result = ($kwota + ($kwota * ($procent/100))) / ($okres*12);
        } else {
            $messages [] = 'Tylko administrator może obliczyć ratę!';
        }
}

//definicja zmiennych kontrolera
$kwota = null;
$okres = null;
$procent = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kwota,$yokres,$procent);
if ( validate($kwota,$yokres,$procent,$messages) ) { // gdy brak błędów
	process($kwota,$yokres,$procent,$messages,$result);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';