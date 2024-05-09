<?php
// W skrypcie definicji kontrolera nie trzeba dołączać już niczego.
// Kontroler wskazuje tylko za pomocą 'use' te klasy z których jawnie korzysta
// (gdy korzysta niejawnie to nie musi - np używa obiektu zwracanego przez funkcję)

// Zarejestrowany autoloader klas załaduje odpowiedni plik automatycznie w momencie, gdy skrypt będzie go chciał użyć.
// Jeśli nie wskaże się klasy za pomocą 'use', to PHP będzie zakładać, iż klasa znajduje się w bieżącej
// przestrzeni nazw - tutaj jest to przestrzeń 'app\controllers'.

// Przypominam, że tu również są dostępne globalne funkcje pomocnicze - o to nam właściwie chodziło

namespace app\controllers;

//zamieniamy zatem 'require' na 'use' wskazując jedynie przestrzeń nazw, w której znajduje się klasa
use app\forms\CalcForm;
use app\transfer\CalcResult;

class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
        private $hide_intro;
	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->result = new CalcResult();
                $this->hide_intro = false;
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kwota = getFromRequest('kwota');
		$this->form->okres = getFromRequest('okres');
		$this->form->procent = getFromRequest('procent');
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kwota ) && isset ( $this->form->okres ) && isset ( $this->form->procent ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		} else { 
			$this->hide_intro = true; //przyszły pola formularza, więc - schowaj wstęp
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kwota == "") {
                    getMessages()->addError('Nie podano kwoty kredytu');
		}
		if ($this->form->okres == "") {
			getMessages()->addError('Nie podano okresu kredytowania');
		}
                if ($this->form->procent == "") {
			getMessages()->addError('Nie podano wysokości oprocentowani');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->kwota ) || ( $this->form->kwota ) < 0) {
				getMessages()->addError('Kwota kredytu nie jest liczbą dodatnią');
			}
			
			if (! is_numeric ( $this->form->okres ) || ( $this->form->okres ) < 0) {
				getMessages()->addError('Okres kredytowania nie jest liczbą dodatnią');
			}
                        
                        if (! is_numeric ( $this->form->procent ) || ( $this->form->procent ) < 0) {
				getMessages()->addError('Oprocentowanie nie jest liczbą dodatnią');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function action_calcCompute(){

		$this->getparams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kwota = intval($this->form->kwota);
			$this->form->okres = intval($this->form->okres);
                        $this->form->procent = intval($this->form->procent);
			getMessages()->addInfo('Parametry poprawne.');
			
                        if(($this->form->kwota) >= 200000){
			//wykonanie operacji
                            
                            if(inRole('admin')){
                                $this->result->result = (($this->form->kwota) + (($this->form->kwota) * (($this->form->procent)/100))) / (($this->form->okres)*12);
			
                                getMessages()->addInfo('Wykonano obliczenia.');
                            
                            }else{
                                getMessages()->addError('Kwota wyższa bądź równa 200 tyś. Tylko administrator może wykonać tę operację');
                            }
                        }else{
                            $this->result->result = (($this->form->kwota) + (($this->form->kwota) * (($this->form->procent)/100))) / (($this->form->okres)*12);
			
                                getMessages()->addInfo('Wykonano obliczenia.');
                        }
		}
		
		$this->generateView();
	}
	
	public function action_calcShow(){
		getMessages()->addInfo('Witaj w kalkulatorze');
		$this->generateView();
	}
        
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		//nie trzeba już tworzyć Smarty i przekazywać mu konfiguracji i messages
		// - wszystko załatwia funkcja getSmarty()
		
                getSmarty()->assign('user',unserialize($_SESSION['user']));
		getSmarty()->assign('page_title','Przykład 07b');
		getSmarty()->assign('page_description','Zamiana funkcji pomocniczej, automatyzującej wywołanie kontrolera, na obiekt routera.');
		
                getSmarty()->assign('hide_intro',$this->hide_intro);
                
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.tpl'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}
