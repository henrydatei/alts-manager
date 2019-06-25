<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Der organisierte Hacker - localsettings</title>
    <link href="../../style.css" type="text/css" rel="stylesheet" />
    <link href="style.css" type="text/css" rel="stylesheet" />
    <link rel="shortcut icon" href="../../media/favicon.ico" />
    <script src="javascript.js" charset="utf-8" defer="defer"></script>
  </head>
  <body>
    <header>
      <a href="../../index.php"><div align="center" id="header-schrift">Der organisierte Hacker</div></a>
    </header>

    <?php
      // Verarbeitung wenn neue localsettings angelegt werden
      if (isset($_POST['s'])) {
        $dateiname = $_POST['dateiname'];
        $filename = "$dateiname.txt";
        $inhalt = $_POST['inhalt'];

        $handle = fopen($filename, 'w');
        fwrite($handle, $inhalt);
        fclose($handle);
      }

      // Verarbeitung wenn localsettings gelöscht werden
      if (isset($_POST['loeschen'])) {
        $filename = $_POST['file'];
        unlink($filename);
      }
     ?>

    <main>
       <div class="liste">
         <h3>verfügbre Localsettings</h3>
         <ul>
           <?php
             $all_dirs = scandir('.');
             foreach ($all_dirs as $file) {
               $name_endung = explode('.', $file);
               if ($name_endung[1] == "txt") {
                 print "<li><a href=\"index.php?setting=$file\">$file</a></li>";
               }
             }
            ?>
         </ul>
       </div>

       <?php
        if (isset($_GET['setting'])) {
          $setting = $_GET['setting'];
          print "<div class=\"viewer\">";
          print "<form action=\"index.php\" method=\"post\">";
          print "<input type=\"hidden\" name=\"file\" value=\"$setting\" />";
          print "<iframe src=\"$setting\">";
          print "</iframe>";
          print "<input type=\"submit\" name=\"loeschen\" value=\"löschen\" id=\"loeschen\" />";
          print "</form>";
          print "</div>";
        }
        ?>

      <div class="neu">
        <h3>neue Localsettings anlegen</h3>
        <form action="index.php" method="post">
          <table>
            <tr>
              <td>Name: </td>
              <td><input type="text" name="dateiname" />.txt</td>
            </tr>
            <tr id="buttonzeile">
              <td></td>
              <td><button type="button" onclick="neu_anlegen()">neu anlegen</button></td>
            </tr>
            <tr id="textareazeile">
              <td>Inhalt: </td>
              <td><textarea rows="20" cols="50" name="inhalt"></textarea></td>
            </tr>
            <tr id="absendezeile">
              <td></td>
              <td><input type="submit" name="s" value="neu anlegen" /></td>
            </tr>
          </table>
        </form>
      </div>
    </main>
  </body>
</html>
