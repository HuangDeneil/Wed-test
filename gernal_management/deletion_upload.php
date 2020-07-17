<?php header("Content-Type:text/html; charset=utf-8"); ?>
<html>
<head>
<title>訂單刪除</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Open+Sans+Condensed:300,700" rel="stylesheet" />
<link href="../default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../fonts.css" rel="stylesheet" type="text/css" media="all" />
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  color: #000000;
}

td, th {
  border: 1px solid ##dddddd ;
  text-align: left;
  padding: 2px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style  style="width:100%">
</head>


<!--- 
######################################################################
###################*####*#####***#####*****######*****################
###################*####*###*#####*########*#####*####*###############
###################******##*********###*****#####*#####*##############
###################*####*###*#########*####**####*###*################
###################*####*####*****######***##*###****#################
######################################################################
--->
<body>
<div id="logo" class="container">
  <a style="font-family:微軟正黑體;text-transform:initial;font-size:120%" href="../index.html" class="button">Home</a>
  <a style="font-family:微軟正黑體;text-transform:initial;font-size:120%" href="input_delete_order_id.php" class="button">刪除其他訂單</a>
  <h1><span></span></h1>
</div>

<div id="wrapper" class="container">
<?php
    function _get($str)
    {
        $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
        return $val;
    }

    /* MySQL uploading */
    $servername = "localhost";
    $username = "hudeneil";
    $password = "78369906";
    $dbname = "the_db";
    $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
          
    /* check connection */
    if ( mysqli_connect_errno() ) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
      
    /* change character set to utf8 */
    if (!$mysqli -> set_charset("utf8")) {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
    } 

    function search_products ( $input, $input2 )
    {
        $myfile = fopen("product_list_from_mysql.csv", "r") or die("Unable to open file!");
        $count=1;
        $data="";
        $price=0;
        while( !feof($myfile) ) 
        {
            $price=0;
            $tmp_text = fgets($myfile);
            if ($tmp_text == "") {}
            else
            {
                $str=explode( "\t",  $tmp_text ) ;
                $product_id = $str[1];
                
                if ($input2 == "info" ){
                    
                    if ($input == $product_id )
                    {
                        $data = "$str[0]\t$str[1]\t$str[2]\t\$$str[3]";
                        return $data;
                    }
                
                }
                elseif($input2 == "price")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[3]);
                        return $price;
                    }
                }
                elseif($input2 == "dicount")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[4]);
                        return $price;
                    }
                }
            }
            $count=$count+1;
        }
        fclose($myfile);
    }

$order_id=_get("order_id");
echo "$order_id";

$cmd ="perl get_sql.pl tmp.csv";
$result=shell_exec ( $cmd );

$cmd ="perl get_order_id_and_deleted.pl tmp.csv $order_id";
$result=shell_exec ( $cmd );

$cmd ="perl gernal_table_process.pl selected_order.csv product_list_from_mysql.csv";
$result=shell_exec ( $cmd );
shell_exec( "rm tmp.csv" );
shell_exec( "rm selected_order.csv" );
$result = $mysqli->query("DROP TABLE gernal_table");
$result = $mysqli->query("CREATE TABLE `the_db`.`gernal_table` ( `訂單編號` TEXT NOT NULL , `訂單日期` TEXT NOT NULL , `訂購方式` TEXT NOT NULL , `訂購人姓名` TEXT NOT NULL , `訂購人電話` TEXT NOT NULL , `訂購人信箱` TEXT NOT NULL , `收件人姓名` TEXT NULL DEFAULT NULL , `收件人電話` TEXT NULL DEFAULT NULL , `收件人信箱` TEXT NULL DEFAULT NULL , `寄送地址` TEXT NULL DEFAULT NULL , `取貨方式` TEXT NULL DEFAULT NULL , `到貨時間` TEXT NULL DEFAULT NULL , `產品編號` TEXT NULL DEFAULT NULL , `總數量` INT NULL DEFAULT NULL , `商品總價小計` FLOAT NULL DEFAULT NULL ,`折扣後總計` FLOAT NULL DEFAULT NULL , `物流費用` FLOAT NULL DEFAULT NULL , `應收款` FLOAT NULL DEFAULT NULL , `收款情形` TEXT NULL DEFAULT NULL , `備註` TEXT NULL DEFAULT NULL , `discount` TEXT NULL DEFAULT NULL) ENGINE = InnoDB;");
        
        
    echo "<p>$result</p>";
      
    $count=1;
    $myfile = fopen("gernal_table_reorganized.csv", "r") or die("Unable to open file!");

     $discount_value="";
        while( !feof($myfile) ) 
        {
            $tmp_text = fgets($myfile);
            if ($tmp_text == "") {}
            else
            {
                $str=explode( ",",  $tmp_text ) ;
                $id = $str[0];
                
                if ( preg_match("/D/i", $str[0]) )
                {
                    $sql = "INSERT IGNORE INTO `gernal_table`
                    (訂單編號,訂單日期,訂購方式,
                    訂購人姓名,訂購人電話,訂購人信箱,
                    收件人姓名,收件人電話,收件人信箱,
                    寄送地址,取貨方式,到貨時間,產品編號,總數量,
                    商品總價小計,折扣後總計,物流費用,應收款,收款情形,備註,discount)
                    VALUES ('$str[0]', '$str[1]', '$str[2]',
                    '$str[3]', '$str[4]', '$str[5]',
                    '$str[6]', '$str[7]', '$str[8]',
                    '$str[9]','$str[10]', '$str[11]', '$str[12]', '$str[13]',
                    '$str[14]', '$str[15]', '$str[16]', '$str[17]', '$str[18]', '$str[19]', '$str[20]')";
		    
                    $result = $mysqli->query($sql);
                }
            }
        }
    fclose($myfile);
    $mysqli->close();
?>


</body>
</html>
        <a href=<?php echo "\"get_gernal_table.php\"" ?> class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%" > 總表檢視 </a>
    <p><?php #echo "$order_id test $discount $discount_value " ?></p></br>
</div>

</body>
</html>






