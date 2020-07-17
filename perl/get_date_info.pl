#!/usr/bin/perl
use strict;

#############################################
# 
# This perl script sorting geranal table
# 
# usage : perl get_date_info.pl $ARGV[0] 
# 
# $ARGV[0] >>> gernal_table_reorganized.csv
# 
# 
# 

if( !$ARGV[0])
{
	print "Usage error!!\n";
	print "Usage : perl get_date_info.pl \$ARGV[0]\n\n";
	print "\t\$ARGV[0] >> input table name (gernal_table_reorganized.csv)\n";
	die "error";
}


my @tmp;
my $date;
my %time;
my %year_month;

open (IN,"$ARGV[0]")|| die "$!":

while(<IN>)
{
    chomp;
    @tmp=split "",$_;

}

close IN;







