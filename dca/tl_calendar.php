<?php
/**
 * Created by PhpStorm.
 * User: Ainschy
 * Date: 17.04.2015
 * Time: 12:43
 */
$GLOBALS['TL_DCA']['tl_calendar']['palettes']['default'] = str_replace(',jumpTo;', ',jumpTo;{booking_legend},available,exceptions;', $GLOBALS['TL_DCA']['tl_calendar']['palettes']['default']);



$GLOBALS['TL_DCA']['tl_calendar']['fields']['available'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_calendar']['available'],
    'inputType' => 'multiColumnWizard',
    'exclude' => true,
    'eval' => array
    (
        'tl_class' => 'm12 clr',
        'columnFields' => array
        (
            'monday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['monday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'tuesday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['tuesday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'wednesday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['wednesday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'thursday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['thursday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'friday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['friday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'saturday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['saturday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
            'sunday' => array
            (
                'label'			=> &$GLOBALS['TL_LANG']['tl_calendar']['sunday'],
                'exclude' 		=> true,
                'inputType' 	=> 'text',
                'eval' 			=> array('style' => 'width:70px')
            ),
        ),
    ),
    'sql' => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_calendar']['fields']['exceptions'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_calendar']['exceptions'],
    'inputType' => 'multiColumnWizard',
    'exclude' => true,
    'eval' => array
    (
        'tl_class' => 'm12 clr',
        'columnFields' => array
        (
            'startdate' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_calendar']['startdate'],
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('style' => 'width:68px', 'rgxp' => 'date', 'datepicker'=>true, 'tl_class'=>'wizard')
            ),
            'enddate' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_calendar']['enddate'],
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('style' => 'width:68px', 'rgxp' => 'date', 'datepicker'=>true, 'tl_class'=>'wizard')
            ),
        ),
    ),
    'sql' => "blob NULL",
);