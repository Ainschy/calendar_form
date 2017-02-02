<?php


$GLOBALS['TL_DCA']['tl_form_field']['palettes']['form_calendar'] = '{type_legend},type,name,label;{calender_legend},selectCalendar,cal_startDay,calForm;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['selectCalendar'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['selectCalendar'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options_callback'        => array('tl_myform_field', 'getCalendars'),
    'eval'                    => array('mandatory'=>true, 'multiple'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['cal_startDay'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'],
    'default'                 => 1,
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array(0, 1, 2, 3, 4, 5, 6),
    'reference'               => &$GLOBALS['TL_LANG']['DAYS'],
    'eval'                    => array('tl_class'=>'w50'),
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
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(6) NOT NULL default 'month'"
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
    public function getCalendars()
    {
        if (!$this->User->isAdmin && !is_array($this->User->calendars))
        {
            return array();
        }

        $arrCalendars = array();
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


