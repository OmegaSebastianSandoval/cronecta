<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="sedes-form" action="/supplier/profile/savesedes" class="supplier-register-form form-bx">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">


  <!-- Vue: v-if="esPruebas" -->
  <div class="text-end mb-2" style="display: none;" id="section-progress-location">
    Haz completado el <span class="completitud" id="completitud9">-%</span> de esta sección
  </div>

  <!-- Contenedor donde se renderizarán las sedes con JS -->
  <div id="locations-container">

  </div>


  <button type="button" class="btn btn-secondary mb-3 text-white" id="add-location-btn">
    Agregar Sede
  </button>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar Sedes
    </button>
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
                <input type="text" class="form-control is_phone" name="location_mobile_phone[]" value="${defaultData.phone || ''}" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label class="form-label">País<span>*</span></label>
                <select class="form-control country-select" name="location_country[]" required>
                  <option selected value="">Seleccione un país</option>  
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
              <button type="button" class="btn btn-danger mb-3 text-white remove-location">Eliminar Sede</button>
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