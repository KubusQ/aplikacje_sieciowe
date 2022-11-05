<?php
// KONTROLER strony kalkulatora

use LDAP\Result;

require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';
// twig
require_once $conf->root_path.'/lib/Twig/Autoloader.php';

class CalcCtrl {
    
    private $msgs;
	private $form;  
	private $res; 
	private $sum;

    public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->res = new CalcResult();
		$this->sum = new CalcResult();
	}
    
    public function getParams(){
		$this->form->x = isset($_REQUEST ['x']) ? $_REQUEST ['x'] : null;
		$this->form->y = isset($_REQUEST ['y']) ? $_REQUEST ['y'] : null;
		$this->form->op = isset($_REQUEST ['z']) ? $_REQUEST ['z'] : null;
	}
    public function validate() {
    if (! (isset ( $this->form->x ) && isset ( $this->form->y ) && isset ( $this->form->z ))) {
        return false; //zakończ walidację z błędem
    }


// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $this->form->x = "") {
	$this->msgs->addError('Nie podano kwoty kredytu');
}
if ( $this->form->y = "") {
	$this->msgs->addError('Nie podano oprocentowania');
}
if ( $this->form->z = "") {
	$this->msgs->addError('Nie podano ilości lat');
}

//nie ma sensu walidować dalej gdy brak parametrów
if ($this->msgs->isError()) {
	
	if (! is_numeric ( $this->form->x )) {
		$this->msgs->addError('Kwota nie jest liczbą');
	}
	if (! is_numeric ( $this->form->y )) {
		$this->msgs->addError('Oprocentowanie nie jest liczbą');
	}	
	if (! is_numeric ( $this->form->z )) {
		$this->msgs->addError('Ilość lat nie jest liczbą');
	}	
    return ! $this->msgs->isError();
}
}
public function process(){

    $this->getParams();

if ($this->validate()) {
	
	//konwersja parametrów na int
	$this->form->x = floatval($this->form->x);
	$this->form->y = floatval($this->form->y);
	$this->form->z = intval($this->form->z);

	$this->res->res = $this->form->x*($this->form->y/100)+$this->form->x;

	$this->res->sum = ($this->form->x*(1+($this->form->y/100)))/($this->form->z*12);

}
 $this->generateView();
}

public function generateView(){
global $conf;
	//start Twig
Twig_Autoloader::register();
//załaduj szablony (wskazanie folderów z potrzebnymi szablonami)
$loader = new Twig_Loader_Filesystem($conf->root_path.'/templates'); //szablon ogólny
$loader->addPath($conf->root_path.'/app'); //szablon strony kalkulatora
//skonfiguruj folder cache
$twig = new Twig_Environment($loader, array(
    'cache' => $conf->root_path.'/twig_cache',
));

//przygotowanie zmiennych dla szablonu
$variables = array(
	'conf' => $conf,
	'app_url' => '/php_05_obiektowosc',
	'root_path' => '/php_05_obiektowosc',
	'page_title' => 'Obiektowość',
	'page_description' => 'Obiektowość pełną parą',
	'form' => $this->form,
	'res' => $this->res,
	'msgs' => $this->msgs,
	'sum' => $this->sum,
);

// 5. Wywołanie szablonu (wygenerowanie widoku)
echo $twig->render('calc.twig', $variables);
}
}
