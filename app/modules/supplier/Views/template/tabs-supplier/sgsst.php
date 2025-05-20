<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="sstForm" method="POST" action="#" class="supplier-register-form form-bx">
  <div id="sstsContainer">
    <!-- Los items de SST se agregarán dinámicamente aquí -->
    <!-- 
    Vue template original:
    <div v-for="(sst, index) in ssts" :key="index" class="mb-3">
      <div class="row">
        <div class="col-md-3">
          <div class="mb-3">
            <label for="operation_year" class="form-label">Año de operacion <span>*</span></label>
            <input type="number" min="2000" max="2100" class="form-control" v-model="sst.operation_year" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="fatalities" class="form-label">Fatalidades <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.fatalities" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disabling_accidents" class="form-label">Número de accidentes incapacitantes <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.disabling_accidents" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="total_incidents" class="form-label">Número total de incidentes <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.total_incidents" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disability_days" class="form-label">Días de incapacidad <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.disability_days" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="workers_number" class="form-label">Número de trabajadores promedio <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.workers_number" required />
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="manhours" class="form-label">Horas hombre trabajadas <span>*</span></label>
            <input type="number" min="0" class="form-control" v-model="sst.manhours" required />
          </div>
        </div>                                                                                    
        <div class="col-md-6">
          <div class="mb-3">
            <label for="risk_level" class="form-label">Nivel de riesgo <span>*</span></label>
            <select class="form-control" v-model="sst.risk_level" required>
              <option :disabled="true">Seleccione un nivel de riesgo</option>
              <option value="Alto">Alto</option>
              <option value="Medio">Medio</option>
              <option value="Bajo">Bajo</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="rating_percentage" class="form-label">Porcentaje de calificación SG-SST (0312)<span>*</span></label>
            <input type="number" min="0" max="100" class="form-control" v-model="sst.rating_percentage" required />
          </div>
        </div>              

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_accident_certificate" class="form-label">Certificado de accidentalidad ARL</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" 
              @change="handleFileUpload7('arl_accident_certificate', $event, index)" />
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0" v-if="sst.arl_accident_certificate" :href="'/storage/'+sst.arl_accident_certificate" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_accident_certificate_date" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" v-model="sst.arl_accident_certificate_date" />
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_affiliation_certificate" class="form-label">Certificado de afiliación ARL</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" 
              @change="handleFileUpload7('arl_affiliation_certificate', $event, index)" />
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0" v-if="sst.arl_affiliation_certificate" :href="'/storage/'+sst.arl_affiliation_certificate" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_affiliation_certificate_date" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" v-model="sst.arl_affiliation_certificate_date" />
          </div>
        </div>  

        <div class="col-md-6">
          <div class="mb-3">
            <label for="evaluation_result_certificate" class="form-label">Certificado de resultado de la evaluación SG-SST (0312)</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" 
              @change="handleFileUpload7('evaluation_result_certificate', $event, index)" />
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0" v-if="sst.evaluation_result_certificate" :href="'/storage/'+sst.evaluation_result_certificate" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="evaluation_result_certificate_date" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" v-model="sst.evaluation_result_certificate_date" />
          </div>
        </div>                            
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white" @click="removeSST(index)">
        Eliminar item
      </button>
      <hr />
    </div>
    -->
  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addSSTBtn">
    Agregar item
  </button>
  <!-- @click="addSST" -->

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar SG-SST
    </button>
  </div>
  <!-- Original: @submit.prevent="submitSST" -->
</form>

<script>
  // Implementación básica para items SST dinámicos
  document.addEventListener('DOMContentLoaded', function() {
    let sstCount = 0;

    // Función para agregar un nuevo item SST
    function addSST() {
      const container = document.getElementById('sstsContainer');
      const newIndex = sstCount++;

      const sstDiv = document.createElement('div');
      sstDiv.className = 'sst-item mb-3';
      sstDiv.dataset.index = newIndex;

      sstDiv.innerHTML = `
      <div class="row">
        <div class="col-md-3">
          <div class="mb-3">
            <label for="operation_year_${newIndex}" class="form-label">Año de operación <span>*</span></label>
            <input type="date" min="2000-01-01" max="2100-01-01" class="form-control" 
              name="ssts[${newIndex}][operation_year]" required />
            <!-- v-model="sst.operation_year" -->
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="fatalities_${newIndex}" class="form-label">Fatalidades <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][fatalities]" placeholder="Introduzca numero de víctimas" required />
            <!-- v-model="sst.fatalities" -->
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disabling_accidents_${newIndex}" class="form-label">Número de accidentes incapacitantes <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][disabling_accidents]" required />
            <!-- v-model="sst.disabling_accidents" -->
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Por favor excluya accidentes incapacitates">
            <label for="total_incidents_${newIndex}" class="form-label">Número total de incidentes <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][total_incidents]" required />
            <!-- v-model="sst.total_incidents" -->
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="disability_days_${newIndex}" class="form-label">Días de incapacidad <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][disability_days]" required />
            <!-- v-model="sst.disability_days" -->
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="workers_number_${newIndex}" class="form-label">Número de trabajadores promedio <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][workers_number]" required />
            <!-- v-model="sst.workers_number" -->
          </div>
        </div>  

        <div class="col-md-3">
          <div class="mb-3">
            <label for="manhours_${newIndex}" class="form-label">Horas hombre trabajadas <span>*</span></label>
            <input type="number" min="0" class="form-control" 
              name="ssts[${newIndex}][manhours]" required />
            <!-- v-model="sst.manhours" -->
          </div>
        </div>                                                                                    
        <div class="col-md-6">
          <div class="mb-3">
            <label for="risk_level_${newIndex}" class="form-label">Nivel de riesgo <span>*</span></label>
            <select class="form-control" name="ssts[${newIndex}][risk_level]" required>
              <option disabled selected>Seleccione un nivel de riesgo</option>
              <option value="Alto">Alto</option>
              <option value="Medio">Medio</option>
              <option value="Bajo">Bajo</option>
            </select>
            <!-- v-model="sst.risk_level" -->
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="rating_percentage_${newIndex}" class="form-label">Porcentaje de calificación SG-SST (0312)<span>*</span></label>
            <input type="number" min="0" max="100" class="form-control" 
              name="ssts[${newIndex}][rating_percentage]" required />
            <!-- v-model="sst.rating_percentage" -->
          </div>
        </div>              

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_accident_certificate_${newIndex}" class="form-label">Certificado de accidentalidad ARL</label>
            <input type="file" name="ssts[${newIndex}][arl_accident_certificate]" 
              accept="application/pdf, image/png, image/jpeg" class="form-control" />
            <!-- @change="handleFileUpload7('arl_accident_certificate', $event, index)" -->
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0 download-accident" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
          <!-- v-if="sst.arl_accident_certificate" :href="'/storage/'+sst.arl_accident_certificate" -->
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_accident_certificate_date_${newIndex}" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][arl_accident_certificate_date]" />
            <!-- v-model="sst.arl_accident_certificate_date" -->
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="arl_affiliation_certificate_${newIndex}" class="form-label">Certificado de afiliación ARL</label>
            <input type="file" name="ssts[${newIndex}][arl_affiliation_certificate]" 
              accept="application/pdf, image/png, image/jpeg" class="form-control" />
            <!-- @change="handleFileUpload7('arl_affiliation_certificate', $event, index)" -->
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0 download-affiliation" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
          <!-- v-if="sst.arl_affiliation_certificate" :href="'/storage/'+sst.arl_affiliation_certificate" -->
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="arl_affiliation_certificate_date_${newIndex}" class="form-label">Fecha de afiliación <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][arl_affiliation_certificate_date]" />
            <!-- v-model="sst.arl_affiliation_certificate_date" -->
          </div>
        </div>  

        <div class="col-md-6">
          <div class="mb-3">
            <label for="evaluation_result_certificate_${newIndex}" class="form-label">Certificado de resultado de la evaluación SG-SST (0312)</label>
            <input type="file" name="ssts[${newIndex}][evaluation_result_certificate]" 
              accept="application/pdf, image/png, image/jpeg" class="form-control" />
            <!-- @change="handleFileUpload7('evaluation_result_certificate', $event, index)" -->
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0 download-evaluation" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
          <!-- v-if="sst.evaluation_result_certificate" :href="'/storage/'+sst.evaluation_result_certificate" -->
        </div>

       <!-- <div class="col-md-4">
          <div class="mb-3">
            <label for="evaluation_result_certificate_date_${newIndex}" class="form-label">Fecha de expedición <span></span></label>
            <input type="date" class="form-control" 
              name="ssts[${newIndex}][evaluation_result_certificate_date]" />
             
          </div>
        </div> --> 
        <div class="col-md-6">
          <div class="mb-3">
            <label for="evaluation_result_certificate_${newIndex}" class="form-label">Soporte del radicado al ministerio de la autoevaluación de estándares mínimos de acuerdo con SG-SST (0312)</label>
            <input type="file" name="ssts[${newIndex}][evaluation_result_certificate]" 
              accept="application/pdf, image/png, image/jpeg" class="form-control" />
            <!-- @change="handleFileUpload7('evaluation_result_certificate', $event, index)" -->
          </div>
        </div>
        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0 download-evaluation" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
          <!-- v-if="sst.evaluation_result_certificate" :href="'/storage/'+sst.evaluation_result_certificate" -->
        </div>                           
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white remove-sst">
        Eliminar item
      </button>
      <hr />
    `;

      container.appendChild(sstDiv);

      // Configurar el evento para eliminar este item
      sstDiv.querySelector('.remove-sst').addEventListener('click', function() {
        sstDiv.remove();
      });

      // Configurar eventos para mostrar botones de descarga cuando se seleccionen archivos
      const setupFileInput = (inputSelector, downloadBtnSelector) => {
        const fileInput = sstDiv.querySelector(inputSelector);
        const downloadBtn = sstDiv.querySelector(downloadBtnSelector);

        fileInput.addEventListener('change', function(e) {
          if (this.files && this.files[0]) {
            downloadBtn.style.display = 'inline-block';
            // En una implementación real, aquí podrías subir el archivo y actualizar la URL de descarga
          }
        });
      };

      setupFileInput('input[name*="arl_accident_certificate"]', '.download-accident');
      setupFileInput('input[name*="arl_affiliation_certificate"]', '.download-affiliation');
      setupFileInput('input[name*="evaluation_result_certificate"]', '.download-evaluation');
    }

    // Configurar el botón para agregar items SST
    document.getElementById('addSSTBtn').addEventListener('click', addSST);

    // Configurar el envío del formulario
    document.getElementById('sstForm').addEventListener('submit', function(e) {
      e.preventDefault();
      console.log('Formulario SG-SST enviado - implementar AJAX o envío normal');
      // Original: submitSST()
    });

    // Agregar un item SST inicial
    addSST();
  });
</script>