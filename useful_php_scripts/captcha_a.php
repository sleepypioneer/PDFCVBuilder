<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
   // graues Bild, schwarze Schrift
   $im = imagecreate(250, 60);
   $grau = imagecolorallocate($im, 192, 192, 192);
   imagefill($im, 0, 0, $grau);
   $schwarz = imagecolorallocate($im, 0, 0, 0);
 
   // ohne verwechselbare Zeichen, Zahlen doppelt
   $allezeichen = "ABCDEFGHIJKLPQRSTUVXY12345781234578";
   $laenge = strlen($allezeichen);
   $text = "";
   
   // 5 Zeichen
   for($i=1; $i<=5; $i++)
   {
      $index = floor(lcg_value() * $laenge);
      $zeichen = substr($allezeichen, $index, 1);
      $text .= $zeichen;
      // Referenz, Schriftgröße, Winkel, x, y, Farbe, Schrift, Text
      imagettftext ($im, 30, -35 * $i, 45 * $i - 20, 40 - $i * 6,
         $schwarz, "arial.ttf", $zeichen);
   }
 
   // Speichern
   imagepng($im, "captcha.png");
   imagedestroy($im);

   // Formular
   echo "<form action='captcha_b.php' method='post'>";
   echo "<p>Bitte geben Sie die Zeichen auf dem Bild ein"
      . " und senden Sie das Formular ab:</p>";
   echo "<input name='bildtext' type='hidden' value='"
      . md5($text) . "'>";
   echo "<p><img src='captcha.png'></p>";
   echo "<p><input name='eingabe'> <input type='submit'></p>";
   echo "</form>";
?>
</body></html>
