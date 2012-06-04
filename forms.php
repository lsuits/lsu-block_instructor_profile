<?php

require_once($CFG->libdir.'/formslib.php');

class instructor_profile_edit_form extends moodleform {
    function definition() {
        global $COURSE, $DB;

        $_s = function($key) { return get_string($key, 'block_instructor_profile'); };

        $mform =& $this->_form;

        $mform->addElement('hidden', 'courseid', $COURSE->id);
        $mform->setType('courseid', PARAM_INT);

        $context = get_context_instance(CONTEXT_COURSE, $COURSE->id);

        $roles = reset(get_roles_with_cap_in_context($context, 'moodle/course:update'));

        foreach ($roles as $role) {
            $users = get_role_users($role, $context);

            if (!empty($users)) {
                $user = reset($users);
                break;
            }
        }

        $mform->addElement('header', 'general', $_s('edit'));

        $mform->addElement('text', 'name', get_string('name'), array('value' => fullname($user)));
        $mform->addElement('text', 'email', get_string('email'), array('value' => $user->email));
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
