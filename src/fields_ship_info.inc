<?php
/* 
 * fields_ship_info.inc
 * contains arrays with the field names and form elements for the shipping data
 */
include("connect_to_db.inc");
include("functions.inc");
include("fields_product_page.inc");
require("Database.php");
include("connect_to_db.inc");
include("vars.inc");
require("Item.php");
require("ShoppingCart.php");
require("WebForm.php");
require("WebPage.php");
require("Order.php");
require("Database.php");

$page = array(
    "title" => "Der Baumarkt: Versanddaten",
    "top" => "Bestellung aufgeben: Versanddaten",
    "top2" => "Be Fragen oder Problemen wenden Sie sich am admin@baumarkt.de",
    "bottom" => "Bei Fragen oder Problemen wenden Sie sich an admin@baumarkt.de"
);
$ship_info = array(
    "email" => "E-Mail Adresse",
    "vers_name" => "Vor-/Nachname",
    "vers_strasse" => "Stra&szlige",
    "vers_ort" => "Stadt",
    "sta" => "Staat",
    "vers_postl" => "PLZ",
    "telefon" => "Tel.",
    "cc_type" => "Kreditkartentyp",
    "cc_number" => "Kreditkartennummer",
    "cc_exp" => "G&uuml;ltig bis"
);
$cc_types = array(
    "visa" => "Visa",
    "mc" => "Mastercard",
    "amex" => "American Express",
);
$length = array(
    "email" => "55",
    "vers_name" => "40",
    "vers_strasse" => "55",
    "vers_ort" => "40",
    "vers_postl" => "10",
    "telefon" => "15",
    "cc_number" => "20"
);
$months = array(1 => "Januar", "Februar", "M&auuml;rz", "April", "Mai",
        "Juni", "Juli", "August", "Sebtember", "Oktober",
        "November", "Dezember"
);
$today = time();
$elements = array("submit" => "Weiter");
$connect = connect_to_db("vars.inc");
$sql = "SELECT vers_name,vers_strasse,vers_ort,sta,vers_postl,telefon,email FROM bestellung WHERE bestell_nr='{$_SESSION['bestell_nr']}'";
$result = mysqli_query($connect,$sql) or die("Error: ".mysqli_error($connect));
$n = mysqli_num_rows($result);
if($n > 0)
{
    $row = mysqli_fetch_assoc($result);
    extract($row);
}
?>