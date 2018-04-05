<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
   if($_POST["bildtext"] == md5($_POST["eingabe"]))
      echo "Ihre Angaben werden gespeichert";
   else
      echo "Ihre Angaben werden nicht gespeichert";
?>
</body></html>
