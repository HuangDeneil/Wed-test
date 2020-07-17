#!/usr/bin/perl
use strict;
use warnings;
use DBI;
use DBD::mysql;
use Encode;
use Encode qw/encode decode from_to/;

#####################################
#  
# 此程式工作為下載 "訂單總表" 並且完成排列去重複
# 
# Usage : perl get_sql.pl $ARGV[0]
# 
# 	$ARGV[0] >> output table name (tmp.csv)
# 
# ex: perl get_sql.pl tmp.csv
# 

if( !$ARGV[0])
{
	print "Usage error!!\n";
	print "Usage : perl get_sql.pl \$ARGV[0]\n\n";
	print "\t\$ARGV[0] >> output table name (tmp.csv)\n";
	die "error";
}

my ($dbh,$sth);

# CONFIG VARIABLES
my $platform = "mysql";
my $database = "the_db";
my $host = "localhost";
my $port = "3306";
my $tablename = "gernal_table";
my $user = "hudeneil";
my $pw = "78369906";

#DATA SOURCE NAME
my $dsn = "dbi:mysql:$database:localhost:3306";


# PERL DBI CONNECT
$dbh = DBI->connect($dsn, $user, $pw); 


###################
# SQL query here
$sth = $dbh->prepare("SELECT * FROM gernal_table");

###################
# setting coding with utf8
$dbh->do(qq{SET NAMES 'utf8';});

###################
# execute the query
$sth->execute();
 

my $i;
my $tmp;
my $data;
my %data;
my $id;

open (OUT,">$ARGV[0]") || die "$!";
while ( my @row = $sth->fetchrow_array( ) )  {
	$data="";
	$id = $row[0];
	for ($i=0; $i<@row; $i++)
	{
		
		if ($i < $#row)
		{
			#print "$row[$i],";
			$data="$data$row[$i],";
		}
		elsif( $i == $#row )
		{
			#print "$row[$i]\n";
			$data="$data$row[$i]";
		}
	}
	$data{$id} = $data;	
#	print "$data\n";
}

my @array = sort keys %data;
#print "@array";
#print "@array\n";

foreach $id (sort keys %data)
{
	if( $data{$id} eq ""){}
	elsif($id=~/\w/)
	{
		print OUT "$data{$id}";
	}
	#print  "$id\n";
}
#system 'echo " \"`pwd`\""';

close OUT;
exit;


