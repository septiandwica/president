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
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language file.
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

$themesettings = new \theme_president\util\settings();
$customcourses = $themesettings->frontpage_custom_courses();

// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();

if (isloggedin()) {
    $courseindexopen = (get_user_preferences('drawer-open-index', true) == true);
    $blockdraweropen = (get_user_preferences('drawer-open-block') == true);
} else {
    $courseindexopen = false;
    $blockdraweropen = false;
}

if (defined('BEHAT_SITE_RUNNING') && get_user_preferences('behat_keep_drawer_closed') != 1) {
    $blockdraweropen = true;
}

$extraclasses = ['uses-drawers'];
if ($courseindexopen) {
    $extraclasses[] = 'drawer-open-index';
}
if (!empty($customcourses['frontpage_courses_enable'])) {
    $extraclasses[] = 'theme-custom-courses-enabled';
}

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
if (!$hasblocks) {
    $blockdraweropen = false;
}
$courseindex = core_course_drawer();
if (!$courseindex) {
    $courseindexopen = false;
}

$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

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

// Add Quick Management to primary navigation if authorized.
$managementitems = \theme_president_get_management_menu();
if ($managementitems && !empty($managementitems['items'])) {
    $primarynav = $PAGE->primarynav;
    $managenode = $primarynav->add('Quick Management', null, \navigation_node::TYPE_CONTAINER, null, 'quick_management');
    $managenode->showinflatnavigation = true;
    
    $currenturl = $PAGE->url->out_as_local_url(false);
    foreach ($managementitems['items'] as $item) {
        $node = $managenode->add($item['text'], $item['url'], \navigation_node::TYPE_SETTING);
        // Check if this item is the current page.
        if (strpos($currenturl, $item['url']->out_as_local_url(false)) !== false) {
            $extraclasses[] = 'is-quick-management';
        }
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions() && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
if ($themesettings->navbartype === 'floating') {
    $bodyattributes = str_replace('class="', 'class="navbar-floating-enabled ', $bodyattributes);
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'courseindexopen' => $courseindexopen,
    'blockdraweropen' => $blockdraweropen,
    'courseindex' => $courseindex,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'forceblockdraweropen' => $forceblockdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'overflow' => $overflow,
    'headercontent' => $headercontent,
    'addblockbutton' => $addblockbutton,
    'management_menu' => theme_president_get_management_menu(),
    'themepreference' => theme_president_get_theme_preference(),
];

if (!empty($customcourses['frontpage_courses_enable'])) {
    $templatecontext['frontpage_custom_courses_html'] = $OUTPUT->render_from_template('theme_president/custom_courses_block', $customcourses);
} else {
    $templatecontext['frontpage_custom_courses_html'] = '';
}

$templatecontext = array_merge($templatecontext, $themesettings->footer());
$templatecontext = array_merge($templatecontext, $themesettings->navbar());

// Generate logged-in user frontpage data.
if (isloggedin() && !isguestuser()) {
    global $USER, $DB;

    // Welcome section data.
    $hour = date('G');
    if ($hour < 12) {
        $greeting = get_string('goodmorning', 'theme_president');
    } else if ($hour < 18) {
        $greeting = get_string('goodafternoon', 'theme_president');
    } else {
        $greeting = get_string('goodevening', 'theme_president');
    }

    // Get active courses count.
    $enrolledcourses = enrol_get_my_courses(['id', 'fullname', 'visible'], 'visible DESC, fullname ASC');
    $activecourses = array_filter($enrolledcourses, function($course) {
        return $course->visible == 1;
    });
    $activecoursescount = count($activecourses);

    // Get pending assignments (simplified).
    $pendingassignments = 0;
    try {
        $sql = "SELECT COUNT(DISTINCT a.id)
                FROM {assign} a
                JOIN {course_modules} cm ON cm.instance = a.id AND cm.module = (SELECT id FROM {modules} WHERE name = 'assign')
                JOIN {course} c ON c.id = a.course
                JOIN {enrol} e ON e.courseid = c.id
                JOIN {user_enrolments} ue ON ue.enrolid = e.id AND ue.userid = :userid
                LEFT JOIN {assign_submission} asub ON asub.assignment = a.id AND asub.userid = :userid2
                WHERE a.duedate > :now
                AND (asub.id IS NULL OR asub.status <> 'submitted')
                AND cm.visible = 1";
        $pendingassignments = $DB->count_records_sql($sql, [
            'userid' => $USER->id,
            'userid2' => $USER->id,
            'now' => time()
        ]);
    } catch (Exception $e) {
        // Silently fail if assign module not available.
        $pendingassignments = 0;
    }

    // Get new messages count.
    $newmessages = 0;
    if (class_exists('\core_message\api')) {
        $newmessages = \core_message\api::count_unread_conversations($USER);
    }

    // Statistics section data.
    $coursescompleted = 0;
    $totallearninghours = 0;
    $averagegrade = 0;
    $certificatesearned = 0;

    // Get completed courses.
    foreach ($enrolledcourses as $course) {
        $completion = new \completion_info($course);
        if ($completion->is_enabled() && $completion->is_course_complete($USER->id)) {
            $coursescompleted++;
        }
    }

    // Calculate learning hours (simplified estimate based on course activities).
    $totallearninghours = count($enrolledcourses) * 40; // Rough estimate.

    // Calculate average grade.
    $gradeitems = $DB->get_records_sql(
        "SELECT gg.id, gg.finalgrade, gi.grademax, gi.grademin
         FROM {grade_grades} gg
         JOIN {grade_items} gi ON gi.id = gg.itemid
         WHERE gg.userid = :userid
         AND gi.itemtype = 'course'
         AND gg.finalgrade IS NOT NULL",
        ['userid' => $USER->id]
    );

    if (!empty($gradeitems)) {
        $totalpercentage = 0;
        $gradecount = 0;
        foreach ($gradeitems as $item) {
            $percentage = (($item->finalgrade - $item->grademin) / ($item->grademax - $item->grademin)) * 100;
            $totalpercentage += $percentage;
            $gradecount++;
        }
        $averagegrade = $gradecount > 0 ? round($totalpercentage / $gradecount) : 0;
    }

    // Get certificates (if customcert module exists).
    if ($DB->get_manager()->table_exists('customcert_issues')) {
        $certificatesearned = $DB->count_records('customcert_issues', ['userid' => $USER->id]);
    }

    // Get custom content from settings.
    $frontpagecustomcontent = get_config('theme_president', 'frontpage_loggedin_content');

    // Build welcome context.
    $welcomecontext = [
        'greeting_time' => $greeting,
        'user_firstname' => $USER->firstname,
        'user_fullname' => fullname($USER),
        'site_fullname' => format_string($SITE->fullname),
        'active_courses_count' => $activecoursescount,
        'pending_assignments' => $pendingassignments,
        'new_messages' => $newmessages,
        'dashboard_url' => new moodle_url('/my/'),
        'my_courses_url' => new moodle_url('/my/courses.php'),
    ];

    // Build statistics context.
    $statscontext = [
        'total_courses_completed' => $coursescompleted,
        'courses_completion_percentage' => min(100, $coursescompleted * 10),
        'total_learning_hours' => $totallearninghours,
        'hours_progress_percentage' => min(100, floor($totallearninghours / 10)),
        'current_average_grade' => $averagegrade,
        'certificates_earned' => $certificatesearned,
        'certificates_percentage' => min(100, $certificatesearned * 20),
        'achievements' => [], // Can be extended with badges if needed.
    ];

    // Custom content context.
    $customcontentcontext = [
        'frontpage_custom_content' => !empty($frontpagecustomcontent) ? format_text($frontpagecustomcontent, FORMAT_HTML) : '',
    ];

    // Render sections.
    $templatecontext['frontpage_welcome_html'] = $OUTPUT->render_from_template('theme_president/frontpage_welcome', $welcomecontext);
    $templatecontext['frontpage_statistics_html'] = $OUTPUT->render_from_template('theme_president/frontpage_statistics', $statscontext);
    $templatecontext['frontpage_custom_content_html'] = $OUTPUT->render_from_template('theme_president/frontpage_custom_content', $customcontentcontext);
}

if (isloggedin()) {
    // For logged in users on frontpage, also use normal navbar.
    $templatecontext = array_merge($templatecontext, $themesettings->navbar());
    $templatecontext['navbartype'] = 'normal';
    $templatecontext['is_floating'] = false;
    $templatecontext['is_normal'] = true;

    echo $OUTPUT->render_from_template('theme_president/drawers', $templatecontext);
} else {
    $templatecontext = array_merge($templatecontext, $themesettings->frontpage());
    $templatecontext = array_merge($templatecontext, $themesettings->navbar());

    echo $OUTPUT->render_from_template('theme_president/frontpage', $templatecontext);
}
