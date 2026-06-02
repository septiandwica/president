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
 * Course pagination utility class
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_president\util;

/**
 * Course pagination utility class
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_pagination {

    /**
     * Get paginated courses based on filter mode
     *
     * @param int $mode Filter mode (0=all, 1=newest, 2=manual, 3=category)
     * @param int $page Page number (0-indexed)
     * @param int $per_page Items per page
     * @return array ['courses' => array, 'total' => int]
     */
    public function get_courses_paginated($mode, $page, $per_page) {
        global $DB;

        $page = intval($page);
        $per_page = intval($per_page);
        $offset = $page * $per_page;

        $courses = [];
        $total = 0;

        if ($mode == 0) {
            // Show all available courses
            $total = $DB->count_records_select('course', 'visible = 1 AND id <> :siteid', ['siteid' => SITEID]);
            $courses = $DB->get_records_select(
                'course',
                'visible = 1 AND id <> :siteid',
                ['siteid' => SITEID],
                'fullname ASC',
                '*',
                $offset,
                $per_page
            );
        } else if ($mode == 1) {
            // Show newest courses first
            $total = $DB->count_records_select('course', 'visible = 1 AND id <> :siteid', ['siteid' => SITEID]);
            $courses = $DB->get_records_select(
                'course',
                'visible = 1 AND id <> :siteid',
                ['siteid' => SITEID],
                'id DESC',
                '*',
                $offset,
                $per_page
            );
        } else if ($mode == 2) {
            // Show specific courses (manual selection)
            $selected = get_config('theme_president', 'frontpage_courses_selected');
            if (!empty($selected)) {
                $ids = explode(',', $selected);
                $ids = array_filter(array_map('intval', $ids));
                if (!empty($ids)) {
                    list($insql, $inparams) = $DB->get_in_or_equal($ids, SQL_PARAMS_NAMED, 'param');
                    $inparams['siteid'] = SITEID;

                    $total = $DB->count_records_select(
                        'course',
                        "visible = 1 AND id <> :siteid AND id $insql",
                        $inparams
                    );

                    $records = $DB->get_records_select(
                        'course',
                        "visible = 1 AND id <> :siteid AND id $insql",
                        $inparams,
                        ''
                    );

                    if ($records) {
                        // Order to match the manual select order
                        $ordered = [];
                        foreach ($ids as $id) {
                            if (isset($records[$id])) {
                                $ordered[$id] = $records[$id];
                            }
                        }
                        // Apply pagination to ordered array
                        $courses = array_slice($ordered, $offset, $per_page, true);
                    }
                }
            }
        } else if ($mode == 3) {
            // Show courses from selected categories
            $categories = get_config('theme_president', 'frontpage_courses_categories');
            if (!empty($categories)) {
                $catids = explode(',', $categories);
                $catids = array_filter(array_map('intval', $catids));
                if (!empty($catids)) {
                    list($insql, $inparams) = $DB->get_in_or_equal($catids, SQL_PARAMS_NAMED, 'param');
                    $inparams['siteid'] = SITEID;

                    $total = $DB->count_records_select(
                        'course',
                        "visible = 1 AND id <> :siteid AND category $insql",
                        $inparams
                    );

                    $courses = $DB->get_records_select(
                        'course',
                        "visible = 1 AND id <> :siteid AND category $insql",
                        $inparams,
                        'fullname ASC',
                        '*',
                        $offset,
                        $per_page
                    );
                }
            }
        }

        return [
            'courses' => $courses ? $courses : [],
            'total' => $total,
        ];
    }

    /**
     * Get preview courses for frontpage (limited number)
     *
     * @param int $mode Filter mode
     * @param int $limit Preview limit
     * @return array
     */
    public function get_preview_courses($mode, $limit) {
        $result = $this->get_courses_paginated($mode, 0, $limit);
        return $result['courses'];
    }
}
