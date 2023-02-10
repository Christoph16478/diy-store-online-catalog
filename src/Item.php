<?php
/**
 * Item.php
 * single element of order
 */
class Item
{
    private $catalog_number;
    private $quantity;
    private $name;
    private $price;

    function __construct($cat_no,$quantity)
    {
        if(is_string($cat_no) && is_numeric($quantity))
        {
            $this->menge = $quantity;
            $this->katalog_nr = $cat_no;
            $cat = new Catalog("vars.inc");
            $cat->selectCatalog("baumarkt");
            $this->name = $cat->getName($cat_no);
            $this->preis = $cat->getPrice($cat_no);
        }
        else
        {
            throw new Exception("Parameter keine g&uuml;ltige Katalognummer/Menge");
        }
    }

    function getCatalogNumber()
    {
        return $this->katalog_nr;
    }

    function getQuantity()
    {
        return $this->menge;
    }

    function getPrice()
    {
        return $this->preis;
    }

    function getName()
    {
        return $this->name;
    }
}
?>