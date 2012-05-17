<?php

require_once($CFG->libdir.'/formslib.php');

class instructor_profile_edit_form extends moodleform {
    function definition() {
        global $COURSE, $DB, $USER;

        $_s = function($key) { return get_string($key, 'block_instructor_profile'); };

        $mform =& $this->_form;

        $mform->addElement('hidden', 'courseid', $COURSE->id);
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('header', 'general', $_s('edit'));

        $mform->addElement('text', 'name', get_string('name'), array('value' => fullname($USER)));
        $mform->addElement('text', 'email', get_string('email'), array('value' => $USER->email));
        $mform->addElement('text', 'phone', get_string('phone'));
        $mform->addElement('textarea', 'other', get_string('other'), array('rows' => 10, 'cols' => '60'));

        $buttons = array(
            $mform->createElement('submit', 'submit', get_string('savechanges')),
            $mform->createElement('cancel')
        );

        $mform->addGroup($buttons, 'buttons', '', array(' '), false);

        $mform->closeHeaderBefore('buttons');
    }
}
