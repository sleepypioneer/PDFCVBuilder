<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
   $fp = @fopen("ajax_json_sammlung.txt","w");
   if (!$fp) exit("Dateifehler");
   $feld_sammlung = array(
      array("farbe"=>"Rot", "geschwindigkeit"=>50.2),
      array("farbe"=>"Blau", "geschwindigkeit"=>85.0),
      array("farbe"=>"Gelb", "geschwindigkeit"=>65.5));
   $ausgabe = json_encode($feld_sammlung);
   fputs ($fp, $ausgabe);
   fclose($fp);
?>
</body></html>
