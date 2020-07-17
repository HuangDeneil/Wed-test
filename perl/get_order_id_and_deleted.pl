#!/usr/bin/perl
use strict;


#############################################
# 
# This perl script sorting geranal table
# 
# usage : perl get_order_id_and_deleted.pl $ARGV[0] $ARGV[1] 
# 
# $ARGV[0] >>> order table
# $ARGV[1] >>> order id
# 
# 

if( !$ARGV[0])
{
	print "Usage error!!\n";
	print "Usage : perl get_order_id_and_deleted.pl \$ARGV[0] \$ARGV[1]\n\n";
	print "\t\$ARGV[0] >> order table (tmp.csv)\n";
    print "\t\$ARGV[1] >> order id\n";
	die "error";
}


my @tmp;
my %data;
my $id;


open(IN,"$ARGV[0]")||die "$!";

while(<IN>)
{
	chomp;
	@tmp=split ",",$_;
	$id = $tmp[0];

    
    $data{$id}=$_;

}

close IN;

my @array= keys %data;
#print "@array";

my @array2;
foreach (@array)
{
	s/D//;
	push @array2,$_;
}

open (OUT,">selected_order.csv")||die "$!";

foreach $_ (sort { $b <=> $a} @array2)
{
	$id="D$_";
	if ($id eq $ARGV[1])
	{}
	else{
		print OUT "$data{$id}\n";
	}
}

close OUT;
