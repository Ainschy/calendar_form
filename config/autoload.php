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
    'Willmes\calendarAjax' => 'system/modules/calendar_form/classes/calendarAjax.php',

	// Forms
    'FormCalendar' => 'system/modules/calendar_form/forms/FormCalendar.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'form_calendarAjax' => 'system/modules/calendar_form/templates',
));
