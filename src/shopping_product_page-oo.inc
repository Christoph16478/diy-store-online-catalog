<?php
/*
 * shopping_product_page-oo.inc
 * displays the products from the catalog for a selected product group
 */
include_once("fields_product_page.inc");
?>
<html>
    <head>
        <title>
            <?php echo $page['title'] ?>
        </title>
    </head>
    <body>
        <?php
            echo "<form action='$_SERVER[PHP_SELF]' method='POST'>\n
            <p style='text-align:right'>\n
            <input type='submit' name='Cart' value='Warenkorb anzeigen'>\n
            </form>\n";
            echo "<div style='margin-left:.1in;margin-right:.1in'>
            <h1 align='center'>{$page['top']}</h1>
            <p style='font-size:150%'><b>{$_POST['interest']}</b>\n";
            echo "<p align='right'>$n_products Produkt(e) gefunden";
            echo "<table border='0' cellpadding='5' width='100%'>";
            echo "<tr>";
            foreach($table_heads as $heading)
            {
                echo "<th>$heading</th>";
            }     
            echo "</tr>";
            echo "<form action='$_SERVER[PHP_SELF]' method='POST'>\n";
            for ($i=$n_start;$i<=$n_end;$i++)
            {
                echo "<tr>";
                echo "<td align='center' width='10%'>{$all[$i]->katalog_nr}</td>\n";
                echo "<td align='center'>{$all[$i]->name}</td>\n";
                echo "<td align='center'>{$all[$i]->pr_beschr}</td>\n";
                echo "<td align='right' width='12%'>{$all[$i]->preis} Euro</td>\n";
                echo "<td align='center' width='12%'><input type='text' name='item{$all[$i]->katalog_nr}' value='0' size='4'></td>\n";
                echo "</tr>";
            }
            echo "<input type='hidden' name='n_end' value='$n_end'>";
            echo "<input type='hidden' name='interest' value='$_POST[interest]'>";
            echo "<tr>
                  <td colspan='2'>
                  <input type='submit' value='Andere Kategorie'></td>\n";
            echo "<td colspan='2'>
                  <input type='submit' name='Cart' value='In den Warenkorb'></td>\n";
            echo "<td colspan='2' align='right'>\n";
            if($n_end > $n_per_page)
            {
                echo "<input type='submit' name='Products' value='Vorherige'>\n";
            }
            if($n_end < $n_products)
            {
                echo "<input type='submit' name='Products' value='N&auml;chste $n_per_page'>\n";
            }
            echo "</td></form></tr></table>\n";
            echo "<p style='align:center;'><font size='-1'>{$page['bottom']}</font></p>\n";
            ?>
        </div>
    </body>
</html>
 