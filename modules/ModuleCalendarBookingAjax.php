<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   CalendarBookingAjax
 * @author    Oliver Willmes
 * @license   GNU/LGPL
 * @copyright Oliver Willmes 2016
 */


/**
 * Namespace
 */
namespace CalendarBookingAjax;

/**
 * Class ModuleCalendarBookingAjax
 *
 * @copyright  Oliver Willmes 2016
 * @author     Oliver Willmes
 * @package    Devtools
 */

class ModuleCalendarBookingAjax extends \System
{
    /**
     * @var array
     */
    protected $FormBooking;
    /**
     * @var integer
     */
    protected $ffID;
    /**
     * @object
     */
    protected $objFFM;
    /**
     *
     * @object
     */
    protected $objFB;
    /**
     * @var
     */
    protected $ft;

    /**
	 * Generate the module
	 */


    public function __construct()
	{
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
        \Session::getInstance()->set('FormBooking',$this->FormBooking);
    }

    /**
     * @param int $id
     * @return bool|int|string
     */
    public function genFT($id = 0 )
    {
        if($id)
        {
            if(is_array($this->FormBooking))
            {
                foreach($this->FormBooking as $ft => $value)
                {
                    if($value['fieldID'] == $id) return $ft;
                }
            }
            $newFT = md5(uniqid(mt_rand(), true));
            $this->FormBooking[$newFT] = array(
                'fieldID'   => $id,
                'current'   => \Date::parse("Ym",time()),
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
        switch ($this->objFFM->calForm) {
            case 'week' :
                return $this->generateWeek();
                break;
            default :
                return $this->generateSheet();
        }
    }

    /**
     * @return bool
     */
    public function getReservations()
    {
        return $this->FormBooking[$this->ft]['reservation'];
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
        $id = \Input::post('data-id');
        if (!is_numeric($id)) return false;

        $datum = new \Date($id, "Ymd");
        $this->objFB->reservation[$id] = array(
            'id' => $id,
            'datum' => \Date::parse("D. d.m.Y", $datum->tstamp),
        );

        return $this->objFB->reservation[$id];
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

        if(!is_array($this->FormBooking[$this->ft]['reservation'])) return false;

        if( array_key_exists($id,$this->FormBooking[$this->ft]['reservation']) ) unset($this->FormBooking[$this->ft]['reservation'][$id]);

        return $id;
    }

    protected function getTableNav()
    {

        $arrHead['prev'] = array(
            'label' => \Date::parse($GLOBALS['CAL_FORM']['elements']['format_prev-next'], $this->Date->monthBegin - 1),
            'id' => \Date::parse("Ym", $this->Date->monthBegin - 1)
        );
        $arrHead['next'] = array(
            'label' => \Date::parse($GLOBALS['CAL_FORM']['elements']['format_prev-next'], $this->Date->monthEnd + 1),
            'id' => \Date::parse("Ym", $this->Date->monthEnd + 1)
        );
        for ($i = -$GLOBALS['CAL_FORM']['elements']['selectable_month']; $i <= $GLOBALS['CAL_FORM']['elements']['selectable_month']; $i++) {
            $newDate = new \Date(strtotime("+$i month", $this->Date->tstamp));
            $selected = ($this->objFB->current == \Date::parse("Ym", $newDate->tstamp)) ? ' selected' : '';
            $arrHead['current'][]['options'] = sprintf('<option value="%s" %s>%s</option>', \Date::parse("Ym", $newDate->tstamp), $selected, \Date::parse($GLOBALS['CAL_FORM']['elements']['format_current'], $newDate->tstamp));
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

            $arrDays[]['table_day'] = sprintf($GLOBALS['CAL_FORM']['elements']['table_days'], $strClass, $GLOBALS['TL_LANG']['DAYS_SHORT'][$intCurrentDay]);
        }
        return $arrDays;
    }

    /**
     * generate month calendarsheet
     * @return array
     */
    protected function generateSheet()
    {
        $this->Date = new \Date($this->objFB->current, "Ym");
        $intDaysInMonth = date('t', $this->Date->monthBegin);
        $intFirstDayOffset = date('w', $this->Date->monthBegin) - $this->objFFM->cal_startDay;

        if ($intFirstDayOffset < 0)
        {
            $intFirstDayOffset += 7;
        }

        $intColumnCount = -1;
        $intNumberOfRows = ceil(($intDaysInMonth + $intFirstDayOffset) / 7);
        $arrDays = $this->getTableNav();
        $arrDays['head'] = $this->compileDays();
        $col = 1;
        for ($i=1; $i<=($intNumberOfRows * 7); $i++)
        {
            $strCol = 'col_';
            if($col > 7) $col = 1;
            $strCol .= $col;
            $intWeek = floor(++$intColumnCount / 7);
            $intDay = $i - $intFirstDayOffset;
            $intCurrentDay = ($i + $this->objFFM->cal_startDay) % 7;

            $strClass = ($intCurrentDay < 2) ? ' weekend' : '';
            $strClass .= ($i == 1 || $i == 8 || $i == 15 || $i == 22 || $i == 29 || $i == 36) ? ' col_first' : '';
            $strClass .= ($i == 7 || $i == 14 || $i == 21 || $i == 28 || $i == 35 || $i == 42) ? ' col_last' : '';

            // Empty cell
            if ($intDay < 1 || $intDay > $intDaysInMonth)
            {
                $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['CAL_FORM']['elements']['month_day'], $strClass, '', '');
                $col++;
                continue;
            }
            $intKey = date('Ym', $this->Date->tstamp) . ((strlen($intDay) < 2) ? '0' . $intDay : $intDay);
            $strClass .= ($intKey == date('Ymd')) ? ' today' : '';
            if ($intKey > date('Ymd')) {
                if(array_key_exists($intKey,$this->FormBooking[$this->ft]['reservation']))
                {
                    $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['CAL_FORM']['elements']['month_day'], 'day ' . $GLOBALS['CAL_FORM']['status_class']['selected'] . $strClass, $intKey, $intDay);
                } else {
                    $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['CAL_FORM']['elements']['month_day'], 'day ' . $GLOBALS['CAL_FORM']['status_class']['bookable'] . $strClass, $intKey, $intDay);
                }
                $col++;
                continue;
            }
            $arrDays['week'][$intWeek]['days'][]['day'] = sprintf($GLOBALS['CAL_FORM']['elements']['month_day'], 'day ' . $strClass, '', $intDay);
            $col++;
        }
        return $arrDays;
    }

    protected function generateWeek()
    {
        $this->Date = new \Date($this->objFB->current, "Ym");

        $arrDays = $this->getTableNav();
        $arrDays['head'] = $this->compileDays();

        return $arrDays;
    }
}
