<?php

require_once($CFG->libdir.'/formslib.php');

class instructor_profile_edit_form extends moodleform {
    function definition() {
        global $COURSE, $DB;

        $_s = function($key) { return get_string($key, 'block_instructor_profile'); };

        $mform =& $this->_form;

        $mform->addElement('hidden', 'courseid', $COURSE->id);
        $mform->setType('courseid', PARAM_INT);

        $context = context_course::instance($COURSE->id);

        $valid_roles = get_roles_with_cap_in_context($context, 'moodle/course:update');
        $roles = reset($valid_roles);

        $mform->addElement('header', 'general', $_s('user'));

        $params = array('courseid' => $COURSE->id);

        if (!$username = $DB->get_record('block_instructor_profile', $params)) {
        $username = new stdClass();
        $username->username = '';
        }

        foreach ($roles as $role) {
            $users = get_role_users($role, $context);
            if (!empty($users)) {
                foreach ($users as $puser) {
                    if ($puser->username == $username->username && $username->username != '') {
                        $user = $puser;
                    }
                }
            }
        }

        if (empty($user)) {
            $user = $puser;
        }

        $mform->addElement('text', 'username', get_string('username'), array('value' => $user->username));
        $mform->setType('username', PARAM_TEXT);

        $mform->addElement('text', 'name', get_string('name'), array('value' => fullname($user)));
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('text', 'email', get_string('email'), array('value' => $user->email));
        $mform->setType('email', PARAM_EMAIL);

        $mform->addElement('text', 'phone', get_string('phone'));
        $mform->setType('phone', PARAM_TEXT);

        $mform->addElement('header', 'general', $_s('additional'));

        $mform->addElement('textarea', 'other', get_string('other'), array('rows' => 10, 'cols' => '60'));

        $buttons = array(
            $mform->createElement('submit', 'submit', get_string('savechanges')),
            $mform->createElement('cancel')
        );

        $mform->addGroup($buttons, 'buttons', '', array(' '), false);

        $mform->closeHeaderBefore('buttons');
    }
}
