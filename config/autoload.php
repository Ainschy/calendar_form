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
    'Willmes',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    'Willmes\calendarBookingAjax' => 'system/modules/form_calendarBooking/classes/calendarBookingAjax.php',

	// Forms
    'form_calendarBooking' => 'system/modules/form_calendarBooking/forms/form_calendarBooking.php',

	// Public
    'Willmes\formAjax' => 'system/modules/form_calendarBooking/public/formAjax.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'form_calendarBookingAjax' => 'system/modules/form_calendarBooking/templates',
));
