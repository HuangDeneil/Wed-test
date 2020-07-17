#!/usr/bin/perl
use strict;

#############################################
# 
# This perl script sorting geranal table
# 
# usage : perl gernal_table_process.pl $ARGV[0] $ARGV[1] $ARGV[2] 
# 
# $ARGV[0] >>> gernal_list_from_mysql.csv
# $ARGV[1] >>> product_list_from_mysql.csv
# $ARGV[2] >>> gernal_table_reorganized.csv
#
# perl gernal_table_process.pl gernal_list_from_mysql.csv product_list_from_mysql.csv gernal_table_reorganized.csv
# 
# 
# gernal_list_from_mysql.csv:
# --------------------------------------------------
# D20190909155243,2019/09/09,網路,謝佳琳,0975306192,,0975306192,,邱慧滿,台北巿合江街182號5樓,,, 208899x1,1,710,,,,
# D20190909164850,2019/09/09,網路,謝佳琳,0975306192,,0975306192,,謝秀芬,台北巿東興路21號B1,,, 208899x1,1,710,,,,
# D20190909165041,2019/09/09,網路,謝佳琳,0975306192,,0975306192,,陳香碧,新北巿三重區文化北路224巷58號,,, 208899x1,1,710,,,,
# 
# 
# product_list_from_mysql.csv
# ----------------------------------------------------
# 單品獨享杯清爽	102501	獨享杯清爽x3	165	165
# 單品獨享杯微甜	102502	獨享杯微甜x3	165	165
# 單品家庭號清爽	102901	家庭號清爽x1	299	299
# 單品家庭號微甜	102902	家庭號微甜x1	299	299
# 
# 
# 
#system 'echo "\"`pwd`\""';
my %product_info;
my %product_name;
my %product_price;
my %gernal_list;
my %gernal_list_info;
my @order;
my @tmp;
my @tmp2;
my $id;
my $count;
my $price;
my @price;
my %product;
my $product_price;
my $i;
my $total_price;

##############
# 
# Reading product_list
# 
open(IN,"$ARGV[1]")||die "$!";

while(<IN>)
{
	chomp;
	@tmp=split "\t",$_;
	$id = $tmp[1];
	$product_info{$id}=$tmp[2];
	$product_name{$id}=$tmp[0];
	$product_price{$id}=$tmp[3];
	$product{$id}="$tmp[3],$tmp[4],$tmp[5]";
}

close IN;


##############
# 
# Reading gernal_list & remove repeat with same id
# 
open(IN,"$ARGV[0]")||die "$!";

while(<IN>)
{
	chomp;
	@tmp=split ",",$_;
	$id = $tmp[0];
	$gernal_list_info{$id}=$_;
	
	
}

close IN;

open (OUT,">$ARGV[2]")||die "$!";

my @array=sort keys %gernal_list_info;

#0 訂單編號		#1 訂單日期		#2 訂購方式		
#3 訂購人姓名	#4 訂購人電話	#5 訂購人信箱
#6 收件人姓名	#7 收件人電話	#8 收件人信箱	#9 寄送地址
#10 取貨方式	#11 到貨時間	#12 產品編號	#13 總數量	#14 商品總價小計	#15 折扣後總計	
#16 物流費用	#17 應收款		#18 收款情形	#19 備註	#20 discount


system '
	if [ ! -d "../order_list" ] ;then
		echo "cannot find ouput folder \"order_list\""
	fi
';
##################################
## 
## format 1 order  
## 

foreach $_ (sort @array)
{
	if ($_ eq ""){}
	else
	{
		$id=$_;
		print OUT "$gernal_list_info{$id}\n";
		open(OUT_html,">../order_list/$id\-format1.html")||die "$!";
		
		@tmp = split ",",$gernal_list_info{$id};
		
			
		use POSIX qw/strftime/;
		my $time = strftime('%Y-%m-%d %H:%M:%S',localtime);
		
		print OUT_html "<!DOCTYPE html>\n";
		print OUT_html "<html>\n";
		print OUT_html "<head>\n";
		print OUT_html "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		print OUT_html "<style>\n";
		print OUT_html "table {\n";
		print OUT_html "  font-family: arial, sans-serif;\n";
		print OUT_html "  border-collapse: collapse;\n";
		print OUT_html "  width: 100%;\n";
		print OUT_html "}\n\n";
		print OUT_html "td, th {\n";
		print OUT_html "  border: 1px solid #dddddd;\n";
		print OUT_html "  text-align: left;\n";
		print OUT_html "  padding: 2px;\n";
		print OUT_html "}\n\n";
		print OUT_html "tr:nth-child(even) {\n";
		print OUT_html "  background-color: #dddddd;\n";
		print OUT_html "}\n\n";
		print OUT_html "</style  style=\"width:100%\">\n";
		print OUT_html "<title>銷貨單$id</title>\n";
		print OUT_html "</head>\n";
		print OUT_html "<body>\n";
		######
		# 上聯
		print OUT_html "<h3 align=\"center\" >銷 貨 單</h3>\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂購單號：$id</font></th>\n";
		print OUT_html "	<th><font size=\"2\">出貨日期：</font></th>\n";
		print OUT_html "	<th><font size=\"2\">訂購方式: $tmp[2]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">訂購人姓名：$tmp[3]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人電話：$tmp[4]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人信箱：$tmp[5]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">收件人姓名：$tmp[6]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人電話：$tmp[7]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人信箱：$tmp[8]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">統一編號：</th></font>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">銷貨人員：</th></font>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">送貨地址：$tmp[9]</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂單型態：</font></th>\n";
		print OUT_html "  </tr>\n";	
		
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <thead>\n";
		print OUT_html "    <tr>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">項次</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">名稱</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">商品明細</font></th>\n";
		print OUT_html "  	  <th align=\"center\" ><font size=\"2\">總數量</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">單價</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">小計</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">備註</font></th>\n";
		print OUT_html "    </tr>\n";
		print OUT_html "  </thead>\n";
		
		#######
		# 產品編號 (上聯)
		$count=1;
		@tmp2=split " ",$tmp[12];
		foreach (sort @tmp2)
		{
			@order =split "x", $_;
			@price =split ",", $product{$order[0]};
			
			print OUT_html "  <tr>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$count</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_name{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_info{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$order[1]</font></th>\n";
			
			if($tmp[20] =~/\$30/)
			{
				$product_price=$price[1];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~/\$60/)
			{
				$product_price=$price[2];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~ /\%/ )
			{
				$i=$tmp[20];
				$i=~s/discount//;
				$i=~s/%//;

				$product_price=$price[0]*$i/100;
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				$total_price = $total_price+$price;
			}
			else
			{
				$product_price=$price[0];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\"></font></th>\n";
				$total_price = $total_price + $price;
			}

			print OUT_html "	<td align=\"center\" ></th>\n";
			print OUT_html "  </tr>\n";
			
			$count++;
		}
		
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">銷售價錢</font></th>\n";	
		print OUT_html "    <th><font size=\"2\"></font></th>\n";	
		print OUT_html "    <th><font size=\"2\">銷售稅</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">-</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">折扣後總計</font></th>\n";	
		print OUT_html "    <th><font size=\"2\"></font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n\n";	
		print OUT_html "<p><font size=\"2\">備註:</font><font size=\"1\">$tmp[19]</font></p>\n";
		print OUT_html "<p align=\"center\">百歐新創食品科技有限公司 0800-668-611 biofraiche\@gmail.com 感謝您的惠顧</p>\n";	
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">客戶簽收</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">倉庫</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">出納</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">審核</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">填表</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n";

		
		######
		# 下聯
		print OUT_html "<p align=\"center\"><font size=\"3\">銷 貨 單</font></p>\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂購單號：$id</font></th>\n";
		print OUT_html "	<th><font size=\"2\">出貨日期：</font></th>\n";
		print OUT_html "	<th><font size=\"2\">訂購方式: $tmp[2]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">訂購人姓名：$tmp[3]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人電話：$tmp[4]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人信箱：$tmp[5]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">收件人姓名：$tmp[6]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人電話：$tmp[7]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人信箱：$tmp[8]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">統一編號：</th></font>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">銷貨人員：</th></font>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">送貨地址：$tmp[9]</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂單型態：</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <thead>\n";
		print OUT_html "    <tr>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">項次</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">名稱</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">商品明細</font></th>\n";
		print OUT_html "  	  <th align=\"center\" ><font size=\"2\">總數量</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">單價</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">小計</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">備註</font></th>\n";
		print OUT_html "    </tr>\n";
		print OUT_html "  </thead>\n";
		
		#######
		# 產品編號 (下聯)
			$count=1;
		@tmp2=split " ",$tmp[12];
		foreach (sort @tmp2)
		{
			@order =split "x", $_;
			@price =split ",", $product{$order[0]};
			
			print OUT_html "  <tr>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$count</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_name{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_info{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$order[1]</font></th>\n";
			
			if($tmp[20] =~/\$30/)
			{
				$product_price=$price[1];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~/\$60/)
			{
				$product_price=$price[2];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~ /\%/ )
			{
				$i=$tmp[20];
				$i=~s/discount//;
				$i=~s/%//;

				$product_price=$price[0]*$i/100;
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price $1</font></th>\n";
				$total_price = $total_price+$price;
			}
			else
			{
				$product_price=$price[0];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price + $price;
			}

			print OUT_html "	<td align=\"center\" ></th>\n";
			print OUT_html "  </tr>\n";
			
			$count++;
		}
		
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">銷售價錢</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$tmp[14]</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">銷售稅</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">-</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">折扣後總計</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$total_price</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n\n";	
		print OUT_html "<p><font size=\"2\">備註:</font><font size=\"1\">$tmp[19]</font></p>\n";
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">客戶簽收</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">倉庫</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">出納</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">審核</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">填表</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n";

		print OUT_html "</body>\n";	
		print OUT_html "</html>\n";	
		
		
		close OUT_html;
	}
}



######################
## 
## format 2 order
## 
my @array2;
foreach $_ (sort { $b <=> $a} @array2)
{
	if ($_ eq ""){}
	else
	{
		$id="D$_";
		print OUT "$gernal_list_info{$id}\n";
		open(OUT_html,">../order_list/$id\-format2.html")||die "$!";
		
		@tmp = split ",",$gernal_list_info{$id};
		
			
		use POSIX qw/strftime/;
		my $time = strftime('%Y-%m-%d %H:%M:%S',localtime);
		
		print OUT_html "<!DOCTYPE html>\n";
		print OUT_html "<html>\n";
		print OUT_html "<head>\n";
		print OUT_html "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		print OUT_html "<style>\n";
		print OUT_html "table {\n";
		print OUT_html "  font-family: arial, sans-serif;\n";
		print OUT_html "  border-collapse: collapse;\n";
		print OUT_html "  width: 100%;\n";
		print OUT_html "}\n\n";
		print OUT_html "td, th {\n";
		print OUT_html "  border: 1px solid #dddddd;\n";
		print OUT_html "  text-align: left;\n";
		print OUT_html "  padding: 2px;\n";
		print OUT_html "}\n\n";
		print OUT_html "tr:nth-child(even) {\n";
		print OUT_html "  background-color: #dddddd;\n";
		print OUT_html "}\n\n";
		print OUT_html "</style  style=\"width:100%\">\n";
		print OUT_html "<title>銷貨單$id</title>\n";
		print OUT_html "</head>\n";
		print OUT_html "<body>\n";
		######
		# 上聯
		print OUT_html "<h3 align=\"center\" >銷 貨 單</h3>\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂購單號：$id</font></th>\n";
		print OUT_html "	<th><font size=\"2\">出貨日期：</font></th>\n";
		print OUT_html "	<th><font size=\"2\">訂購方式: $tmp[2]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">訂購人姓名：$tmp[3]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人電話：$tmp[4]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人信箱：$tmp[5]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">收件人姓名：$tmp[6]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人電話：$tmp[7]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人信箱：$tmp[8]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">統一編號：</th></font>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">銷貨人員：</th></font>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">送貨地址：$tmp[9]</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂單型態：</font></th>\n";
		print OUT_html "  </tr>\n";	
		
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <thead>\n";
		print OUT_html "    <tr>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">項次</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">名稱</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">商品明細</font></th>\n";
		print OUT_html "  	  <th align=\"center\" ><font size=\"2\">總數量</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">單價</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">小計</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">備註</font></th>\n";
		print OUT_html "    </tr>\n";
		print OUT_html "  </thead>\n";
		
		#######
		# 產品編號 (上聯)
		$count=1;
		@tmp2=split " ",$tmp[12];
		foreach (sort @tmp2)
		{
			@order =split "x", $_;
			@price =split ",", $product{$order[0]};
			
			print OUT_html "  <tr>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$count</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_name{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_info{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$order[1]</font></th>\n";
			
			if($tmp[20] =~/\$30/)
			{
				$product_price=$price[1];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~/\$60/)
			{
				$product_price=$price[2];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~ /\%/ )
			{
				$i=$tmp[20];
				$i=~s/discount//;
				$i=~s/%//;

				$product_price=$price[0]*$i/100;
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price $1</font></th>\n";
				$total_price = $total_price+$price;
			}
			else
			{
				$product_price=$price[0];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price + $price;
			}

			print OUT_html "	<td align=\"center\" ></th>\n";
			print OUT_html "  </tr>\n";
			
			$count++;
		}
		
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">銷售價錢</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$tmp[14]</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">銷售稅</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">-</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">折扣後總計</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$total_price</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n\n";	
		print OUT_html "<p><font size=\"2\">備註:</font><font size=\"1\">$tmp[19]</font></p>\n";
		print OUT_html "<p align=\"center\">百歐新創食品科技有限公司 0800-668-611 biofraiche\@gmail.com 感謝您的惠顧</p>\n";	
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">客戶簽收</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">倉庫</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">出納</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">審核</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">填表</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n";

		
		######
		# 下聯
		print OUT_html "<p align=\"center\"><font size=\"3\">銷 貨 單</font></p>\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂購單號：$id</font></th>\n";
		print OUT_html "	<th><font size=\"2\">出貨日期：</font></th>\n";
		print OUT_html "	<th><font size=\"2\">訂購方式: $tmp[2]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">訂購人姓名：$tmp[3]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人電話：$tmp[4]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">訂購人信箱：$tmp[5]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "	<th><font size=\"2\">收件人姓名：$tmp[6]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人電話：$tmp[7]</font></th>\n";
		print OUT_html "    <th><font size=\"2\">收件人信箱：$tmp[8]</font></th>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "</table>\n\n";
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">統一編號：</th></font>\n";
		print OUT_html "  </tr>\n";
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">銷貨人員：</th></font>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">送貨地址：$tmp[9]</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "  <tr>\n";
		print OUT_html "    <th><font size=\"2\">訂單型態：</font></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "<table  style=\"width:100%\">\n";
		print OUT_html "  <thead>\n";
		print OUT_html "    <tr>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">項次</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">名稱</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">商品明細</font></th>\n";
		print OUT_html "  	  <th align=\"center\" ><font size=\"2\">總數量</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">單價</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">小計</font></th>\n";
		print OUT_html "	  <th align=\"center\" ><font size=\"2\">備註</font></th>\n";
		print OUT_html "    </tr>\n";
		print OUT_html "  </thead>\n";
		
		#######
		# 產品編號 (下聯)
			$count=1;
		@tmp2=split " ",$tmp[12];
		foreach (sort @tmp2)
		{
			@order =split "x", $_;
			@price =split ",", $product{$order[0]};
			
			print OUT_html "  <tr>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$count</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_name{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_info{$order[0]}</font></th>\n";
			print OUT_html "	<td align=\"center\" ><font size=\"1\">$order[1]</font></th>\n";
			
			if($tmp[20] =~/\$30/)
			{
				$product_price=$price[1];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~/\$60/)
			{
				$product_price=$price[2];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price+$price;
			}
			elsif($tmp[20] =~ /\%/ )
			{
				$i=$tmp[20];
				$i=~s/discount//;
				$i=~s/%//;

				$product_price=$price[0]*$i/100;
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price $1</font></th>\n";
				$total_price = $total_price+$price;
			}
			else
			{
				$product_price=$price[0];
				$price = int( $product_price*$order[1]);
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$product_price</font></th>\n";
				print OUT_html "	<td align=\"center\" ><font size=\"1\">$price</font></th>\n";
				$total_price = $total_price + $price;
			}

			print OUT_html "	<td align=\"center\" ></th>\n";
			print OUT_html "  </tr>\n";
			
			$count++;
		}
		
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">銷售價錢</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$tmp[14]</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">銷售稅</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">-</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">折扣後總計</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">$total_price</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n\n";	
		print OUT_html "<p><font size=\"2\">備註:</font><font size=\"1\">$tmp[19]</font></p>\n";
		print OUT_html "<table  style=\"width:100%\">\n";	
		print OUT_html "  <tr>\n";	
		print OUT_html "    <th><font size=\"2\">客戶簽收</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">倉庫</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">出納</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">審核</font></th>\n";	
		print OUT_html "    <th><font size=\"2\">填表</font></th>\n";	
		print OUT_html "  </tr>\n";	
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "    <th height=\"30\"></th>\n";
		print OUT_html "  </tr>\n";	
		print OUT_html "</table>\n";

		print OUT_html "</body>\n";	
		print OUT_html "</html>\n";	
		
		
		close OUT_html;
	}
}

close OUT;


