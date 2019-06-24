<?php
include("../dbconnect.php");
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="../style.css" type="text/css" rel="stylesheet" />
    <link href="style.css" type="text/css" rel="stylesheet" />
    <title>Der organisierte Hacker - API-Explorer</title>
    <link rel="shortcut icon" href="../media/favicon.ico" />
    <script src="javascript.js" charset="utf-8" defer="defer"></script>
  </head>
  <body>
    <header>
      <a href="../index.php"><div align="center" id="header-schrift">Der organisierte Hacker</div></a>
    </header>

    <main>
      <div class="config">
        <h3>freeAlts</h3>
        <p class="beschreibung">
          Diese Funktion gibt eine Liste der freien Accounts (ohne Main-Accounts), die auf einem speziellen Server nicht gebannt sind, in
          folgendem Format zurück:
          <code>username:password:name</code>
        </p>
        <p>
          <form action="index.php" method="post">
            <table>
              <tr>
                <td>Server: </td>
                <td>
                  <select name="freeAlts_server">
                    <?php
                      $anfrage = mysqli_query($db, "SELECT `server` FROM `alts`");
                      while ($zeile=mysqli_fetch_object($anfrage)) {
                        $aktuellerServer = $zeile->server;
                        if ($aktuellerServer == $_GET['server']) {
                          print "<option selected>$aktuellerServer</option>";
                        } else {
                          print "<option>$aktuellerServer</option>";
                        }
                      }
                     ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="freeAlts" value="API testen"/></td>
              </tr>
            </table>
          </form>
        </p>

        <hr>

        <h3>getAccounts</h3>
        <p class="beschreibung">
          Diese Funktion braucht keine Input-Argumente und gibt eine komplette Liste der Accounts (ohne Main-Accounts) in folgendem
          Format zurück <code>username:password:name</code>
        </p>
        <p>
          <form action="index.php" method="post">
            <input type="submit" name="getAccounts" value="API testen"/>
          </form>
        </p>

        <hr>

        <h3>getStatsForServer</h3>
        <p class="beschreibung">
          Diese Funktion gibt die Anzahl an permanent gebannten, temporär gebannten und freien Accounts für einen spezeillen Server
          zurück (inklusive Main-Accounts).
        </p>
        <p>
          <form action="index.php" method="post">
            <table>
              <tr>
                <td>Server: </td>
                <td>
                  <select name="getStatsForServer_server">
                    <?php
                      $anfrage = mysqli_query($db, "SELECT `server` FROM `alts`");
                      while ($zeile=mysqli_fetch_object($anfrage)) {
                        $aktuellerServer = $zeile->server;
                        if ($aktuellerServer == $_GET['server']) {
                          print "<option selected>$aktuellerServer</option>";
                        } else {
                          print "<option>$aktuellerServer</option>";
                        }
                      }
                     ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="getStatsForServer" value="API testen"/></td>
              </tr>
            </table>
          </form>
        </p>
      </div>

      <div class="link">
        <code id="link">
          <?php
            if (isset($_POST['freeAlts'])) {
              $server = $_POST['freeAlts_server'];
              $link = "freeAlts.php?server=$server";
              print "/api/$link";
            }
            if (isset($_POST['getAccounts'])) {
              $link = "getAccounts.php";
              print "/api/$link";
            }
            if (isset($_POST['getStatsForServer'])) {
              $server = $_POST['getStatsForServer_server'];
              $link = "getStatsForServer.php?server=$server";
              print "/api/$link";
            }
           ?>
        </code>
      </div>

      <div class="result">
        <?php
          if (isset($_POST['freeAlts']) || isset($_POST['getAccounts']) || isset($_POST['getStatsForServer'])) {
            print "<iframe src=\"$link\">";
            print "</iframe>";
          } else {
            print "<iframe>";
            print "</iframe>";
          }
         ?>
      </div>
    </main>
  </body>
</html>
