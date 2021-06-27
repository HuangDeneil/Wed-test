<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>資料確認</title>
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
  padding: 2px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
body {
  background-image: url('../images/APG-3.PNG');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: top left ;
  background-size: 15%;
  }
</style>
</head>
<body>


<!--- 
#######################################################################
###################*####*#####***#####*****######*****################
###################*####*###*#####*########*#####*####*###############
###################******##*********###*****#####*#####*##############
###################*####*###*#########*####**####*###*################
###################*####*####*****######***##*###****#################
#######################################################################
--->

<div id="logo" class="container">
  <a href="order_process.php" class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%">Cancel & Back</a>
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%"><span>新增資料確認</span></h1>
</div>

<?php
    function _get($str)
    {
        $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
        return $val;
    }
/*
id  name    genus   type    key_word
source  Halos_id    Description
reference1  reference2  reference3  reference4  reference5
*/
    $id=$organism_name=$genus=$type=$key_word="";
    $source=$Halos_id=$Description="";
    $reference1=$reference2=$reference3=$reference4=$reference5="";
    
    $id=_get("id");
    $organism_name=_get("organism_name");
    $chinese_name=_get("chinese_name");
    $genus=_get("genus");
    $gram_stain=_get("gram_stain");
    $type=_get("type");
    $key_word=_get("key_word");

    $source=_get("source");
    $Halos_id=_get("Halos_id");
    $taxid=_get("taxid");
    $Description=_get("Description");
    
    $reference1=_get("reference1");
    $reference2=_get("reference2");
    $reference3=_get("reference3");
    $reference4=_get("reference4");
    $reference5=_get("reference5");
    
    $date=date("Ymdhis");
    $data_source=_get("data_source");
    $data_status=_get("data_status");

    if ( !empty($id) ){}
    else
    {
        $id="S".date("Ymdhis");
    }

?>

<div id="wrapper" class="container">
<form name="table_value" method="POST" action="upload.php">

<h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">基礎資訊</h2>
<svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>

<table>
    <tr>
        <td>編號: </td>
        <td><?php echo "$id"; ?><input type="hidden" name="id" value ="<?php echo $id; ?>" ></td>
    <tr> 
    </tr>
        <td>物種名: </td>
        <td><?php echo "$organism_name"; ?> <input type="hidden" name="organism_name" value ="<?php echo $organism_name; ?>" ></td> 
        <td>物種中文名: </td>
        <td><?php echo "$chinese_name"; ?> <input type="hidden" name="chinese_name" value ="<?php echo $chinese_name; ?>" ></td> 
    <tr>
</table>
</br>
    <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">分類資訊</h2>
  <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>

  <table>
    <tr>
        <td>&ensp;屬名:</br>&ensp;genus</td>
        <td><?php echo "$genus"; ?><input type="hidden" name="genus" id="genus" value ="<?php echo $genus; ?>"></td>
        <td>&ensp;大分類:</br>&ensp;type:</td>
        <td><?php echo "$type"; ?><input type="hidden" name="type" id="type" value ="<?php echo $type; ?>"></td>
    </tr>
    <tr>
        <td>&ensp;Gram stain:</td>
        <td><?php echo "$gram_stain"; ?><input type="hidden" name="gram_stain" value ="<?php echo $gram_stain; ?>"><p></p></td>
        <td>&ensp;關鍵字:</br>&ensp;key_word</td>
        <td><?php echo "$key_word"; ?><input type="hidden" name="key_word" id="key_word" value ="<?php echo $key_word; ?>"></td>
    </tr>
    <tr>
        <td>&ensp;Halos_id:</td>
        <td><?php echo "$Halos_id"; ?><input type="hidden" name="Halos_id" value ="<?php echo $Halos_id; ?>"><p></p></td>
        <td>&ensp;資訊來源:</br>&ensp;source</td>
        <td><?php echo "$source"; ?><input type="hidden" name="source" value ="<?php echo $source; ?>"></td>
    </tr>
  </table>

    </br>
    <table>
      <tr>
        <td>&ensp;物種描述:</br>&ensp;Description</td>
        <td><?php echo "$Description"; ?><input type="hidden" name="Description" id="Description" value ="<?php echo $Description; ?>"></td>
      </tr>
    </table>
    </br>
      
    <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">文獻(reference):</h2>
    <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>
    <table>
      <tr>
        <td>文獻1</br>reference1:</td>
        <td><?php echo "$reference1"; ?><input type="hidden" name="reference1" value ="<?php echo $reference1; ?>"></td>
      </tr>
      <tr>
        <td>文獻2</br>reference2:</td>
        <td><?php echo "$reference2"; ?><input type="hidden" name="reference2" value ="<?php echo $reference2; ?>"></td>
      </tr>
      <tr>
        <td>文獻3</br>reference3:</td>
        <td><?php echo "$reference3"; ?><input type="hidden" name="reference3" value ="<?php echo $reference3; ?>"></td>
      </tr>
      <tr>
        <td>文獻4</br>reference4:</td>
        <td><?php echo "$reference4"; ?><input type="hidden" name="reference4" value ="<?php echo $reference4; ?>"></td>
      </tr>
      <tr>
        <td>文獻5</br>reference5:</td>
        <td><?php echo "$reference5"; ?><input type="hidden" name="reference5" value ="<?php echo $reference5; ?>"></td>
      </tr>
    </table>
    </br>
<script>
    var name = document.getElementById("name").value;
    var genus = document.getElementById("genus").value;
    var type = document.getElementById("type").value;
    var key_word = document.getElementById("key_word").value;
    var Description = document.getElementById("Description").value;
    var reference1 = document.getElementById("reference1").value;

    if( name === "" ){alert("請填寫訂單來源(網路or現場)");}
    else if( genus === "" ){alert("請填寫訂貨人姓名");}
    else if( type === "" ){alert("請填寫訂貨人電話");}
    else if( key_word === "" ){alert("請填寫收貨人姓名");}
    else if( Description === "" ){alert("請填寫收貨人電話");}
    else if( reference1 === "" ){alert("請填寫到貨地址");}
    
</script>
</br></br>
<?php for($i=0;$i<70;$i++) {echo "&ensp;"; }?>

<input class="button" type='submit' value='確認並送出'> 

</form>
</div>
</body>
<div class='container' align=center><br>
<em >Copyright 2020 <a href='../'>HOME</a>. Allrights reserved.</em></br>
<img src="../images/APG-3.PNG" width=300>
</div>
</html>
