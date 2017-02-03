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
     * @var
     */
    protected $objFFM;
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
     *
     */
    public function __destruct()
    {
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
     * @param string $ft
     * @return bool
     */
    public function setFT($ft)
    {
        if (!$ft) return false;

        if ((is_array($this->FormBooking[$ft]))) {
            $this->ffID = $this->FormBooking[$ft]['fieldID'];
            $this->objFFM = \FormFieldModel::findById($this->ffID);
            $this->ft = $ft;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $ft
     * @return array|bool
     */
    public function getCalanderSheet()
    {
        $this->Date = new \Date($this->FormBooking[$this->ft]['current'],"Ym");
        $this->cal_startDay = $this->objFFM->cal_startDay;

        return $this->generateSheet();
    }

    /**
     * @param int $ft
     * @return bool
     */
    public function getReservations()
    {
        return $this->FormBooking[$this->ft]['reservation'];
    }

    /**
     * @param int $ft
     * @return array|bool
     */
    public function changeMonth()
    {
        if (!is_numeric(\Input::post('data-id'))) return false;
        $this->Date = new \Date(\Input::post('data-id'),"Ym");
        $this->FormBooking[$this->ft]['current'] = \Input::post('data-id');

        return $this->generateSheet();
    }

    /**
     * @param int $ft
     * @return bool
     */
    public function addReservation()
    {
        $id = \Input::post('data-id');
        if (!is_numeric($id)) return false;

        if(is_array($this->FormBooking[$this->ft]['reservation']))
        {
            if( !array_key_exists($id,$this->FormBooking[$this->ft]['reservation']) )
            {
                $datum = new \Date($id,"Ymd");
                $this->FormBooking[$this->ft]['reservation'][$id] = array(
                    'id' => $id,
                    'datum' => \Date::parse("D. d.m.Y",$datum->tstamp),
                    'options'   => array(
                        '0'     => array(
                            'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="morgens" id="'.$id.'_21"><label for="'.$id.'_21">Morgens</label>'),
                        '1'     => array(
                            'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="mittags" id="'.$id.'_22"><label for="'.$id.'_22">Mittags</label>'),
                        '2'     => array(
                            'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="abends" id="'.$id.'_23"><label for="'.$id.'_23">Abends</label>'),
                        '3'     => array(
                            'option' => '<input type="radio" class="option" checked name="'.$id.'_cb1" value="egal" id="'.$id.'_24"><label for="'.$id.'_24">Egal</label>'),
                    )
                );
            }
        } else {
            $datum = new \Date($id,"Ymd");
            $this->FormBooking[$this->ft]['reservation'][$id] = array(
                'id'        => $id,
                'datum'     => \Date::parse("D. d.m.Y",$datum->tstamp),
                'options'   => array(
                    '0'     => array(
                        'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="morgens" id="'.$id.'_21"><label for="'.$id.'_21">Morgens</label>'),
                    '1'     => array(
                        'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="mittags" id="'.$id.'_22"><label for="'.$id.'_22">Mittags</label>'),
                    '2'     => array(
                        'option' => '<input type="radio" class="option" name="'.$id.'_cb1" value="abends" id="'.$id.'_23"><label for="'.$id.'_23">Abends</label>'),
                    '3'     => array(
                        'option' => '<input type="radio" class="option" checked name="'.$id.'_cb1" value="egal" id="'.$id.'_24"><label for="'.$id.'_24">Egal</label>'),
                )
            );
        }
        return $this->FormBooking[$this->ft]['reservation'][$id];
    }

    /**
     * @param int $ft
     * @return bool|mixed
     */
    public function rmReservation()
    {
        $id = \Input::post('data-id');
        if (!is_numeric($id)) return false;

        if(!is_array($this->FormBooking[$this->ft]['reservation'])) return false;

        if( array_key_exists($id,$this->FormBooking[$this->ft]['reservation']) ) unset($this->FormBooking[$this->ft]['reservation'][$id]);

        return $id;
    }

    /**
     * @param int $ft
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
     * @return array
     */
    protected function generateSheet()
    {
        $intDaysInMonth = date('t', $this->Date->monthBegin);
        $intFirstDayOffset = date('w', $this->Date->monthBegin) - $this->objFFM->cal_startDay;

        if ($intFirstDayOffset < 0)
        {
            $intFirstDayOffset += 7;
        }

        $intColumnCount = -1;
        $intNumberOfRows = ceil(($intDaysInMonth + $intFirstDayOffset) / 7);
        $arrDays = array(
            'prev' => array(
                'label' => \Date::parse("M Y",$this->Date->monthBegin-1),
                'id'  => \Date::parse("Ym",$this->Date->monthBegin-1)
            ),
            'current' => array(
                'label' => \Date::parse("F Y",$this->Date->tstamp)
            ),
            'next' => array(
                'label' => \Date::parse("M Y",$this->Date->monthEnd+1),
                'id'  => \Date::parse("Ym",$this->Date->monthEnd+1)
            )
        );
        $col = 1;
        for ($i=1; $i<=($intNumberOfRows * 7); $i++)
        {
            $strCol = 'col_';
            if($col > 7) $col = 1;
            $strCol .= $col;
            $intWeek = floor(++$intColumnCount / 7);
            $intDay = $i - $intFirstDayOffset;
            $intCurrentDay = ($i + $this->objFFM->cal_startDay) % 7;

            $strWeekClass = 'week_' . $intWeek;

            $strClass = ($intCurrentDay < 2) ? ' weekend' : '';
            $strClass .= ($i == 1 || $i == 8 || $i == 15 || $i == 22 || $i == 29 || $i == 36) ? ' col_first' : '';
            $strClass .= ($i == 7 || $i == 14 || $i == 21 || $i == 28 || $i == 35 || $i == 42) ? ' col_last' : '';

            // Empty cell
            if ($intDay < 1 || $intDay > $intDaysInMonth)
            {
                $arrDays[$strWeekClass][$strCol]['label'] = '';
                $arrDays[$strWeekClass][$strCol]['class'] = '' . $strClass ;
                $arrDays[$strWeekClass][$strCol]['day'] = '';
                $col++;
                continue;
            }
            $intKey = date('Ym', $this->Date->tstamp) . ((strlen($intDay) < 2) ? '0' . $intDay : $intDay);
            $strClass .= ($intKey == date('Ymd')) ? ' today' : '';
            if ($intKey > date('Ymd')) {
                $arrDays[$strWeekClass][$strCol]['day'] = $intKey;
                $arrDays[$strWeekClass][$strCol]['label'] = $intDay;
                if(array_key_exists($intKey,$this->FormBooking[$this->ft]['reservation']))
                {
                    $arrDays[$strWeekClass][$strCol]['class'] = 'day selected' . $strClass;
                } else {
                    $arrDays[$strWeekClass][$strCol]['class'] = 'day bookable' . $strClass;
                }
                $col++;
                continue;
            }
            $arrDays[$strWeekClass][$strCol]['class'] = 'day ' . $strClass;
            $arrDays[$strWeekClass][$strCol]['label'] = $intDay;
            $col++;
        }

        return $arrDays;
    }
}
