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

require_once(__DIR__ . '/../../config.php');

$view = optional_param('view', 'programs', PARAM_ALPHANUM);

$PAGE->set_url(new moodle_url('/theme/president/view.php', ['view' => $view]));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('custom');
$PAGE->set_title(get_string($view, 'theme_president'));
$PAGE->set_heading(get_string($view, 'theme_president'));

echo $OUTPUT->header();
echo $OUTPUT->footer();
