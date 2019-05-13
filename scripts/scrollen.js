//luisteren naar het scrollen van een element
$('#content').scroll(function() {
  console.log('ik ben aan het scrollen');
  //variabele aanmaken
  let huidigeScrollPositie = $('#content>header').offset().top;
  let hoogteZoekbalk = $('main>header').height();
  let hoogteInfoBalk = $('#content>header').height();
  let delta = hoogteZoekbalk - hoogteInfoBalk;

  //toon schaduw (al dan niet, (afhankelijk of ik aan het scrollen ben))
  if (huidigeScrollPositie < 40) {
    $('main>header').addClass('schaduw');
  } else {
    $('main>header').removeClass('schaduw');
  }

  if (huidigeScrollPositie < delta) {
    console.log('ANDERE WEERGAVE');
    $('#content').addClass('isscrolled');
  } else {
    $('#content').removeClass('isscrolled');
  }

  console.log(huidigeScrollPositie);
  console.log('hoogte zoekbalk' + hoogteZoekbalk);
  console.log('hoogte infobalk' + hoogteInfoBalk);
});
