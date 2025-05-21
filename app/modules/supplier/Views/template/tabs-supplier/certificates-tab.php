<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="certificationForm" method="POST" action="#">
  <div id="certificationsContainer" class="supplier-register-form form-bx">
    <!-- Las certificaciones se agregarán dinámicamente aquí -->
    <!-- 
    Vue template original:
    <div v-for="(certification, index) in certifications" :key="index" class="mb-3">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="account_type" class="form-label">Tipo de certificacion <span>*</span></label>
            <select class="form-control" v-model="certification.type" required>
              <option :disabled="true">Seleccione un tipo</option>
              <option v-for="item in certification_types" v-bind:value="item">{{ item }}</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio <span>*</span></label>
            <input type="date" class="form-control" v-model="certification.start_date" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de finalización <span>*</span></label>
            <input type="date" class="form-control cuenta1" v-model="certification.end_date" required />
          </div>
        </div>              

        <div class="col-md-4">
          <div class="mb-3">
            <label for="certification_file" class="form-label">Adjunto</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" 
              @change="handleFileUpload8('certification_file', $event, index)" />
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0" v-if="certification.certification_file" :href="'/storage/'+certification.certification_file" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="comment" class="form-label">Comentario <span></span></label>
            <input type="text" class="form-control" v-model="certification.comment" />
          </div>
        </div> 
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white" @click="removeCertification(index)">
        Eliminar certificación
      </button>
      <hr />
    </div>
    -->
  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addCertificationBtn">
    Agregar certificación
  </button>
  <!-- @click="addCertification" -->

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar certificación
    </button>
  </div>
  <!-- Original: @submit.prevent="submitCertification" -->
</form>

<script>
// Implementación básica para certificaciones dinámicas
document.addEventListener('DOMContentLoaded', function() {
  let certificationCount = 0;
  
  // Función para agregar una nueva certificación
  function addCertification() {
    const container = document.getElementById('certificationsContainer');
    const newIndex = certificationCount++;
    
    const certificationDiv = document.createElement('div');
    certificationDiv.className = 'certification mb-3';
    certificationDiv.dataset.index = newIndex;
    
    certificationDiv.innerHTML = `
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="type_${newIndex}" class="form-label">Tipo de certificación <span>*</span></label>
            <select class="form-control" name="certifications[${newIndex}][type]" required>
              <option disabled selected>Seleccione un tipo</option>
              <!-- Las opciones deberían cargarse desde el servidor o definirse aquí -->
              <option value="ISO 9001">ISO 9001</option>
              <option value="ISO 14001">ISO 14001</option>
              <option value="OHSAS 18001">OHSAS 18001</option>
            </select>
            <!-- v-model="certification.type" -->
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="start_date_${newIndex}" class="form-label">Fecha de expedición <span>*</span></label>
            <input type="date" class="form-control" name="certifications[${newIndex}][start_date]" max="${new Date().toISOString().split('T')[0]}" required />
            <!-- v-model="certification.start_date" -->
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="end_date_${newIndex}" class="form-label">Fecha de finalización <span>*</span></label>
            <input type="date" class="form-control cuenta1" name="certifications[${newIndex}][end_date]" required />
            <!-- v-model="certification.end_date" -->
          </div>
        </div>              

        <div class="col-md-4">
          <div class="mb-3">
            <label for="certification_file_${newIndex}" class="form-label">Adjunto</label>
            <input type="file" name="certifications[${newIndex}][certification_file]" 
              accept="application/pdf, image/png, image/jpeg" class="form-control" />
            <!-- @change="handleFileUpload8('certification_file', $event, index)" -->
          </div>
        </div>

        <div class="col-md-2 mt-7">
          <a class="btn bg-blue text-white rounded-0 download-btn" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
          <!-- v-if="certification.certification_file" :href="'/storage/'+certification.certification_file" -->
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="comment_${newIndex}" class="form-label">Comentario <span></span></label>
            <input type="text" class="form-control" name="certifications[${newIndex}][comment]" />
            <!-- v-model="certification.comment" -->
          </div>
        </div> 
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white remove-certification">
        Eliminar certificación
      </button>
      <hr />
    `;
    
    container.appendChild(certificationDiv);
    
    // Configurar el evento para eliminar esta certificación
    certificationDiv.querySelector('.remove-certification').addEventListener('click', function() {
      certificationDiv.remove();
    });
    
    // Configurar el evento para mostrar el botón de descarga cuando se seleccione un archivo
    const fileInput = certificationDiv.querySelector('input[type="file"]');
    const downloadBtn = certificationDiv.querySelector('.download-btn');
    
    fileInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        downloadBtn.style.display = 'inline-block';
        // En una implementación real, aquí podrías subir el archivo y actualizar la URL de descarga
      }
    });
  }
  
  // Configurar el botón para agregar certificaciones
  document.getElementById('addCertificationBtn').addEventListener('click', addCertification);
  
  // Configurar el envío del formulario
  document.getElementById('certificationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Formulario enviado - implementar AJAX o envío normal');
    // Original: submitCertification()
  });
  
  // Agregar una certificación inicial
  addCertification();
});
</script>