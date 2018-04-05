<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
   /* Sammlung von Objekten */
   $fp = @fopen("ajax_json_einzel.txt","r");
   if (!$fp) exit("Dateifehler");
   $zeile = fgets($fp, 1000);
   $feld_einzel = json_decode($zeile);
   foreach($feld_einzel as $eigenschaft=>$wert)
      echo "$eigenschaft: $wert<br>";
   fclose($fp);
   echo "<br>";

   /* Sammlung von Objekten */
   $fp = @fopen("ajax_json_sammlung.txt","r");
   if (!$fp) exit("Dateifehler");
   $zeile = fgets($fp, 1000);
   $feld_sammlung = json_decode($zeile);
   foreach($feld_sammlung as $feld_einzel)
      foreach($feld_einzel as $eigenschaft=>$wert)
         echo "$eigenschaft: $wert<br>";
   fclose($fp);
?>
</body></html>
