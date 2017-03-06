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

$GLOBALS['TL_LANG']['FFL']['formcalendar'] = ['Calendar', 'Provides a calendar view to select appointments.'];

/**
 * Fields
 */

$GLOBALS['TL_LANG']['tl_form_field']['calender_legend'] = 'Calendar settings';
$GLOBALS['TL_LANG']['tl_form_field']['calenderpro_legend'] = 'Dependencies and bookings';
$GLOBALS['TL_LANG']['tl_form_field']['selectCalendar'] = ['Calendar', 'Select one or more calendars to book.'];
$GLOBALS['TL_LANG']['tl_form_field']['cal_startDay'] = ['Start day of the week', 'Select the day on which the week starts.'];

$GLOBALS['TL_LANG']['tl_form_field']['calForm'] = ['Calendar display', 'Select the appropriate display.'];
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['month'] = 'Month';
$GLOBALS['TL_LANG']['tl_form_field']['calForms']['week'] = 'Week';
$GLOBALS['TL_LANG']['tl_form_field']['getCalender']['default'] = 'no calendar';
$GLOBALS['TL_LANG']['tl_form_field']['calSetReservation']['1'] = 'without activation';
$GLOBALS['TL_LANG']['tl_form_field']['calSetReservation']['2'] = 'with activation';

$GLOBALS['TL_LANG']['tl_form_field']['calChoise_label'] = ['limitations'];
$GLOBALS['TL_LANG']['tl_form_field']['calChoise']['selection'] = 'Selection - only defined appointments are selectable.';
$GLOBALS['TL_LANG']['tl_form_field']['calChoise']['exception'] = 'Exceptions - Exceptions are not bookable, e.g. Holidays / Holidays';

$GLOBALS['TL_LANG']['tl_form_field']['calLogicMonth'] = ['Max. Selection', 'Restricts the maximum bookable days. 0 = no restriction'];
$GLOBALS['TL_LANG']['tl_form_field']['calLogicWeek'] = ['Selection rule', 'Enter the selection.'];
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['onlyOne'] = 'only one appointment';
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['onePerDay'] = 'only one appointment per day';
$GLOBALS['TL_LANG']['tl_form_field']['calLogics']['multiPerDay'] = 'multi appointment per day';

$GLOBALS['TL_LANG']['tl_form_field']['calRange'] = ['Period of time', 'Start and end dates are a period.'];

$GLOBALS['TL_LANG']['tl_form_field']['available'] = ['Define selection', 'The following formats are supported: 08:00, 08:00/60, 08:00-09:00'];
$GLOBALS['TL_LANG']['tl_form_field']['exceptions'] = ['Selection / Exceptions (Date from - to)', 'Selection / exceptions define bookable or blocked times.'];
$GLOBALS['TL_LANG']['tl_form_field']['startdate'] = ['Start', ''];
$GLOBALS['TL_LANG']['tl_form_field']['enddate'] = ['End', ''];

$GLOBALS['TL_LANG']['tl_form_field']['calOutput'] = ['Date format in the email', 'The date format string is parsed using the PHP function date ().'];
$GLOBALS['TL_LANG']['tl_form_field']['calOutputTime'] = ['Time format in the email', 'The time format string is parsed using the PHP function date ().'];

$GLOBALS['TL_LANG']['tl_form_field']['monday'] = ['Monday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['tuesday'] = ['Tuesday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['wednesday'] = ['Wednesday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['thursday'] = ['Thursday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['friday'] = ['Friday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['saturday'] = ['Saturday', ''];
$GLOBALS['TL_LANG']['tl_form_field']['sunday'] = ['Sunday', ''];

// Kopfbereich der Tabelle
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['removeAll'] = 'Deselect
';
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
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['day_option_label_end'] = '%s - %s';

$GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_prev-next'] = 'M Y';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['month_format_current'] = 'F Y';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_prev-next'] = 'W';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_current'] = 'Week %s (%s - %s)';
$GLOBALS['TL_LANG']['CAL_FORM']['elements']['week_format_current_option'] = 'W';