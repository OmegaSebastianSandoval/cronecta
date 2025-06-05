<div class="container" style="margin-left: 19%;">

  <form class="supplier-register-form form-bx">


    <div class="col-12 py-3 pt-4">
      <div class="row align-items-center">
        <div class="col-4 pe-0">
          <span class="text-lg text-slate-800 font-medium">Ubicación geográfica</span>
        </div>
        <div class="col-8">
          <hr>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-12 text-center">
        <label>Cobertura global</label>
        <input type="checkbox" class="form-checkbox" name="worldwide" id="worldwide" value="1" <?php if ($this->supplier) {echo 'checked'; } ?> onclick="cobertura_global();" />
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="buscador" class="form-label ">Buscar por nombre<span></span></label>

          <div class="row">

            <div class="col-lg-8">
              <select class="form-control select2" id="buscador" name="buscador" required>
                <option value="" disabled selected>Seleccione una ubicación</option>
                <?php foreach ($this->items as $value) { ?>
                  <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-lg-1">
              <button type="button" onclick="agregaritem();" class="btn btn-primary">Agregar</button>
            </div>
          </div>

        </div>
      </div>


      <div class="col-md-6">
        <div class="mb-3">
          <label for="buscador" class="form-label ">Buscar por región<span></span></label>


          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" id="menu_regiones" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false" onclick="$('.regiones').show(); $('.paises').hide(); $('.estados').hide();  $('.ciudades').hide()">
              Seleccionar
            </button>
            <ul class="dropdown-menu">
              <?php foreach ($this->regiones as $region) { ?>
                <?php if ($region != "") { ?>

                  <li class="mb-1 regiones"><a class="dropdown-item" onclick="$('.regiones').hide(); cargar_paises('<?php echo $region; ?>'); "><?php echo $region; ?> <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $region; ?>');" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>

                  <div id="div_paises" class="paises"></div>
                  <div id="div_estados" class="estados"></div>
                  <div id="div_ciudades" class="ciudades"></div>

                <?php } ?>
              <?php } ?>


            </ul>
          </div>



        </div>

      </div>

      <div class="col-12">
        <?php foreach ($this->geolocations as $geolocation) { ?>
          <span
            class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 geolocation<?php echo $geolocation->id; ?>">
            <?php echo $geolocation->name; ?> <i class="fa fa-times" onclick="remove_geolocation('<?php echo $geolocation->id; ?>')"></i>
          </span>
        <?php } ?>
      </div>

    </div>


  </form>

</div>


<script type="text/javascript">
  $("#buscador").select2({
    placeholder: "Buscar",
    minimumInputLength: 3
  });

  function cargar_paises(region) {
    $('.regiones').hide();
    $('.paises').show();
    $.post("/supplier/ubicaciongeografica/get_paises/", {
      "region": region
    }, function(res) {
      $("#div_paises").html(res.paises);
    });
  }

  function get_estados(pais) {
    $('.regiones').hide();
    $('.paises').hide();
    $('.estados').show();
    $.post("/supplier/ubicaciongeografica/get_estados/", {
      "pais": pais
    }, function(res) {
      $("#div_estados").html(res.estados);
    });
  }

  function get_ciudades(estado, pais) {
    $('.regiones').hide();
    $('.paises').hide();
    $('.estados').hide();
    $('.ciudades').show();
    $.post("/supplier/ubicaciongeografica/get_ciudades/", {
      "estado": estado,
      "pais": pais
    }, function(res) {
      $("#div_ciudades").html(res.ciudades);
    });
  }

  function cobertura_global() {
    var valor = 0;
    if ($("#worldwide").is(':checked')) {
      valor = 1;
    }
    $.post("/supplier/ubicaciongeografica/worldwide/", {
      "valor": valor
    }, function(res) {
      //$("#saved").show();
      if (valor == 1) {
        $("#buscador").prop("disabled", true);
        $("#menu_regiones").prop("disabled", true);
      } else {
        $("#buscador").prop("disabled", false);
        $("#menu_regiones").prop("disabled", false);
      }
    });

  }

  function agregaritem() {
    var valor = $("#buscador").val();
    $.post("/supplier/ubicaciongeografica/agregar_ubicacion/", {
      "valor": valor
    }, function(res) {
      window.location = '/supplier/ubicaciongeografica';
    });
  }

  function agregar(valor) {
    $.post("/supplier/ubicaciongeografica/agregar_ubicacion/", {
      "valor": valor
    }, function(res) {
      window.location = '/supplier/ubicaciongeografica';
    });
  }

  function remove_geolocation(id) {
    $.post("/supplier/ubicaciongeografica/borrar_ubicacion/", {
      "id": id
    }, function(res) {

    });
    if (id != "") {
      $(".geolocation" + id).hide();
    }
  }
</script>


<style>
  .dropdown .dropdown-menu {
    width: 80%;
    max-height: 300px;
    overflow-y: auto;
  }

  #menu_regiones {
    width: 80%;
  }

  .dropdown-menu li {
    display: flex;
  }

  .dropdown .dropdown-item {
    width: 90%;
    white-space: break-spaces;
  }

  .dropdown button {
    max-height: 32px;
  }

  .flecha {
    font-size: 10px;
    vertical-align: top;
    margin-top: 8px;
    margin-left: 10px;
  }

  .interest {
    background-color: #20469730;
    color: #204697;
    border: 1px solid #204697;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: 300ms ease;
  }

  .interest i:hover {
    color: red;
    cursor: pointer;
    transition: 300ms ease;
  }

  .interest1 {
    background-color: #20469730 !important;
    color: #204697 !important;
    border: 1px solid #204697 !important;
  }

  .interest1 i {
    vertical-align: text-bottom;
    font-size: 14px;

    vertical-align: top;
    font-size: 14px;
    margin-top: -1px;
  }
</style>

<style>
  .select2-container .select2-selection--single {
    height: auto !important;
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0 !important;

    padding: 8px 15px;
    margin-bottom: 10px;
    border-radius: 0;
    font-size: 1em !important;

  }
</style>