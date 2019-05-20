<?php
require_once 'scripts/database.php';
require_once 'scripts/helpfuncties.php';

//query eigen playlist
$sqlMijnPlaylist = "SELECT playlistid, titel FROM savedplaylist s INNER JOIN playlist p ON s.playlistid = p.idplaylist";

//QUERY VOOR TONEN VAN AL MIJN BEWAARDE SONGS
$sqlLijstSongs = "SELECT s.idsongs, s.title, s.duur, a.naam, cd.cdtitel, ss.date as toegevoegd
 FROM savedsongs ss INNER JOIN song s ON ss.songid = s.idsongs INNER JOIN artiest a ON s.artistid = a.idartiest INNER JOIN songopcd soc ON s.idsongs = soc.songid INNER JOIN cd ON soc.cdid = cd.idcd";

//query van playlist uitvoeren om in NAV te plaatsen
if (!$resNavMijnPlaylist = $mysqli->query($sqlMijnPlaylist)) {
    echo "oeps, error op database bij eigen playlist";
    print("<p>Error: " . $mysqli->error . "<p>");
    exit();
}

//query van mijn songs uitvoeren om in centrum te plaatsen
if (!$resListSongs = $mysqli->query($sqlLijstSongs)) {
    echo "oeps, error op database bij mijn songs";
    print("<p>Error: " . $mysqli->error . "<p>");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,400" rel="stylesheet" />
    <link rel="stylesheet" href="style/screen.css" />
  </head>
  <body class="container-fluid h-100">
    <div id="container" class="row h-100">
      <aside class="col-2 h-100">
        <nav>
          <ul class="list-unstyled">
            <li><a href="#">Browse</a></li>
            <li><a href="#">Radio</a></li>
          </ul>
        </nav>
        <nav>
          <h1>your library</h1>
          <ul class="list-unstyled">
            <li><a href="#">Your daily mix</a></li>
            <li><a href="#">Recent played</a></li>
            <li><a href="#">Songs</a></li>
            <li class="active"><a href="#">Albums</a></li>
            <li><a href="#">Artists</a></li>
            <li><a href="#">Stations</a></li>
          </ul>
        </nav>
        <nav>
          <h1>playlist</h1>
          <ul class="list-unstyled">
<?php
//ophalen resultaat query
//per rij van playlist
while ($row = $resNavMijnPlaylist->fetch_assoc()) {
    $tempId = $row['playlistid'];
    $tempTitel = $row['titel'];

    //gebruiken var om li te makent
    ?>
              <li><a href="playlist.php?idplaylist=<?php print($tempId)?>"><?php print($tempTitel);?></pre></a></li>
<?php
}
?>
          </ul>
        </nav>
      </aside>
      <main class="col-10 h-100">
        <header class="row">
          <div class="col-6">
            <i class="fas fa-chevron-left"></i>
            <i class="fas fa-chevron-right"></i>
            <form>
              <input type="text" name="zoeken" id="zoeken" />
            </form>
          </div>
          <div class="col-6 text-right">
            <img src="images/person.png" alt="mijn account" />
            Christophe Laprudence
            <a href="#"><i class="fas fa-chevron-down"></i></a>
          </div>
        </header>

        <section class="row" id="content">
          <header class="col-12">
            <div class="row">
              <div class="col-12">
                <div class="type"><h1>Omschrijving</h1></div>
              </div>
              <div class="col-6" id="content-actions">
                <a class="btn solid" href="#">Play</a>
                <a class="btn" href="#">Following</a>
                <a class="btn more" href="#"><i class="fas fa-ellipsis-h"></i></a>
              </div>
              <div class="col-6 text-right" id="content-followers">xxxx aantal followers</div>
            </div>
          </header>

          <section class="col-12 tabelview" id="bevat">
            <div class="row">
              <!--hier stond de articles-->
              <table class="table">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>title</th>
                    <th>artist</th>
                    <th>album</th>
                    <th><i class="far fa-calendar"></i></th>
                    <th></th>
                    <th><i class="far fa-clock"></i></th>
                  </tr>
                </thead>
                <tbody>



              <!--- while loop voor sons ---->
                <?php
while ($row = $resListSongs->fetch_assoc()) {
    $tempTitel = $row['title'];
    $tempArtist = $row['naam'];
    $tempAlbum = $row['cdtitel'];
    $tempDate = $row['toegevoegd'];
    $tempTime = $row['duur'];
    $tempDuur = sec_naar_tijd($tempTime);
    ?>
                  <tr>
                    <td class="play_status"><i class="fas fa-volume-up"></i> <i class="far fa-play-circle"></i><i class="far fa-pause-circle"></i></td>
                    <!--de check is om nummers te wissen-->
                    <td><i class="fas fa-check"></i></td>
                    <td><?php print($tempTitel);?></td>
                    <td><?php print($tempArtist);?></td>
                    <td><?php print($tempAlbum);?></td>
                    <td><?php print($tempDate);?></td>
                    <td><i class="fas fa-ellipsis-h"></i></td>
                    <td><?php print($tempDuur);?></td>
                  </tr>
                  <?php }?>
                  <!---  ---->
                </tbody>
              </table>
            </div>
          </section>
        </section>
      </main>
    </div>
    <footer class="row fixed-bottom">
      <section class="col-3" id="nav_playing">
        <div class="row">
          <div class="col-4">
            <img src="images/placeholder.png" class="img-fluid" alt="now playing" />
          </div>
          <div class="col-8 m-auto">
            <section class="infoplaying">
              <div class="songtitle">Title</div>
              <div class="artiest">artiest</div>
            </section>
          </div>
        </div>
      </section>
      <section class="col-6 m-auto" id="nav_ctrl">
        <div class="row">
          <div class="col-1 text-center">x:xx</div>
          <div class="col-10 m-auto">
            <div class="playbar">
              <div class="currentposbar"></div>
              <div class="currentpos"></div>
            </div>
          </div>
          <div class="col-1 text-center">x:xx</div>
        </div>
      </section>
      <section class="col-3 m-auto" id="now_remote">
        <div class="row">
          <div class="col-4"></div>
          <div class="col-5 m-auto">
            <div class="playbar">
              <div class="currentposbar"></div>
              <div class="currentpos"></div>
            </div>
          </div>
          <div class="col-3"></div>
        </div>
      </section>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="scripts/scrollen.js"></script>
  </body>
</html>
