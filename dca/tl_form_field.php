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

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['formcalendar'] = '{type_legend},type,name,label;{calender_legend},cal_startDay,calForm,exceptions,calChoise;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl';

$GLOBALS['TL_DCA']['tl_form_field']['subpalettes'] = array(
    'calForm_month' => 'calLogicMonth,calRange'
);

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'calForm';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['cal_startDay'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'select',
    'options' => array(0, 1, 2, 3, 4, 5, 6),
    'reference' => &$GLOBALS['TL_LANG']['DAYS'],
    'eval' => array('tl_class' => 'clr w50'),
    'sql' => "smallint(5) unsigned NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calForm'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['calForm'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('month'),
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['calForms'],
    'eval' => array('tl_class' => 'w50', 'submitOnChange' => true),
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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['calChoise'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['calChoise_label'],
    'exclude' => true,
    'default' => 'selection',
    'inputType' => 'radio',
    'options' => array('selection', 'exception'),
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['calChoise'],
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['exceptions'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['exceptions'],
    'inputType' => 'multiColumnWizard',
    'exclude' => true,
    'eval' => array
    (
        'tl_class' => 'clr w50',
        'columnFields' => array
        (
            'startdate' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['startdate'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:90px', 'rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'wizard')
            ),
            'enddate' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_form_field']['enddate'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => array('style' => 'width:90px', 'rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'wizard')
            ),
        ),
    ),
    'sql' => "blob NULL",
);


