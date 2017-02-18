<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   calendar_form
 * @author    Oliver Willmes
 * @license   GNU/LGPL
 * @copyright Oliver Willmes 2017
 */
class FormCalendar extends \Widget
{
    protected $strTemplate = 'form_calendarAjax';

    protected $strPrefix = 'widget widget-calendar';

    protected $blnSubmitInput = true;

    public function validator($input)
    {
        $FormBooking = \Session::getInstance()->get('FormBooking');

        if (is_array($FormBooking[$input]['reservation'])) {
            ksort($FormBooking[$input]['reservation']);
            $arrTermine = array();
            foreach ($FormBooking[$input]['reservation'] as $reservation) {
                if ($this->calForm == 'week') {
                    $arrTermine[] = $reservation['datum'] . ' ' . $reservation['min'] . "min";
                } else {
                    $arrTermine[] = $reservation['datum'];
                }
            }
            unset($FormBooking[$input]);
            \Session::getInstance()->set('FormBooking', $FormBooking);
            return "\n" . implode(",\n", $arrTermine);
        }
    }

    public function parse($attributes = null)
    {
        if (TL_MODE == 'BE') {
            $template = new BackendTemplate('be_wildcard');
            $template->wildcard = '### CALENDAR ###';

            return $template->parse();
        }

        $this->loadLanguageFile('tl_form_field');
        $formToken = new \Willmes\calendarAjax();
        $this->FormToken = $formToken->genFT($this->id);

        return parent::parse($attributes);
    }

    /**
     * Old generate() method that must be implemented due to abstract declaration.
     *
     * @throws \BadMethodCallException
     */
    public function generate()
    {
        throw new BadMethodCallException('Calling generate() has been deprecated, you must use parse() instead!');
    }
}