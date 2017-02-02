<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'CalendarBookingAjax',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'CalendarBookingAjax\CalendarBookingModule'     => 'system/modules/calendarbookingajax/classes/CalendarBookingModule.php',
	'CalendarBookingAjax\CalendarSheet'             => 'system/modules/calendarbookingajax/classes/CalendarSheet.php',

	// Forms
	'FormCalendar'                                  => 'system/modules/calendarbookingajax/forms/FormCalendar.php',

	// Modules
	'CalendarBookingAjax\ModuleCalendarBookingAjax' => 'system/modules/calendarbookingajax/modules/ModuleCalendarBookingAjax.php',

	// Public
	'CalendarBookingAjax\formAjax'                  => 'system/modules/calendarbookingajax/public/formAjax.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_calendar'           => 'system/modules/calendarbookingajax/templates',
	'mod_calendarBookingAjax' => 'system/modules/calendarbookingajax/templates',
));
