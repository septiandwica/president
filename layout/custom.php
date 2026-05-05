<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');

$extraclasses = ['uses-drawers'];
$courseindexopen = false;
$blockdraweropen = false;

$secondarynavigation = false;
$overflow = '';
if ($PAGE->has_secondary_navigation()) {
    $secondary = $PAGE->secondarynav;

    if ($secondary->get_children_key_list()) {
        $tablistnav = $PAGE->has_tablist_secondary_navigation();
        $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
        $secondarynavigation = $moremenu->export_for_template($OUTPUT);
        $extraclasses[] = 'has-secondarynavigation';
    }

    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$themesettings = new \theme_president\util\settings();

// Add class for floating navbar consistency.
$bodyattributes = str_replace('class="', 'class="navbar-floating-enabled ', $bodyattributes);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'overflow' => $overflow,
    'themepreference' => theme_president_get_theme_preference(),
];

$templatecontext = array_merge($templatecontext, $themesettings->footer());
$templatecontext = array_merge($templatecontext, $themesettings->navbar());

// Get the custom page content.
$page_type = optional_param('view', '', PARAM_ALPHANUM);
$templatecontext['page_title'] = get_string($page_type, 'theme_president');
$templatecontext['page_content'] = get_config('theme_president', $page_type . '_content');
$templatecontext['main_content'] = $OUTPUT->main_content();

echo $OUTPUT->render_from_template('theme_president/custom_page_layout', $templatecontext);
