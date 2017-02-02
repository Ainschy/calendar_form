<?php

/**
 * Created by PhpStorm.
 * User: Ainschy
 * Date: 12.01.2017
 * Time: 18:46
 */

namespace CalendarBookingAjax;

$arrPost = $_POST;
unset($_POST);

if (!defined('TL_SCRIPT')) {
    define('TL_SCRIPT', 'system/modules/calendarbookingajax/public/formAjax.php');
}

if (!defined('TL_MODE')) {
    define('TL_MODE', 'FE');

    $dir = dirname($_SERVER['SCRIPT_FILENAME']);
    while (($dir != '.') && ($dir != '/') && !is_file($dir . '/system/initialize.php')) {
        $dir = dirname($dir);
    }
    if (!is_file($dir . '/system/initialize.php')) {
        echo 'Could not find initialize.php';
        exit;
    }
    require_once($dir . '/system/initialize.php');
}

$_POST = $arrPost;



class formAjax extends \Frontend
{
    public function __construct()
    {
        \FrontendUser::getInstance();

        parent::__construct();
        define('BE_USER_LOGGED_IN', $this->getLoginStatus('BE_USER_AUTH'));
        define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
        \System::loadLanguageFile('default');
        \Controller::setStaticUrls();
    }
    public function run()
    {
        try {

            parse_str(file_get_contents("php://input"), $input);

            $objResModel = new \CalendarBookingAjax\ModuleCalendarBookingAjax();

            if( (\Input::post('rt') == \RequestToken::get() ) && ( true == $objResModel->checkFT(\Input::post('ft')) ) )
            {

                switch(\Input::post('action'))
                {
                    case 'initialLoad' :
                        $response = $objResModel->getCalanderSheet(\Input::post('ft'));
                        break;
                    case 'loadReservations' :
                        $response = $objResModel->getReservations(\Input::post('ft'));
                        break;
                    case 'prev' :
                        $response = $objResModel->changeMonth(\Input::post('ft'));
                        break;
                    case 'next' :
                        $response = $objResModel->changeMonth(\Input::post('ft'));
                        break;
                    case 'goto' :
                        $response = $objResModel->changeMonth(\Input::post('ft'));
                        break;
                    case 'addReservation' :
                        $response = $objResModel->addReservation(\Input::post('ft'));
                        break;
                    case 'rmReservation' :
                        $response = $objResModel->rmReservation(\Input::post('ft'));
                        break;
                    case 'changeOption' :
                        $response = $objResModel->changeOption(\Input::post('ft'));
                        break;
                }
                header('HTTP/1.0 200 OK');
            } else {
                header('HTTP/1.0 409 Bad Request');
            }
        } catch ( \Exception $e) {
            header('HTTP/1.0 409 Bad Request');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
$formAjax = new formAjax();
$formAjax->run();