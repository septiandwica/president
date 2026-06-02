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

$string['pluginname'] = 'President';
$string['configtitle'] = 'President';
$string['choosereadme'] = 'The President Theme is a modern, customizable Moodle theme designed exclusively for President University. Built with Bootstrap 4, it offers a clean, responsive, and user-friendly interface to enhance the online learning experience.
Developed by <a href="https://github.com/septiandwica">Septian Dwi Cahyo</a>';

$string['currentinparentheses'] = '(current)';
$string['region-side-pre'] = 'Right';
$string['prev_section'] = 'Previous section';
$string['next_section'] = 'Next section';
$string['themedevelopedby'] = 'This theme was proudly developed by Septian Dwi Cahyo';
$string['needsupport'] = 'Need support for your Moodle site? ';
$string['pleasuretohelp'] = 'It will be a pleasure to help you!';
$string['access'] = 'Access';
$string['prev_activity'] = 'Previous activity';
$string['next_activity'] = 'Next activity';
$string['donthaveanaccount'] = 'Don\'t have an account?';
$string['signinwith'] = 'Sign in with';

// General settings tab.
$string['generalsettings'] = 'General';
$string['logo'] = 'Navbar Light Logo';
$string['logodesc'] = 'The logo is displayed in the header when using the light theme.';
$string['logodark'] = 'Navbar Dark Logo';
$string['logodarkdesc'] = 'The alternative logo displayed in the header when Dark Mode is active (usually a white/light version of your logo).';
$string['favicon'] = 'Custom favicon';
$string['favicondesc'] = 'Upload your own favicon.  It should be an .ico file.';
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';
$string['presetfiles'] = 'Additional theme preset files';
$string['presetfiles_desc'] = 'Preset files can be used to dramatically alter the appearance of the theme. See <a href="https://docs.moodle.org/dev/Boost_Presets">Boost presets</a> for information on creating and sharing your own preset files.';
$string['loginbgimg'] = 'Login page background';
$string['loginbgimg_desc'] = 'Upload your custom background image for the login page.';
$string['brandcolor'] = 'Brand colour';
$string['brandcolor_desc'] = 'The accent colour.';
$string['secondarymenucolor'] = 'Secondary menu color';
$string['secondarymenucolor_desc'] = 'Secondary menu background color';
$string['navbarbg'] = 'Navbar color';
$string['navbarbg_desc'] = 'The left navbar color';
$string['navbarbghover'] = 'Navbar hover color';
$string['navbarbghover_desc'] = 'The left navbar hover color';
$string['fontsite'] = 'Site font';
$string['fontsite_desc'] = 'Default font site. You can try out the fonts on <a href="https://fonts.google.com">Google Fonts site</a>.';
$string['enablecourseindex'] = 'Enable course index';
$string['enablecourseindex_desc'] = 'You can show/hide course index navigation';
$string['enableclassicbreadcrumb'] = 'Enable classic breadcrumb';
$string['enableclassicbreadcrumb_desc'] = 'This setting enables the classic breadcrumb, showing it on pages like course and categories.';

$string['navbartype'] = 'Navbar style';
$string['navbartype_desc'] = 'Choose the visual style for the top navigation bar.';
$string['navbartype_normal'] = 'Normal (Default)';
$string['navbartype_floating'] = 'Floating (Modern)';
$string['navbartype_sticky'] = 'Sticky (Fixed on Top)';

// Advanced settings tab.
$string['advancedsettings'] = 'Advanced';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS or CSS code which will be injected at the end of the style sheet.';
$string['enabledarkmode'] = 'Enable Dark Mode switcher';
$string['enabledarkmode_desc'] = 'If enabled, users will be able to switch between Light, Dark, and System theme modes.';
$string['googleanalytics'] = 'Google Analytics V4 Code';
$string['googleanalyticsdesc'] = 'Please enter your Google Analytics V4 code to enable analytics on your website. The code format shold be like [G-XXXXXXXXXX]';
$string['hvpcss'] = 'Raw H5P CSS';
$string['hvpcss_desc'] = 'Use this field to provide a CSS file which will be injected on mod_hvp plugin pages.';

// Frontpage settings tab.
$string['frontpagesettings'] = 'Frontpage';
$string['displaymarketingboxes'] = 'Show front page faculty boxes';
$string['displaymarketingboxesdesc'] = 'If you want to see the boxes, select yes <strong>then click SAVE</strong> to load the input fields.';
$string['marketingsectionheading'] = 'Faculty section heading title';
$string['marketingsectioncontent'] = 'Faculty section content';
$string['marketingicon'] = 'Faculty Icon {$a}';
$string['marketingheading'] = 'Faculty Heading {$a}';
$string['marketingcontent'] = 'Faculty Content {$a}';

$string['disableteacherspic'] = 'Disable teachers picture';
$string['disableteacherspicdesc'] = 'This setting hides the teachers\' pictures from the course cards.';

$string['sliderfrontpageloggedin'] = 'Show slideshow in frontpage after login?';
$string['sliderfrontpageloggedindesc'] = 'If enabled, the slideshow will be showed in the frontpage page replacing the header image.';
$string['slidercount'] = 'Slider count';
$string['slidercountdesc'] = 'Select how many slides you want to add <strong>then click SAVE</strong> to load the input fields.';
$string['sliderimage'] = 'Slider picture';
$string['sliderimagedesc'] = 'Add an image for your slide. Recommended size is 1500px x 540px or higher.';
$string['slidertitle'] = 'Slide title';
$string['slidertitledesc'] = 'Add the slide\'s title.';
$string['slidercaption'] = 'Slider caption';
$string['slidercaptiondesc'] = 'Add a caption for your slide';
$string['slidercta1text'] = 'Slider CTA 1 Button Text';
$string['slidercta1textdesc'] = 'The text for the first call-to-action button on the slider.';
$string['slidercta1url'] = 'Slider CTA 1 Button URL';
$string['slidercta1urldesc'] = 'The URL for the first call-to-action button on the slider.';
$string['slidercta2text'] = 'Slider CTA 2 Button Text';
$string['slidercta2textdesc'] = 'The text for the second call-to-action button on the slider.';
$string['slidercta2url'] = 'Slider CTA 2 URL';
$string['slidercta2urldesc'] = 'Destination URL for the second CTA button.';

// Guest Pages.
$string['guestpages'] = 'Guest Pages';
$string['programs'] = 'Programs';
$string['programs_content'] = 'Programs Page Content';
$string['programs_content_desc'] = 'HTML content for the Programs page. This page is only linked in the navbar for guests.';
$string['faq'] = 'FAQ';
$string['faq_content'] = 'FAQ Page Content';
$string['faq_content_desc'] = 'HTML content for the FAQ page. This page is only linked in the navbar for guests.';
$string['about'] = 'About Us';
$string['about_content'] = 'About Us Content';
$string['about_content_desc'] = 'HTML content for the About Us page.';
$string['custompage_count'] = 'Number of Custom Pages';
$string['custompage_count_desc'] = 'Select how many custom guest pages you want to create (max 10). After changing this, click Save to update the fields below.';
$string['custompage_navbar'] = 'Show in navbar';
$string['custompage_navbar_desc'] = 'If enabled, a link to this custom page will be added automatically to the guest navbar.';


$string['numbersfrontpage'] = 'Show site numberss';
$string['numbersfrontpagedesc'] = 'If enabled, display the number of active users and courses in the frontpage.';
$string['numbersfrontpagecontent'] = 'Numbers section content';
$string['numbersfrontpagecontentdesc'] = 'You can add any text to the left side of the numbers section';
$string['numbersfrontpagecontentdefault'] = '<h2> Learning Made Simple with President University eCampus</h2>
                    <p>Discover a seamless learning experience at President University eCampus. Stay connected, access available courses, and engage with fellow learners—all in one convenient platform.</p>';
$string['numbersusers'] = 'active users on President University eCampus';
$string['numberscourses'] = 'courses available on President University eCampus';
$string['recognitioncount'] = 'Global Recognition Logo Count';
$string['recognitioncountdesc'] = 'Select how many recognition logos you want to display in the carousel.';
$string['recognitionimage'] = 'Recognition Logo';
$string['recognitionimagedesc'] = 'Upload a logo (recommended size 200x100px, transparent PNG/SVG).';
$string['globalrecognition'] = 'Our Global Recognition';

$string['faq'] = 'FAQ';
$string['faqcount'] = 'FAQ questions';
$string['faqcountdesc'] = 'Select how many questions you want to add <strong>then click SAVE</strong> to load the input fields.<br>If you don\'t want a FAQ, just select 0.';
$string['faqquestion'] = 'FAQ question {$a}';
$string['faqanswer'] = 'FAQ answer {$a}';

// Footer settings tab.
$string['footersettings'] = 'Footer';
$string['footerlogo'] = 'Footer Logo';
$string['footerlogodesc'] = 'Upload Your Logo for footer';
$string['address'] = 'Address';
$string['addressdesc'] = 'Enter Officialy Address of President University';
$string['website'] = 'Website URL';
$string['websitedesc'] = 'Main company Website';
$string['mobile'] = 'Mobile';
$string['mobiledesc'] = 'Enter Mobile No. Ex: +5598912341234';
$string['mail'] = 'E-Mail';
$string['maildesc'] = 'Company support e-mail';
$string['facebook'] = 'Facebook URL';
$string['facebookdesc'] = 'Enter the URL of your Facebook. (i.e http://www.facebook.com/myinstitution)';
$string['twitter'] = 'Twitter URL';
$string['twitterdesc'] = 'Enter the URL of your twitter. (i.e http://www.twitter.com/myinstitution)';
$string['linkedin'] = 'Linkedin URL';
$string['linkedindesc'] = 'Enter the URL of your Linkedin. (i.e http://www.linkedin.com/myinstitution)';
$string['youtube'] = 'Youtube URL';
$string['youtubedesc'] = 'Enter the URL of your Youtube. (i.e https://www.youtube.com/user/myinstitution)';
$string['instagram'] = 'Instagram URL';
$string['instagramdesc'] = 'Enter the URL of your Instagram. (i.e https://www.instagram.com/myinstitution)';
$string['whatsapp'] = 'Whatsapp number';
$string['whatsappdesc'] = 'Enter your whatsapp number for contact.';
$string['telegram'] = 'Telegram';
$string['telegramdesc'] = 'Enter your Telegram contact or group link.';
$string['contactus'] = 'Contact us';
$string['followus'] = 'Follow us';

// Mypublic page.
$string['aboutme'] = 'About me';
$string['personalinformation'] = 'Personal information';
$string['addcontact'] = 'Add contact';
$string['removecontact'] = 'Remove contact';

// Theme settings.
$string['themesettings:accessibility'] = 'Accessibility';
$string['themesettings:fonttype'] = 'Font type';
$string['themesettings:defaultfont'] = 'Default font';
$string['themesettings:dyslexicfont'] = 'Dyslexic font';
$string['themesettings:enableaccessibilitytoolbar'] = 'Enable accessibility toolbar';
$string['themesettingg:successfullysaved'] = 'Accessibility settings successfully saved';

// Accessibility features.
$string['accessibility:fontsize'] = 'Font size';
$string['accessibility:decreasefont'] = 'Decrease font size';
$string['accessibility:resetfont'] = 'Reset font size';
$string['accessibility:increasefont'] = 'Increase font size';
$string['accessibility:sitecolor'] = 'Site color';
$string['accessibility:resetsitecolor'] = 'Reset site color';
$string['accessibility:sitecolor2'] = 'Low contrast 1';
$string['accessibility:sitecolor3'] = 'Low contrast 2';
$string['accessibility:sitecolor4'] = 'High contrast';

// Data privacy.
$string['privacy:metadata:preference:accessibilitystyles_fontsizeclass'] = 'The user\'s preference for font size.';
$string['privacy:metadata:preference:accessibilitystyles_sitecolorclass'] = 'The user\'s preference for site color.';
$string['privacy:metadata:preference:themepresidentsettings_fonttype'] = 'The user\'s preference for font type.';
$string['privacy:metadata:preference:themepresidentsettings_enableaccessibilitytoolbar'] = 'The user\'s preference for enable the accessibility toolbar.';

$string['privacy:accessibilitystyles_fontsizeclass'] = 'The current preference for the font size is: {$a}.';
$string['privacy:accessibilitystyles_sitecolorclass'] = 'The current preference for the site color is: {$a}.';
$string['privacy:themepresidentsettings_fonttype'] = 'The current preference for the font type is: {$a}.';
$string['privacy:themepresidentsettings_enableaccessibilitytoolbar'] = 'The current preference for enable accessibility toolbar is to show it.';

$string['redirectmessage'] = 'This page should automatically redirect.';
$string['redirectbtntext'] = 'If nothing is happening please click here to continue.';

// Page
$string['aboutus'] = 'About Us';

// Frontpage Course Filtering
$string['frontpage_courses_enable'] = 'Show Front Page Courses Section';
$string['frontpage_courses_enable_desc'] = 'If enabled, a custom courses section will be displayed on the front page.';
$string['frontpage_courses_title_setting'] = 'Courses Section Title';
$string['frontpage_courses_title_setting_desc'] = 'Enter a custom title for the courses section on the front page (e.g. Open Course).';
$string['frontpage_courses_title_default'] = 'Available Courses';
$string['frontpage_courses_select_mode'] = 'Filter Front Page Courses';
$string['frontpage_courses_select_mode_desc'] = 'Select how to display available courses on the front page.';
$string['frontpage_courses_select_mode_all'] = 'Show all available courses';
$string['frontpage_courses_select_mode_newest'] = 'Show newest courses first';
$string['frontpage_courses_select_mode_manual'] = 'Show specific courses (Select manually)';
$string['frontpage_courses_select_mode_category'] = 'Show courses from selected categories';
$string['frontpage_courses_selected'] = 'Select Specific Courses';
$string['frontpage_courses_selected_desc'] = 'Choose which courses you want to display on the front page (hold Ctrl/Cmd to select multiple).';
$string['frontpage_courses_categories'] = 'Select Categories';
$string['frontpage_courses_categories_desc'] = 'Choose which course categories you want to display on the front page (hold Ctrl/Cmd to select multiple).';
$string['frontpage_courses_limit'] = 'Max Courses Limit';
$string['frontpage_courses_limit_desc'] = 'Enter the maximum number of courses to display. Default is 12.';
$string['frontpage_courses_preview_limit'] = 'Frontpage Preview Limit';
$string['frontpage_courses_preview_limit_desc'] = 'Number of courses to show as preview on the frontpage (default 3). Users can click "View All Courses" to see all.';
$string['frontpage_courses_per_page'] = 'Courses Per Page';
$string['frontpage_courses_per_page_desc'] = 'Number of courses per page in the full courses listing (default 9 for 3x3 grid).';
$string['nocoursesfound'] = 'No courses found.';
$string['explorecourses'] = 'Explore Courses';
$string['frontpage_courses_heading'] = 'Custom Courses Section';