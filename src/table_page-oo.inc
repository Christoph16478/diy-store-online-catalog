<?php
/*
 * table_page-oo.inc
 * defines a HTML page, with products in a table with price information
 */
include_once("fields_cart-oo.inc");
echo "<html>
    <head><title>{$page['title']}</title></head>\n
    <body>\n";
echo "<h1 style='text-align:center'>{$page['top']}</h1>\n";
echo "<h2 style='text-align:center'>{$page['top2']}</h2>\n";
echo "<p style='font-weight:bold'>$this->message<hr>\n";
echo "<table border='0' style='width:100%'>\n";
echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
if(sizeof($this->items) > 0)
{
    echo "<tr>";
    foreach($table_headers as $header)
    {
        echo "<th>$header</th>";
    }
    echo "</tr>";
    echo "<tr><td colspan='6'><hr></td></tr>\n";
    for($i=0;$i<sizeof($this->items);$i++)
    {
        echo "<tr>";
        echo "<td width='5%' align='center'>".($i+1)."</td>\n";
        $cat=new Catalog("vars.inc");
        $cat->selectCatalog("baumarkt");
        $cat_no = $this->items[$i]->getCatalogNumber();
        $bau_name=$cat->getName($cat_no);
        echo "<td width='5%' align='center'>$cat_no</td>\n";
        echo "<td align='center'>".$bau_name."</td>\n";
        echo "<td width='20%' style='text-align:center'>
        <input size='4' type='text' name='item$cat_no' value='"
        .$this->items[$i]->getQuantity()."'>Stueck</td>\n";
        echo "<td width='15%' align='right'>".number_format($this->items[$i]->getPrice(),2)." Euro</td>\n";
        $total=$this->items[$i]->getQuantity() * $this->items[$i]->getPrice();
        echo "<td align='right' width='10%'>".number_format($total, 2)." Euro</td>\n";
        @$order_total=$order_total+$total;          
    }
    $f_order_total=number_format($order_total,2);
    echo "<tr><td colspan='6'><hr></tr>";
    echo "<tr><td colspan='5' style='text-align:right; font-weight:bold'>Gesamt</td>
    <td style='text-align:right;line-height:200%'>$f_order_total Euro</td></tr>\n";
    echo "<tr><td colspan='6'><hr></tr>";
    echo "<tr><td colspan='2' style='text-align:left'><input type='submit' value='Einkauf fortsetzen'></td>\n";
    echo "<tr><td colspan='2' style='text-align:center'><input type='submit' name='Ship' value='Bestellung aufgeben'></td>\n";
    echo "<tr><td colspan='2' style='text-align:right'><input type='submit' name='Cart' value='Warenkorb aktualisieren'></td>\n";
    echo "</tr>\n";
}
else
{
    echo "<hr>";
    echo "<tr><td colspan='5' style='text-align:left'><input type='submit' value='Einkaufen fortsetzen'></td>\n";
}
?>
</table>
</form>