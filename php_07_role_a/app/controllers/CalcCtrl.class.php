<?php


namespace app\controllers;

//zamieniamy zatem 'require' na 'use' wskazując jedynie przestrzeń nazw, w której znajduje się klasa
use app\forms\CalcForm;
use app\transfer\CalcResult;


class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $res; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->res = new CalcResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->x = getFromRequest('x');
		$this->form->y = getFromRequest('y');
		$this->form->z = getFromRequest('z');
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->x ) && isset ( $this->form->y ) && isset ( $this->form->z ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false;
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
if ($this->form->x == "") {
	getMessages()->addError('Nie podano kwoty kredytu');
}
if ($this->form->y == "") {
	getMessages()->addError('Nie podano oprocentowania');
}
if ($this->form->z == "") {
	getMessages()->addError('Nie podano ilości lat');
}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		 if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->x )) {
				getMessages()->addError('Kwota nie jest liczbą');
			}
			
			if (! is_numeric ( $this->form->y )) {
				getMessages()->addError('Oprocentowanie nie jest liczbą');
			}
			if (! is_numeric ( $this->form->z )) {
				getMessages()->addError('Ilość lat nie jest liczbą');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->x = floatval($this->form->x);
	  		$this->form->y = floatval($this->form->y);
			$this->form->z = intval($this->form->z);
			getMessages()->addInfo('Parametry poprawne.');
			

			
			//wykonanie operacji
		
					if (inRole('admin')) {
						$this->res->sum = ($this->form->x*(1+($this->form->y/100)))/($this->form->z*12);	
					} else {
						getMessages()->addError('Tylko administrator może wyświetlić wynik');
					}
					$this->res->res = $this->form->x*($this->form->y/100)+$this->form->x;
			
			
			getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){

		getSmarty()->assign('user',unserialize($_SESSION['user']));
				
		getSmarty()->assign('page_title','Super kalkulator - role');

		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->res);
		
		getSmarty()->display('CalcView.tpl');
	}
}
