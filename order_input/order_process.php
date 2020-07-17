<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>訂單輸入 order input</title>
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
  <table>
    <tr>
      <td>物種編號(本欄未填寫則自動生成) : <input type="text" name="id" rows="2" cols="30"></td>
      <td>物種名 : <input type="text" name="name"" rows="2" cols="30"></td>
    </tr>
  </table>
  <svg height="7" width="1200"><line x1="0" y1="0" x2="1300" y2="0" style="stroke:rgb(0,150,255);stroke-width:2" /></svg>
    <table>
      <tr>
        <td>定貨人:</td>
        <td><input type="text" name="source_name" rows="2" cols="30"><span class="error">* </span></td>
        <td>電話:</td>
        <td><input type="text" name="source_phone" rows="2" cols="50"><span class="error">* </span></td>
        <td>e-mail:</td>
        <td><input type="text" name="source_email" rows="2" cols="50"></td>
      </tr>
      <tr>
        <td>收貨人:</td>
        <td><input type="text" name="arrive_name" rows="2" cols="30"><span class="error">* </span></td>
        <td>電話:</td>
        <td><input type="text" name="arrive_phone" rows="2" cols="50"><span class="error">* </span></td>
        <td>e-mail:</td>
        <td><input type="text" name="arrive_email" rows="2" cols="50"></td>
      </tr>
    </table>
    <table>
      <tr>
        <td>收貨人地址:</td>
        <td><textarea type="text" name="address" rows="2" cols="100"></textarea><span class="error">* </span>
         </td>
      </tr>
      <tr>
        <td>備註:</td>
        <td><p><textarea type="text" name="note" rows="4" cols="100"></textarea></p></td>
      </tr>
    </table>
    </br>
    <p><input type='submit' value='送出訂單'> <input type='reset' value='清除'></p>
    </br>
    
    <table id="mt" style="width:100%" border="1" cellpadding="5">
      <thead>
        <th>產品    &   產品編號    &   內容物   &   單價</th>
        <th>數目</th>
      </thead>
      <tbody>
          <th>
          </th>
          <th><input type="text" name="count_num" ><span class="error">* </span></th>
      </tbody>
    </table>
    
    <input type="hidden" id="products" name="hidden_objects" value='<?php  show_products(); ?> '>
    

  <p><?php  #check_error(checking_value()) ?></p>
   </form>
   <button id="add">增加欄位</button>
   <button id="del">刪除欄位</button>
</div>
</body>
</html>


