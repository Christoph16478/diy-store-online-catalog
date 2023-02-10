<?php
/**
 * WebPage.php
 * class for homepage display
 */
class WebPage
{
    private $filename;
    private $data;

    function __construct($filename,$data=NULL)
    {
        if(is_string($filename))
        {
            $this->filename = $filename;
        }
        else
        {
            throw new Exception("Dateiname muss String sein.");
        }

        if($data == NULL or is_array($data))
        {
            $this->data = $data;
        }
        else
        {
            throw new Exception("Daten m&uuml;ssen einem array &uuml;bergeben werden.");
        }
    }

    function displayPage()
    {
        include("fields_summary-oo.inc");
        @extract($this->data);
        include($this->filename);
    }
}
?>