<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>


<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud6">-%</span> de esta sección</div>

<form id="experienceForm" method="POST" action="/supplier/profile/saveexperiences" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
  <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">

  <div id="experienceContainer" class="supplier-register-form form-bx"></div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addExperienceBtn">
    Agregar experiencia
  </button>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0" id="submitExperienceForm">
      Guardar experiencias
    </button>
  </div>
</form>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    let experienceCount = 0;
    const experienceContainer = document.getElementById('experienceContainer');
    const today = new Date().toISOString().split('T')[0];

    const experiencesFromDB = <?= json_encode($this->list_experiences ?? []) ?>;
    // console.log(experiencesFromDB);
    //const countries = <?= json_encode($this->list_country ?? []) ?>;
    countries = countriesData;
    //const countriesData = <?= json_encode($this->list_country) ?>;
    const industriesFromServer = <?= json_encode($this->list_industry ?? []) ?>;

    // Convertir el objeto de industrias a un array de opciones
    const industries = Object.entries(industriesFromServer).map(([id, label]) => ({
      id,
      label
    }));

    async function fetchAndRenderSegments(industryId, segmentSelect, defaultValue = null) {
      try {
        const resp = await fetch(`/supplier/register/getsegments/?industryId=${industryId}`);
        const list = await resp.json();

        $(segmentSelect).empty();
        $(segmentSelect).append('<option value="">Seleccione un segmento</option>');
        list.forEach((s) => {
          const selected = s.id === defaultValue ? 'selected' : '';
          const opt = new Option(s.name, s.id, selected, selected);
          $(segmentSelect).append(opt);
        });

        $(segmentSelect).select2({
          placeholder: "Seleccione un segmento",
          allowClear: true
        });

        // Si hay un valor por defecto, seleccionarlo
        if (defaultValue) {
          $(segmentSelect).val(defaultValue).trigger('change');
        }
      } catch (err) {
        console.error("Error cargando segmentos:", err);
      }
    }

    function initIndustrySegmentDynamic(experienceItem) {
      const industrySelect = experienceItem.querySelector('.industry-select');
      const segmentSelect = experienceItem.querySelector('.segment-select');
      const defaultSegment = $(segmentSelect).data('default-value');

      // Inicializar Select2 en ambos selects
      $(industrySelect).select2({
        placeholder: 'Seleccione una industria',
        allowClear: true
      });

      $(segmentSelect).select2({
        placeholder: 'Seleccione un segmento',
        allowClear: true
      });

      // Manejar el cambio de industria
      $(industrySelect).on('change', function() {
        const industryId = $(this).val();
        if (industryId) {
          fetchAndRenderSegments(industryId, segmentSelect, defaultSegment);
        } else {
          $(segmentSelect).empty().append('<option value="">Seleccione un segmento</option>').trigger('change');
        }
      });

      // Si hay un valor por defecto para la industria, cargar sus segmentos
      const defaultIndustry = $(industrySelect).val();
      if (defaultIndustry) {
        fetchAndRenderSegments(defaultIndustry, segmentSelect, defaultSegment);
      }
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

    function addExperience(data = {}) {
      const index = experienceCount++;
      const div = document.createElement('div');
      div.className = 'experience-item mb-3';
      div.dataset.index = index;

      let countryOptions = `<option value="Colombia">Colombia</option><option class="separador" disabled>____________________________</option>`;
      countries.forEach(c => {
        const selected = c.name === data.country ? 'selected' : '';
        countryOptions += `<option value="${c.name}" ${selected}>${c.name}</option>`;
      });

      let industryOptions = `<option value="">Seleccione una industria</option>`;
      industries.forEach(ind => {
        const selected = ind.id === data.industry ? 'selected' : '';
        industryOptions += `<option value="${ind.id}" ${selected}>${ind.label}</option>`;
      });

      div.innerHTML = `
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label>Nombre empresa cliente <span>*</span></label>
            <input type="text" class="form-control" name="experiences[${index}][company_name]" value="${data.company_name || ''}" required />
          </div>
        </div>

        <div class="col-lg-4">
          <div class="mb-3">
            <label>Industria <span>*</span></label>
            <select name="experiences[${index}][industry]" class="form-control industry-select" required>
              ${industryOptions}
            </select>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="mb-3">
            <label>Segmento <span>*</span></label>
            <select name="experiences[${index}][segment]" class="form-control segment-select" required>
              <option value="">Seleccione un segmento</option>
            </select>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="mb-3">
            <label>País <span>*</span></label>
            <select name="experiences[${index}][country]" class="form-control country-select" required>
              ${countryOptions}
            </select>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="mb-3">
            <label>Departamento/Estado <span>*</span></label>
            <select name="experiences[${index}][state]" class="form-control state-select" required>
              <option value="">Seleccione un estado</option>
            </select>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="mb-3">
            <label>Ciudad <span>*</span></label>
            <select name="experiences[${index}][city]" class="form-control city-select" required>
              <option value="">Seleccione una ciudad</option>
            </select>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="mb-3">
            <label>Objeto contractual <span>*</span></label>
            <input type="text" class="form-control" name="experiences[${index}][contract_object]" value="${data.contract_object || ''}" required />
          </div>
        </div>

        <div class="col-lg-3">
          <div class="mb-3">
            <label>Moneda <span>*</span></label>
            <select name="experiences[${index}][currency]" class="form-control" required>
              <option value="">Seleccione...</option>
              <option value="USD" ${data.currency === 'USD' ? 'selected' : ''}>USD</option>
              <option value="COP" ${data.currency === 'COP' ? 'selected' : ''}>COP</option>
              <option value="EUR" ${data.currency === 'EUR' ? 'selected' : ''}>EUR</option>
            </select>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="mb-3">
            <label>Valor del contrato <span>*</span></label>
            <input type="text" class="form-control only_numbers" name="experiences[${index}][contract_value]" value="${data.contract_value || ''}" required />
          </div>
        </div>



        <div class="col-lg-3">
          <div class="mb-3">
            <label>Fecha de inicio <span>*</span></label>
            <input type="date" name="experiences[${index}][contract_start_year]" class="form-control" value="${data.contract_start_year || ''}" max="${today}" required />
          </div>
        </div>

        <div class="col-lg-3">
          <div class="mb-3">
            <label>Fecha de fin <span>*</span></label>
            <input type="date" name="experiences[${index}][contract_end_year]" class="form-control end-date" value="${data.contract_end_year || ''}" max="<?= date('Y-m-d', strtotime('+5 years')) ?>" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3 mt-4">
          <label class="mt-1">
            <input type="checkbox" name="experiences[${index}][contract_current]" class="current-checkbox" ${data.contract_end_year == 'En curso' ? 'checked' : ''} />
            Actualmente vigente
            </label>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="mb-3">
            <label>Certificado de experiencia</label>
            <input type="file" name="experiences[${index}][document_file]" id="experiences${index}document_file" class="form-control d-none" accept="application/pdf, image/png, image/jpeg" onchange="$('#experiences${index}document_file_file').val(limpiar_path(this.value));" />
            <input type="hidden" name="experiences[${index}][existing_file]" value="${data.document_file || ''}" />

            <div class="input-group">
              <div class="input-group-prepend div-examinar">
                <button class="btn boton-examinar" type="button" onclick="$('#experiences${index}document_file').click();">Examinar</button>
              </div>
              <input id="experiences${index}document_file_file" readonly type="text" class="form-control campo-examinar" onclick="$('#experiences${index}document_file').click();" value="${data.document_file || 'Seleccione un archivo'}" />
            </div>

          </div>
        </div>

        <div class="col-lg-3">
          <a class="btn bg-blue text-white rounded-0 download-btn mt-4 mb-4 mb-md-0" href="${data.document_file ? '/files/' + data.document_file : '#'}" target="_blank" style="${data.document_file ? 'display:inline-block' : 'display:none'}">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>
      </div>

      <button type="button" class="btn btn-danger remove-experience text-white">Eliminar experiencia</button>

      <button type="submit" class="btn btn-confirmar bg-orange text-white rounded-0">Confirmar experiencia</button>

      <hr />
    `;

      experienceContainer.appendChild(div);

      // Guardar el valor del segmento antes de inicializar los selects
      $(div.querySelector('.segment-select')).data('default-value', data.segments);

      initCountryStateCityDynamic(div, data);
      initIndustrySegmentDynamic(div);

      // Agregar evento para el checkbox de "Actualmente vigente"
      const currentCheckbox = div.querySelector('.current-checkbox');
      const endDateInput = div.querySelector('.end-date');

      function handleCurrentCheckbox() {
        if (currentCheckbox.checked) {
          endDateInput.disabled = true;
          endDateInput.value = '';
          endDateInput.required = false;
        } else {
          endDateInput.disabled = false;
          endDateInput.required = true;
        }
      }

      currentCheckbox.addEventListener('change', handleCurrentCheckbox);
      // Ejecutar al inicio para manejar el estado inicial
      handleCurrentCheckbox();

      div.querySelector('.remove-experience').addEventListener('click', () => {
        div.remove();
      });
    }

    // Cargar datos iniciales
    if (experiencesFromDB.length > 0) {
      experiencesFromDB.forEach(exp => addExperience(exp));
    } else {
      addExperience();
    }

    // Agregar experiencia nueva
    document.getElementById('addExperienceBtn').addEventListener('click', () => {
      addExperience();
    });

    // Enviar formulario por AJAX
    document.getElementById('experienceForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      const submitBtn = document.getElementById('submitExperienceForm');
      submitBtn.disabled = true;
      submitBtn.innerText = 'Guardando...';

      try {
        const resp = await fetch(this.action, {
          method: 'POST',
          body: formData
        });
        const json = await resp.json();

        if (json.success && json.experiences) {
          experienceContainer.innerHTML = '';
          json.experiences.forEach(exp => addExperience(exp));
        }

        showAlert({
          title: json.title || 'Listo',
          text: json.text || 'Experiencias guardadas correctamente',
          icon: json.icon || 'success',
          confirmButtonText: json.confirmButtonText || 'Continuar',
        });
        completitud6();
      } catch (err) {
        showAlert({
          title: 'Error',
          text: 'No se pudo guardar la información.',
          icon: 'error',
        });
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Guardar Experiencias';
      }
    });
  });
</script>


<script type="text/javascript">
  function completitud6(){
    $.post("/supplier/profile/completitud6/",{ },function(res){
      $("#completitud6").html(res.porcentaje+"%");
      array_completitud[6]=res.porcentaje;
      completeness();
    });
  }
  completitud6();

  function limpiar_path(x){
    return x.replace("C:\\fakepath\\","");
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