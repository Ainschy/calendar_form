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
$GLOBALS['TL_LANG']['tl_form_field']['calenderpro_legend'] = 'Abhängigkeiten und Buchungen';
$GLOBALS['TL_LANG']['tl_form_field']['selectCalendar'] = ['Kalender', 'Wählen Sie einen oder mehrere Kalender zur Buchung aus.'];
$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'] = ['Wochenstart', 'Wählen Sie den Tag an dem die Wochen beginnen soll.'];

$GLOBALS['TL_LANG']['tl_form_field']['calForm'] = ['Kalenderdarstellung', 'Wählen die passende Darstellung aus.'];
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['month'] = 'Monat';
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['week'] = 'Woche';
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

// Kopfbereich der Tabelle
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['removeAll'] = 'Auswahl löschen';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['next'] = '<a data-id="<%next.id%>" class="next"><%next.label%> &gt;</a>';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['prev'] = '<a data-id="<%prev.id%>" class="prev">&lt; <%prev.label%></a>';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['current'] = '<select class="current"><%#current%><%{options}%><%/current%></select>';

// Tabellen Inhalte
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['table_days'] = '<th class="%s">%s</th>';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['table_days_week'] = '<th class="%s">%s %s</th>';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['empty'] = '<div class="empty">&nbsp;</div>';

$GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_day'] = '<td><div class="inside %s" data-id="%s">%s</div></td>';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_day'] = '<div class="%s" data-id="%s">%s</div>';

$GLOBALS['TL_LANG']['CAL_FORM']['elements']['day_option_label'] = '%s';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['day_option_label_min'] = '%s <span>%smin</span>';

$GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_prev-next'] = 'M Y';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_current'] = 'F Y';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_prev-next'] = 'W';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_current'] = 'KW %s (%s - %s)';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_current_option'] = 'W';