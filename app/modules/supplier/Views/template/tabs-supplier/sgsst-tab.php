<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>

<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud10">-%</span> de esta sección</div>

<form id="sstForm" method="POST" action="/supplier/profile/savesgsst" class="supplier-register-form form-bx">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div id="sstsContainer">

  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addSSTBtn">
    Agregar item
  </button>
  <!-- @click="addSST" -->

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0" id="submitFormSST">
      Guardar SG-SST
    </button>
  </div>
  <!-- Original: @submit.prevent="submitSST" -->
</form>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos desde la base de datos al iniciar
    loadSSTDataFromDB();

    // Manejar el evento para agregar nuevos campos SST
    $('#addSSTBtn').click(function() {
      addSST();
    });

    // Delegación de eventos para elementos dinámicos
    $(document).on('click', '.remove-sst', function() {
      $(this).closest('.sst-item').remove();
    });
  });

  // Función para cargar datos desde la base de datos
  function loadSSTDataFromDB() {
    // Este es un ejemplo con datos simulados
    const sstData = Object.values(<?= json_encode($this->list_sst ?? []) ?>);
    if (sstData.length > 0) {
      sstData.forEach(data => {
        addSST(data);
      });
    } else {
      // Si no hay datos, agregar un formulario vacío
      // addSST();
    }
  }

  // Función para agregar un nuevo conjunto de campos SST
  function addSST(data = null, clear = false) {
    const container = document.getElementById('sstsContainer');

    const newIndex = container.querySelectorAll('.sst-item').length;

    const sstDiv = document.createElement('div');
    sstDiv.className = 'sst-item mb-3';
    sstDiv.dataset.index = newIndex;

    sstDiv.innerHTML = `
      <div class="row">
        <div class="col-md-3">
          <div class="mb-3">
            <label for="operation_year_${newIndex}" class="form-label">Año de operación <span>*</span></label>
            <input type="date" min="2000" max="2100" class="form-control" 
              name="ssts[${newIndex}][operation_year]" value="${data ? (data.operation_year || '') : ''}" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="fatalities_${newIndex}" class="form-label">Fatalidades <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][fatalities]" value="${data ? (data.fatalities || '') : ''}" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disabling_accidents_${newIndex}" class="form-label">Número de accidentes incapacitantes <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][disabling_accidents]" value="${data ? (data.disabling_accidents || '') : ''}" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bstitle="Por favor excluya accidentes incapacitates">
            <label for="total_incidents_${newIndex}" class="form-label">Número total de incidentes <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][total_incidents]" value="${data ? (data.total_incidents || '') : ''}" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disability_days_${newIndex}" class="form-label">Días de incapacidad <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][disability_days]" value="${data ? (data.disability_days || '') : ''}" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="workers_number_${newIndex}" class="form-label">Número de trabajadores promedio <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][workers_number]" value="${data ? (data.workers_number || '') : ''}" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="manhours_${newIndex}" class="form-label">Horas hombre trabajadas <span>*</span></label>
            <input type="number" min="0" class="form-control only_numbers" 
              name="ssts[${newIndex}][manhours]" value="${data ? (data.manhours || '') : ''}" required />
          </div>
        </div>                                                                                    
      

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_accident_certificate_${newIndex}" class="form-label">Certificado de accidentalidad ARL</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control d-none" 
              name="ssts[${newIndex}][arl_accident_certificate]" id="ssts${newIndex}arl_accident_certificate" onchange="$('#ssts${newIndex}arl_accident_certificate_file').val(limpiar_path(this.value));" />
            <input type="hidden" name="ssts[${newIndex}][existing_arl_accident_certificate]" value="${data ? (data.arl_accident_certificate || '') : ''}" />


            <div class="input-group">
              <div class="input-group-prepend div-examinar">
                <button class="btn boton-examinar" type="button" onclick="$('#ssts${newIndex}arl_accident_certificate').click();">Examinar</button>
              </div>
              <input id="ssts${newIndex}arl_accident_certificate_file" readonly type="text" class="form-control campo-examinar" onclick="$('#ssts${newIndex}arl_accident_certificate').click();" value="${data.arl_accident_certificate || 'Seleccione un archivo'}" />
            </div>

          </div>
        </div>

        <div class="col-md-2">
          <a class="btn bg-blue text-white rounded-0 download-accident mt-4" href="${data && data.arl_accident_certificate ? '/files/' + data.arl_accident_certificate : '#'}" target="_blank" style="${data && data.arl_accident_certificate ? '' : 'display: none;'}">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_accident_certificate_date_${newIndex}" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][arl_accident_certificate_date]" 
              value="${data ? (data.arl_accident_certificate_date || '') : ''}" 
              max="<?= date('Y-m-d') ?>" min="1950-01-01" />
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_affiliation_certificate_${newIndex}" class="form-label">Certificado de afiliación ARL</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control d-none" 
              name="ssts[${newIndex}][arl_affiliation_certificate]" id="ssts${newIndex}arl_affiliation_certificate" onchange="$('#ssts${newIndex}arl_affiliation_certificate_file').val(limpiar_path(this.value));" />
            <input type="hidden" name="ssts[${newIndex}][existing_arl_affiliation_certificate]" value="${data ? (data.arl_affiliation_certificate || '') : ''}" />

            <div class="input-group">
              <div class="input-group-prepend div-examinar">
                <button class="btn boton-examinar" type="button" onclick="$('#ssts${newIndex}arl_affiliation_certificate').click();">Examinar</button>
              </div>
              <input id="ssts${newIndex}arl_affiliation_certificate_file" readonly type="text" class="form-control campo-examinar" onclick="$('#ssts${newIndex}arl_affiliation_certificate').click();" value="${data.arl_affiliation_certificate || 'Seleccione un archivo'}" />
            </div>

          </div>
        </div>

        <div class="col-md-2">
          <a class="btn bg-blue text-white rounded-0 download-affiliation mt-4" href="${data && data.arl_affiliation_certificate ? '/files/' + data.arl_affiliation_certificate : '#'}" target="_blank" style="${data && data.arl_affiliation_certificate ? '' : 'display: none;'}">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_affiliation_certificate_date_${newIndex}" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][arl_affiliation_certificate_date]" 
              value="${data ? (data.arl_affiliation_certificate_date || '') : ''}" 
              max="<?= date('Y-m-d') ?>" min="1950-01-01" />
          </div>
        </div>  
  <div class="col-md-6">
          <div class="mb-3">
            <label for="risk_level_${newIndex}" class="form-label">Nivel de riesgo <span>*</span></label>
            <select class="form-control" name="ssts[${newIndex}][risk_level]" required>
              <option value="" disabled selected>Seleccione un nivel de riesgo</option>
              <option value="Alto" ${data && data.risk_level === 'Alto' ? 'selected' : ''}>Alto</option>
              <option value="Medio" ${data && data.risk_level === 'Medio' ? 'selected' : ''}>Medio</option>
              <option value="Bajo" ${data && data.risk_level === 'Bajo' ? 'selected' : ''}>Bajo</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="rating_percentage_${newIndex}" class="form-label">Porcentaje de calificación SG-SST (0312)<span>*</span></label>
            <input type="number" min="0" max="100" class="form-control only_numbers" 
              name="ssts[${newIndex}][rating_percentage]" value="${data ? (data.rating_percentage || '') : ''}" required />
          </div>
        </div>              
        <div class="col-md-6">
          <div class="mb-3">
            <label for="evaluation_result_certificate_${newIndex}" class="form-label">Certificado de resultado de la evaluación SG-SST (0312)</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control d-none" 
              name="ssts[${newIndex}][evaluation_result_certificate]" id="ssts${newIndex}evaluation_result_certificate" onchange="$('#ssts${newIndex}evaluation_result_certificate_file').val(limpiar_path(this.value));" />
            <input type="hidden" name="ssts[${newIndex}][existing_evaluation_result_certificate]" value="${data ? (data.evaluation_result_certificate || '') : ''}" />

            <div class="input-group">
              <div class="input-group-prepend div-examinar">
                <button class="btn boton-examinar" type="button" onclick="$('#ssts${newIndex}evaluation_result_certificate').click();">Examinar</button>
              </div>
              <input id="ssts${newIndex}evaluation_result_certificate_file" readonly type="text" class="form-control campo-examinar" onclick="$('#ssts${newIndex}evaluation_result_certificate').click();" value="${data.evaluation_result_certificate || 'Seleccione un archivo'}" />
            </div>

          </div>
        </div>

        <div class="col-md-2">
          <a class="btn bg-blue text-white rounded-0 download-evaluation mt-4" href="${data && data.evaluation_result_certificate ? '/files/' + data.evaluation_result_certificate : '#'}" target="_blank" style="${data && data.evaluation_result_certificate ? '' : 'display: none;'}">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="evaluation_result_certificate_date_${newIndex}" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][evaluation_result_certificate_date]" 
              value="${data ? (data.evaluation_result_certificate_date || '') : ''}" 
              max="<?= date('Y-m-d') ?>" min="1950-01-01" />
          </div>
        </div>                            
      </div>

      <button type="button" class="btn btn-danger  text-white remove-sst">
        Eliminar item
      </button>
      <button type="submit" class="btn btn-confirmar bg-orange text-white rounded-0">Confirmar item</button>
      <hr />
    `;

    container.appendChild(sstDiv);

    // Configurar eventos para mostrar botones de descarga cuando se seleccionen archivos
    /*   const setupFileInput = (inputSelector, downloadBtnSelector) => {
        const fileInput = sstDiv.querySelector(inputSelector);
        const downloadBtn = sstDiv.querySelector(downloadBtnSelector);

        fileInput.addEventListener('change', function(e) {
          if (this.files && this.files[0]) {
            downloadBtn.style.display = 'inline-block';
          }
        });
      };

      setupFileInput('input[name*="arl_accident_certificate"]', '.download-accident');
      setupFileInput('input[name*="arl_affiliation_certificate"]', '.download-affiliation');
      setupFileInput('input[name*="evaluation_result_certificate"]', '.download-evaluation'); */
  }

  // Configurar el envío del formulario
  document.getElementById('sstForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const btn = document.querySelector('#submitFormSST');

    try {
      btn.disabled = true;
      btn.innerHTML = `Enviando...`;

      const resp = await fetch(this.action, {
        method: "POST",
        body: formData,
      });

      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();

      if (json.success) {
        // Limpiar el contenedor actual
        const container = document.getElementById('sstsContainer');
        container.innerHTML = '';

        // Si hay datos en la respuesta, agregarlos al formulario
        if (json.ssts && json.ssts.length > 0) {
          json.ssts.forEach(sst => {
            addSST(sst);
          });
        } else {
          // Si no hay datos, agregar un formulario vacío
          addSST();
        }

        showAlert({
          title: json.title || "Éxito",
          text: json.text || "Información SG-SST actualizada correctamente",
          icon: json.icon || "success",
          showCancel: false,
          confirmButtonText: "Continuar",
          html: json.html || null,
          redirect: json.redirect,
        });
        completitud10();
      } else {
        showAlert({
          title: json.title || "Error",
          text: json.text || "Revisa los datos",
          icon: json.icon || "info",
          showCancel: false,
          confirmButtonText: "Continuar",
          html: json.html || null,
        });
      }
    } catch (err) {
      console.error(err);
      showAlert({
        title: "Error",
        text: "No se pudo comunicar con el servidor.",
        icon: "error",
        showCancel: false,
        confirmButtonText: "Continuar",
      });
    } finally {
      btn.disabled = false;
      btn.innerHTML = `Guardar SG-SST`;
    }
  });
</script>

<script type="text/javascript">
  function completitud10(){
    $.post("/supplier/profile/completitud10/",{ },function(res){
      $("#completitud10").html(res.porcentaje+"%");
    });
  }
  completitud10();
</script>

<style type="text/css">
.div_completitud{
  position: sticky;
  right: 0;
  top: 200px;
  z-index: 2;
  background-color: white;
}  
</style>