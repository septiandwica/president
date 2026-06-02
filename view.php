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

require_once(__DIR__ . '/../../config.php');

$view = optional_param('view', 'programs', PARAM_ALPHANUMEXT);
$page = optional_param('page', 0, PARAM_INT);

$PAGE->set_context(context_system::instance());
$themesettings = new \theme_president\util\settings();

// Check if this is a courses listing page (based on frontpage_courses_title setting)
$courses_title = get_config('theme_president', 'frontpage_courses_title');
if (empty($courses_title)) {
    $courses_title = get_string('frontpage_courses_title_default', 'theme_president');
}

$courses_slug = '';
if (method_exists($themesettings, 'slugify')) {
    // Use reflection to access protected method
    $reflection = new ReflectionClass($themesettings);
    $method = $reflection->getMethod('slugify');
    $method->setAccessible(true);
    $courses_slug = $method->invoke($themesettings, $courses_title);
}

// If this matches the courses slug, show courses listing
if ($view === $courses_slug && !empty($courses_slug)) {
    // Include courses listing logic
    require_once(__DIR__ . '/courses.php');
    exit;
}

// Otherwise, show custom guest page
$PAGE->set_url(new moodle_url('/theme/president/view.php', ['view' => $view]));
$PAGE->set_pagelayout('custom');
$pagetitle = $themesettings->guest_page_title($view);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($pagetitle);

echo $OUTPUT->header();
// Content is handled by the layout and template via page_content.
echo $OUTPUT->footer();
