<?php header("Content-Type:text/html; charset=utf-8"); ?>

<html>
<head>
<title>php mysql testing</title>
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
  /* body {
  background-image: url('../images/APG-3.PNG');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: top left ;
  background-size: 15%;
  } */
</style>


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
<body>
<div id="logo" class="container">
  <a href="../index.html" class="button" style="font-family:微軟正黑體;text-transform:initial;font-size:200%">Back</a>
   <h1 style="font-family:微軟正黑體;text-transform:initial;font-size:300%">物種資料庫<span>Loacl web system</span><h1>List all libraries</h1></h1>
  </br>
</div>

<!--- Table region  --->



<div id="wrapper" class="container">
    <?php
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
        if (!$mysqli->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $mysqli->error);
        } 
        $result = $mysqli->query("SELECT * FROM reference_summary");

        if ($result->num_rows > 0) {
            // output data of each row

            echo "<table id=\"mt\" style=\"width:100%\" border=\"1\" cellpadding=\"5\">";
            echo "<thead>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">ID</td>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">Organism Name</td>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">Genus</td>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">Type</td>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">Source</td>";
            echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:150%\">Key words</td>";
            echo "</thead>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\">" . $row["ID"]. "</td>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\"><I>" . $row["organism_name"]. "</I></td>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\"><I>" . $row["genus"]. "</I></td>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\"> " . $row["type"]. "</td>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\"> " . $row["source"]. "</td>";
                echo "<td style=\"font-family:微軟正黑體;text-transform:initial;font-size:100%\"> " . $row["key_word"]. "</td>";
                echo "</tr>";

            }
            
            echo "</table>";
           # fclose($myfile);
        } else {
            echo "0 results";
        }

        $mysqli->close();
      ?>
</div>
</body>
<div class='container' align=center><br>
<em >Copyright 2020 <a href='../'>HOME</a>. Allrights reserved.</em></br>
<!-- <img src="../images/APG-3.PNG" width=300> -->
</div>
</html>
