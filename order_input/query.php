<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>訂單確認</title>
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
  <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%"><span>訂單確認</span></h1>
</div>

<?php
    function _get($str)
    {
        $val = !empty($_POST["$str"]) ? $_POST[$str] : null;
        return $val;
    }

    /*
   #########################################################################################################
   #################### 讀取 產品資訊 from 暫存資料夾中的 "product_list_from_mysql.csv"  ######################
   #########################################################################################################
   */
    function search_products ( $input, $input2 )
    {
        $myfile = fopen("../temp/product_list_from_mysql.csv", "r") or die("Unable to open file!");
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
                elseif($input2 == "dicount30")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[4]);
                        return $price;
                    }
                }
                elseif($input2 == "dicount60")
                {
                    if ($input == $product_id )
                    {
                        $price= floatval($str[5]);
                        return $price;
                    }
                }
            }
            $count=$count+1;
        }
        fclose($myfile);
    }

    $order_id=$order_from="";
    $source_name=$source_phone=$source_email="";
    $arrive_name=$arrive_phone=$arrive_email="";
    $address=$note="";
    $order_product="";
    $count_num=$order_product_price=0;
    
    $order_id=_get("order_id");
    $order_from=_get("order_from");
    $discount=_get("discount");
    
    $source_name=_get("source_name");
    $source_phone=_get("source_phone");
    $source_email=_get("source_email");
    
    $arrive_name=_get("arrive_name");
    $arrive_phone=_get("arrive_phone");
    $arrive_email=_get("arrive_email");
    
    $address=_get("address");
    $note=_get("note");    
    $order_product=search_products(_get("order_product"),"info" );
    $count_num=floatval(_get("count_num"));
    $order_product_price=( floatval($count_num) * search_products("order_product","price"));
    
    if ( empty($order_id)  == 1 )
    {
        $order_id="D".date("Ymdhis");
        $date=date("Ymd");
    }
    else
    {
        $date=date("Ymd");
    }
    
    
   /*
   ##############################################################
   #################### 顯示訂單詳細內容資訊 ######################
   ##############################################################
   */
    function print_order()
    {
        $product_order_info="";
        $product_order_count="";
        $product_order_price=0;
        $product_price=0;

        foreach ($_POST as $key => $value) {
           
            
            if ( preg_match ( "/order_product/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order_info = search_products(_get($key),"info");
                
                echo "<tr>";
                echo "<th> $product_order_info  </th>";
                $product_price = search_products($value,"price");
                #var_dump($product_price);
            }
            elseif(preg_match ( "/count_num/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order_count = floatval($value);
                $product_order_price= $product_order_count*$product_price;
                echo "<th> $product_order_count </th>";
                echo "<th> $product_order_price </th>";
                echo "</tr>";
            }
        }
    }

    /*
   #######################################################
   #################### 計算訂單金額 ######################
   #######################################################
   */
    function total_price()
    {
        $product_value=1;
        $total_price=0;
        $product_order_price=0;
        $discount=_get("discount");
        foreach ($_POST as $key => $value) 
        {
            if ( preg_match ( "/order_product/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order_info = search_products(_get($key),"info");
                $product_price=search_products($value,"price");
            }
            elseif(preg_match ( "/count_num/", $key) )
            {
                $product_order_count = floatval($value);
                $product_order_price=(floatval(_get($key)) * $product_price);       
                $total_price = $total_price + $product_order_price;
            }
        }
        echo $total_price;
    }
    
    function total_count()
    {
        $product_value = 1;
        $total_count=0;
        $product_order=0;
                
        foreach ($_POST as $key => $value) 
        {
            if ( preg_match( "/count_num/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order = (floatval($value) );
                $total_count = $total_count + $product_order;
                $product_value = $product_value+1;
            }
        }
        echo $product_order;
    }


    #####################
    # 計算折扣價錢
    function discount()
    {
        $product_value = 1;
        $total_count=0;
        $product_order=0;
        $discount=_get("discount");        
        
        foreach ($_POST as $key => $value) 
        {
            if ( preg_match( "/count_num/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order = (floatval($value) );
                $total_count = $total_count + $product_order;
                $product_value = $product_value+1;
            }
        }
        
        
        $product_order = $total_count;
        $total_price=0;
        $product_order_price=0;

        
        if ( $product_order > 6 )
        {
            foreach ($_POST as $key => $value) 
            {
                if ( preg_match( "/order_product/", $key) )
                {
                    if ( $discount == "yes30" OR $discount == "auto30" )
                    {
                        $product_price = search_products($value,"dicount30");
                    }
                    elseif ( $discount == "yes60" OR $discount == "auto60" )
                    {
                        $product_price = search_products($value,"dicount60");
                    }
                    else{
                        $product_price = search_products($value,"price");
                    }
                }
                elseif(preg_match ( "/count_num/", $key) )
                {
                    $product_order_price = ( floatval($value) * $product_price );
                    $total_price = $total_price + $product_order_price;
                }
            }
            if ( $discount == "no" )
            {
            echo total_price();
            }
            elseif ( $discount == "auto" )
            {
                $discount_value=floatval(_get("discount_value"))/100;
                
                echo $total_price*$discount_value;
            }
            else
            {
                echo $total_price;
            }
        }
        else
        {
            echo total_price();
            #var_dump(total_order_num());
        }
    }
    
    
    function order()
    {
        $product_order_info="";
        $product_order_count=0;
        $product_order= "";
        $total="";
        $total=_get('order_product')."x"._get('count_num');
        foreach ($_POST as $key => $value) 
        {
            if ( preg_match ( "/order_product[0-9]/", $key) )
            {
                #print "{$key} {$value}<br />";
                $product_order_info = $value;
            }
            elseif(preg_match ( "/count_num[0-9]/", $key) )
            {
                $product_order_count = floatval($value);
                $product_order= $product_order_info."x".$product_order_count;       
                $total = "$total $product_order";
            }

        }
        echo $total;
    }


?>



<div id="wrapper" class="container">
<form name="table_value" method="POST" action="upload.php">
<?php
/*
###################################################
#################### 訂單呈現 ######################
###################################################
*/
?>
<table>
    <tr>
        <td>貨號: <?php echo "$order_id"; ?><input type="hidden" name="order_id" value ="<?php echo $order_id; ?>" ></td>
	    <td>訂貨方式: <?php echo "$order_from   "; ?> </td> 
   	    <td> <?php	    	
			if( _get("discount") == "auto")
			{
				echo "折扣方式: 自訂"._get("discount_value")."%";
			}
			elseif( _get("discount") == "yes30")
			{
				$text= "折扣方式: 折扣$30";
				echo "$text";
			}elseif( _get("discount") == "auto30")
			{
			        $text= "折扣方式: 自動折扣$30";
				echo "$text";
			}
			elseif( _get("discount") == "yes60")
			{
				$text= "折扣方式: 折扣$60";
				echo "$text";
			}
			elseif( _get("discount") == "auto60")
			{
				$text= "折扣方式: 自動折扣$60";
				echo "$text";
			}
			elseif( _get("discount") == "no")
			{
				$text= "折扣方式: 無折扣";
				echo "$text";
            } ?>
            <input id="order_form" type="hidden" name="order_from" value ="<?php echo $order_from; ?>" >
            <input id="discount_value" type="hidden" name="discount_value" value ="<?php 
            if( _get("discount") == "auto")
            {
                $text="discount"._get("discount_value")."%"; 
                echo $text;
            }
            elseif( _get("discount") == "yes30")
			{
				$text= "discount-$30";
				echo "$text";
			}elseif( _get("discount") == "auto30")
			{
			        $text= "discount_auto-$30";
				echo "$text";
			}
			elseif( _get("discount") == "yes60")
			{
				$text= "discount-$60";
				echo "$text";
			}
			elseif( _get("discount") == "auto60")
			{
				$text= "discount_auto-$60";
				echo "$text";
			}
			elseif( _get("discount") == "no")
			{
				$text= "no";
				echo "$text";
            } 
            ?>" >
        </td>
    </tr>
</table>

<input type="hidden" name="date" value ="<?php echo $date; ?>" >

<table>
    <tr>
        <td>定貨人: <?php echo "$source_name" ; ?><input id="source_name" type="hidden" name="source_name" value ="<?php echo $source_name; ?>" ></td>
        <td>電話: <?php echo "$source_phone" ; ?><input id="source_phone" type="hidden" name="source_phone" value ="<?php echo $source_phone; ?>" ></td>
        <td>信箱: <?php echo "$source_email" ; ?><input type="hidden" name="source_email" value ="<?php echo $source_email; ?>" ></td>
    </tr>
    <tr>
        <td>收貨人: <?php echo "$arrive_name" ; ?><input id="arrive_name" type="hidden" name="arrive_name" value ="<?php echo $arrive_name; ?>" ></td>
        <td>電話: <?php echo "$arrive_phone" ; ?><input id="arrive_phone" type="hidden" name="arrive_phone" value ="<?php echo $arrive_phone; ?>" ></td>
        <td>信箱: <?php echo "$arrive_email" ; ?><input type="hidden" name="arrive_email" value ="<?php echo $arrive_email; ?>" ></td>
      </tr>
</table>
<table>
    <tr>
        <td>地址: <?php echo "$address" ; ?><input id="address" type="hidden" name="address" value ="<?php echo $address; ?>" ></td>
    </tr>
    <tr>
        <td>備註: <?php echo "$note" ; ?><input type="hidden" name="note"  value ="<?php echo $note; ?>" ></td>
    </tr>
</table>
<table  style="width:100%">
    <tr>
        <th>合計 : <?php echo total_price() ; ?><input type="hidden" name="total_price" value ="<?php echo total_price(); ?>" ></th>
        <td></td>
        <th>銷售稅 : --</th>
        <th></th>
        <th>折扣後總計 : <?php discount("total"); ?><input type="hidden" name="discount" value ="<?php echo discount("total"); ?>" ></th>
        <td></td>
    </tr>
</table>
<script>
    var order_form = document.getElementById("order_form").value;
    var source_name = document.getElementById("source_name").value;
    var source_phone = document.getElementById("source_phone").value;
    var arrive_name = document.getElementById("arrive_name").value;
    var arrive_phone = document.getElementById("arrive_phone").value;
    var arrive_address = document.getElementById("address").value;

    if( order_form === "" ){alert("請填寫訂單來源(網路or現場)");}
    else if( source_name === "" ){alert("請填寫訂貨人姓名");}
    //else if( source_phone === "" ){alert("請填寫訂貨人電話");}
    else if( arrive_name === "" ){alert("請填寫收貨人姓名");}
    //else if( arrive_phone === "" ){alert("請填寫收貨人電話");}
    //else if( arrive_address === "" ){alert("請填寫到貨地址");}
    
</script>
</br>

    <table  style="width:100%" style="width:100%" border="1" cellpadding="5">
      <tr>
        <th>產品    &   產品編號    &   內容物   &   單價</th>
        <th>數目</th>
        <th>總價</th>
      </tr>
      <tr>
        <?php   print_order(); ?>
      </tr>
    </table>
    <input type="hidden" name="orders" value ="<?php echo order(); ?>" >
    <input type="hidden" name="total_count" value ="<?php echo total_count(); ?>" >
    </br></br>
    <input type='submit' value='確認訂單並送出'> 
    
    </form>
</div>

</body>
</html>
