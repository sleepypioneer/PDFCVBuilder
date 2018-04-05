<!DOCTYPE html><html><head><meta charset="utf-8">
<script type="text/javascript">
function anfordern(personalnummer)
{
   var req = new XMLHttpRequest();
   req.open("get", "ajax_db_b.php?pnr=" + personalnummer, true);
   req.setRequestHeader("Content-Type",
      "application/x-www-form-urlencoded");
   req.onreadystatechange = auswerten;
   req.send();
}

function auswerten(e)
{
   if(e.target.readyState == 4 && e.target.status == 200)
   {
      var antwort = e.target.responseXML;
      document.getElementById("idGehalt").firstChild.nodeValue
         = antwort.getElementsByTagName("gh")[0].
         firstChild.nodeValue;
      document.getElementById("idGeburtstag").firstChild.nodeValue
         = antwort.getElementsByTagName("gb")[0].
         firstChild.nodeValue;
   }
}
</script>
</head>

<body>
<p>
<?php
   $con = mysqli_connect("", "root", "", "firma");
   $res = mysqli_query($con, 
      "SELECT * FROM personen ORDER BY name, vorname");
   while ($dsatz = mysqli_fetch_assoc($res))
      echo "<a href='javascript:anfordern("
         . $dsatz["personalnummer"] . ")'>" . $dsatz["name"]
         . ", " . $dsatz["vorname"] . "</a><br>";
   mysqli_close($con);
?>
</p> 
<p><span id="idGehalt">&nbsp;</span>
<span id="idGeburtstag">&nbsp;</span></p>
</body></html>
