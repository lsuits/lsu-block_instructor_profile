<?php

function xmldb_block_instructor_profile_upgrade($oldversion) {
    global $DB;

    $result = true;

    $dbman = $DB->get_manager();

    // add new field for multi instructor settins
    if ($oldversion < 2017081102) {
        $table = new xmldb_table('block_instructor_profile');
        $field = new xmldb_field('username', XMLDB_TYPE_CHAR, '64', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0');

        // Add new field to table block_instructor_profile
        $dbman->add_field($table, $field);

        // instructor_profile savepoint reached.
        upgrade_block_savepoint($result, 2017081102, 'instructor_profile');

    }

    return $result;
}
