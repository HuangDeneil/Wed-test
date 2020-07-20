<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>輸入 order input</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Open+Sans+Condensed:300,700" rel="stylesheet" />
<link href="../default.css" rel="stylesheet" type="text/css" media="all" />
<link href="../fonts.css" rel="stylesheet" type="text/css" media="all" />

<script src="../javascript/jquery-1.8.3.js"></script>

<script>
  var tag = 1;

  $(function(){
    $("#add").click(function(){
        var text = document.getElementById("products").value;
        $('#mt tbody').append("<tr><td><select name='order_product"+tag+"'>"+text+"</select></td><td><input type=\"text\" name=\"count_num"+tag+"\" ></td></tr>");
      tag++;
    });

    $("#del").click(function(){
        $("#mt tbody tr:last").remove();
        tag= tag-1;
    });
  })
</script>


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
.error {color: #FF0000;}
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
  <a href="../index.html" class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:120%">Back</a>
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%">物種資料庫<span>Loacl web system</span>
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:200%" >新增資料</h1></h1>
</div>


<?php
   /*
   ########################################################
   #################### 表格資訊填寫  ######################
   ########################################################
   */
  ?>

  
<!--- Table region  --->
<div id="wrapper" class="container">
  <form name="table_value" method="POST" action="query.php">
  <p><span class="error">* require value</span><p>
  <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">基礎資訊</h2>
  <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>

  <table>
    <tr>
      <td>&ensp;物種編號 : </br><p>&ensp;id</p></td>
      <td><input type="text" name="id" rows="2" cols="50">(本欄未填寫則自動生成) </td>
    </tr>
    <tr>
      <td>&ensp;物種名 : </br>&ensp;name</td>
      <td><input type="text" name="name" id="name" rows="2" cols="50"><span class="error">* </span></td>
    </tr>
  </table>

    </br></br>

  <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">分類資訊</h2>
  <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>

  <table>
    <tr>
        <td>&ensp;屬名:</br>&ensp;genus</td>
        <td><input type="text" name="genus" id="genus" rows="2" cols="30"><span class="error">* </span>
          <p>(ex:Clostridium,Acinetobacter)</p>
        </td>
        <td>&ensp;大分類:</br>&ensp;type:</td>
        <td><input type="text" name="type" id="type" rows="2" cols="50"><span class="error">*</span>
          <p>(ex:bacteria, archaea, fungi)</p>
        </td>
    </tr>
    <tr>
        <td>&ensp;Halos_id:</td>
        <td><input type="text" name="Halos_id" rows="2" cols="50"><p></p></td>
        <td>&ensp;關鍵字:</br>&ensp;key_word</td>
        <td><textarea type="text" name="key_word" id="key_word" rows="2" cols="90"></textarea><span class="error">* </span>
          <p>(ex: "anaerobic/aerobic","gram positive/negaive","opportunistic pathgen/pathogen",</br> "normal flora/environmental")</p>
        </td>
    </tr>
    <tr>
        <td>&ensp;資訊來源:</br>&ensp;source</td>
        <td><input type="text" name="source" rows="2" cols="50"><p>(ex: Halos)</p></td>
    </tr>
  </table>

    </br>
    <table>
      <tr>
        <td>&ensp;物種描述:</br>&ensp;Description</td>
        <td><textarea type="text" name="Description" id="Description" rows="5" cols="130"></textarea><span class="error">* </span>
         </td>
      </tr>
    </table>
    </br>
      
    <h2 style="font-family:微軟正黑體;text-transform:initial;font-size:200%">文獻(reference):</h2>
    <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>
    <table>
      <tr>
        <td>文獻1</br>reference1:</td>
        <td><textarea type="text" name="reference1" id="reference1" rows="2" cols="130" id="order_form"></textarea><span class="error">* </span></td>
      </tr>
      <tr>
        <td>文獻2</br>reference2:</td>
        <td><textarea type="text" name="reference2" rows="2" cols="130"></textarea></td>
      </tr>
      <tr>
        <td>文獻3</br>reference3:</td>
        <td><textarea type="text" name="reference3" rows="2" cols="130"></textarea></td>
      </tr>
      <tr>
        <td>文獻4</br>reference4:</td>
        <td><textarea type="text" name="reference4" rows="2" cols="130"></textarea></td>
      </tr>
      <tr>
        <td>文獻5</br>reference5:</td>
        <td><textarea type="text" name="reference5" rows="2" cols="130"></textarea></td>
      </tr>
    </table>
    </br>
    
<script>
    var order_form = document.getElementById("name").value;
    var source_name = document.getElementById("genus").value;
    var source_phone = document.getElementById("type").value;
    var arrive_name = document.getElementById("key_word").value;
    var arrive_phone = document.getElementById("Description").value;
    var arrive_address = document.getElementById("reference1").value;

    if( order_form === "" ){ }
    else if( source_name === "" ){ }
    else if( source_phone === "" ){ }
    else if( arrive_name === "" ){ }
    else if( arrive_phone === "" ){ }
    else if( arrive_address === "" ){  }
    else{
      document.write("test");
      }
    
</script>
<p>
<?php
  for($i=0;$i<60;$i++) {echo "&ensp;"; }
  echo '<input class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:300%" type="submit" value="送出">'; 
  echo '<input class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:300%" type="reset" value="清除">';
?>
</p></br>
</div>
</body>
</html>


