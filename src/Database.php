<?php
/**
 * Database.php
 * class for connection to the MySQL database
 */
class Database
{
    private $cxn;
    private $database_name;
    private $host;
    private $user;
    private $password;

    function __construct($filename)
    {
        include($filename);
        if(!$this->cxn = new mysqli($host,$user,$passwd))
        {
            throw new Exception("DDatenbank nicht verf&uuml;gbar. Versuchen Sie es sp&auml;ter erneut.");
            email("dbadmin@unseresite.de","DB-Problem","MySQL-Server antwortet nicht. ".$this->cxn->error());
            exit();
        }
        $this->host=$host;
        $this->user=$user;
        $this->password=$passwd;
    }

    function useDatabase($dbname)
    {
        if(!$result=$this->cxn->query("SHOW DATABASES"))
        {
            throw new Exception("DDatenbank nicht verf&uuml;gbar. Versuchen Sie es sp&auml;ter erneut.");
            email("dbadmin@unseresite.de","DB-Problem","MySQL-Server antwortet nicht. ".$this->cxn->error());
            exit();
        }
        else
        {
            while($row=$result->fetch_row())
            {
                $databases[]=$row[0];
            }
        }
        if(in_array($dbname,$databases) || in_array(strtolower($dbname),$databases))
        {
            $this->database_name=$dbname;
            $this->cxn->select_db($dbname);
            return TRUE;
        }
        else
        {
            throw new Exception("Datenbank $dbname nicht gefunden.");
            return FALSE;
        }
    }

    function getConnection()
    {
        return $this->cxn;
    }

    function getDatabaseName()
    {
        return $this->database_name;
    }
}
?>