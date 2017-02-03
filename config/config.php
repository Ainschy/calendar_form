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


//define interactiv form elements
$GLOBALS['CAL_FORM']['elements']['checkbox'] = '<input type="checkbox" class="option" name="%s" value="%s" id="%s"><label for="%s">%s</label>';
$GLOBALS['CAL_FORM']['elements']['radiobutton'] = '<input type="radio" class="option" name="%s" value="%s" id="%s"><label for="%s">%s</label>';
$GLOBALS['CAL_FORM']['elements']['next'] = '<a data-id="<%next.id%>" class="next"><%next.label%> &gt;</a>';
$GLOBALS['CAL_FORM']['elements']['prev'] = '<a data-id="<%prev.id%>" class="prev">&lt; <%prev.label%></a>';
$GLOBALS['CAL_FORM']['elements']['current'] = '<%current.label%>';
$GLOBALS['CAL_FORM']['elements']['week_day'] = '';
$GLOBALS['CAL_FORM']['elements']['month_week'] = '<%#week%><tr class="week"><%/{days}%></tr><%/week%>';
$GLOBALS['CAL_FORM']['elements']['month_day'] = '<td class="<%col_<?= $j ?>.class%>"><div class="inside" data-id="<%col_<?= $j ?>.day%>"><%col_<?= $j ?>.label%></div></td>';
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