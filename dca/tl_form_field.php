<?php


$GLOBALS['TL_DCA']['tl_form_field']['palettes']['form_calendar'] = '{type_legend},type,name,label;{calender_legend},selectCalendar,cal_startDay,calForm;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl';

$GLOBALS['TL_DCA']['tl_form_field']['subpalettes'] = array(
    'calForm_month' => 'calLogicMonth,calRange',
    'calForm_week' => 'calLogicWeek,available,exceptions'
);

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'calForm';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['selectCalendar'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['selectCalendar'],
    'exclude'                 => true,
    'inputType' => 'radio',
    'options_callback' => array('tl_myform_field', 'getCalendar'),
    'sql' => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['cal_startDay'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'],
    'default'                 => 1,
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array(0, 1, 2, 3, 4, 5, 6),
    'reference'               => &$GLOBALS['TL_LANG']['DAYS'],
    'eval' => array('tl_class' => 'clr w50'),
    'sql'                     => "smallint(5) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calForm'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['calForm'],
    'default'                 => 1,
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('month','week'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['calForms'],
    'eval' => array('tl_class' => 'w50', 'submitOnChange' => true),
    'sql'                     => "varchar(6) NOT NULL default 'month'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calLogicWeek'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['calLogicWeek'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('onlyOne', 'onePerDay', 'multiPerDay'),
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['calLogics'],
    'eval' => array('tl_class' => 'clr w50'),
    'sql' => "varchar(6) NOT NULL default 'month'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calLogicMonth'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['calLogicMonth'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'clr w50', 'rgxp' => 'natural'),
    'sql' => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calRange'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['calRange'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50 m12'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['available'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['available'],
    'inputType' => 'multiColumnWizard',
    'exclude' => true,
    'eval' => array
    (
        'tl_class' => 'm12 clr',
        'columnFields' => array
        (
            'mon' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['monday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'tue' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['tuesday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'wed' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['wednesday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'thu' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['thursday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'fri' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['friday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'sat' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['saturday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
            'sun' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['sunday'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:70px')
            ),
        ),
    ),
    'sql' => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['exceptions'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['exceptions'],
    'inputType' => 'multiColumnWizard',
    'exclude' => true,
    'eval' => array
    (
        'tl_class' => 'm12 clr',
        'columnFields' => array
        (
            'startdate' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['startdate'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:68px', 'rgxp' => 'date', 'datepicker' => true, 'tl_class' => 'wizard')
            ),
            'enddate' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['enddate'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:68px', 'rgxp' => 'date', 'datepicker' => true, 'tl_class' => 'wizard')
            ),
        ),
    ),
    'sql' => "blob NULL",
);

class tl_myform_field extends tl_form_field
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Get all calendars and return them as array
     *
     * @return array
     */
    public function getCalendar()
    {
        if (!$this->User->isAdmin && !is_array($this->User->calendars))
        {
            return array();
        }

        $arrCalendars = array('0' => &$GLOBALS['TL_LANG']['tl_form_field']['getCalender']['default']);
        $objCalendars = $this->Database->execute("SELECT id, title FROM tl_calendar ORDER BY title");

        while ($objCalendars->next())
        {
            if ($this->User->hasAccess($objCalendars->id, 'calendars'))
            {
                $arrCalendars[$objCalendars->id] = $objCalendars->title;
            }
        }

        return $arrCalendars;
    }
}


