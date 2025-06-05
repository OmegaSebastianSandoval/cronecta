<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>

<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud5">-%</span> de esta sección</div>

<form id="sedes-form" action="/supplier/profile/savesedes" class="supplier-register-form form-bx" onclick="">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">


  <!-- Contenedor donde se renderizarán las sedes con JS -->
  <div id="locations-container">

  </div>



  <button type="button" class="btn btn-secondary mb-3 text-white" id="add-location-btn">
    Agregar sede
  </button>


  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar sedes
    </button>
  </div>


  <div class="row gx-0 p-0 align-items-center mb-2">
    <div class="col-3">
      <span class="text-lg text-slate-800 font-medium">
        Cobertura geográfica
      </span>
    </div>
    <div class="col-9">
      <hr>
    </div>
  </div>

  <div class="row">

    <div class="col-12 text-center">
      <label>Cobertura global</label>
      <input type="checkbox" class="form-checkbox" name="worldwide" id="worldwide" value="1" <?php if ($this->supplier->worldwide == 1) {  echo 'checked';    } ?> onclick="cobertura_global();" />
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="buscador" class="form-label ">Buscar por nombre<span></span></label>

        <div class="row">

          <div class="col-lg-8">
            <select class="form-control select2" id="buscador-location" name="buscador" >
              <option value="" disabled selected>Seleccione una ubicación</option>

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

        <!-- data-bs-auto-close="outside" aria-labelledby="dropdownMenuClickableInside" cerrar al hacer click por fuera -->
        <!-- data-bs-display="static" abrir siempre hacia abajo -->

        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" id="menu_regiones" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-display="static" onclick="$('.regiones').show(); $('.paises').hide(); $('.estados').hide();  $('.ciudades').hide()" <?php if ($this->supplier->worldwide == 1) {     echo 'disabled';   } ?>>
            Seleccionar
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
            <?php foreach ($this->regiones as $region) { ?>
              <?php if ($region != "") { ?>

                <li class="mb-1 regiones"><a class="dropdown-item" onclick="cargar_paises('<?php echo $region; ?>','<?php echo md5($region); ?>'); "><?php echo $region; ?> <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar('<?php echo $region; ?>',1);" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>

                <div id="div_paises<?php echo md5($region); ?>" class="paises" style="margin-left: 10px;"></div>

              <?php } ?>
            <?php } ?>


          </ul>
        </div>


      </div>

    </div>

    <div class="col-12" style="min-height: 100px;" id="div_geolocations">
      <?php foreach ($this->geolocations as $geolocation) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 geolocation<?php echo $geolocation->id; ?>">
          <?php echo $geolocation->name; ?> <i class="fa fa-times" onclick="remove_geolocation('<?php echo $geolocation->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>



  </div>

</form>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("locations-container");
    const addLocationBtn = document.getElementById("add-location-btn");
    const form = document.getElementById("sedes-form");

    function createLocationHTML(index = 0, defaultData = {}) {
      return `
        <div class="location-item mb-3" data-location-index="${index}">
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">Nombre de la sede <span>*</span></label>
                <input type="text" class="form-control" name="location_name[]" value="${defaultData.name || ''}" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">Dirección <span>*</span></label>
                <input type="text" class="form-control" name="location_address[]" value="${defaultData.address || ''}" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">Teléfono <span>*</span></label>
                <input type="text" class="form-control is_phone" id="telefono_indicativo${index}" name="location_mobile_phone[]" value="${defaultData.phone || ''}" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">País<span>*</span></label>
                <select class="form-control country-select" name="location_country[]" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option> 
                  <?php foreach ($this->list_country as $c): ?>
                    <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">Departamento/Estado <span>*</span></label>
                <select class="form-control state-select" name="location_state[]" required></select>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">Ciudad <span>*</span></label>
                <select class="form-control city-select" name="location_city[]" required></select>
              </div>
            </div>
            <div class="col-12">
              <button type="button" class="btn btn-danger mb-3 text-white remove-location">Eliminar sede</button>

              <button type="submit" class="btn btn-confirmar bg-orange text-white rounded-0 margen1">Confirmar sede</button>
              <hr />
            </div>
          </div>
        </div>`;
    }

    function initCountryStateCityDynamic(group, defaultData = {}) {
      const countryEl = group.querySelector('.country-select');
      const stateEl = group.querySelector('.state-select');
      const cityEl = group.querySelector('.city-select');

      $(countryEl).select2({
        placeholder: "Seleccione el país",
        allowClear: true
      });
      $(stateEl).select2({
        placeholder: "Seleccione el departamento/estado",
        allowClear: true
      });
      $(cityEl).select2({
        placeholder: "Seleccione la ciudad",
        allowClear: true
      });

      // Establecer valor por defecto si existe
      if (defaultData.country) {
        $(countryEl).val(defaultData.country).trigger('change');
      }

      // Usar eventos de Select2
      $(countryEl).on('change', function() {
        loadStates(countryEl, stateEl, cityEl, defaultData);
      });

      $(stateEl).on('change', function() {
        loadCities(countryEl, stateEl, cityEl, defaultData);
      });

      // Cargar estados si ya hay un país seleccionado
      if (defaultData.country) {
        loadStates(countryEl, stateEl, cityEl, defaultData);
      }
    }

    function loadStates(countryEl, stateEl, cityEl, defaultData = {}) {
      const selectedCountry = $(countryEl).val();
      const country = countriesData.find(c => c.name === selectedCountry);

      // Resetear ciudades
      $(cityEl).empty().append('<option value="">Seleccione una ciudad</option>').trigger('change');

      if (!country) {
        $(stateEl).empty().append('<option value="">Seleccione un estado</option>').trigger('change');
        return;
      }

      const options = ['<option value="">Seleccione un estado</option>'];
      country.states.forEach(s => {
        const selected = s.name === defaultData.state ? 'selected' : '';
        options.push(`<option value="${s.name}" ${selected}>${s.name}</option>`);
      });

      $(stateEl).empty().append(options.join('')).trigger('change');

      // Si hay estado por defecto, cargar ciudades
      if (defaultData.state) {
        loadCities(countryEl, stateEl, cityEl, defaultData);
      }
    }

    function loadCities(countryEl, stateEl, cityEl, defaultData = {}) {
      const selectedCountry = $(countryEl).val();
      const selectedState = $(stateEl).val();
      const country = countriesData.find(c => c.name === selectedCountry);

      if (!country) return;

      const state = country.states.find(s => s.name === selectedState);

      if (!state) {
        $(cityEl).empty().append('<option value="">Seleccione una ciudad</option>').trigger('change');
        return;
      }

      const options = ['<option value="">Seleccione una ciudad</option>'];
      state.cities.forEach(c => {
        const selected = c.name === defaultData.city ? 'selected' : '';
        options.push(`<option value="${c.name}" ${selected}>${c.name}</option>`);
      });

      $(cityEl).empty().append(options.join('')).trigger('change');
    }

    function addLocation(defaultData = {}) {
      const index = container.querySelectorAll(".location-item").length;
      container.insertAdjacentHTML("beforeend", createLocationHTML(index, defaultData));
      const newItem = container.querySelector(`.location-item[data-location-index='${index}']`);
      initCountryStateCityDynamic(newItem, defaultData);
      cargar_indicativo(index);
    }

    addLocationBtn.addEventListener("click", () => addLocation());

    container.addEventListener("click", function(e) {
      if (e.target.classList.contains("remove-location")) {
        const item = e.target.closest(".location-item");
        if (item) item.remove();
      }
    });

    form.addEventListener("submit", async function(e) {
      e.preventDefault();
      const submitBtn = form.querySelector("button[type='submit']");
      const formData = new FormData(form);

      try {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "Guardando...";

        const resp = await fetch(form.action, {
          method: "POST",
          body: formData
        });

        const json = await resp.json();

        if (json.success) {
          showAlert({
            title: json.title || "Éxito",
            text: json.text || "Sedes guardadas correctamente",
            icon: json.icon || "success",
            redirect: json.redirect || null,
            showCancel: false,
            confirmButtonText: "Continuar"
          });

          completitud5();

        } else {
          showAlert({
            title: json.title || "Error",
            text: json.text || "Revisa los datos",
            icon: json.icon || "info",
            showCancel: false,
            confirmButtonText: "Continuar"
          });
        }
      } catch (err) {
        console.error(err);
        showAlert({
          title: "Error",
          text: "No se pudo comunicar con el servidor.",
          icon: "error",
          showCancel: false,
          confirmButtonText: "Continuar"
        });
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = "Guardar Sedes";
      }
    });

    // Puedes reemplazar esto por un foreach si ya tienes datos precargados desde PHP
    const existingLocations = <?= json_encode($this->sedesSupplier ?? []) ?>;
    if (existingLocations && existingLocations.length > 0) {
      existingLocations.forEach(location => {
        addLocation({
          name: location.name,
          address: location.address,
          phone: location.mobile_phone,
          country: location.country,
          state: location.state,
          city: location.city
          // Agrega más campos según tu estructura
        });
      });
    } else {
      // Si no hay sedes, agregar una vacía
      addLocation();
    }
  });
</script>


<script type="text/javascript">
  $("#buscador-location").select2({
    placeholder: "Buscar",
    minimumInputLength: 4,


    ajax: {
      url: function(params) {
        return '/supplier/profile/search/?q=' + params.term;
      },
      /*
       processResults: function (data) {
          return {
              results: $.map(data.results, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
      }
      */

    }

  });

  function cargar_paises(region,region_md5) {
    //$('.regiones').hide();
    $('.paises').show();
    $.post("/supplier/profile/get_paises/", {
      "region": region
    }, function(res) {
      $("#div_paises"+region_md5).html(res.paises);
    });
  }

  function get_estados(pais_md5) {
    //$('.regiones').hide();
    //$('.paises').hide();
    $('.estados').show();
    $.post("/supplier/profile/get_estados/", {
      "pais": pais_md5
    }, function(res) {
      $("#div_estados"+pais_md5).html(res.estados);
    });
  }

  function get_ciudades(estado_md5, pais_md5) {
    //$('.regiones').hide();
    //$('.paises').hide();
    //$('.estados').hide();
    $('.ciudades').show();
    $.post("/supplier/profile/get_ciudades/", {
      "estado": estado_md5,
      "pais": pais_md5
    }, function(res) {
      $("#div_ciudades"+estado_md5).html(res.ciudades);
    });
  }

  function cobertura_global() {
    var valor = 0;
    if ($("#worldwide").is(':checked')) {
      valor = 1;
    }
    $.post("/supplier/profile/worldwide/", {
      "valor": valor
    }, function(res) {
      //$("#saved").show();
      if (valor == 1) {
        $("#buscador-location").prop("disabled", true);
        $("#menu_regiones").prop("disabled", true);
      } else {
        $("#buscador-location").prop("disabled", false);
        $("#menu_regiones").prop("disabled", false);
      }
    });

  }

  function agregaritem() {
    var valor = $("#buscador-location").val();
    if (valor == "") return
    $.post("/supplier/profile/agregar_ubicacion/", {
      "valor": valor
    }, function(res) {
      //window.location = '/supplier/profile?tab=5';
      actualizar_geolocations();
    });
  }

  function agregar(valor,nivel) {
    $.post("/supplier/profile/agregar_ubicacion/", {
      "valor": valor,
      "nivel": nivel
    }, function(res) {
      //window.location = '/supplier/profile?tab=5';
      actualizar_geolocations();
    });
  }

  function remove_geolocation(id) {
    $.post("/supplier/profile/borrar_ubicacion/", {
      "id": id
    }, function(res) {

    });
    if (id != "") {
      $(".geolocation" + id).hide();
    }
  }

  function actualizar_geolocations() {
    $.post("/supplier/profile/get_geolocations/", {

    }, function(res) {
      $("#div_geolocations").html(res.geolocations);
    });
  }

</script>


<style>
  .dropdown .dropdown-menu, .dropright .dropdown-menu {
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


<script type="text/javascript">
  function completitud5(){
    $.post("/supplier/profile/completitud5/",{ },function(res){
      $("#completitud5").html(res.porcentaje+"%");
      array_completitud[5]=res.porcentaje;
      completeness();
    });
  }
  completitud5();
</script>

<script>

  function cargar_indicativo(index){
    var input = document.querySelector("#telefono_indicativo"+index);
    window.intlTelInput(input, {
      initialCountry: "co",
      strictMode: true,
      loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
    });
  }
 
 
</script>

<style type="text/css">
.select2-container--default .select2-results__option--disabled {
  padding: 0px !important;
  margin-top: -10px !important;
  margin-bottom: 5px !important;
}  
.div_completitud{
  position: sticky;
  right: 0;
  top: 200px;
  z-index: 2;
  background-color: white;
}
</style>