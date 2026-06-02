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
 * Full courses listing page with pagination
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$page = optional_param('page', 0, PARAM_INT);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/theme/president/courses.php', ['page' => $page]);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('courses'));
$PAGE->set_heading(get_string('courses'));

$themesettings = new \theme_president\util\settings();
$courseutil = new \theme_president\util\course_pagination();

// Get pagination settings
$per_page = get_config('theme_president', 'frontpage_courses_per_page');
if ($per_page === false || $per_page === '') {
    $per_page = 9;
} else {
    $per_page = intval($per_page);
}

// Get filter mode and settings
$mode = get_config('theme_president', 'frontpage_courses_select_mode');
if ($mode === false) {
    $mode = 0;
}

// Get courses with pagination
$result = $courseutil->get_courses_paginated($mode, $page, $per_page);

$courses = $result['courses'];
$total = $result['total'];
$total_pages = ceil($total / $per_page);

// Format courses for template
$formattedcourses = [];
$chelper = new coursecat_helper();
$renderer = $PAGE->get_renderer('core');

foreach ($courses as $c) {
    $courseobj = new core_course_list_element($c);
    $courseutilobj = new \theme_president\util\course($courseobj);
    $coursecontacts = $courseutilobj->get_course_contacts();

    $courseenrolmenticons = $courseutilobj->get_enrolment_icons();
    $enrolmenticonshtml = [];
    if (!empty($courseenrolmenticons)) {
        foreach ($courseenrolmenticons as $icon) {
            $enrolmenticonshtml[] = $renderer->render($icon);
        }
    }

    $courseprogress = $courseutilobj->get_progress();
    $hasprogress = $courseprogress !== null;

    if (class_exists('\local_course\output\index')) {
        $courseurl = new moodle_url('/local/course/index.php', ['id' => $c->id]);
    } else {
        $courseurl = new moodle_url('/course/view.php', ['id' => $c->id]);
    }

    $formattedcourses[] = [
        'id' => $c->id,
        'fullname' => $chelper->get_course_formatted_name($courseobj),
        'visible' => $c->visible,
        'image' => $courseutilobj->get_summary_image(),
        'summary' => $courseutilobj->get_summary($chelper),
        'category' => $courseutilobj->get_category(),
        'customfields' => $courseutilobj->get_custom_fields(),
        'hasprogress' => $hasprogress,
        'progress' => (int) $courseprogress,
        'hasenrolmenticons' => !empty($enrolmenticonshtml),
        'enrolmenticons' => $enrolmenticonshtml,
        'hascontacts' => !empty($coursecontacts),
        'contacts' => $coursecontacts,
        'courseurl' => $courseurl->out(false),
    ];
}

// Build pagination
$pagination = [];
if ($total_pages > 1) {
    // Previous button
    if ($page > 0) {
        $pagination['has_prev'] = true;
        $pagination['prev_url'] = new moodle_url('/theme/president/courses.php', ['page' => $page - 1]);
    }

    // Page numbers
    $pages = [];
    $start = max(0, $page - 2);
    $end = min($total_pages - 1, $page + 2);

    if ($start > 0) {
        $pages[] = [
            'number' => 1,
            'url' => new moodle_url('/theme/president/courses.php', ['page' => 0]),
            'active' => false,
        ];
        if ($start > 1) {
            $pages[] = ['ellipsis' => true];
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        $pages[] = [
            'number' => $i + 1,
            'url' => new moodle_url('/theme/president/courses.php', ['page' => $i]),
            'active' => ($i == $page),
        ];
    }

    if ($end < $total_pages - 1) {
        if ($end < $total_pages - 2) {
            $pages[] = ['ellipsis' => true];
        }
        $pages[] = [
            'number' => $total_pages,
            'url' => new moodle_url('/theme/president/courses.php', ['page' => $total_pages - 1]),
            'active' => false,
        ];
    }

    $pagination['pages'] = $pages;

    // Next button
    if ($page < $total_pages - 1) {
        $pagination['has_next'] = true;
        $pagination['next_url'] = new moodle_url('/theme/president/courses.php', ['page' => $page + 1]);
    }
}

$title = get_config('theme_president', 'frontpage_courses_title');
if (empty($title)) {
    $title = get_string('courses');
}

$templatecontext = [
    'courses' => $formattedcourses,
    'has_courses' => !empty($formattedcourses),
    'pagination' => $pagination,
    'has_pagination' => !empty($pagination),
    'page_title' => $title,
    'total_courses' => $total,
    'showing_start' => ($page * $per_page) + 1,
    'showing_end' => min(($page + 1) * $per_page, $total),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('theme_president/courses_page', $templatecontext);
echo $OUTPUT->footer();
