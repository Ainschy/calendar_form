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

$GLOBALS['TL_LANG']['FFL']['formcalendar'] = ['Kalender', 'Stellt einen Kalenderansicht zur Auswahl von Terminen bereit.'];

/**
 * Fields
 */

$GLOBALS['TL_LANG']['tl_form_field']['calender_legend'] = 'Kalender Einstellungen';
$GLOBALS['TL_LANG']['tl_form_field']['selectCalendar'] = ['Kalender', 'Wählen Sie einen oder mehrere Kalender zur Buchung aus.'];
$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'] = ['Wochenstart', 'Wählen Sie den Tag an dem die Wochen beginnen soll.'];

$GLOBALS['TL_LANG']['tl_form_field']['calForm'] = ['Kalenderdarstellung', 'Wählen die passende Darstellung aus.'];
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['month'] = 'Monat';
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['week']  = 'Woche';
$GLOBALS['TL_LANG']['tl_form_field']['getCalender']['default'] = 'ohne Kalender';
$GLOBALS['TL_LANG']['tl_form_field']['calSetReservation']['1'] = 'eintragen ohne Aktivierung';
$GLOBALS['TL_LANG']['tl_form_field']['calSetReservation']['2'] = 'eintragen mit Aktivierung';


$GLOBALS['TL_LANG']['tl_form_field']['calLogicMonth'] = array('Max. Auswahl', 'Schränkt die maximal buchbaren Tage ein. 0=keine Einschränkung');
$GLOBALS['TL_LANG']['tl_form_field']['calLogicWeek'] = array('Auswahlregel', 'Schränke die Auwahl ein.');
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['onlyOne'] = '1 Termin';
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['onePerDay'] = '1 Termin pro Tag';
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['multiPerDay'] = 'x Termine pro Tag';

$GLOBALS['TL_LANG']['tl_form_field']['calRange'] = array('Zeitraum', 'Start- und Enddatum bilden eine Zeitraum.');

$GLOBALS['TL_LANG']['tl_form_field']['available'] = array('Auswahl (Uhrzeit/Minuten)', 'Uhrzeit und Dauer in Minuten. Format 08:00/60 bedeutet: 8.00 Uhr für 60 Minuten');
$GLOBALS['TL_LANG']['tl_form_field']['exceptions'] = array('Ausnahmen (Datum von - bis)', 'Ausnahmen verhindern die Auswahl und Buchung an den betreffenden Tagen.');
$GLOBALS['TL_LANG']['tl_form_field']['startdate'] = array('Beginn', '');
$GLOBALS['TL_LANG']['tl_form_field']['enddate'] = array('Ende', '');

$GLOBALS['TL_LANG']['tl_form_field']['monday'] = array('Montags', '');
$GLOBALS['TL_LANG']['tl_form_field']['tuesday'] = array('Dienstags', '');
$GLOBALS['TL_LANG']['tl_form_field']['wednesday'] = array('Mittwochs', '');
$GLOBALS['TL_LANG']['tl_form_field']['thursday'] = array('Donnerstags', '');
$GLOBALS['TL_LANG']['tl_form_field']['friday'] = array('Freitags', '');
$GLOBALS['TL_LANG']['tl_form_field']['saturday'] = array('Samstags', '');
$GLOBALS['TL_LANG']['tl_form_field']['sunday'] = array('Sonntag', '');

$GLOBALS['TL_LANG']['tl_form_field']['removeAll'] = 'Auswahl löschen';