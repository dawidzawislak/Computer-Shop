<?php
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'sklep';

function ReleaseSessionVar($name)
{
    if(isset($_SESSION[$name]))
    	unset($_SESSION[$name]);
}

function Alert($message)
{
    echo "<script>alert('$message');</script>";
}

/*  ----- Drawing profile options and order status functions ------------------------------------------------------------------------------------------------------ */
function ProfileInfo()
{
    if(isset($_SESSION['log']))
    {
        echo '<a href="orders.php">'.$_SESSION['name']." ".$_SESSION['lname']."</a><br>";

        echo '<div style="text-align: left; float:left; font-size: 20px;"><a href="edit_profile.php">Edytuj profil</a></div>';
        echo '<a href="logout.php"><i class="icon-logout"></i></a>';
        echo '<div class="clear"></div>';
    }
    else
    {
        echo '<a href="login.php">Zaloguj się</a><br>';
        echo '<a href="reg.php">Utwórz konto</a>';
    }
}

function DrawProgressBar($hide, $step = 0)
{
    if(!$hide && $step != 0)
    {
        $tab = array("Płyta główna", "Procesor", "Karta graficzna", "Zasilacz", "RAM", "Dysk1", "Dysk2", "Obudowa", "Dane kontaktowe", "Podsumowanie");
        echo '<div id="prog">';
        for($i = 1; $i <= count($tab); $i++)
        {
            if($i != count($tab) && $i != $step)
                $tab[$i-1] .= " &#10140; ";
            if($i == $step)
            {
                echo '<div id="prog_step">'.$tab[$i-1].'</div>';
                if($i != count($tab))
                    echo '  &#10140; ';
            }
            else
                echo '<div class="prog_text">'.$tab[$i-1].'</div>';
        }
        echo '</div>';
    }
}
/*  ----- END: Drawing profile options and order status functions ------------------------------------------------------------------------------------------------  */

/*  ----- Update session variables and DB functions ----------------------------------------------------------------------------------------------------------- */
function ClientDataToSessionVars()
{
    global $host, $dbuser, $dbpass, $dbname;
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if($conn->connect_error)
        die("Connection to \"sklep\" failed: ".$conn->connect_error);

	$query = "SELECT * FROM klienci WHERE login = \"".$_SESSION['log']."\";";
    $result = $conn->query($query);
    if ($result === FALSE)
        echo "Error: ".$query ."<br>".$conn->error;

    $row = $result->fetch_assoc();

    if($row['imie'] != '')
        $_SESSION['name'] = $row['imie'];

    if($row['nazwisko'] != '')
        $_SESSION['lname'] = $row['nazwisko'];

    if($row['telefon'] != '')
        $_SESSION['phone'] = $row['telefon'];

    if($row['email'] != '')
        $_SESSION['email'] = $row['email'];

    if($row['miasto'] != '')
        $_SESSION['city'] = $row['miasto'];

    if($row['kod_pocztowy'] != '')
        $_SESSION['pcode'] = $row['kod_pocztowy'];

    if($row['adres'] != '')
        $_SESSION['address'] = $row['adres'];

    $conn->close();
}

function UnsetClientDataInSessionVars()
{
    if(isset($_SESSION['phone']))
	 	  unset($_SESSION['phone']);
    if(isset($_SESSION['email']))
        unset($_SESSION['email']);
    if(isset($_SESSION['city']))
        unset($_SESSION['city']);
    if(isset($_SESSION['pcode']))
        unset($_SESSION['pcode']);
    if(isset($_SESSION['address']))
        unset($_SESSION['address']);
}

function UpdateClientDataInDB(&$query, $column, $post_field)
{
    if(isset($_POST[$post_field]))
    {
        if(isset($_SESSION[$post_field]))
        {
            if(!empty($_POST[$post_field]) && $_POST[$post_field] != $_SESSION[$post_field])
            {
                if($post_field == "pcode")
                {
                    $code = trim($_POST['pcode']);
                    if(strlen($code) >= 3)
                        if($code[2] == '-' & strlen($code) == 6)
                            $query .= $column." = \"".$code."\" ,";
                }
                if($post_field == 'email')
                    $query .= $column." = \"".mb_strtolower($_POST[$post_field])."\" ,";
                else
                    $query .= $column." = \"".ucwords($_POST[$post_field])."\" ,";
            }
        }
        else 
        {
            if(!empty($_POST[$post_field]))
            {
                if($post_field == "pcode")
                {
                    $code = trim($_POST['pcode']);
                    if(strlen($code) >= 3)
                        if($code[2] == '-' & strlen($code) == 6)
                            $query .= $column." = \"".$code."\" ,";
                }
                if($post_field == 'email')
                    $query .= $column." = \"".mb_strtolower($_POST[$post_field])."\" ,";
                else
                    $query .= $column." = \"".ucwords($_POST[$post_field])."\" ,";
            }
        }
    }
}
/*  ----- END: Update and session variables and DB functions --------------------------------------------------------------------------------------------------- */

/*  ----- Createing filters functions --------------------------------------------------------------------------------------------------------------------------- */
function CreateCheckboxesForProperty($label, $prop, $table_name, $conn, $condition = '')
{
    $query = "SELECT DISTINCT $prop FROM $table_name WHERE ilosc_sztuk > 0 ".($condition != '' ? "AND ".$condition : '')." ORDER BY ".$prop." ASC;";
    $result = $conn->query($query);
    if ($result === FALSE)
        echo "Error: ".$query ."<br>".$conn->error;

    if($result->num_rows > 0)
    {
        echo '<p><span class="p_header">'.$label.":</span><br>";
        $i = 1;
        while($row = $result->fetch_assoc())
        {
            if($row[$prop] != '')
            {
                $checked = (!isset($_SESSION['reset']) && isset($_POST[$prop.$i])) ? "checked" : "";
                echo '<label class="chbox_opt"><input type="checkbox" name="'.$prop.$i.'" value="'.$row[$prop].'"'.$checked.'>'.$row[$prop].'</label><br>';
                $i++;
            }
        }
        echo "</p>";
        $_SESSION[$prop] = ($i-1);
    }
}
function CreateCheckboxesForMultiProperty($label, $prop, $table_name, $conn)
{
    $query = "SELECT DISTINCT $prop FROM $table_name WHERE ilosc_sztuk > 0 ORDER BY $prop ASC;";
    $result = $conn->query($query);
    if ($result === FALSE)
        echo "Error: ".$query ."<br>".$conn->error;

    if($result->num_rows > 0)
    {
        echo '<p><span class="p_header">'.$label.":</span><br>";
        $i = 1;
        $vals = [];

        while($row = $result->fetch_assoc())
        {
            if($row[$prop] != '')
            {
                $props = explode(',', $row[$prop]);
                foreach ($props as $val)
                    array_push($vals, trim($val));
            }
        }
        $unique_vals = array_unique($vals);
        foreach ($unique_vals as $val)
        {
            $checked = (!isset($_SESSION['reset']) && isset($_POST[$prop.$i])) ? "checked" : "";
            echo '<label><input type="checkbox" name="'.$prop.$i.'" value="'.$val.'"'.$checked.'>'.$val.'</label><br>';
            $i++;
        }
        echo "</p>";
        $_SESSION[$prop] = ($i-1);
    }
}
function CreateCheckboxesForBoolProperty($label, $prop)
{
    echo '<p><span class="p_header">'.$label.":</span><br>";
    $checked1 = (!isset($_SESSION['reset']) && isset($_POST[$prop."1"])) ? "checked" : "";
    $checked2 = (!isset($_SESSION['reset']) && isset($_POST[$prop."2"])) ? "checked" : "";
    echo '<label><input type="checkbox" name="'.$prop."1".'" value="tak"'.$checked1.'>tak</label><br>';
    echo '<label><input type="checkbox" name="'.$prop."2".'" value="nie"'.$checked2.'>nie</label><br>';
    echo '</p>';
    $_SESSION[$prop] = 2;
}

function RememberParams($name)
{
    if (!isset($_SESSION['reset']) && isset($_POST[$name]))
        echo $_POST[$name];
}
function RememberSlectedAsc($name)
{
    if (isset($_POST[$name]) && $_POST[$name] == 'ASC')
        echo "selected";
}
function RememberSlectedDesc($name)
{
    if (isset($_POST[$name]) && $_POST[$name] == 'DESC')
        echo "selected";
}
/*  ----- END: Createing filters functions ------------------------------------------------------------------------------------------------------------------------ */

/*  ----- Query modufying functions ------------------------------------------------------------------------------------------------------------------------------- */
function FilterByNameAndPrice(&$query, $name, $pricemin, $pricemax)
{
    if(!empty($name))
        $query .= " (firma LIKE '%".$name."%' OR model LIKE '%".$name."%') AND";
    if(!empty($pricemin))
        $query .= " cena > ".$pricemin." AND";
    if(!empty($pricemax))
        $query .= " cena < ".$pricemax." AND";
}
function FilterByCheckboxProp(&$query, $prop)
{
    if(isset($_SESSION[$prop]))
    {
        $empty = 0;
        for($i = 1; $i <= $_SESSION[$prop]; $i++)
            if(!empty($_POST[$prop.$i])) $empty++;

        if($empty > 0)
        {
            $query .= " (";
            for($i = 1; $i <= $_SESSION[$prop]; $i++)
                if(!empty($_POST[$prop.$i]))
                    $query .= " $prop LIKE '".$_POST[$prop.$i]."' OR";

            $query = substr($query, 0, -2);
            $query .= ") AND";
        }
        unset($_SESSION[$prop]);
    }
}
function FilterByCheckboxMultiProp(&$query, $prop)
{
    if(isset($_SESSION[$prop]))
    {
        $empty = 0;
        for($i = 1; $i <= $_SESSION[$prop]; $i++)
            if(!empty($_POST[$prop.$i])) $empty++;

        if($empty > 0)
        {
            $query .= " (";
            for($i = 1; $i <= $_SESSION[$prop]; $i++)
                if(!empty($_POST[$prop.$i]))
                {
                    if($_POST[$prop.$i] == 'ATX')
                        $query .= " $prop LIKE '".$_POST[$prop.$i]."%' OR";
                    else
                        $query .= " $prop LIKE '%".$_POST[$prop.$i]."%' OR";
                }

            $query = substr($query, 0, -2);
            $query .= ") AND";
        }
        unset($_SESSION[$prop]);
    }
}
function FilterByCheckboxBoolProp(&$query, $prop)
{
    if(isset($_SESSION[$prop]))
    {
        $empty = 0;
        for($i = 1; $i <= $_SESSION[$prop]; $i++)
            if(!empty($_POST[$prop.$i])) $empty++;

        if($empty > 0)
        {
            $query .= " (";
            for($i = 1; $i <= $_SESSION[$prop]; $i++)
                if(!empty($_POST[$prop.$i]))
                {
                    if($_POST[$prop.$i] == "tak")
                        $query .= " $prop LIKE '1' OR";
                    else if($_POST[$prop.$i] == "nie")
                        $query .= " $prop LIKE '0' OR";
                }

            $query = substr($query, 0, -2);
            $query .= ") AND";
        }
        unset($_SESSION[$prop]);
    }
}

function SortQuery(&$query, $order)
{
    if(empty($order))
        $query .= " ORDER BY cena ASC;";
    else
        $query .= " ORDER BY cena ".$order.";";
}
/*  ----- END: Query modufying functions -------------------------------------------------------------------------------------------------------------------------- */

/*  ----- Product displaying functions and product classes -------------------------------------------------------------------------------------------------------- */
class ProductProp {
    public $name;
    public $val;

    function __construct($name, $val)
    {
        $this->name = $name;
        $this->val = $val;
    }
}

class ProductByID {
    public $table_name;
    public $id_name;
    public $id;

    function __construct($table_name, $id_name, $id)
    {
        $this->table_name = $table_name;
        $this->id_name = $id_name;
        $this->id = $id;
    }
}

function CreateProductDivsFromDB($products)
{
    global $host, $dbuser, $dbpass, $dbname;
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if($conn->connect_error)
        die("Connection to \"sklep\" failed: ".$conn->connect_error);

    $price = 0;

    foreach ($products as $product)
    {
        $query = "SELECT * FROM ".$product->table_name." WHERE ".$product->id_name." LIKE \"".$product->id."\";";
        $result = $conn->query($query);
        if ($result === FALSE)
            echo "Error: ".$query ."<br>".$conn->error;

        $row = $result->fetch_assoc();

        echo '<div class="product2">';
        echo '<div class="product_img2"><img style="max-width: 100%;" src="res/img/products/'.$row['img_path'].'"></div>';
        echo '<div class="product_desc2">';
        echo '<span style="font-size: 20px; font-weight: 700;">'.$row['firma'].' '.$row['model'].'</span><br>';
        echo '</div>';
        echo '<div class="product_price2">';
        echo number_format($row['cena'], 2, ',', ' ').' zł<br>';
        echo '</div>';
        echo '</div>';

        $price += $row['cena'];
    }

    echo '<div class="product2">';
    echo '<div style="width:380px; height: 90px; float:left;"></div>';
    echo '<div class="product_price2" style="text-align: left; height: 45px;">';
    echo 'Razem: <br>';
    echo number_format($price, 2, ',', ' ').' zł<br>';
    echo '</div>';
    echo '</div>';

    $_SESSION['price'] = $price;
    $conn->close();
}

function CreateProductDiv($id, $product_name, $img_path, $price, $num_left, $properties, $config_version=TRUE)
{
    if($num_left > 0)
    {
        echo '<div class="product">';
        echo '<div class="product_img"><a class="without-caption" href="res/img/products/'.$img_path.'"><img style="max-width: 100%;" src="res/img/products/'.$img_path.'"></a></div>';
        echo '<div class="product_desc">';
        echo '<span style="font-size: 20px; font-weight: 700;">'.$product_name.'</span><br>';
        if(count($properties) > 5)
        {
            echo '<div style="width=50%; float: left; border-right: 1px dashed #999; padding-right: 30px;">';
            for($i = 0; $i < 5; $i++)
                echo $properties[$i]->name.': '.$properties[$i]->val.'<br>';
            echo '</div>';
            echo '<div style="width=50%; float: left; padding-left: 30px;">';
            for($i = 5; $i < count($properties); $i++)
                echo $properties[$i]->name.': '.$properties[$i]->val.'<br>';
            echo '</div>';
            echo '<div class="clear"></div>';
        }
        else
        {
            foreach ($properties as &$prop)
                echo $prop->name.': '.$prop->val.'<br>';
        }
        echo '</div>';
        echo '<div class="product_price">';
        echo 'Cena: <br>';
        echo number_format($price, 2, ',', ' ').' zł<br>';
        echo '<form method="POST" action="">';
        echo '<input name="product_id" type="hidden" value="'.$id.'">';
        echo '<input type="submit" name="id" value="'.($config_version ? "Wybierz" : "Kup teraz").'">';
        echo '</form>';
        echo '<span style="font-size: 12px;">Pozostało: '.$num_left.'</span>';
        echo '</div>';
        echo '<div class="clear"></div>';
        echo "</div>";
    }
}

function BoolToStr($num)
{
    return ($num ? "tak" : "nie");
}

?>
