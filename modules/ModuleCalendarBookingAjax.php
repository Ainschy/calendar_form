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
                'current' => \Date::parse("Ymd", time()),
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
            switch ($this->objFFM->calForm) {
                case 'week' :
                    $this->arrMap = $this->prepareAvailableTable();
                    break;
            }
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

        if(!is_array($this->FormBooking[$this->ft]['reservation'])) return false;

        if( array_key_exists($id,$this->FormBooking[$this->ft]['reservation']) ) unset($this->FormBooking[$this->ft]['reservation'][$id]);

        return $id;
    }

    /**
     * @return mixed
     */
    protected function getTableNavMonth()
    {

        $arrHead['prev'] = array(
            'label' => \Date::parse($GLOBALS['CAL_FORM']['elements']['month_format_prev-next'], $this->Date->monthBegin - 1),
            'id' => \Date::parse("Ymd", $this->Date->monthBegin - 1)
        );
        $arrHead['next'] = array(
            'label' => \Date::parse($GLOBALS['CAL_FORM']['elements']['month_format_prev-next'], $this->Date->monthEnd + 1),
            'id' => \Date::parse("Ymd", $this->Date->monthEnd + 1)
        );
        for ($i = -$GLOBALS['CAL_FORM']['elements']['selectable_month']; $i <= $GLOBALS['CAL_FORM']['elements']['selectable_month']; $i++) {
            $newDate = new \Date(strtotime("+$i month", $this->Date->tstamp));
            $selected = ($this->objFB->current == \Date::parse("Ymd", $newDate->tstamp)) ? ' selected' : '';
            $arrHead['current'][]['options'] = sprintf('<option value="%s" %s>%s</option>', \Date::parse("Ymd", $newDate->tstamp), $selected, \Date::parse($GLOBALS['CAL_FORM']['elements']['month_format_current'], $newDate->tstamp));
        }
        return $arrHead;
    }

    /**
     * @return mixed
     */
    protected function getTableNavWeek()
    {

        $arrHead['prev'] = array(
            'label' => 'KW ' . \Date::parse($GLOBALS['CAL_FORM']['elements']['week_format_prev-next'], $this->Date->getWeekBegin($this->objFFM->cal_startDay) - 86400) . '',
            'id' => \Date::parse("Ymd", $this->Date->getWeekBegin($this->objFFM->cal_startDay) - 86400)
        );
        $arrHead['next'] = array(
            'label' => 'KW ' . \Date::parse($GLOBALS['CAL_FORM']['elements']['week_format_prev-next'], $this->Date->getWeekEnd($this->objFFM->cal_startDay) + 86400) . '',
            'id' => \Date::parse("Ymd", $this->Date->getWeekEnd($this->objFFM->cal_startDay) + 86400)
        );
        for ($i = -$GLOBALS['CAL_FORM']['elements']['selectable_weeks']; $i <= $GLOBALS['CAL_FORM']['elements']['selectable_weeks']; $i++) {
            $newDate = new \Date(strtotime("+$i week", $this->Date->tstamp));
            $selected = ($this->objFB->current == \Date::parse("Ymd", $newDate->tstamp)) ? ' selected' : '';
            $label = sprintf("KW %s (%s - %s)",
                \Date::parse($GLOBALS['CAL_FORM']['elements']['week_format_current'], $newDate->tstamp),
                \Date::parse("d.m.y", $newDate->getWeekBegin($this->objFFM->cal_startDay)),
                \Date::parse("d.m.y", $newDate->getWeekEnd($this->objFFM->cal_startDay)));
            $arrHead['current'][]['options'] = sprintf('<option value="%s" %s>%s</option>', \Date::parse("Ymd", $newDate->tstamp), $selected, $label);
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
            switch ($this->objFFM->calForm) {
                case 'week' :
                    $arrDays[]['table_day'] = sprintf(
                        $GLOBALS['CAL_FORM']['elements']['table_days_week'],
                        $strClass, $GLOBALS['TL_LANG']['DAYS_SHORT'][$intCurrentDay],
                        \Date::parse("d.m.", $this->Date->getWeekBegin($this->objFFM->cal_startDay) + $intDayAtWeek));
                    break;
                default :
                    $arrDays[]['table_day'] = sprintf($GLOBALS['CAL_FORM']['elements']['table_days'], $strClass, $GLOBALS['TL_LANG']['DAYS_SHORT'][$intCurrentDay]);
            }
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

        if ($intFirstDayOffset < 0)
        {
            $intFirstDayOffset += 7;
        }

        $intColumnCount = -1;
        $intNumberOfRows = ceil(($intDaysInMonth + $intFirstDayOffset) / 7);
        $arrDays = $this->getTableNavMonth();
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
                if (array_key_exists($intKey, $this->objFB->reservation))
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

    /**
     * @return mixed
     */
    protected function generateWeek()
    {
        $this->Date = new \Date($this->objFB->current, "Ymd");
        $intWeekBegin = $this->Date->getWeekBegin($this->objFFM->cal_startDay);
        $arrDays = $this->getTableNavWeek();

        $arrDays['head'] = $this->compileDays();
        for ($i = 0; $i <= 6; $i++) {
            $j = \Date::parse("Ymd", strtotime('+' . $i . ' days', $intWeekBegin));
            $arrCR = $this->checkDayAndOptions($j);
            $arrDays['week'][0]['days'][]['day'] = sprintf($GLOBALS['CAL_FORM']['elements']['month_day'], $arrCR['class'], $arrCR['id'], $arrCR['option']);
        }
        return $arrDays;
    }

    /**
     * @param int $intDay
     * @return array
     */
    protected function checkDayAndOptions($intDay = 0)
    {
        if (!$intDay) return array();

        $tstamp = new \Date($intDay, "Ymd");
        $day = strtolower(date("D", $tstamp->tstamp));
        $strOption = '';
        foreach ($this->arrMap[$day] as $options) {
            if (strlen($options['time']) == '4') {
                if ($intDay > \Date::parse("Ymd", time())) {
                    $intDayTime = $intDay . $options['time'];
                    $strClass = (array_key_exists($intDay . $options['time'], $this->objFB->reservation)) ? 'selected' : 'bookable';
                    $strOption .= sprintf($GLOBALS['CAL_FORM']['elements']['week_day'],
                        $strClass,
                        $intDayTime,
                        $options['label']
                    );
                } else {
                    $strOption .= sprintf($GLOBALS['CAL_FORM']['elements']['week_day'],
                        $GLOBALS['CAL_FORM']['status_class']['notavailable'],
                        '',
                        $options['label']
                    );
                }

            } else {
                $strOption .= $GLOBALS['CAL_FORM']['elements']['empty'];
            }
        }
        $strClass = ($intDay == \Date::parse("Ymd", time())) ? ' today' : '';
        $arrReturn = array(
            'class' => 'day' . $strClass,
            'id' => $intDay,
            'option' => $strOption
        );

        return $arrReturn;
    }

    /**
     * generate Array from Timetable with this bookable Options
     * @return array
     */
    protected function prepareAvailableTable()
    {
        $arrAvailable = unserialize($this->objFFM->available);
        $arrMap = array();
        if (is_array($arrAvailable)) {
            foreach ($arrAvailable as $items) {
                foreach ($items as $key => $item) {
                    $explode = explode("/", $item);
                    $time = explode(":", $explode[0]);
                    $strTime = $time[0] . $time[1];
                    $arrMap[$key][] = array(
                        'time' => $strTime,
                        'min' => $explode[1],
                        'label' => sprintf($GLOBALS['CAL_FORM']['elements']['day_option_label'], $explode[0], $explode[1])
                    );
                }
            }
        }
        return $arrMap;
    }

    /**
     * add new reservation to session
     * @return bool
     */
    protected function addRes()
    {
        switch ($this->objFFM->calForm) {
            case 'month' :
                $id = \Input::post('data-id');
                $datum = new \Date($id, "Ymd");

                if ($this->objFFM->calRange && ('2' == count($this->objFB->reservation))) {
                    $key = key($this->objFB->reservation);
                    unset($this->objFB->reservation[$key]);
                }
                $this->objFB->reservation[$id] = array(
                    'id' => $id,
                    'datum' => \Date::parse("D. d.m.Y", $datum->tstamp),
                );
                ksort($this->objFB->reservation);
                return $this->objFB->reservation[$id];
                break;
            case 'week' :
                $id = \Input::post('data-id');
                $datum = new \Date($id, "YmdHi");
                $this->objFB->reservation[$id] = array(
                    'id' => $id,
                    'datum' => \Date::parse("D. d.m.Y H:i", $datum->tstamp) . ' Uhr',
                    'min' => $this->getMin($datum->tstamp)
                );
                return $this->objFB->reservation[$id];
                break;
        }
        return false;
    }

    /**
     * @param int $intTstamp
     * @return string
     */
    protected function getMin($intTstamp = 0)
    {
        if (!$intTstamp) return '';

        $day = strtolower(date("D", $intTstamp));
        $hour = date("Hi", $intTstamp);

        $key = array_search($hour, array_column($this->arrMap[$day], 'time'));

        return $this->arrMap[$day][$key]['min'];
    }
}
