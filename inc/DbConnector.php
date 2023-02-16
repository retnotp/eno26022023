
<?php

/**
 * Class	: DbConnector
 * Purpose	: Connect to a database Mysqli
 */
require_once('SystemComponent.php');

class DbConnector extends SystemComponent
{

    var $theQuery;
    var $link;
    var $debug = 1;

    // Function: DbConnector, Purpose: Connect to database
    function __construct()
    {
        // Load settings from parent class
        $settings = SystemComponent::getSettings();

        // Get main setting from the array we just loaded
        $host = $settings['dbhost'];
        $db = $settings['dbname'];
        $user = $settings['dbusername'];
        $pass = $settings['dbpassword'];

        // Connect to the database
        $this->link = new mysqli($host, $user, $pass, $db);
        if (mysqli_connect_errno()) {
            echo "<center><font color=red><BR /><BR /><BR /><BR />DATABASE eror</font></center> ";
            exit();
        }
    }

    // Function: query, Purpose: Execute a database query
    function query($sql)
    {
        $this->theQuery = $sql;
        return mysqli_query($this->link, $sql);
    }

    // Function: getQuery, Purpose: Returns the last database query, for debugging
    function getQuery()
    {
        return $this->theQuery;
    }

    // Function: getNumRows, Purpose: Return row count, mysql version 
    function getNumRows($result)
    {
        return mysqli_num_rows($result);
    }

    // Function: fetchArray, Purpose: Get array of query result
    function fetchArray($result)
    {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    function fetchRow($result)
    {
        return mysqli_fetch_row($result);
    }

    // Function: fetchObject, Purpose: Get object of query result
    function fetchObject($result)
    {
        return mysqli_fetch_object($result);
    }

    // Function: close, Purpose: Close the connection
    function close()
    {
        return mysqli_close($this->link);
    }

    // Function: escaped
    function escaped($result)
    {
        return mysqli_real_escape_string($this->link, $result);
    }

    // Function: check last id
    function checkId()
    {
        return mysqli_insert_id($this->link);
    }
}

?>