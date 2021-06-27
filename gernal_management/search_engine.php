<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>物種資料查詢</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Open+Sans+Condensed:300,700" rel="stylesheet" />
<link href="../default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../fonts.css" rel="stylesheet" type="text/css" media="all" />
<style>
table {
  font-family: 微軟正黑體, sans-serif;
  border-collapse: collapse;
  width: 100%;
  color: #000000;
}

td, th {
  border: 1px solid ##dddddd ;
  text-align: left;
  padding: 10px;
}

.input_type1
{
    border:1px solid #999999;
    width:90%;
    margin:5px 0;
    padding:1%;
}
.textarea_typ1
{
    border:1px solid #999999;
    width:50%;
    margin:5px 0;
    padding:1%;
}
.select_type1
{
    border:1px solid #999999;
    width:60%;
    margin:5px 0;
    padding:1%;
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
<style>
  body {
  background-image: url('../images/APG-3.PNG');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: center top;
  background-size: 30%;
  }
</style>

<body>
<div id="logo" class="container">
  
  <a href="../index.html" class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:150%">Home</a>
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%">物種資料庫查詢系統</br></h1>
</div>

<!--- Table region  --->


<div id="wrapper" class="container" >
<form name="table_value" method="POST" action="search_engine.php">
  <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">&ensp;查詢</h2>
  <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>
 <table>
    <tr>
      <td>&ensp;</p>
      <td></td>
      
    </tr>
    <tr>
    <td>&ensp;&ensp;分類:</br>&ensp;category:&ensp;&ensp;</td>
    <td>
        <select class=select_type1 name="category">
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="organism_name">物種名</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="ID">ID</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="chinese_name">中文名</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="genus">屬名</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="gram_stain">gram stain</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="type">大分類</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="source">資料來源</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="key_word">key_word</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="Halos_id">Halos_id</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="taxid">taxid</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="Description">Description</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="reference">reference</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="date">date</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="data_source">data_source</option>
            <option style="font-family:微軟正黑體;text-transform:initial;font-size:120%" value="data_status">data_status</option>
        </select>
    </td>
      <td><input class=input_type1  type="text" name="input" rows="3" cols="130"></td>
      <td></td>
    </tr>
  </table>

<?php
for($i=0;$i<113;$i++) {echo "&ensp;"; }
echo '<input class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:300%" type="submit" value="送出">';

echo "</br>";


function _get($str)
{
    $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
    return $val;
}

$category=$input="";
$category=_get("category");
$input=_get("input");

/*
#########################################################################################################
#################### 讀取 產品資訊 from 暫存資料夾中的 ""  ######################
#########################################################################################################
*/
     
$servername = "localhost";
$username = "hudeneil";
$password = "78369906";
$dbname = "the_db";
$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        
        /* change character set to utf8 */
        if ( !$mysqli->set_charset("utf8") ) {
            printf("Error loading character set utf8: %s\n", $mysqli->error);
        } 
        /*
        1	ID
        2	organism_name
        3	chinese_name
        4	genus
        5	gram_stain
        6	type
        7	source
        8	key_word
        9	Halos_id
        10	taxid
        11	Description
        12	reference1
        13	reference2
        14	reference3
        15	reference4
        16	reference5
        17	date
        18	data_source
        19	data_status

         WHERE `$category` LIKE '$input' ORDER BY `$category` ASC

        SELECT * FROM `reference_summary` WHERE `ID` LIKE 'S000001' ORDER BY `ID` ASC
        %    >>>   萬用字元
        _    >>>   matches exactly one character.
% matches any number of characters, even zero characters.

_ matches exactly one character.
        */

        if ( empty($input) ){print "$input</br></br><h1>No input</h1></br>";}
        else
        {
           print " 
           <table>
           <tr>
             <td><h1>Input category : $category &ensp;&ensp;Input info : $input</h1></td>
            <tr>
           </table>";
           
           print '<svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(255,100,100);stroke-width:50" /></svg>';
           print "</br></br></br>";

            $result = $mysqli -> query("SELECT * FROM reference_summary WHERE `$category` LIKE '%$input%' ORDER BY `$category` ASC");
            
            
            if ($result->num_rows > 0) 
            {
                // output data of each row
                #$myfile = fopen("../temp/data.csv", "w") or die("Unable to open file!");
                $tmp_count=1;
                while($row = $result->fetch_assoc()) 
                {
                    print "<table>";
                    print "<tr>";
                    print "</tr>";
                    print "<tr>";
                    print "<td>ID: ".$row["ID"]."</td>";
                    print "<td>organism_name: <i>".$row["organism_name"]."</i></td>";
                    print "<td>chinese_name: ".$row["chinese_name"]."</td>";
                    print "</tr>";
                    print "<tr>";
                    print "<td>genus: <i>".$row["genus"]."</i></td>";
                    print "<td>type: ".$row["type"]."</td>";
                    print "<td></td>";
                    print "</tr>";
                    print "</table>";
                    print '<svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>';

                    print "<table>";
                    print "<tr>";
                    print "</tr>";
                    print "<tr>";
                    print "<td>source: ".$row["source"]."</td>";
                    print "<td>Halos_id: ".$row["Halos_id"]."</td>";
                    print "<td>taxid: ".$row["taxid"]."</td>";
                    print "</tr>";
                    print "</table>";
                    
                    print "<table>";
                    print "<td>key_word: </td><td>".$row["key_word"]."</td>";
                    print "<tr><td>Description: </td><td>".$row["Description"]."</td></tr>";
                    print "<tr><td>reference: </td><td>".$row["reference1"]."</td></tr>";
                    print "<tr><td>reference: </td><td>".$row["reference2"]."</td></tr>";
                    print "<tr><td>reference: </td><td>".$row["reference3"]."</td></tr>";
                    print "<tr><td>reference: </td><td>".$row["reference4"]."</td></tr>";
                    print "<tr><td>reference: </td><td>".$row["reference5"]."</td></tr>";
                    print "</table>";
                    print '<svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(255,150,150);stroke-width:20" /></svg>';
                    
                    
                    ++$tmp_count;
                    #print_r($row);
                    print "</br></br></br></br></br>";
                }
            } else 
            {
                echo "";
            }
        }


        
      
        
        
        
     /*   
        $result = $mysqli->query("SELECT * FROM gernal_table");
        #$result = $mysqli->query("SELECT * FROM product_list");
        if ($result->num_rows > 0) 
        {*/
            // output data of each row
            #$myfile = fopen("../temp/gernal_list_from_mysql.csv", "w") or die("Unable to open file!");
            /*
            (訂單編號,訂單日期,訂購方式,
            訂購人姓名,訂購人電話,訂購人信箱,
            收件人姓名,收件人電話,收件人信箱,
            寄送地址,取貨方式,到貨時間,產品編號,總數量,商品總價小計,折扣後總計
            ,物流費用,應收款,收款情形,備註,discount) 
            */
  /*          
            while($row = $result->fetch_assoc()) 
            {
                $txt = ("".$row["訂單編號"].",".$row["訂單日期"].",".$row["訂購方式"].",".$row["訂購人姓名"].",".$row["訂購人電話"].",".$row["訂購人信箱"].",".$row["收件人姓名"].",".$row["收件人電話"].",".$row["收件人信箱"].",".$row["寄送地址"].",".$row["取貨方式"].",".$row["到貨時間"].",".$row["產品編號"].",".$row["總數量"].",".$row["商品總價小計"].",".$row["折扣後總計"].",".$row["物流費用"].",".$row["應收款"].",".$row["收款情形"].",".$row["備註"].",".$row["discount"]."\n");
                #fwrite($myfile, $txt);
            }
            
            echo "</table>";
           #fclose($myfile);
        } else {
            echo "";
        }
*/
        #$result = $mysqli->query("DROP TABLE gernal_table");
        #$result = $mysqli->query("CREATE TABLE `the_db`.`gernal_table` ( `訂單編號` TEXT NOT NULL , `訂單日期` TEXT NOT NULL , `訂購方式` TEXT NOT NULL , `訂購人姓名` TEXT NOT NULL , `訂購人電話` TEXT NOT NULL , `訂購人信箱` TEXT NOT NULL , `收件人姓名` TEXT NULL DEFAULT NULL , `收件人電話` TEXT NULL DEFAULT NULL , `收件人信箱` TEXT NULL DEFAULT NULL , `寄送地址` TEXT NULL DEFAULT NULL , `取貨方式` TEXT NULL DEFAULT NULL , `到貨時間` TEXT NULL DEFAULT NULL , `產品編號` TEXT NULL DEFAULT NULL , `總數量` INT NULL DEFAULT NULL , `商品總價小計` FLOAT NULL DEFAULT NULL ,`折扣後總計` FLOAT NULL DEFAULT NULL , `物流費用` FLOAT NULL DEFAULT NULL , `應收款` FLOAT NULL DEFAULT NULL , `收款情形` TEXT NULL DEFAULT NULL , `備註` TEXT NULL DEFAULT NULL , `discount` TEXT NULL DEFAULT NULL) ENGINE = InnoDB;");
 
        

        #$cmd ="perl ../perl/gernal_table_process.pl ../temp/tmp.csv ../temp/product_list_from_mysql.csv ../temp/gernal_table_reorganized.csv";
        #echo $result = shell_exec ( $cmd );
        echo "</br>";
        
        #echo "<p>$result</p>";
      /*
        $count=1;
        $myfile = fopen("../temp/tmp.csv", "r") or die("Unable to open file!");
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
        while( !feof($myfile) ) 
        {
            $tmp_text = fgets($myfile);
            if ($tmp_text == "") {}
            else
            {
                $str=explode( ",",  $tmp_text ) ;
                $id = $str[0];
                if ( empty($str[0]) == 1 OR empty($str[2]) == 1  ) {}
                #elseif ( empty($str[3]) == TRUE OR empty($str[4]) == TRUE OR empty($str[6]) == TRUE ) {}
                #elseif ( empty($str[7]) == TRUE OR empty($str[8]) == TRUE OR empty($str[9]) == TRUE  ) {}
                #elseif ( empty($str[12]) == TRUE OR empty($str[13]) == TRUE OR empty($str[19]) == TRUE ) {}
                else
                {
                    echo "<tr>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[0]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[2]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[3]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[4]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[6]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[7]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[9]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[12]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[13]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[15]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">" . $str[19]. "</td>";
                    echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:75%\">
                        <a href='order_list/$id-format1.html'>格式一</a></br>
                        <a href='order_list/$id-format2.html'>格式二</a></td>";
                    echo "</tr>";
                    #echo "<option value=\"$product_id\">$text</option>";
                    ++$count;
                

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
        fclose($myfile);*/
        $mysqli->close();
      ?>
</div>
</body>

<div class='container' align=center><br>
<em >Copyright 2020 <a href='../'>HOME</a>. Allrights reserved.</em></br>
<img src="../images/APG-3.PNG" width=300>
</div>

</html>


