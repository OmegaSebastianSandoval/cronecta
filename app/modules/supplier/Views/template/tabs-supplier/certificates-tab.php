<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="certificationForm" method="POST" action="/supplier/profile/savecertifications">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div id="certificationsContainer" class="supplier-register-form form-bx">

  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addCertificationBtn">
    Agregar certificación
  </button>

  <div class="d-flex justify-content-center">
    <button type="submit" class="bg-orange text-white rounded-0">
      Guardar certificación
    </button>
  </div>
</form>

<script>
  const certificationsFromDB = <?= json_encode($this->list_certifications ?? []); ?>;
</script>
<script>
  const certificationTypes = Object.values(<?= json_encode($this->list_certification_types ?? []) ?>);
</script>


<script>
  // Implementación básica para certificaciones dinámicas
  document.addEventListener('DOMContentLoaded', function() {
    let certificationCount = 0;

    // Función para agregar una nueva certificación
    function addCertification(data = null) {
      // console.log(data);
      const container = document.getElementById('certificationsContainer');
      const newIndex = certificationCount++;

      const today = new Date().toISOString().split('T')[0];
      const certificationDiv = document.createElement('div');
      certificationDiv.className = 'certification mb-3';
      certificationDiv.dataset.index = newIndex;
      const selectedType = decodeHtml(data?.type || '');
      let optionsHTML = '<option disabled>Seleccione un tipo</option>';

      certificationTypes.forEach(type => {
        const selected = selectedType == type ? 'selected' : '';
        optionsHTML += `<option value="${type}" ${selected}>${type}</option>`;
      });


      certificationDiv.innerHTML = `
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Tipo de certificación <span>*</span></label>
          <select class="form-control" name="certifications[${newIndex}][type]" required>
             ${optionsHTML}
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="mb-3">
          <label class="form-label">Fecha de expedición <span>*</span></label>
          <input type="date" class="form-control" name="certifications[${newIndex}][start_date]" max="${today}" value="${data ? data.start_date : ''}" required />
        </div>
      </div>

      <div class="col-md-3">
        <div class="mb-3">
          <label class="form-label">Fecha de finalización <span>*</span></label>
          <input type="date" class="form-control" name="certifications[${newIndex}][end_date]" value="${data ? data.end_date : ''}" required />
        </div>
      </div>

      <div class="col-md-4">
        <div class="mb-3">
          <label class="form-label">Adjunto</label>
          <input type="file" name="certifications[${newIndex}][certification_file]" accept="application/pdf, image/png, image/jpeg" class="form-control" />
        </div>
      </div>

      <div class="col-md-2 mt-7">
        <a class="btn bg-blue text-white rounded-0 download-btn" href="${data && data.certification_file ? '/files/' + data.certification_file : '#'}" target="_blank" style="${data && data.certification_file ? 'display:inline-block;' : 'display:none;'}">
          <i class="fa-solid fa-download"></i> Descargar
        </a>
        <input type="hidden" name="certifications[${newIndex}][existing_file]" value="${data?.certification_file || ''}" />
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Comentario</label>
          <input type="text" class="form-control" name="certifications[${newIndex}][comment]" value="${data && data.comment!=='' && data.comment!==undefined ? data.comment : '' }" />
        </div>
      </div>
    </div>

    <button type="button" class="btn btn-danger mb-3 text-white remove-certification">
      Eliminar certificación
    </button>
    <hr />
  `;

      container.appendChild(certificationDiv);

      certificationDiv.querySelector('.remove-certification').addEventListener('click', () => {
        certificationDiv.remove();
      });

      const fileInput = certificationDiv.querySelector('input[type="file"]');
      const downloadBtn = certificationDiv.querySelector('.download-btn');

      /*   fileInput.addEventListener('change', function() {
          if (this.files && this.files[0]) {
            downloadBtn.style.display = 'inline-block';
          
          }
        }); */

      // Establecer el tipo si es edición
      if (data && data.type) {
        certificationDiv.querySelector('select').value = data.type;
      }
    }



    // Agregar una certificación inicial
    if (certificationsFromDB.length > 0) {
      certificationsFromDB.forEach(cert => {
        addCertification(cert);
      });
    } else {
      // addCertification();
    }

    // Configurar el botón para agregar certificaciones
    document.getElementById('addCertificationBtn').addEventListener('click', addCertification);

    // Configurar el envío del formulario
    const formularioCertificados = document.getElementById('certificationForm')

    formularioCertificados.addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(formularioCertificados);
      const btn = formularioCertificados.querySelector('button[type="submit"]');



      try {
        btn.disabled = true;
        btn.innerHTML = `Enviando...`;

        const resp = await fetch(formularioCertificados.action, {
          method: "POST",
          body: formData,
        });

        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const json = await resp.json();
        // console.log(json);
        if (json.success) {
          // Actualizar la lista de cuentas bancarias con la respuesta
          if (json.certifications && json.certifications.length > 0) {
            const container = document.getElementById('certificationsContainer');
            container.innerHTML = ''; // limpiar anterior
            json.certifications.forEach(cert => {
              addCertification(cert); // volver a pintar
            });
          }

          showAlert({
            title: json.title || "Éxito",
            text: json.text || "Certificaciones actualizadas correctamente",
            icon: json.icon || "success",
            showCancel: false,
            confirmButtonText: "Continuar",
            html: json.html || null,
            redirect: json.redirect,
          });
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
        // console.error(err);
        showAlert({
          title: "Error",
          text: "No se pudo comunicar con el servidor.",
          icon: "error",
          showCancel: false,
          confirmButtonText: "Continuar",
        });
      } finally {
        btn.disabled = false;
        btn.innerHTML = `Guardar Certificaciones`;
      }

    });
  });
</script>