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
 * Theme helper to load a theme configuration.
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_president\util;

use theme_config;

/**
 * Helper to load a theme configuration.
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings {
    /**
     * @var \stdClass $theme The theme object.
     */
    protected $theme;
    /**
     * @var array $files Theme file settings.
     */
    protected $files = [
        'logo', 'favicon', 'loginbgimg', 'logodark', 'footerlogo',
        'sliderimage1', 'sliderimage2', 'sliderimage3', 'sliderimage4', 'sliderimage5', 'sliderimage6',
        'sliderimage7', 'sliderimage8', 'sliderimage9', 'sliderimage10', 'sliderimage11', 'sliderimage12',
        'marketing1icon', 'marketing2icon', 'marketing3icon', 'marketing4icon','marketing5icon', 'marketing6icon', 'marketing7icon',
        'recognitionimage1', 'recognitionimage2', 'recognitionimage3', 'recognitionimage4', 'recognitionimage5',
        'recognitionimage6', 'recognitionimage7', 'recognitionimage8', 'recognitionimage9', 'recognitionimage10',
    ];

    /**
     * Class constructor
     */
    public function __construct() {
        $this->theme = theme_config::load('president');
    }

    /**
     * Magic method to get theme settings
     *
     * @param string $name
     *
     * @return false|string|null
     */
    public function __get(string $name) {
        if (in_array($name, $this->files)) {
            $url = $this->theme->setting_file_url($name, $name);
            if (!$url) {
                switch($name) {
                    case 'logo':
                        return (new \moodle_url('/theme/president/pix/logo.png'))->out();
                    case 'favicon':
                        return (new \moodle_url('/theme/president/pix/favicon.ico'))->out();
                    case 'logodark':
                        return (new \moodle_url('/theme/president/pix/logo-dark.png'))->out();
                    case 'footerlogo':
                        return (new \moodle_url('/theme/president/pix/footer-logo.png'))->out();
                    case 'loginbgimg':
                        return (new \moodle_url('/theme/president/pix/loginbg.png'))->out();
                }
            }
            return $url;
        }

        if (empty($this->theme->settings->$name)) {
            return false;
        }

        return $this->theme->settings->$name;
    }

    /**
     * Get content for guest pages with fallbacks
     *
     * @param string $view
     * @return string
     */
    public function guest_page_content($view) {
        // First try to find in dynamic custom pages.
        $count = get_config('theme_president', 'custompage_count') ?: 3;
        for ($i = 1; $i <= $count; $i++) {
            $title = get_config('theme_president', "custompage_title_$i");
            $slug = $this->slugify($title);
            if ($slug === $view) {
                $content = get_config('theme_president', "custompage_content_$i");
                if (!empty($content)) {
                    return format_text($content, FORMAT_HTML);
                }
                break;
            }
        }

        return "";
    }

    /**
     * Get title for guest pages
     *
     * @param string $view
     * @return string
     */
    public function guest_page_title($view) {
        $count = get_config('theme_president', 'custompage_count') ?: 3;
        for ($i = 1; $i <= $count; $i++) {
            $title = get_config('theme_president', "custompage_title_$i");
            $slug = $this->slugify($title);
            if ($slug === $view) {
                return $title;
            }
        }
        
        // Fallback for strings that might exist in lang file
        $string = get_string($view, 'theme_president');
        return (strpos($string, '[[') === false) ? $string : ucfirst(str_replace('-', ' ', $view));
    }

    /**
     * Get footer settings
     *
     * @return array
     */
    public function footer() {
        global $CFG;

        $templatecontext = [];

        $settings = [
            'footerlogo','address','facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'whatsapp', 'telegram',
            'website', 'mobile', 'mail',
        ];

        foreach ($settings as $setting) {
            $templatecontext[$setting] = $this->$setting;
        }

        $templatecontext['enablemobilewebservice'] = $CFG->enablemobilewebservice;

        if ($CFG->enablemobilewebservice) {
            $iosappid = get_config('tool_mobile', 'iosappid');
            if (!empty($iosappid)) {
                $templatecontext['iosappid'] = $iosappid;
            }

            $androidappid = get_config('tool_mobile', 'androidappid');
            if (!empty($androidappid)) {
                $templatecontext['androidappid'] = $androidappid;
            }

            $setuplink = get_config('tool_mobile', 'setuplink');
            if (!empty($setuplink)) {
                $templatecontext['mobilesetuplink'] = $setuplink;
            }
        }

        return $templatecontext;
    }

    /**
     * Get frontpage settings
     *
     * @return array
     */
    public function frontpage() {
        $templatecontext = array_merge(
            $this->frontpage_slideshow(),
            $this->frontpage_marketingboxes(),
            $this->frontpage_numbers(),
            $this->frontpage_recognition(),
            $this->faq(),
            $this->frontpage_custom_courses()
        );
    
        $templatecontext['getAnimeScriptUrl'] = $this->getAnimeScriptUrl();
    
        return $templatecontext;
    }

    /**
     * Get custom frontpage courses based on theme settings.
     *
     * @return array
     */
    public function frontpage_custom_courses() {
        global $PAGE;

        $enable = get_config('theme_president', 'frontpage_courses_enable');
        // Default to enabled if not set
        if ($enable === false) {
            $enable = 1;
        }

        if (!$enable) {
            return [
                'frontpage_courses_enable' => false,
                'frontpage_courses' => [],
                'show_view_all' => false,
            ];
        }

        $title = get_config('theme_president', 'frontpage_courses_title');
        if (empty($title)) {
            $title = get_string('frontpage_courses_title_default', 'theme_president');
        }

        $mode = get_config('theme_president', 'frontpage_courses_select_mode');
        if ($mode === false) {
            $mode = 0; // Default: Show all
        }

        // Use preview limit for frontpage (default 3)
        $preview_limit = get_config('theme_president', 'frontpage_courses_preview_limit');
        if ($preview_limit === false || $preview_limit === '') {
            $preview_limit = 3;
        } else {
            $preview_limit = intval($preview_limit);
        }

        // Get preview courses using pagination utility
        $courseutil = new course_pagination();
        $courses = $courseutil->get_preview_courses($mode, $preview_limit);

        // Get total count to determine if "View All" button should show
        $result = $courseutil->get_courses_paginated($mode, 0, 1);
        $total = $result['total'];
        $show_view_all = ($total > $preview_limit);

        $formattedcourses = [];
        $chelper = new \coursecat_helper();
        $renderer = $PAGE->get_renderer('core');

        foreach ($courses as $c) {
            $courseobj = new \core_course_list_element($c);
            $courseutil = new course($courseobj);
            $coursecontacts = $courseutil->get_course_contacts();

            $courseenrolmenticons = $courseutil->get_enrolment_icons();
            $enrolmenticonshtml = [];
            if (!empty($courseenrolmenticons)) {
                foreach ($courseenrolmenticons as $icon) {
                    $enrolmenticonshtml[] = $renderer->render($icon);
                }
            }

            $courseprogress = $courseutil->get_progress();
            $hasprogress = $courseprogress !== null;

            if (class_exists('\local_course\output\index')) {
                $courseurl = new \moodle_url('/local/course/index.php', ['id' => $c->id]);
            } else {
                $courseurl = new \moodle_url('/course/view.php', ['id' => $c->id]);
            }

            $formattedcourses[] = [
                'id' => $c->id,
                'fullname' => $chelper->get_course_formatted_name($courseobj),
                'visible' => $c->visible,
                'image' => $courseutil->get_summary_image(),
                'summary' => $courseutil->get_summary($chelper),
                'category' => $courseutil->get_category(),
                'customfields' => $courseutil->get_custom_fields(),
                'hasprogress' => $hasprogress,
                'progress' => (int) $courseprogress,
                'hasenrolmenticons' => !empty($enrolmenticonshtml),
                'enrolmenticons' => $enrolmenticonshtml,
                'hascontacts' => !empty($coursecontacts),
                'contacts' => $coursecontacts,
                'courseurl' => $courseurl->out(false),
            ];
        }

        return [
            'frontpage_courses_enable' => true,
            'frontpage_courses_title' => $title,
            'frontpage_courses' => $formattedcourses,
            'show_view_all' => $show_view_all,
            'view_all_url' => (new \moodle_url('/theme/president/courses.php'))->out(false),
            'total_courses' => $total,
        ];
    }

    /**
     * Get config theme slideshow
     *
     * @return array
     */
    public function frontpage_slideshow() {
        $templatecontext['slidercount'] = $this->slidercount;

        $defaultimage = new \moodle_url('/theme/president/pix/default_slide.jpg');
        for ($i = 1, $j = 0; $i <= $templatecontext['slidercount']; $i++, $j++) {
            $sliderimage = "sliderimage{$i}";
            $slidertitle = "slidertitle{$i}";
            $slidercap = "slidercap{$i}";
            $slidercapcontent = $this->$slidercap ?: null;

            $slidetitle = format_string($this->$slidertitle) ?: null;
            $slidecontent = format_text($slidercapcontent, FORMAT_MOODLE, ['noclean' => false]) ?: null;
            $image = $this->$sliderimage;

            $hascaption = isset($slidetitle) || isset($slidecontent);

            $templatecontext['slides'][$j]['key'] = $j;
            $templatecontext['slides'][$j]['active'] = $i === 1;
            $templatecontext['slides'][$j]['image'] = $image ?: $defaultimage->out();
            $templatecontext['slides'][$j]['title'] = $slidetitle;
            $templatecontext['slides'][$j]['caption'] = $slidecontent;
            $templatecontext['slides'][$j]['hascaption'] = $hascaption;
        }

        $templatecontext['slidersingleslide'] = $this->slidercount == 1;
        
        $templatecontext['slidercta1text'] = $this->slidercta1text ?: 'Apply Now';
        $templatecontext['slidercta1url'] = $this->slidercta1url ?: 'https://admission.president.ac.id/join';
        $templatecontext['slidercta2text'] = $this->slidercta2text ?: 'Explore Programs';
        $templatecontext['slidercta2url'] = $this->slidercta2url ?: 'https://president.ac.id';

        return $templatecontext;
    }

    /**
     * Get config theme slideshow
     *
     * @return array
     */
    public function frontpage_marketingboxes() {
        if ($templatecontext['displaymarketingbox'] = $this->displaymarketingbox) {
            $templatecontext['marketingheading'] = format_text($this->marketingheading, FORMAT_HTML);
            $templatecontext['marketingcontent'] = format_text($this->marketingcontent, FORMAT_HTML);

            $defaultimage = new \moodle_url('/theme/president/pix/default_markegingicon.jpg');

            for ($i = 1, $j = 0; $i < 8; $i++, $j++) {
                $marketingicon = 'marketing' . $i . 'icon';
                $marketingheading = 'marketing' . $i . 'heading';
                $marketingcontent = 'marketing' . $i . 'content';

                $templatecontext['marketingboxes'][$j]['icon'] = $this->$marketingicon ?: $defaultimage->out();
                $templatecontext['marketingboxes'][$j]['heading'] = $this->$marketingheading ?
                    format_text($this->$marketingheading, FORMAT_HTML) : 'Lorem';
                $templatecontext['marketingboxes'][$j]['content'] = $this->$marketingcontent ?
                    format_text($this->$marketingcontent, FORMAT_HTML) :
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.';
            }
        }

        return $templatecontext;
    }

    /**
     * Get config theme slideshow
     *
     * @return array
     */
    public function frontpage_numbers() {
        global $DB;

        if ($templatecontext['numbersfrontpage'] = $this->numbersfrontpage) {
            $templatecontext['numberscontent'] = $this->numbersfrontpagecontent ? format_text($this->numbersfrontpagecontent) : '';
            $templatecontext['numbersusers'] = $DB->count_records('user', ['deleted' => 0, 'suspended' => 0]) - 1;
            $templatecontext['numberscourses'] = $DB->count_records('course', ['visible' => 1]) - 1;
        }

        return $templatecontext;
    }

    /**
     * Get recognition logos
     *
     * @return array
     */
    public function frontpage_recognition() {
        $templatecontext = [];
        $templatecontext['recognitioncount'] = $this->recognitioncount;
        
        if ($this->recognitioncount) {
            for ($i = 1; $i <= $this->recognitioncount; $i++) {
                $imagefield = 'recognitionimage' . $i;
                $url = $this->$imagefield;
                
                // Fallback to default images in pix/recognition/X.png if not uploaded.
                if (!$url && $i <= 6) {
                    $url = (new \moodle_url('/theme/president/pix/recognition/' . $i . '.png'))->out();
                }

                if ($url) {
                    $templatecontext['recognitionlogos'][] = ['image' => $url];
                }
            }
        }

        return $templatecontext;
    }

    /**
     * Get config theme slideshow
     *
     * @return array
     */
    public function faq() {
        $templatecontext['faqenabled'] = false;

        if ($this->faqcount) {
            for ($i = 1; $i <= $this->faqcount; $i++) {
                $faqquestion = 'faqquestion' . $i;
                $faqanswer = 'faqanswer' . $i;

                if (!$this->$faqquestion || !$this->$faqanswer) {
                    continue;
                }

                $templatecontext['faq'][] = [
                    'id' => $i,
                    'question' => format_text($this->$faqquestion),
                    'answer' => format_text($this->$faqanswer),
                ];
            }

            if (!empty($templatecontext['faq'])) {
                $templatecontext['faqenabled'] = true;
            }
        }

        return $templatecontext;
    }
   
   /**
     * Get the URL for the anime script
     *
     * @return string
     */
    public function getAnimeScriptUrl() {
        return (new \moodle_url('/theme/president/scripts/anime.min.js'))->out();
    }

    /**
     * Get navbar settings
     *
     * @return array
     */
    public function navbar() {
        global $CFG;
        $navbartype = $this->navbartype ?: 'normal';
        $logodark = $this->logodark;
        
        $templatecontext = [
            'navbartype' => $navbartype,
            'is_normal' => $navbartype === 'normal',
            'is_floating' => $navbartype === 'floating',
            'is_sticky' => $navbartype === 'sticky',
            'logodark_url' => $logodark ? $logodark : false,
            'enabledarkmode' => $this->enabledarkmode,
            'management_menu' => \theme_president_get_management_menu(),
        ];

        // Ensure all custom page folders exist for pretty URLs.
        $this->ensure_guest_folders();

        // Add guest page links.
        $is_guest = !isloggedin() || isguestuser();
        $templatecontext['is_guest'] = $is_guest;

        if ($is_guest) {
            global $CFG, $PAGE;
            $currentview = optional_param('view', '', PARAM_ALPHANUM);
            $is_home = ($PAGE->url->out_as_local_url(false) === $CFG->wwwroot . '/' || $PAGE->url->out_as_local_url(false) === '/');
            
            $links = [
                ['title' => get_string('home'), 'url' => new \moodle_url('/'), 'active' => $is_home],
            ];

            // Dynamic Custom Pages.
            $count = get_config('theme_president', 'custompage_count') ?: 3;
            for ($i = 1; $i <= $count; $i++) {
                $title = get_config('theme_president', "custompage_title_$i");
                $shownavbar = get_config('theme_president', "custompage_navbar_$i");
                
                // Fallback for default titles if not saved in DB yet.
                if (!$title && $i <= 3) {
                    $title = ($i == 1) ? 'Programs' : (($i == 2) ? 'FAQ' : 'About Us');
                }

                if ($title && $shownavbar) {
                    $slug = $this->slugify($title);
                    $links[] = [
                        'title' => $title,
                        'url' => new \moodle_url('/' . $slug . '/'),
                        'active' => ($currentview === $slug)
                    ];
                }
            }

            $templatecontext['guest_links'] = [];
            foreach ($links as $link) {
                $templatecontext['guest_links'][] = [
                    'title' => $link['title'],
                    'url' => $link['url'],
                    'isactive' => $link['active']
                ];
            }
        }

        return $templatecontext;
    }

    /**
     * Convert a string to a URL-friendly slug.
     *
     * @param string $text
     * @return string
     */
    protected function slugify($text) {
        if (empty($text)) {
            return '';
        }
        
        // Remove special characters and convert spaces to hyphens.
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        return $text ?: 'n-a';
    }

    /**
     * Ensure that physical folders exist for each custom guest page to enable pretty URLs.
     */
    protected function ensure_guest_folders() {
        global $CFG;
        
        $count = get_config('theme_president', 'custompage_count') ?: 3;
        for ($i = 1; $i <= $count; $i++) {
            $title = get_config('theme_president', "custompage_title_$i");
            
            // Fallback for defaults.
            if (!$title && $i <= 3) {
                $title = ($i == 1) ? 'Programs' : (($i == 2) ? 'FAQ' : 'About Us');
            }

            if ($title) {
                $slug = $this->slugify($title);
                $dir = $CFG->dirroot . '/' . $slug;
                
                // If directory doesn't exist, create it and its index.php.
                if (!empty($slug) && !is_dir($dir)) {
                    if (@mkdir($dir, 0755, true)) {
                        $indexfile = $dir . '/index.php';
                        $phpcontent = "<?php\n";
                        $phpcontent .= "require_once(__DIR__ . '/../config.php');\n";
                        $phpcontent .= "\$_GET['view'] = '$slug';\n";
                        $phpcontent .= "require_once(__DIR__ . '/../theme/president/view.php');\n";
                        @file_put_contents($indexfile, $phpcontent);
                    }
                }
            }
        }
    }
}
