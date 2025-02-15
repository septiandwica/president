<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme president block settings file
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://tiancode.my.id
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingpresident', get_string('configtitle', 'theme_president'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_president_general', get_string('generalsettings', 'theme_president'));

    // Logo file setting.
    $name = 'theme_president/logo';
    $title = get_string('logo', 'theme_president');
    $description = get_string('logodesc', 'theme_president');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $page->add($setting);

    // Favicon setting.
    $name = 'theme_president/favicon';
    $title = get_string('favicon', 'theme_president');
    $description = get_string('favicondesc', 'theme_president');
    $opts = ['accepted_types' => ['.ico'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $page->add($setting);

    // Preset.
    $name = 'theme_president/preset';
    $title = get_string('preset', 'theme_president');
    $description = get_string('preset_desc', 'theme_president');
    $default = 'default.scss';

    $context = \core\context\system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_president', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_president/presetfiles';
    $title = get_string('presetfiles', 'theme_president');
    $description = get_string('presetfiles_desc', 'theme_president');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        ['maxfiles' => 10, 'accepted_types' => ['.scss']]);
    $page->add($setting);

    // Login page background image.
    $name = 'theme_president/loginbgimg';
    $title = get_string('loginbgimg', 'theme_president');
    $description = get_string('loginbgimg_desc', 'theme_president');
    $opts = ['accepted_types' => ['.png', '.jpg', '.svg']];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_president/brandcolor';
    $title = get_string('brandcolor', 'theme_president');
    $description = get_string('brandcolor_desc', 'theme_president');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#0f47ad');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $navbar-header-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_president/secondarymenucolor';
    $title = get_string('secondarymenucolor', 'theme_president');
    $description = get_string('secondarymenucolor_desc', 'theme_president');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#0f47ad');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $fontsarr = [
        'Moodle' => 'Moodle Font',
        'Roboto' => 'Roboto',
        'Poppins' => 'Poppins',
        'Montserrat' => 'Montserrat',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Raleway' => 'Raleway',
        'Inter' => 'Inter',
        'Nunito' => 'Nunito',
        'Encode Sans' => 'Encode Sans',
        'Work Sans' => 'Work Sans',
        'Oxygen' => 'Oxygen',
        'Manrope' => 'Manrope',
        'Sora' => 'Sora',
        'Epilogue' => 'Epilogue',
    ];

    $name = 'theme_president/fontsite';
    $title = get_string('fontsite', 'theme_president');
    $description = get_string('fontsite_desc', 'theme_president');
    $setting = new admin_setting_configselect($name, $title, $description, 'Poppins', $fontsarr);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_president/enablecourseindex';
    $title = get_string('enablecourseindex', 'theme_president');
    $description = get_string('enablecourseindex_desc', 'theme_president');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $name = 'theme_president/enableclassicbreadcrumb';
    $title = get_string('enableclassicbreadcrumb', 'theme_president');
    $description = get_string('enableclassicbreadcrumb_desc', 'theme_president');
    $default = 0;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_president_advanced', get_string('advancedsettings', 'theme_president'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_president/scsspre',
        get_string('rawscsspre', 'theme_president'), get_string('rawscsspre_desc', 'theme_president'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_president/scss', get_string('rawscss', 'theme_president'),
        get_string('rawscss_desc', 'theme_president'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_president/googleanalytics';
    $title = get_string('googleanalytics', 'theme_president');
    $description = get_string('googleanalyticsdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // H5P custom CSS.
    $setting = new admin_setting_configtextarea('theme_president/hvpcss', get_string('hvpcss', 'theme_president'), get_string('hvpcss_desc', 'theme_president'), '');
    $page->add($setting);

    $settings->add($page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_president_frontpage', get_string('frontpagesettings', 'theme_president'));

    // Disable teachers from cards.
    $name = 'theme_president/disableteacherspic';
    $title = get_string('disableteacherspic', 'theme_president');
    $description = get_string('disableteacherspicdesc', 'theme_president');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Slideshow.
    $name = 'theme_president/slidercount';
    $title = get_string('slidercount', 'theme_president');
    $description = get_string('slidercountdesc', 'theme_president');
    $default = 0;
    $options = [];
    for ($i = 0; $i < 13; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // If we don't have an slide yet, default to the preset.
    $slidercount = get_config('theme_president', 'slidercount');

    if (!$slidercount) {
        $slidercount = $default;
    }

    if ($slidercount) {
        for ($sliderindex = 1; $sliderindex <= $slidercount; $sliderindex++) {
            $fileid = 'sliderimage' . $sliderindex;
            $name = 'theme_president/sliderimage' . $sliderindex;
            $title = get_string('sliderimage', 'theme_president');
            $description = get_string('sliderimagedesc', 'theme_president');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
            $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
            $page->add($setting);

            $name = 'theme_president/slidertitle' . $sliderindex;
            $title = get_string('slidertitle', 'theme_president');
            $description = get_string('slidertitledesc', 'theme_president');
            $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
            $page->add($setting);

            $name = 'theme_president/slidercap' . $sliderindex;
            $title = get_string('slidercaption', 'theme_president');
            $description = get_string('slidercaptiondesc', 'theme_president');
            $default = '';
            $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
            $page->add($setting);
        }
    }

    $setting = new admin_setting_heading('slidercountseparator', '', '<hr>');
    $page->add($setting);

    $name = 'theme_president/displaymarketingbox';
    $title = get_string('displaymarketingboxes', 'theme_president');
    $description = get_string('displaymarketingboxesdesc', 'theme_president');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $displaymarketingbox = get_config('theme_president', 'displaymarketingbox');

    if ($displaymarketingbox) {
        // Marketingheading.
        $name = 'theme_president/marketingheading';
        $title = get_string('marketingsectionheading', 'theme_president');
        $default = 'OUR FACULTIES';
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $page->add($setting);

        // Marketingcontent.
        $name = 'theme_president/marketingcontent';
        $title = get_string('marketingsectioncontent', 'theme_president');
        $default = 'We offer our students comprehensive programs that enrich their education through multidisciplinary, cross-faculty approaches and a wide range of major options.';
        $setting = new admin_setting_confightmleditor($name, $title, '', $default);
        $page->add($setting);

        for ($i = 1; $i < 8; $i++) {
            $filearea = "marketing{$i}icon";
            $name = "theme_president/$filearea";
            $title = get_string('marketingicon', 'theme_president', $i . '');
            $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg']];
            $setting = new admin_setting_configstoredfile($name, $title, '', $filearea, 0, $opts);
            $page->add($setting);

            $name = "theme_president/marketing{$i}heading";
            $title = get_string('marketingheading', 'theme_president', $i . '');
            $default = 'Faculty';
            $setting = new admin_setting_configtext($name, $title, '', $default);
            $page->add($setting);

          
        }

        $setting = new admin_setting_heading('displaymarketingboxseparator', '', '<hr>');
        $page->add($setting);
    }

    // Enable or disable Numbers sections settings.
    $name = 'theme_president/numbersfrontpage';
    $title = get_string('numbersfrontpage', 'theme_president');
    $description = get_string('numbersfrontpagedesc', 'theme_president');
    $default = 1;
    $choices = [0 => get_string('no'), 1 => get_string('yes')];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    $numbersfrontpage = get_config('theme_president', 'numbersfrontpage');

    if ($numbersfrontpage) {
        $name = 'theme_president/numbersfrontpagecontent';
        $title = get_string('numbersfrontpagecontent', 'theme_president');
        $description = get_string('numbersfrontpagecontentdesc', 'theme_president');
        $default = get_string('numbersfrontpagecontentdefault', 'theme_president');
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    // Enable FAQ.
    $name = 'theme_president/faqcount';
    $title = get_string('faqcount', 'theme_president');
    $description = get_string('faqcountdesc', 'theme_president');
    $default = 0;
    $options = [];
    for ($i = 0; $i < 11; $i++) {
        $options[$i] = $i;
    }
    $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
    $page->add($setting);

    $faqcount = get_config('theme_president', 'faqcount');

    if ($faqcount > 0) {
        for ($i = 1; $i <= $faqcount; $i++) {
            $name = "theme_president/faqquestion{$i}";
            $title = get_string('faqquestion', 'theme_president', $i . '');
            $setting = new admin_setting_configtext($name, $title, '', '');
            $page->add($setting);

            $name = "theme_president/faqanswer{$i}";
            $title = get_string('faqanswer', 'theme_president', $i . '');
            $setting = new admin_setting_confightmleditor($name, $title, '', '');
            $page->add($setting);
        }

        $setting = new admin_setting_heading('faqseparator', '', '<hr>');
        $page->add($setting);
    }

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_president_footer', get_string('footersettings', 'theme_president'));

    $name = 'theme_president/footerlogo';
    $title = get_string('footerlogo', 'theme_president');
    $description = get_string('footerlogodesc', 'theme_president');
    $opts = ['accepted_types' => ['.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'], 'maxfiles' => 1];
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo', 0, $opts);
    $page->add($setting);

    $name = 'theme_president/address';
    $title = get_string('address', 'theme_president');
    $description = get_string('addressdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Website.
    $name = 'theme_president/website';
    $title = get_string('website', 'theme_president');
    $description = get_string('websitedesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mobile.
    $name = 'theme_president/mobile';
    $title = get_string('mobile', 'theme_president');
    $description = get_string('mobiledesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Mail.
    $name = 'theme_president/mail';
    $title = get_string('mail', 'theme_president');
    $description = get_string('maildesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Facebook url setting.
    $name = 'theme_president/facebook';
    $title = get_string('facebook', 'theme_president');
    $description = get_string('facebookdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Twitter url setting.
    $name = 'theme_president/twitter';
    $title = get_string('twitter', 'theme_president');
    $description = get_string('twitterdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Linkdin url setting.
    $name = 'theme_president/linkedin';
    $title = get_string('linkedin', 'theme_president');
    $description = get_string('linkedindesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Youtube url setting.
    $name = 'theme_president/youtube';
    $title = get_string('youtube', 'theme_president');
    $description = get_string('youtubedesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Instagram url setting.
    $name = 'theme_president/instagram';
    $title = get_string('instagram', 'theme_president');
    $description = get_string('instagramdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Whatsapp url setting.
    $name = 'theme_president/whatsapp';
    $title = get_string('whatsapp', 'theme_president');
    $description = get_string('whatsappdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    // Telegram url setting.
    $name = 'theme_president/telegram';
    $title = get_string('telegram', 'theme_president');
    $description = get_string('telegramdesc', 'theme_president');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    $settings->add($page);
}
