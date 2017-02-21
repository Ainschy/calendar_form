<?php
/**
 * Namespace
 */

namespace Willmes;


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

abstract class CalendarAjax extends \System
{
    /**
     *
     * @var array
     */
    protected $FormBooking;
    /**
     * formfieldID
     * @var integer
     */
    protected $ffID;
    /**
     * formfield object
     * @object
     */
    protected $objFFM;
    /**
     * reservation object
     * @object
     */
    protected $objFB;
    /**
     * Formular Token
     * @var
     */
    protected $ft;

    /**
     * Generate the module
     */

    public function __construct()
    {
        parent::__construct();
        $this->Import('Database');
        $this->Import('Session');
        $this->Import('Input');
        $this->objMember = \FrontendUser::getInstance();
        $this->FormBooking = \Session::getInstance()->get('FormBooking');
    }

    /**
     * write object back in Session
     */
    public function __destruct()
    {
        $this->FormBooking[$this->ft] = (array)$this->objFB;
        \Session::getInstance()->set('FormBooking', $this->FormBooking);
    }

    /**
     * @param int $id
     * @return bool|int|string
     */
    public function genFT($id = 0)
    {
        if ($id) {
            if (is_array($this->FormBooking)) {
                foreach ($this->FormBooking as $ft => $value) {
                    if ($value['fieldID'] == $id) return $ft;
                }
            }
            $this->objFFM = \FormFieldModel::findById($id);
            $newFT = md5(uniqid(mt_rand(), true));
            $this->FormBooking[$newFT] = array(
                'fieldID' => $id,
                'current' => \Date::parse("Ymd", $this->getInitialDate()),
                'reservation' => []
            );
            return $newFT;
        }
        return false;
    }

    /**
     * check and define FormFieldToken
     * define FormFieldiD from Session Array
     * load FormFieldObject
     * @param string $ft
     * @return bool
     */
    public function setFT($ft)
    {
        if (!$ft) return false;
        $this->loadLanguageFile('tl_form_field');
        if ((is_array($this->FormBooking[$ft]))) {
            $this->ffID = $this->FormBooking[$ft]['fieldID'];
            $this->objFFM = \FormFieldModel::findById($this->ffID);
            $this->objFB = (object)$this->FormBooking[$ft];
            $this->ft = $ft;
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @return array|bool
     */
    public function getCalanderSheet()
    {
        return $this->generateSheet();
    }

    /**
     * @return bool
     */
    public function getReservations()
    {
        ksort($this->objFB->reservation);
        return $this->objFB->reservation;
    }

    /**
     * @return array|bool
     */
    public function changeMonth()
    {
        if (!is_numeric(\Input::post('data-id'))) return false;
        $this->objFB->current = \Input::post('data-id');
        return $this->generateSheet();
    }

    /**
     * @return bool
     */
    public function addReservation()
    {
        if (!is_numeric(\Input::post('data-id'))) return false;
        return $this->addRes();
    }

    /**
     * @return bool|mixed
     */
    public function rmReservation()
    {
        $id = \Input::post('data-id');
        if (!is_numeric($id)) return false;
        unset($this->objFB->reservation[$id]);
        return $id;
    }

    /**
     * @return bool|mixed
     */
    public function changeOption()
    {
        $id = \Input::post('data-id');
        if (!is_numeric($id)) return false;

        if (!is_array($this->FormBooking[$this->ft]['reservation'])) return false;

        if (array_key_exists($id, $this->FormBooking[$this->ft]['reservation'])) unset($this->FormBooking[$this->ft]['reservation'][$id]);

        return $id;
    }

    /**
     * @return bool
     */
    public function removeAll()
    {
        $this->objFB->reservation = array();
        return true;
    }

    /**
     * @return mixed
     */
    protected function getTableNavMonth()
    {

        $arrHead['prev'] = array(
            'label' => \Date::parse($GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_prev-next'], $this->Date->monthBegin - 1),
            'id' => \Date::parse("Ymd", $this->Date->monthBegin - 1)
        );
        $arrHead['next'] = array(
            'label' => \Date::parse($GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_prev-next'], $this->Date->monthEnd + 1),
            'id' => \Date::parse("Ymd", $this->Date->monthEnd + 1)
        );
        for ($i = -$GLOBALS['CAL_FORM']['elements']['selectable_month']; $i <= $GLOBALS['CAL_FORM']['elements']['selectable_month']; $i++) {
            $newDate = new \Date(strtotime("+$i month", $this->Date->tstamp));
            $selected = ($this->objFB->current == \Date::parse("Ymd", $newDate->tstamp)) ? ' selected' : '';
            $arrHead['current'][]['options'] = sprintf('<option value="%s" %s>%s</option>', \Date::parse("Ymd", $newDate->tstamp), $selected, \Date::parse($GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_current'], $newDate->tstamp));
        }
        return $arrHead;
    }

    /**
     * Return the week days and labels as array
     *
     * @return array
     */
    protected function compileDays()
    {
        $arrDays = array();
        $intDayAtWeek = 0;
        for ($i = 0; $i < 7; $i++) {
            $strClass = '';
            $intCurrentDay = ($i + $this->objFFM->cal_startDay) % 7;

            if ($i == 0) {
                $strClass .= ' col_first';
            } elseif ($i == 6) {
                $strClass .= ' col_last';
            }

            if ($intCurrentDay == 0 || $intCurrentDay == 6) {
                $strClass .= ' weekend';
            }
            $arrDays[]['table_day'] = sprintf($GLOBALS['TL_LANG']['CAL_FORM']['elements']['table_days'], $strClass, $GLOBALS['TL_LANG']['DAYS_SHORT'][$intCurrentDay]);
            $intDayAtWeek += 86400;
        }
        return $arrDays;
    }

    /**
     * generate month calendarsheet
     * @return array
     */
    protected function generateSheet()
    {
        $this->Date = new \Date($this->objFB->current, "Ymd");
        $intDaysInMonth = date('t', $this->Date->monthBegin);
        $intFirstDayOffset = date('w', $this->Date->monthBegin) - $this->objFFM->cal_startDay;

        if ($intFirstDayOffset < 0) {
            $intFirstDayOffset += 7;
        }

        $intColumnCount = -1;
        $intNumberOfRows = ceil(($intDaysInMonth + $intFirstDayOffset) / 7);
        $arrDays = $this->getTableNavMonth();
        $arrDays['head'] = $this->compileDays();
        $col = 1;
        for ($i = 1; $i <= ($intNumberOfRows * 7); $i++) {
            if ($col > 7) $col = 1;
            $intWeek = floor(++$intColumnCount / 7);
            $intDay = $i - $intFirstDayOffset;
            $intCurrentDay = ($i + $this->objFFM->cal_startDay) % 7;

            $strClass = ($intCurrentDay < 2) ? ' weekend' : '';
            $strClass .= ($i == 1 || $i == 8 || $i == 15 || $i == 22 || $i == 29 || $i == 36) ? ' col_first' : '';
            $strClass .= ($i == 7 || $i == 14 || $i == 21 || $i == 28 || $i == 35 || $i == 42) ? ' col_last' : '';

            // Empty cell
            if ($intDay < 1 || $intDay > $intDaysInMonth) {
                $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_day'], $strClass, '', '');
                $col++;
                continue;
            }
            $intKey = date('Ym', $this->Date->tstamp) . ((strlen($intDay) < 2) ? '0' . $intDay : $intDay);
            $arrCR = $this->generateDayAndOptions($intKey);
            $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_day'], $arrCR['class'], $arrCR['id'], $arrCR['option']);
            $col++;
        }
        return $arrDays;
    }

    /**
     * @param int $intDay
     * @return array
     */
    protected function generateDayAndOptions($intDay = 0)
    {
        if (!$intDay) return array();

        $tstamp = new \Date($intDay, "Ymd");
        $strClass = ($intDay == \Date::parse("Ymd", time())) ? ' today' : '';
        $strBook = ($this->objFFM->calChoise == 'selection') ? 'free' : 'bookable';

        if ($tstamp->tstamp > time()) {
            if (!$this->checkExceptionList($tstamp->tstamp)) {
                $strClass .= ($this->objFFM->calChoise == 'selection') ? $GLOBALS['CAL_FORM']['status_class']['notavailable'] : $GLOBALS['CAL_FORM']['status_class']['blocked'];
                $intDay = '';
            } else {
                $strClass .= (array_key_exists($intDay, $this->objFB->reservation)) ? 'selected' : $strBook;
            }
        } else {
            $intDay = '';
        }
        $strOption = \Date::parse("d", $tstamp->tstamp);

        $arrReturn = array(
            'class' => 'day ' . $strClass,
            'id' => $intDay,
            'option' => $strOption
        );

        return $arrReturn;
    }

    /**
     * add new reservation to session
     * @return bool
     */
    protected function addRes()
    {
        $id = \Input::post('data-id');
        $datum = new \Date($id, "Ymd");
        if ($this->objFFM->calChoise != 'selection' && $this->objFFM->calRange && ('2' == count($this->objFB->reservation)) ||
            ($this->objFFM->calLogicMonth > 0 && !$this->objFFM->calRange && ($this->objFFM->calLogicMonth <= count($this->objFB->reservation)))
        ) {
            $key = key($this->objFB->reservation);
            unset($this->objFB->reservation[$key]);
        }
        $this->objFB->reservation[$id] = array(
            'id' => $id,
            'datum' => \Date::parse($this->objFFM->calOutput, $datum->tstamp),
        );
        ksort($this->objFB->reservation);
        return $this->objFB->reservation[$id];
    }

    /**
     * @param int $tstamp
     * @return bool
     */
    protected function checkExceptionList($tstamp = 0)
    {
        $arrExceptions = unserialize($this->objFFM->exceptions);
        if (is_array($arrExceptions) && $tstamp > 0) {
            foreach ($arrExceptions as $exception) {
                if ($this->objFFM->calChoise == 'selection') {
                    if ($exception['startdate'] <= $tstamp && $exception['enddate'] >= $tstamp) return true;
                } else {
                    if ($exception['startdate'] <= $tstamp && $exception['enddate'] >= $tstamp) return false;
                }
            }
        }
        return ($this->objFFM->calChoise == 'selection') ? false : true;
    }

    /**
     * @param int $tstamp
     * @return bool
     */
    protected function getInitialDate()
    {
        $tstamp = time();
        $arrExceptions = unserialize($this->objFFM->exceptions);
        if (is_array($arrExceptions)) {
            foreach ($arrExceptions as $exception) {
                if ($this->objFFM->calChoise == 'selection') {
                    if ($exception['startdate'] >= $tstamp) return $exception['startdate'];
                }
            }
        }
        return $tstamp;
    }
}
