<?php
/*
 * single_form.inc
 * code for a web page that displays an HTML form displayed
 */
// include_once("functions.inc");
// include_once("fields_ship_info.inc");
// include_once("summary_page.inc");
echo "<head><title>{$page['title']}</title></head>\n
<h2 align='center'>{$page['top']}</h2>\n
<p style='font-style:italic;font-weight:bold'>{$page['top2']}\n
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<table border='0' cellpadding='5' cellspacing='0'>\n";
if(isset($GLOBALS['message']))
{
    echo "<tr>
    <td colspan='2' style=\"font-weight:bold;font-style:italic;font-size:90%;color:red;\">
    {$GLOBALS['message']}<p></td></tr>";
}
foreach($ship_info as $field=>$value)
{
    if($field=="ship_state")
    {
        echo "<tr><td style=\"text-align:right;font-weight:bold;\">Staat</td>
        <td><select name='sta'>";
        $stateName=getStateName();
        $stateCode=getStateCode();
        for($n=1;$n<=19;$n++)
        {
            $state=$stateName[$n];
            $scode=$stateCode[$n];
            echo "<option value='$scode'";
            if($scode=="AL")
            {
                echo " selected";
            }
            echo ">$state\n";
        }
        echo "</select>";
    }
    elseif($field=="cc_type")
    {
        echo "<tr><td style=\"text-align:right;font-weight:bold\">
        Kreditkartentyp</td><td><select name='cc_type'>";
        foreach($cc_types as $field => $value)
        {
            echo "<option value='$field'>";
            echo "$value\n";
        }
        echo "</select>";
    }
    elseif($field == "cc_exp")
    {
        echo "<tr><td style=\"text-align:right;font-weight:bold\">
        G&uuml;ltig bis</td><td><select name='cc_exp_mo'>";
        for($n=1;$n=12;$n++)
        {
            echo "<option value='$n'>{$months[$n]}\n";
        }
        echo "</select>\n";
        echo "<select name='cc_exp_da'>";
        for($n=1;$n<=31;$n++)
        {
            echo "<option value='$n'>$n\n";
        }
        echo "</select>\n";
        echo "<select name='cc_exp_yr'>";
        $start_yr = date("Y",$today);
        for($n=$start_yr;$n<=$start_yr+5;$n++)
        {
            echo "<option value='$n'>$n\n";
        }
        echo "</select>\n";
    }
    else
    {
        echo "<tr>
            <td style=\"text-align:right;font-weight:bold\">$value</td>
            <td>
                <input type='text' name='$field' value='".@$$field."' size='{$length[$field]}' maxsize='{$length[$field]}'/>
            </td>
        </tr>";


    }
}
?>
<tr><td colspan='2' style='text-align:center'>
        <p style='margin-top:.05in'>
            <input type='submit' name='Summary' value='<?php echo $elements['submit'] ?>'>
        </p>
    </td>
</tr>
</table>
</form>
</body>
</html>
        