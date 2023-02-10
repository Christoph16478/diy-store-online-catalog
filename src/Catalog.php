<?php
/**
 * Catalog.php
 * class contains functions for catalog data
 */
class Catalog
{
    private $cxn;
    private $catalog_name;
    private $host;
    private $user;
    private $password;

    function __construct($filename)
    {
        if(is_string($filename))
        {
            include("$filename");
        }
        else
        {
            throw new Exception("Parameter ist kein Dateiname");
        }
        $this->cxn = new mysqli($host,$user,$passwd);
        if(mysqli_connect_errno())
        {
            throw new Exception("Datenbank ist nicht verf&uuml;gbar. Versuchen Sie es sp&auml;ter erneut.");
            exit();
        }
        $this->host = $host;
        $this->user = $user;
        $this->password = $passwd;
    }

    function selectCatalog($database)
    {
        $db = $this->cxn->select_db($database);
        if(mysqli_errno($this->cxn))
        {
            if(mysqli_errno($this->cxn)==1049)
            {
                throw new Exception("$database existiert nicht.");
                exit();
            }
            else
            {
                throw new Exception("Datenbank ist nicht verf&uuml;gbar. Versuchen Sie es sp&auml;ter erneut.");
                exit();    
            }
        }
        $this->catalog_name=$database;
    }

    function getCategoriesAndTypes()
    {
        $sql = "SELECT DISTINCT kateins,katzwei FROM katalog ORDER BY kateins,katzwei";
        if(!$result = $this->cxn->query($sql))
        {
            throw new Exception(mysqli_error($this->cxn));
            exit();
        }
        while($row=$result->fetch_array())
        {
            $array_cat_type[$row['kateins']][]=$row['katzwei'];
        }
        return $array_cat_type;
    }
    function getAllofType($type)
    {
        if(is_string($type))
        {
            $sql = "SELECT * FROm katalog WHERE katzwei='$type' ORDER BY name";
        }
        else
        {
            throw new Exception("$type ist nicht katzwei");
            exit();
        }
        if(!$result = $this->cxn->query($sql))
        {
            throw new Exception(mysqli_error($this->cxn));
            exit();
        }
        $n=1;
        while($row=$result->fetch_object())
        {
            $array_all[$n]=$row;
            $n++;
        }
        return $array_all;
    }

    function displayCategories()
    {
        $food_categories=$this->getCategoriesAndTypes();
        include("fields_index_page.inc");
        include("catalog_index_page.inc");
    }

    function displayAllofType($type,$page)
    {
        if(is_string($type))
        {
            $all=$this->getAllofType($type);
        }
        else
        {
            throw new Exception("$type ist kein Typ.");
            exit();
        }
        if(is_int($page))
        {
            $n_per_page=$page;
        }
        else
        {
            throw new Exception("$page ist nicht Integer.");
            exit();
        }
        $n_products=sizeof($all);
        if(isset($_POST['n_end']))
        {
            if($_POST['Products']=="Vorherige")
            {
                $n_start=$_POST['n_end']-($n_per_page);
            }
            else
            {
                $n_start=$_POST['n_end']+1;
            }
        }
        else
        {
            $n_start=1;
        }
        $n_end=$n_start+$n_per_page-1;
        if($n_end>=$n_products)
        {
            $n_end=$n_products;
        }
        include("fields_product_page.inc");
        include("shopping_product_page-oo.inc");
    }

    function getName($catalog_number)
    {
        if(preg_match("/[0-9]*/",$catalog_number))
        {
            $sql="SELECT name,katzwei FROM katalog WHERE katalog_nr='$catalog_number'";
        }
        else
        {
            throw new Exception("$katalog_nr ist keine Katalognummer.");
            exit();
        }
        if(!$result=$this->cxn->query($sql))
        {
            throw new Exception(mysqli_error($this->cxn));
            exit();
        }
        $name=$result->fetch_assoc();
        return "{$name['name']}"."{$name['katzwei']}";
    }
    function getPrice($katalog_nr)
    {
        if(preg_match("/[0-9]*/",$katalog_nr))
        {
            $sql="SELECT preis FROM katalog WHERE katalog_nr='$katalog_nr'";
        }
        else
        {
            throw new Exception("$katalog_nr ist keine Katalognummer.");
            exit();
        }
        if(!$result=$this->cxn->query($sql))
        {
            throw new Exception(mysqli_error($this->cxn));
            exit();
        }
        $price=$result->fetch_assoc();
        return "{$price['preis']}";
    }
}
?>