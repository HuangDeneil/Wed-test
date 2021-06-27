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
  /* body {
  background-image: url('../images/APG-3.PNG');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: center top;
  background-size: 30%;
  } */
</style>

<body>
<div id="logo" class="container">
  
  <a href="../index.html" class="button" style="font-size:150%">Home</a>
  <h1>物種資料庫查詢系統</br></h1>
</div>

<!--- Table region  --->


<div id="wrapper" class="container" >
<form name="table_value" method="POST" action="search_engine.php">
  <h2>&ensp;查詢</h2>
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
            <option value="organism_name">物種名</option>
            <option value="ID">ID</option>
            <option value="chinese_name">中文名</option>
            <option value="genus">屬名</option>
            <option value="gram_stain">gram stain</option>
            <option value="type">大分類</option>
            <option value="source">資料來源</option>
            <option value="key_word">key_word</option>
            <option value="Halos_id">Halos_id</option>
            <option value="taxid">taxid</option>
            <option value="Description">Description</option>
            <option value="reference">reference</option>
            <option value="date">date</option>
            <option value="data_source">data_source</option>
            <option value="data_status">data_status</option>
        </select>
    </td>
      <td><input class=input_type1  type="text" name="input" rows="3" cols="130"></td>
      <td></td>
    </tr>
  </table>

<?php
for($i=0;$i<113;$i++) {echo "&ensp;"; }
echo '<input class="button" type="submit" value="送出">';

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
        echo "</br>";
        $mysqli->close();
      ?>
</div>
</body>

<div class='container' align=center><br>
<em >Copyright 2020 <a href='../'>HOME</a>. Allrights reserved.</em></br>
<!-- <img src="../images/APG-3.PNG" width=300> -->
</div>

</html>


