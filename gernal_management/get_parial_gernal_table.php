<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>部分訂單總覽</title>
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
<a href="../index.html" class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:150%">Home</a>
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%">訂單整理系統<span>Loacl web system</span><h1>Parial Gernal Table</h1></br></h1>
</div>


<?php
  $servername = "localhost";
  $username = "hudeneil";
  $password = "78369906";
  $dbname = "the_db";
  $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
            
  /* check connection */
  if (mysqli_connect_errno()) 
  {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
        
  /* change character set to utf8 */
  if (!$mysqli->set_charset("utf8")) {
      printf("Error loading character set utf8: %s\n", $mysqli->error);
  } 
        
  $result = $mysqli -> query("SELECT * FROM product_list");

  if ($result->num_rows > 0) 
  {
    // output data of each row
    $myfile = fopen("product_list_from_mysql.csv", "w") or die("Unable to open file!");
    $tmp_count=1;
    while($row = $result->fetch_assoc()) 
    {
        $txt = "".$row["product"]."\t".$row["product_id"]."\t".$row["product_detail"]."\t".$row["price"]."\t".$row["discount_price30"]."\t".$row["discount_price60"]."\n";
        fwrite($myfile, $txt);	
        ++$tmp_count;
    }
    fclose($myfile);
  } else {
    echo "0 results";
  }
        
  $result = $mysqli->query("SELECT * FROM gernal_table");

  $mysqli->close();
        
  function _get($str)
  {
    $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
    return $val;
  }
  
  function checking_value ()
  {
    $year_from=$month_from=$day_from="";
    $year_fromErr=$month_fromErr=$day_fromErr="";
    $year_to=$month_to=$day_to="";
    $year_toErr=$month_toErr=$day_toErr="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
      if ( _get("year_from")== "null" OR _get("month_from")== "null" OR _get("day_from")== "null") 
      {
        $year_fromErr = "required";
        $year_from = $year_fromErr;
      } 
      else 
      {
        $order_from = test_input($_POST["order_from"]);
        $order_fromErr = "";
      }
      
      if ( _get("source_name") == "null" ) 
      {
        $source_nameErr = "required";
        $source_name = "Invalid";
      }

      echo "<table id=\"mt\" style=\"width:100%\" border=\"1\" cellpadding=\"5\">";
      echo "<thead>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"80px\">訂單編號</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"50px\">訂購方式</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"60px\">訂購人</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"75px\">訂購人電話</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"60px\">收件人</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"75px\">收件人電話</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"210px\">寄送地址</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"130px\">產品編號</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"60px\">總數量</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"60px\">商品總價小計</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"300px\">備註</td>";
      echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:120%\" WIDTH=\"60px\">銷貨單</td>";
      echo "</thead>";


    }
  }
?>
<!--- Table region  --->
<div id="wrapper" class="container">
<form name="table_value" method="POST" action="get_parial_gernal_table.php"></br>

<p>請填寫日期區間</p>
<table style="width:80%" border="1" >
<td>起始日期</td>
<td>終止日期</td>
</table>
<table style="width:80%" border="1" >
  <thead>
    <td><input type="number" name="year_from" min="2019" max="2050">年
    <input type="number" name="month_from" min="1" max="12">月
    <input type="number" name="day_from" min="1" max="31">日</td>
    <td><input type="number" name="year_to" min="2019" max="2050">年
    <input type="number" name="month_to" min="1" max="12">月
    <input type="number" name="day_to" min="1" max="31">日</td>
  </thead>
</table></br>


<input type='submit' value='送出'> <input type='reset' value='清除'></br></br>
<?php
  
  
  echo "<p></p>"


?>


</div>
</body>
</html>


