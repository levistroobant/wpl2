<?php
require_once 'scripts/database.php';

//query eigen playlist
$sqlMijnPlaylist = "SELECT playlistid, titel FROM savedplaylist s INNER JOIN playlist p ON s.playlistid = p.idplaylist";
//query alle playlist
$sqlBrowselijst = "SELECT idplaylist, titel, omschrijving, afbeelding, createdby FROM playlist";

//query van playlist uitvoeren om in NAV te plaatsen
if (!$resNavMijnPlaylist = $mysqli->query($sqlMijnPlaylist)) {
    echo "oeps, error op database bij eigen playlist";
    print("<p>Error: " . $mysqli->error . "<p>");
    exit();
}

//query van ALLR playlist uitvoeren om in centrum pagina te plaatsen
//opvangen fouten
if (!$resBrowselijst = $mysqli->query($sqlBrowselijst)) {
    echo "oeps, error op database bij alle playlist";
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
              <div class="col-12" id="content-cover">
              </div>
                <h1>Browse</h1>
              <div class="col-12" id="content-actions">
                <a class="btn solid" href="#">Play</a>
              </div>
            </div>
          </header>


          <div class="col-12 scrolledsmall">
            <div class="row">
              <div class="col-6"> <h1> Browse </h1> </div>
              <div class="col-6 text-right"> <a class="btn solid" href="#">Play</a> </div>
            </div>
          </div>




          <section class="col-12 catalogus" id="bevat">
            <div class="row">

<!--- voor elk nummer een article maken php  --->

              <?php
while ($row = $resBrowselijst->fetch_assoc()) {
    $tempId = $row['idplaylist'];
    $tempTitel = $row['titel'];
    $tempOmschrijving = $row['omschrijving'];
    $tempAfbeelding = $row['afbeelding'];

    ?>

<!--- voor elk nummer een article maken html   --->

              <article class="col-sm-6 col-md-4 col-lg-3">

                <header>

                  <img src="images/playlist/<?php print($tempAfbeelding);?>" alt="<?php print($tempTitel);?>" class="img-fluid" />

                  <div class="overlay">
                    <div class="ctrl">
                      <i class="fas fa-plus"></i>
                      <a href="playlist.php?idplaylist=<?php print($tempId);?>"> <i class="fas fa-play"></i> </a>
                      <i class="fas fa-ellipsis-h"></i>
                    </div>
                  </div>
                </header>
                <div class="infocard">
                  <h1><?php print($tempTitel);?></h1>
                  <section>
                  </section>
                  <footer>
                  <?php print($tempOmschrijving);?>
                  </footer>
                </div>

              </article>



              <?php }?>
<!---  --->

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