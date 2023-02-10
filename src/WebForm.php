<?php
/**
 * WebForm.php
 * collects, saves and executes data in HTML formular
 */
class WebForm
{
    const FORM = "single_form.inc";
    // private $form;           // Dateiname
    const FIELDS = "fields_ship_info.inc";
    // private $fields;         // Dateiname
    private $data;           // Array
    private $not_required;   // Array

    function __construct($form,$fields,$data=NULL)
    {
        if(is_string($form) and is_string($fields))
        {
            echo "<pre>";
            #var_dump($form);
            #var_dump($fields);
            echo "</pre>";
            $this->form=$form;
            $this->fields=$fields;
        }
        else
        {
            throw new Exception("Die ersten 2 Parameter m&uuml;ssen Dateinamen sein.");
        }

        if($data==NULL OR is_array($data))
        {
            $this->data=$data;
        }
        else
        {
            throw new Exception("Die ersten 2 Parameter m&uuml;ssen Dateinamen sein.");
        }
    }

    function setFieldsNotRequired($not_required)
    {
        if( !is_array($not_required))
        {
            throw new Exception("Felder m&uuml;ssen in Array &uuml;bergeben werden.");
        }
        else
        {
            $this->not_required = $not_required;
        }
    }

    function displayForm()
    {
        #echo "<pre>";
        #var_dump($this->data);
        #var_dump($this->fields);
        #var_dump($this->form);
        @extract($this->data);
        include($this->fields);
        #var_dump($page);

        include($this->form);
        echo "</pre>";
    }

    function getAllFields()
    {
        return $this->data;
    }

    function checkForBlanks()
    {
        if(sizeof($this->data) < 1)
        {
            throw new Exception("Keine Formulardaten.");
        }

        foreach($this->data as $key => $value)
        {
            if($value == "")
            {
                $match = "no";
                if(is_array($this->not_required))
                {
                    foreach($this->not_required as $field)
                    {
                        if($field == $key)
                        {
                            $match == "yes";
                        }
                    }
                }
                if($match == "no")
                {
                    $blanks[] = $key;
                }
            }
        }
        if(isset($blanks))
        {
            return $blanks;
        }
        else
        {
            return TRUE;
        }
    }

    function verifyData()
    {
        if(sizeof($this->data)<1)
        {
            throw new Exception("Keine Formulardaten");
        }
        foreach($this->data as $key => $value)
        {
            if(!empty($value))
            {
                if(preg_match("/name/",$key) and !preg_match("/user/",$key))
                {
                    $result = $this->checkName($value);
                    if(is_string($result))
                    {
                        $errors[$key] = $result;
                    }  
                }

                if(preg_match("/addr/",$key) or preg_match("/street/",$key) or preg_match("/city/",$key))
                {
                    $result = $this->checkAddress( $value );
                    if(is_string($result))
                    {
                        $errors[$key] = $result;
                    }  
                }

                if(preg_match("/email/",$key))
                {
                    $result = $this->checkEmail($value);
                    if(is_string($result))
                    {
                        $errors[$key] = $result;
                    }  
                }

                if(preg_match("/phone/",$key) or preg_match("/fax/",$key))
                {
                    $result = $this->checkPhone($value);
                    if(is_string($result))
                    {
                        $errors[$key] = $result;
                    }  
                }

                if(preg_match("/zip/",$key))
                {
                    $result = $this->checkZip($value);
                    if(is_string($result))
                    {
                        $errors[$key] = $result;
                    }  
                }
            }
        }
        if(isset($errors))
        {
            return $errors;
        }
        else
        {
            return TRUE;
        }
    }

    function trimData()
    {
        foreach($this->data as $key => $value)
        {
            $data[$key] = trim($value);
        }
        $this->data = $data;
    }

    function stripTagsFromData()
    {
        foreach($this->data as $key => $value)
        {
            $data[$key] = strip_tags($value);
        }
        $this->data = $data;
    }

    function checkName($field)
    {
        if(!preg_match("/^[A-Za-z' -]{1,50}$/",$field))
        {
            return "$field ist kein g&uuml;ltiger Name. Versuchen Sie es erneut.";
        }
        else
        {
            return TRUE;
        }
    }

    function checkAddress($field)
    {
        if(!preg_match("/^[A-Za-z0-9.,' -]{1,50}$/",$field))
        {
            return "$field ist keine g&uuml;ltige Adresse. Versuchen Sie es erneut.";
        }
        else
        {
            return TRUE;
        }
    }

    function checkZip($field)
    {
        if(!preg_match("/^[0-9]{5}{\-[0-9]{4}}?$/",$field))
        {
            return "$field ist keine g&uuml;ltige Postleitzahl. Versuchen Sie es erneut.";
        }
        else
        {
            return TRUE;
        }
    }

    function checkPhone($field)
    {
        if(!preg_match("/^[0-9]) (Xx -]{7,20}$/",$field))
        {
            return "$field ist keine g&uuml;ltige Tel. Nr. Versuchen Sie es erneut.";
        }
        else
        {
            return TRUE;
        }
    }

    function checkEmail($field)
    {
        if(!preg_match("/^.+@.+\\..+$/",field))
        {
            return "$field ist keine g&uuml;ltige E-Mail-Adresse. Versuchen Sie es erneut.";
        }
        else
        {
            return TRUE;
        }
    }
}
?>