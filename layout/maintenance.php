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
 * Maintenance layout.
 *
 * @package   theme_president
 * @copyright 2026 Tateta
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$theme = theme_config::load('president');
$loginbgimg = $theme->setting_file_url('loginbgimg', 'loginbgimg');
if (!$loginbgimg) {
    $loginbgimg = (new moodle_url('/theme/president/pix/login-bg.jpg'))->out();
}

$templatecontext = [
    'sitename' => format_string($SITE->fullname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'maintenancedatetime' => get_config('theme_president', 'maintenancedatetime'),
    'loginbgimg' => $loginbgimg,
    'maintenanceimg' => (new moodle_url('/theme/president/pix/maintenance.png'))->out()
];

echo $OUTPUT->render_from_template('theme_president/maintenance', $templatecontext);
