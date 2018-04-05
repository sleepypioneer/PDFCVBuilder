<?php
   header("Content-Type: text/xml; charset=utf-8");

   $con = mysqli_connect("", "root", "", "firma");
   $res = mysqli_query($con, "SELECT * FROM personen"
      . " WHERE personalnummer = " . $_GET["pnr"]);
   $dsatz = mysqli_fetch_assoc($res);

   echo "<?xml version='1.0' encoding='utf-8'?>";
   echo "<daten>";
   echo " <gh>" . $dsatz["gehalt"] . "</gh>";
   echo " <gb>" . $dsatz["geburtstag"] . "</gb>";
   echo "</daten>";
?>