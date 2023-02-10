<?php
/**
 * Orders-oo.php
 * all functions for online shopping application
 * name of submit-button is going to be checked what part of program
 * woul dbe executed
 */
require("Item.php");
// require("Catalog.php");
require("ShoppingCart.php");
require("WebForm.php");
require("WebPage.php");
require("Order.php");
require("Database.php");
include("functions.inc");
session_start();

if(isset($_POST['Products']) && isset($_POST['interest']))
{
    try
    {
        $catalog=new Catalog('vars.inc');
        $catalog->selectCatalog('baumarkt');
        $catalog->displayAllofType($_POST['interest'],2);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        exit();
    }
}
elseif(isset($_POST['Cart']))
{
    $cart = new ShoppingCart();
    if($_POST['Cart'] == "Warenkorb aktualisieren")
    {
        try
        {
            $cart->updateCart($_POST);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }
    elseif($_POST['Cart'] == "In den Warenkorb")
    {
        foreach($_POST as $field => $value)
        {
            if(preg_match("/item/",$field) && $value > 0)
            {
                try
                {
                   $cat_no = substr($field,4);
                   $item = new Item($cat_no,$value);
                   $cart->addItem($item); 
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                    exit();
                }
            }
        }
    }
    try
    {
        $cart->displayCart("fields_cart-oo.inc","table_page-oo.inc");
    }
    catch (Exception $e)
    {
        echo $e->getMessage;
        exit();
    }
}
elseif(isset($_POST['Ship']))
{
    try
    {
        $db = new Database("vars.inc");
        $db->useDatabase("baumarkt");
        $order = new Order($db->getConnection(),"bestellung");
        if(isset($_SESSION['bestell_nr']))
        {
            $order->selectOrder($_SESSION['bestell_nr']);
        }
        else
        {
            $order->createOrder();
        }
        $ord = $order->getOrderNumber();
        $info = $order->getOrderInfo();
        $form = new WebForm("single_form.inc","fields_ship_info.inc",$info);
        $form->displayForm();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
        exit();
    }
}
elseif(isset($_POST['Summary']))
{
    try
    {
        $form = new WebForm("single_form.inc","fields_ship_info.inc",$_POST);
        $blanks = $form->checkForBlanks();
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    if(is_array($blanks))
    {
        $GLOBALS['message'] = "Die foglenden Felder sind
                               leer. Bitte geben Sie die
                               erforderlichen Daten ein: ";
        foreach($blanks as $value)
        {
            $GLOBALS['message'].="$value, ";
        }
        $form->trimData();
        $form->stripTagsFromData();
        try
        {
            $errors = $form->verifyData();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if(is_array($errors))
        {
            $GLOBAL['message']="";
            foreach($errors as $value)
            {
                $GLOBALS['message'].="$value<br> ";
            }
            $form->displayForm();
            exit();
        }
        try
        {
            $db = new Database("vars.inc");
            $db->useDatabase("baumarkt");
            $order = new Order($db->getConnection(),"bestellung");
            $order->selectOrder($_SESSION['bestell_nr']);

            // Versanddaten in DB aufnehmen.
            $order->updateOrderInfo($_POST);
            
            // Elemente in DB aufnehmen
            $cart = new ShoppingCart();
            $order->addCart($cart);

            // Auftragszusammenfassung anzeigen
            $order->displayOrderSummary("fields_summary-oo.inc","summary_page.inc");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    elseif(isset($_POST['Final']))
    {
        if($_POST['Final'] == "Bestellung aufgeben")
        {
            $order->setSubmitted();
            $order->sendToShipping();
            $order->sendEMailtoCustomer();
            $confirm = new WebPage("confirm_page.inc",$data);
            $confirmpage->displayPage();
        }
        else
        {
            $order->cancel();
            $unapp = new WebPage("not_accepted_page.inc",$data);
            $unapp->displayPage();
            unset($_SESSION['bestell_nr']);
            unset($_SESSION);
            session_destroy();
        }
    }
    else
    {
        $order->cancel();
        $cancel = new WebPage("not_accepted_page.inc",$data);
        $cancel->displayPage();
        unset($_SESSION['bestell_nr']);
        unset($_SESSION );
        session_destroy();
    }
}
else
{
    $catalog = new Catalog("vars.inc");
    $catalog->selectCatalog("baumarkt");
    $catalog->displayCategories();
}