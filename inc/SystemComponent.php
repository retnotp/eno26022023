<?php
class SystemComponent
{
    var $settings;

    /**
     * Database variable
     */
    function getSettings()
    {

        $settings['dbhost'] = 'localhost';
        $settings['dbusername'] = 'root';
        $settings['dbpassword'] = '';
        $settings['dbname'] = 'db_test16feb';
        return $settings;
    }
}
