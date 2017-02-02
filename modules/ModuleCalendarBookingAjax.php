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

use \Contao\Date;

class ModuleCalendarBookingAjax extends \System
{
    /**
     * @var array
     */
    protected $FormBooking;
    /**
     * @var integer
     */
    protected $ffid;
    /**
     * @var integer
     */
    protected $Date;
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
    public function checkFT( $ft = '' )
    {
        if (!$ft) return false;
        return (is_array($this->FormBooking[$ft])) ? true : false ;
    }

    /**
     * @param int $ft
     * @return array|bool
     */
    public function getCalanderSheet($ft = 0)
    {
        if(!$ft) return false;
        $this->ft = $ft;

        $objFF = \FormFieldModel::findById($this->FormBooking[$this->ft]['fieldID']);
        $this->Date = new \Date($this->FormBooking[$this->ft]['current'],"Ym");
        $this->cal_startDay = $objFF->cal_startDay;

        return $this->generateSheet();
    }

    /**
     * @param int $ft
     * @return bool
     */
    public function getReservations($ft = 0)
    {
        if(!$ft) return false;
        $this->ft = $ft;

        return $this->FormBooking[$this->ft]['reservation'];
    }

    /**
     * @param int $ft
     * @return array|bool
     */
    public function changeMonth($ft = 0)
    {
        if( !$ft || !is_numeric(\Input::post('data-id')) ) return false;
        $this->ft = $ft;

        $objFF = \FormFieldModel::findById($this->FormBooking[$this->ft]['fieldID']);
        $this->cal_startDay = $objFF->cal_startDay;
        $this->Date = new \Date(\Input::post('data-id'),"Ym");
        $this->FormBooking[$this->ft]['current'] = \Input::post('data-id');

        return $this->generateSheet();
    }

    /**
     * @param int $ft
     * @return bool
     */
    public function addReservation($ft = 0)
    {
        $id = \Input::post('data-id');
        if( !$ft || !is_numeric($id) ) return false;
        $this->ft = $ft;

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
    public function rmReservation($ft = 0)
    {
        $id = \Input::post('data-id');
        if( !$ft || !is_numeric($id) ) return false;
        $this->ft = $ft;

        if(!is_array($this->FormBooking[$this->ft]['reservation'])) return false;

        if( array_key_exists($id,$this->FormBooking[$this->ft]['reservation']) ) unset($this->FormBooking[$this->ft]['reservation'][$id]);

        return $id;
    }

    /**
     * @param int $ft
     * @return bool|mixed
     */
    public function changeOption($ft = 0)
    {
        $id = \Input::post('data-id');
        if( !$ft || !is_numeric($id) ) return false;
        $this->ft = $ft;

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
        $intFirstDayOffset = date('w', $this->Date->monthBegin) - $this->cal_startDay;

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
            $intCurrentDay = ($i + $this->cal_startDay) % 7;

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
            //$tag = \Date::parse("D",$this->Date->tstamp + (86400 * $intDay-1));
            $intKey = date('Ym', $this->Date->tstamp) . ((strlen($intDay) < 2) ? '0' . $intDay : $intDay);
            $strClass .= ($intKey == date('Ymd')) ? ' today' : '';
            $arrDays[$strWeekClass][$strCol]['label'] = $intDay;

            if(is_array($this->FormBooking[$this->ft]['reservation']))
            {
                if(array_key_exists($intKey,$this->FormBooking[$this->ft]['reservation']))
                {
                    $arrDays[$strWeekClass][$strCol]['class'] = 'days selected' . $strClass ;
                } else {
                    $arrDays[$strWeekClass][$strCol]['class'] = 'days empty' . $strClass ;
                }
            } else {
                $arrDays[$strWeekClass][$strCol]['class'] = 'days empty' . $strClass ;
            }
            $arrDays[$strWeekClass][$strCol]['day'] = $intKey;
            $col++;
        }

        return $arrDays;
    }
}
