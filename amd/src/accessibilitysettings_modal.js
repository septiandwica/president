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
 * Theme settings modal js.
 *
 * @package   theme_president
 * @copyright 2025 Septian Dwi Cahyo(@septian.dwica) - https://samastanuswantara.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/ajax', 'core/modal', 'core/custom_interaction_events', 'core/notification'],
function(Ajax, Modal, CustomEvents, Notification) {

    var AccessibilityModal = function(root) {
        Modal.call(this, root);

        var request = Ajax.call([{
            methodname: 'theme_president_getthemesettings',
            args: {}
        }]);

        request[0].done(function(result) {
            var fontTypeElement = document.getElementById('fonttype');
            if (fontTypeElement) {
                fontTypeElement.value = result.fonttype;
            }

            if (result.enableaccessibilitytoolbar) {
                var toolbarElement = document.getElementById('enableaccessibilitytoolbar');
                if (toolbarElement) {
                    toolbarElement.checked = true;
                }
            }
        });
    };

    AccessibilityModal.TYPE = "theme_president/themesettings_modal";
    AccessibilityModal.TEMPLATE = "theme_president/accessibilitysettings_modal";

    AccessibilityModal.prototype = Object.create(Modal.prototype);
    AccessibilityModal.prototype.constructor = AccessibilityModal;

    /**
     * Set up all of the event handling for the modal.
     */
    AccessibilityModal.prototype.registerEventListeners = function() {
        // Apply parent event listeners.
        Modal.prototype.registerEventListeners.call(this);

        this.getModal().on(CustomEvents.events.activate, '[data-action="save"]', function() {
            var request = Ajax.call([{
                methodname: 'theme_president_savethemesettings',
                args: {
                    formdata: this.getBody().find('form').serialize()
                }
            }]);

            request[0].done(function() {
                document.location.reload(true);
            }).fail(function(error) {
                var message = error.message;

                if (!message) {
                    message = error.error;
                }

                Notification.addNotification({
                    message: message,
                    type: 'error'
                });

                this.hide();

                this.destroy();
            }.bind(this));
        }.bind(this));

        this.getModal().on(CustomEvents.events.activate, '[data-action="cancel"]', function() {
            this.hide();
            this.destroy();
        }.bind(this));
    };

    return AccessibilityModal;
});