<?php

require_once('../../config.php');

require_once('forms.php');

$_s = function($key, $a=NULL) { return get_string($key, 'block_instructor_profile', $a); };

$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);

$blockname = $_s('pluginname');

$context = context_course::instance($courseid);

require_capability('moodle/course:update', $context);

$PAGE->set_context($context);

$PAGE->navbar->add($blockname);
$PAGE->set_title($blockname);
$PAGE->set_heading($SITE->shortname . ': ' . $blockname);
$PAGE->set_url('/blocks/instructor_profile/index.php', array('id' => $courseid));

$form = new instructor_profile_edit_form();

$params = array('courseid' => $courseid);
if (!$profile = $DB->get_record('block_instructor_profile', $params)) {
    $update = false;

    $profile = new stdClass();
} else {
    $update = true;
}

if ($form->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', array('id' => $courseid)));
} else if ($form_data = $form->get_data()) {
    $profile->courseid = $form_data->courseid;
    $profile->name = $form_data->name;
    $profile->email = $form_data->email;
    $profile->phone = $form_data->phone;
    $profile->other = $form_data->other;

    if ($update) {
        $DB->update_record('block_instructor_profile', $profile);
    } else {
        $DB->insert_record('block_instructor_profile', $profile);
    }

    $url = new moodle_url('/course/view.php', array('id' => $courseid));

    redirect($url);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($blockname);

$form->set_data($profile);
$form->display();

echo $OUTPUT->footer();
