<?php
/*
 * fields_summary.inc
 * creates the arrays necessary for displaying a summary of the order
 */
include_once("summary_page.inc");
$page = array(
    "title" => "Der Baumarkt - Bestellung",
    "top" => "Der Baumarkt - Bestellung",
    "top2" => "Zusammenfassung der Bestellung",
    "bottom" => "Bei Fragen oder Problemen wenden Sie
                sich an admin@Baumarkt.de" 
);
$table_headers = array(
    "Pos.","Kat.Nr.","Bezeichnung","Menge","Preis","Gesamt"
);
$order_number = $_SESSION['bestell_nr'];
$shipping_rate = .25;
$table_name = $order_number;
?>