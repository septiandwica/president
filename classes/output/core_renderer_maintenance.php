<?php
namespace theme_president\output;

defined('MOODLE_INTERNAL') || die;

class core_renderer_maintenance extends \core_renderer_maintenance {
    public function maintenance_message() {
        global $CFG;
        $info = $this->page->site->maintenance_message ?? get_config('core', 'maintenance_message');
        if (empty($info)) {
            $info = get_string('sitemaintenance', 'admin');
        }
        $context = [
            'info' => format_text($info, FORMAT_HTML),
            'maintenancedatetime' => get_config('theme_president', 'maintenancedatetime'),
        ];
        return $this->render_from_template('core/maintenance', $context);
    }
}
