<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title><?= $this->_titlepage ?></title>
  <?php $infopageModel = new Page_Model_DbTable_Informacion();
  $infopage = $infopageModel->getById(1);
  ?>
  <!-- Skins Carousel -->
  <link rel="stylesheet" type="text/css" href="/scripts/carousel/carousel.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/components/bootstrap-5.3/css/bootstrap.min.css">  <!-- Slick CSS -->
  <link rel="stylesheet" href="/components/slick/slick.css">
  <link rel="stylesheet" href="/components/slick/slick-theme.css">
  <!-- Global CSS -->
  <link rel="stylesheet" href="/skins/page/css/global.css?v=2">
  <link rel="stylesheet" href="/skins/page/css/responsive.css?v=2">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="/components/Font-Awesome/css/all.css">

  <link rel="shortcut icon" href="/images/<?= $infopage->info_pagina_favicon; ?>">


  <script type="text/javascript" id="www-widgetapi-script" src="https://s.ytimg.com/yts/jsbin/www-widgetapi-vflS50iB-/www-widgetapi.js" async=""></script>

  <!-- Jquery -->
  <script src="/components/jquery/jquery-3.6.0.min.js"></script>
  <!-- SELECT 2 -->
  <link href="/components/select2/dist/css/select2.min.css" rel="stylesheet" />
  <script src="/components/select2/dist/js/select2.min.js"></script>

    <!-- TAG -->
    <link href="/components/tags/tags.css" rel="stylesheet" />
  <script src="/components/tags/tags.js"></script>


  <!-- Bootstrap Js -->
  <script src="/components/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>

  <!-- Carousel -->
  <script type="text/javascript" src="/scripts/carousel/carousel.js"></script>
  <!-- Slick -->
  <link href="/components/slick/slick-theme.css" rel="stylesheet" />
  <link href="/components/slick/slick.css" rel="stylesheet" />

   <script src="/components/slick/slick.min.js"></script>

  <script src="/components/jquery-knob/js/jquery.knob.js"></script>
  <!-- AOS -->
  <link rel="stylesheet" href="/components/aos-master/dist/aos.css">
  <script src="/components/aos-master/dist/aos.js"></script>
  <!-- SweetAlert -->
  <script src="/components/sweetalert/sweetalert.js"></script>

  <!-- Main Js -->
  <script src="/skins/page/js/main.js?v=2"></script>

  <!-- Recaptcha -->
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <meta name="description" content="<?= $this->_data['meta_description']; ?>" />
  <meta name=" keywords" content="<?= $this->_data['meta_keywords']; ?>" />
  <?php echo $this->_data['scripts'];  ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWYVxdF4VwIPfmB65X2kMt342GbUXApwQ&sensor=true"></script>
  <script type="text/javascript">
    var map;
    var longitude = 0;
    var latitude = 0;
    var icon = '/skins/administracion/images/ubicacion.png';
    var point = false;
    var zoom = 10;

    function setValuesMap(longitud, latitud, punto, zoomm, icono) {
      longitude = longitud;
      latitude = latitud;
      if (punto) {
        point = punto;
      }
      if (zoomm) {
        zoom = zoomm;
      }
      if (icono) {
        icon = icono
      }
    }

    function initializeMap() {
      var mapOptions = {
        zoom: parseInt(zoom),
        center: new google.maps.LatLng(longitude, longitude),
      };
      // Place a draggable marker on the map
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      if (point == true) {
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(longitude, latitude),
          map: map,
          icon: icon
        });
      }
      map.setCenter(new google.maps.LatLng(longitude, latitude));
    }
  </script>
</head>

<body>
  <header>
    <?= $this->_data['header']; ?>
  </header>
  <div class="contenedor-general"><?= $this->_content ?></div>
  <footer>
    <?= $this->_data['footer']; ?>
  </footer>
  <?= $this->_data['adicionales']; ?>

</body>

</html>