<?php header("Content-Type:text/html; charset=utf-8"); ?>
<html>
<head>
<title>訂單上傳</title>
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
#######################################################################
###################*####*#####***#####*****######*****################
###################*####*###*#####*########*#####*####*###############
###################******##*********###*****#####*#####*##############
###################*####*###*#########*####**####*###*################
###################*####*####*****######***##*###****#################
#######################################################################
--->
<body>
<div id="logo" class="container">
  <a style="font-family:微軟正黑體;text-transform:initial;font-size:120%" href="order_process.php" class="button">下個訂單next order</a>
  <a style="font-family:微軟正黑體;text-transform:initial;font-size:120%" href="../index.html" class="button">回首頁 Homepage</a>
  <h1><span></span></h1>
</div>

<div id="wrapper" class="container">
<?php
    function _get($str)
    {
        $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
        return $val;
    }


    /* 
    ##########################################################
    #################### MySQL Connecting ####################
    ##########################################################
   */
    $servername = "localhost";
    $username = "hudeneil";
    $password = "78369906";
    $dbname = "the_db";
    $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
          
    /* check connection */
    if ( mysqli_connect_errno() ) 
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
      
    /* change character set to utf8 */
    if (!$mysqli -> set_charset("utf8")) 
    {
        printf("Error loading character set utf8: %s\n", $mysqli->error);
    } 
    

    /*
    order_id : D20191023013743
    order_from : 現場
    date : 20191023

    source_name : 謝佳琳
    source_phone : 0975306192
    source_email : hudeneil@gmail.com

    arrive_name : 邱慧滿
    arrive_phone : 0921472322
    arrive_email : hudeneil@gmail.com

    address : 新北市新店區黎明路98號11樓(管理員代收）
    note :
    total_price : 7430
    discount : 7130
    orders : 208894x1 209902x2 202503x3 208802x4
    */
    $order_id=_get("order_id");
    $order_from=_get("order_from");
    $date=_get("date");

    $source_name=_get("source_name");
    $source_phone=_get("source_phone");
    $source_email=_get("source_email");
    
    $arrive_name=_get("arrive_name");
    $arrive_phone=_get("arrive_phone");
    $arrive_email=_get("arrive_email");
    
    $address=_get("address");
    $note=_get("note");    
    $total_price=_get("total_price");
    $discount=intval(_get("discount"));
    $orders=_get("orders");
    $total_count=_get("total_count");
    $discount_value=_get("discount_value");


    /* 
    ##########################################################
    #################### MySQL Uploading  ####################
    ##########################################################
   */
    $sql = "INSERT IGNORE INTO `gernal_table` 
    (訂單編號,訂單日期,訂購方式,
    訂購人姓名,訂購人電話,訂購人信箱,
    收件人姓名,收件人電話,收件人信箱,
    寄送地址,取貨方式,到貨時間,產品編號,總數量,
    商品總價小計,折扣後總計,物流費用,應收款,收款情形,備註,discount) 
    VALUES ('$order_id', '$date', '$order_from', 
    '$source_name', '$source_phone', '$source_email', 
    '$arrive_name', '$arrive_phone', '$arrive_email', '$address', 
    '', '', '$orders', '$total_count',
    '$total_price', '$discount', '', '', '', '$note', '$discount_value')";

    #echo "$sql </br>";
/*   
    "INSERT IGNORE INTO `gernal_table` 
    
    VALUES ('', '', '')";
*/

    if ($mysqli -> query( $sql ) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mysqli->error;
    }

    function search_products ( $input, $input2 )
    {
        $myfile = fopen("../tmp/product_list_from_mysql.csv", "r") or die("Unable to open file!");
        $count=1;
        $data="";
        $price=0;
        while( !feof($myfile) ) 
        {
            $price=0;
            $tmp_text = fgets($myfile);
            if ( empty($tmp_text) === 1) {}
            else
            {
                $str=explode( "\t",  $tmp_text ) ;
                $product_id = $str[1];
                
                if ($input2 === "info" ){
                    
                    if ($input == $product_id )
                    {
                        $data = "$str[0]\t$str[1]\t$str[2]\t\$$str[3]";
                        return $data;
                    }
                
                }
                elseif($input2 === "price")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[3]);
                        return $price;
                    }
                }
                elseif($input2 === "dicount")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[4]);
                        return $price;
                    }
                }
            }
            $count = $count+1;
        }
        fclose($myfile);
    }
/* 
################################################################
#################### 下載訂單總表 from MySQL ####################
################################################################
*/
$cmd ="perl ../perl/get_sql.pl ../temp/tmp.csv";
echo $result = shell_exec ( $cmd );
echo "</br>";

/* 
###################################################
#################### 產生出貨單 ####################
###################################################
*/
$cmd ="perl ../perl/gernal_table_process.pl ../temp/tmp.csv ../temp/product_list_from_mysql.csv ../temp/gernal_table_reorganized.csv";
echo $result = shell_exec ( $cmd );
echo "</br>";
?>

<?php 

sleep(0);

$result = $mysqli->query("DROP TABLE gernal_table");
$result = $mysqli->query("CREATE TABLE `the_db`.`gernal_table` ( `訂單編號` TEXT NOT NULL , `訂單日期` TEXT NOT NULL , `訂購方式` TEXT NOT NULL , `訂購人姓名` TEXT NOT NULL , `訂購人電話` TEXT NOT NULL , `訂購人信箱` TEXT NOT NULL , `收件人姓名` TEXT NULL DEFAULT NULL , `收件人電話` TEXT NULL DEFAULT NULL , `收件人信箱` TEXT NULL DEFAULT NULL , `寄送地址` TEXT NULL DEFAULT NULL , `取貨方式` TEXT NULL DEFAULT NULL , `到貨時間` TEXT NULL DEFAULT NULL , `產品編號` TEXT NULL DEFAULT NULL , `總數量` INT NULL DEFAULT NULL , `商品總價小計` FLOAT NULL DEFAULT NULL ,`折扣後總計` FLOAT NULL DEFAULT NULL , `物流費用` FLOAT NULL DEFAULT NULL , `應收款` FLOAT NULL DEFAULT NULL , `收款情形` TEXT NULL DEFAULT NULL , `備註` TEXT NULL DEFAULT NULL , `discount` TEXT NULL DEFAULT NULL) ENGINE = InnoDB;");
        
echo "<p>$result</p>";


$count=0;
$myfile = fopen("../temp/tmp.csv", "r") or die("Unable to open file!");

$discount_value="";
while( !feof($myfile) ) 
    {
        $tmp_text = fgets($myfile);
        if ( empty($tmp_text) == 1) {}
        else
        {
            $str = explode( ",",  $tmp_text ) ;
            $id = $str[0];
            $count++;
            if ( empty( $str[0]) == 1 ){echo "</br>--$str[0]--test</br>";}
            elseif ( preg_match( "\w+?", $str[0])  ) { }
            else
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
                echo "$sql</br>";
                $result = $mysqli->query($sql);
                
                echo "</br>$count</br>'$tmp_text'</br>";
            }
        }
    }
fclose($myfile);
/*
$result = $mysqli->query("
CREATE TABLE `the_db`.`gernal_table` ( 
`訂單編號` TEXT NOT NULL , 
`訂單日期` TEXT NOT NULL , 
`訂購方式` TEXT NOT NULL , 
`訂購人姓名` TEXT NOT NULL , 
`訂購人電話` TEXT NOT NULL , 
`訂購人信箱` TEXT NOT NULL , 
`收件人姓名` TEXT NULL DEFAULT NULL , 
`收件人電話` TEXT NULL DEFAULT NULL , 
`收件人信箱` TEXT NULL DEFAULT NULL , 
`寄送地址` TEXT NULL DEFAULT NULL , 
`取貨方式` TEXT NULL DEFAULT NULL , 
`到貨時間` TEXT NULL DEFAULT NULL , 
`產品編號` TEXT NULL DEFAULT NULL , 
`總數量` INT NULL DEFAULT NULL , 
`商品總價小計` FLOAT NULL DEFAULT NULL ,
`折扣後總計` FLOAT NULL DEFAULT NULL , 
`物流費用` FLOAT NULL DEFAULT NULL , 
`應收款` FLOAT NULL DEFAULT NULL , 
`收款情形` TEXT NULL DEFAULT NULL , 
`備註` TEXT NULL DEFAULT NULL , 
`discount` TEXT NULL DEFAULT NULL
) ENGINE = InnoDB;");
*/
    
/* 
##########################################################
#################### 尋找MySQL中重複質 ####################
##########################################################

    $sql = "Select 訂單編號 From `the_db`.`gernal_table` Group By 訂單編號 Having Count(*)>1;";
    $result = $mysqli->query($sql);
    $repeat_id = array();
    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc() ) 
        {
            if( empty($row["訂單編號"]) ==1 ){}else
            {
                $id = strval($row["訂單編號"]);
                array_push($repeat_id, $id);  // 重複質存入 $repeat_id 的array 中
                
                // 印出 array  
                #$view=print_r($row, true);
                #echo "$view</br></br>";
            } 
        }
    }
 
foreach( $repeat_id as $i )
{
    $sql = "Select * From `the_db`.`gernal_table` Which 訂單編號=".$i.";";
    #echo "$sql</br>";
}
    $sql = "Select * From `the_db`.`gernal_table` Which 訂單編號=".$repeat_id[0].";";
    $row = $result->fetch_row();
    $view = print_r($row, true);
    #echo "$view</br></br>";
 */  
    #echo "</br>$result</br>";
   /* 
    "Select 訂單編號 From `the_db`.`gernal_table` Group By 訂單編號 Having Count(*)>1;"
    DELETE from `the_db`.`gernal_table` where 訂單編號 in
    (
        SELECT 訂單編號 FROM 
        (
            SELECT 訂單編號 from `the_db`.`gernal_table` where 訂單編號 in 
            (
                SELECT 訂單編號 from `the_db`.`gernal_table` GROUP BY 訂單編號 HAVING count(1)>1
            )
            and 訂單編號 not in 
            (
                SELECT MIN(訂單編號) from `the_db`.`gernal_table` GROUP BY 訂單編號 HAVING count(1)>1
            ) 
        )
    ) ;

SELECT A.S_ID, A.S_NAME, MAX(A.REG_DATE) AS MAX_REG_DATE FROM [STUDENT1] A (NOLOCK)
GROUP BY A.S_ID, A.S_NAME


    DELETE from telbook where id in
    (
        SELECT id FROM 
        (
            SELECT id from telbook where Mobile in 
            (
                SELECT b.Mobile from telbook b GROUP BY b.Mobile HAVING count(1)>1
            )
            and id not in 
            (
                SELECT MIN(c.ID) from telbook c GROUP BY c.Mobile HAVING count(1)>1
            ) 
        )v 
    )
*/

    $mysqli -> close();
?>


</body>
</html>
    <a href=<?php echo "\"../order_list/$order_id-format1.html\"" ?> class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%" > 銷貨單 格式一</a>
    <a href=<?php echo "\"../order_list/$order_id-format2.html\"" ?> class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%" > 銷貨單 格式二</a>
    <a href=<?php echo "\"../gernal_management/get_gernal_table.php\"" ?> class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%" > 總表檢視 </a>
    <p><?php #echo "$order_id test $discount $discount_value " ?></p></br>
</div>




</body>
</html>
