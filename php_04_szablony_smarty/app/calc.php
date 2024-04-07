<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';

//pobranie parametrów
function getParams(&$form){
    $form['kwota'] = isset($_REQUEST ['kwota']) ? $_REQUEST['kwota'] : null;
    $form['okres'] = isset($_REQUEST ['okres']) ? $_REQUEST['okres'] : null;
    $form['procent'] = isset($_REQUEST ['procent']) ? $_REQUEST['procent'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$messages,&$hide_intro){

	//sprawdzenie, czy parametry zostały przekazane - jeśli nie to zakończ walidację
	if ( ! (isset($form['kwota']) && isset($form['okres']) && isset($form['procent']))) {
            return false;
        }    
	
	//parametry przekazane  
	$hide_intro = true;

	$infos [] = 'Przekazano parametry.';

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['kwota'] == "") {
            $messages [] = 'Nie podano kwoty kredytu';
        }
        if ( $form['okres'] == "") {
            $messages [] = 'Nie podano okresu kredytowania';
        }
        if ( $form['procent'] == "") {
            $messages [] = 'Nie podano wysokości oprocentowani';
        }
	//nie ma sensu walidować dalej gdy brak parametrów
	if ( count($messages)==0 ) {
            //sprawdzamy, czy podane liczby są liczbami całkowitymi
            if (!is_numeric( $form['kwota']) || $form['kwota'] < 0) {
                $messages [] = 'Kwota kredytu nie jest liczbą dodatnią';
            }
            if (! is_numeric( $form['okres']) || $form['okres'] < 0) {
                $messages [] = 'Okres kredytowania nie jest liczbą dodatnią';
            }
            if (! is_numeric( $form['procent']) || $form['procent'] < 0){
                $messages [] = 'Oprocentowanie nie jest liczbą dodatnią';
            }
	}
	
	if (count($messages)>0) {
            return false;
        }
	else return true;
}
	
// wykonaj obliczenia
function process(&$form,&$infos,&$messages,&$result){
	$infos [] = 'Parametry poprawne. Wykonuję obliczenia.';
	
	//konwersja parametrów na int
	$form['kwota'] = floatval($form['kwota']);
	$form['okres'] = floatval($form['okres']);
        $form['procent'] = floatval($form['procent']);
        
	//wykonanie operacji
        $result = ($form['kwota'] + ($form['kwota'] * ($form['procent']/100))) / ($form['okres']*12);	
}

//inicjacja zmiennych
$form = null;
$infos = array();
$messages = array();
$result = null;
$hide_intro = false;
	
getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ){
	process($form,$infos,$messages,$result);
}

// 4. Przygotowanie danych dla szablonu

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Przykład 04');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');

$smarty->assign('hide_intro',$hide_intro);

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc.tpl');