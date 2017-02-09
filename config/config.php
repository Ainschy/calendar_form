<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   CalendarBookingAjax
 * @author    Oliver Willmes
 * @license   GNU/LGPL
 * @copyright Oliver Willmes 2017
 */

$GLOBALS['TL_FFL']['form_calendar'] = 'FormCalendar';


//define interactiv static form elements
$GLOBALS['CAL_FORM']['elements']['next'] = '<a data-id="<%next.id%>" class="next"><%next.label%> &gt;</a>';
$GLOBALS['CAL_FORM']['elements']['prev'] = '<a data-id="<%prev.id%>" class="prev">&lt; <%prev.label%></a>';
$GLOBALS['CAL_FORM']['elements']['current'] = '<select class="current"><%#current%><%{options}%><%/current%></select>';

//define interactiv dynamic form elements
$GLOBALS['CAL_FORM']['elements']['table_days'] = '<th class="%s">%s</th>';
$GLOBALS['CAL_FORM']['elements']['table_days_week'] = '<th class="%s">%s %s</th>';
$GLOBALS['CAL_FORM']['elements']['empty'] = '<div class="empty">&nbsp;</div>';

// items in month-year select field
$GLOBALS['CAL_FORM']['elements']['selectable_month'] = '8';
$GLOBALS['CAL_FORM']['elements']['selectable_weeks'] = '8';
$GLOBALS['CAL_FORM']['elements']['month_format_prev-next'] = 'M Y';
$GLOBALS['CAL_FORM']['elements']['month_format_current'] = 'F Y';
$GLOBALS['CAL_FORM']['elements']['week_format_prev-next'] = 'W';
$GLOBALS['CAL_FORM']['elements']['week_format_current'] = 'W';

$GLOBALS['CAL_FORM']['elements']['day_option_label'] = '%s';
$GLOBALS['CAL_FORM']['elements']['day_option_label_min'] = '%s <span>%smin</span>';

$GLOBALS['CAL_FORM']['elements']['month_week'] = '<%#week%><tr class="week"><%{days}%></tr><%/week%>';
$GLOBALS['CAL_FORM']['elements']['month_day'] = '<td><div class="inside %s" data-id="%s">%s</div></td>';
$GLOBALS['CAL_FORM']['elements']['week_day'] = '<div class="%s" data-id="%s">%s</div>';
$GLOBALS['CAL_FORM']['elements']['btn_remove'] = '<button type="button" data-id="%s" class="remove">&times;</button>';
$GLOBALS['CAL_FORM']['elements']['li_content'] = '<span class="datum"><%datum%></span><%#options%><%{option}%><%/options%>';
$GLOBALS['CAL_FORM']['elements']['res_list'] = '<li data-id="<%id%>"><%{btn_remove}%></li>';

// define css classes
$GLOBALS['CAL_FORM']['status_class']['bookable'] = 'bookable';
$GLOBALS['CAL_FORM']['status_class']['blocked'] = 'blocked';
$GLOBALS['CAL_FORM']['status_class']['selected'] = 'selected';
$GLOBALS['CAL_FORM']['status_class']['free'] = 'free';
$GLOBALS['CAL_FORM']['status_class']['reserved'] = 'reserved';
$GLOBALS['CAL_FORM']['status_class']['notavailable'] = 'notavailable';
$GLOBALS['CAL_FORM']['status_class']['partially'] = 'partially';