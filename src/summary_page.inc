<?php
/*
 * summary_page.inc
 * defines an HTML page that displays a summary of the order
 */
echo "<html>
        <head><title>{$page['title']}</title></head>\n
        <body>\n";
echo "<h2 style='text-align:center'>{$page['top']}</h2>";
echo "<p style='position:absolute;margin-top:.25in;
        font-weight:bold'>Adresse:</p>";
echo "<p style='position:absolute;margin-top:.25in;
        margin-left:.75in'>$ship_name<br>";
echo "$ship_street<br>
    $ship_zip $ship_city $ship_state<br>
    $phone<br>
    $email<br>";
echo "<div style='margin-top:1.5in'>";
echo "<p style='font-weight:bold'>
Auftrag Nummer: $table_name\n";
echo "<table border='0' style='width:100%'>\n";
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
echo "<tr>";
foreach($table_headers as $header)
{
    echo "<th>$header</th>\n";
}
echo "</tr><tr><hr></tr>";
for($i=1;$i<=sizeof($items);$i++)
{
    echo "<tr>";
    echo "<td width='10%' align='center'>$i</td>";
    echo "<td width='10%' align='center'>{$items[$i]['katalog_nr']}</td>";
    echo "<td align='center'>{$items[$i]['name']}</td>";
    echo "<td align='center'>{$items[$i]['menge']}</td>";
    $f_price = number_format($items[$i]['preis'],2);
    echo "<td align='right' width='12%'>$f_price Euro</td>\n";
    $total = $items[$i]['quantity'] * $items[$i]['price'];
    $f_total = number_format($total,2);
    echo "<td align='right' width='12%'>$f_total Euro</td>\n";
    echo "</tr>";
    @$order_subtotal = $order_subtotal + $total;
}
$f_order_subtotal = number_format($order_subtotal,2);
if($ship_state == DE) # Steuer nur fuer Deutschland
{
    $taxrate = 0.0700;
}
else
{
    $taxrate = 0.00;
}
$sales_tax = $order_subtotal * $taxrate;
$f_sales_tax = number_format($sales_tax,2);
$shipping = $shipping_rate * sizeof($items);
$f_shipping = number_format($shipping,2);
$order_total = $order_subtotal + $sales_tax + $shipping;
$f_order_total = number_format($order_total,2);
echo "<tr><td colspan='6'><hr></td></tr>\n";
echo "<tr><td colspan='5' style='text-align:right;font-weight:bold'>Zwischensumme</td></tr><td style='text-align:right;line-height:200%'>$f_order_subtotal Euro</td></tr>\n";
echo "<tr><td colspan='5' style='text-align:right;font-weight:bold;>MwSt</td><td style='text-align:right;line-height:75%'>$f_sales_tax Euro</td></tr>\n";
echo "<tr><td colspan='5' style='text-align:right;font-weight:bold;>Versandkosten</td><td style='text-align:right;line-height:75%'>$f_shipping</td></tr>\n";

echo "<tr><td colspan='6'><hr></td></tr>\n";

echo "<tr><td colspan='5' style='text-align:right;font-weight:bold;>Gesamtsumme</td><td style='text-align:right;line-height:300%'>$f_order_total</td></tr>\n";

echo "<tr><td colspan='2' style='text-align:left;'><input type='submit' value='Einkauf fortsetzen'></td>\n";
echo "<tr><td colspan='1' style='text-align:left;'><input type='submit' name='Ship' value='Versanddaten bearbeiten'></td>\n";
echo "<tr><td colspan='1' style='text-align:left;'><input type='submit' name='Final' value='Bestellung abbrechen'></td>\n";
echo "<tr><td colspan='2' style='text-align:right;'><input type='submit' name='Final' value='Bestellung aufgeben'></td>\n";
echo "</tr></table></form>\n";
?>