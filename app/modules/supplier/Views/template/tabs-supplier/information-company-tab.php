<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>

<form method="post" enctype="multipart/form-data" id="submitSupplierInfo" class="supplier-register-form form-bx"> <!-- VUE: @submit.prevent="submitSupplierInfo" -->
  <div class="row">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="is_legal_entity" class="form-label">Tipo de entidad <span>*</span></label>
        <select class="form-control" id="is_legal_entity" name="is_legal_entity" required>
          <option value="1">Persona Natural</option>
          <option value="2">Persona Jurídica</option>
        </select>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="counterparty_type" class="form-label">Tipo de contraparte <span>*</span></label>
        <select class="form-control" id="counterparty_type" name="counterparty_type" required>
          <option value="1">Colombiano</option>
          <option value="2">Extranjero</option>
        </select>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="company_type" class="form-label">Tipo de empresa <span>*</span></label>
        <select class="form-control" id="company_type" name="company_type" required>
          <option value="" disabled selected>Seleccione...</option>
          <option value="Público">Público</option>
          <option value="Privado">Privado</option>
          <option value="Mixto">Mixto</option>
        </select>
      </div>
    </div>


    <!-- VUE: textarea v-model="supplier.commercial_activity" -->
    <!-- <div class="mb-3">
    <label for="commercial_activity" class="form-label">Descripción de la Actividad Comercial</label>
    <textarea class="form-control" id="commercial_activity" rows="3" name="commercial_activity" required></textarea>
  </div> -->




    <div class="col-md-4">
      <div class="mb-3">
        <label for="activity_type" class="form-label">Tipo de actividad <span>*</span></label>
        <select id="activity_type" class="form-control" name="activity_type" required>
          <option value="" disabled selected>Seleccione...</option>
          <option value="Industrial">Industrial</option>
          <option value="Comercial">Comercial</option>
          <option value="Servicios">Servicios</option>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="main_address" class="form-label">Dirección principal <span>*</span></label>
        <input type="text" class="form-control" id="main_address" name="main_address" required />
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="country" class="form-label">País <span>*</span></label>
        <select class="form-control" id="country" name="country" required>
          <option value="" disabled selected>Seleccione un país</option>
          <!-- VUE: v-for="country in sortedCountries" -->
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="state" class="form-label">Departamento/Estado <span>*</span></label>
        <select class="form-control" id="state" name="state" required>
          <option value="" disabled selected>Seleccione un estado</option>
          <!-- VUE: v-for="state in getStates()" -->
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="city" class="form-label">Ciudad <span>*</span></label>
        <select class="form-control" id="city" name="city" required>
          <option value="" disabled selected>Seleccione una ciudad</option>
          <!-- VUE: v-for="city in getCities()" -->
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="mb-3">
        <label for="mobile_phone" class="form-label">Teléfono Corporativo / de la empresa <span>*</span></label>
        <!-- VUE: <vue-tel-input v-model="supplier.mobile_phone" @input="onMobileChange" /> -->
        <input type="tel" class="form-control" id="mobile_phone" name="mobile_phone" required />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="mb-3">
        <label for="primary_email" class="form-label">Correo electrónico del área contable <span>*</span></label>
        <input type="email" class="form-control" id="primary_email" name="primary_email" required />
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Tamaño de la empresa <span>*</span></label>
        <select class="form-control" name="company_size" required>
          <option value="1">Micro</option>
          <option value="2">Pequeña</option>
          <option value="3">Mediana</option>
          <option value="4">Grande</option>
        </select>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label class="form-label">Certificado de tamaño de la empresa</label>
        <input type="file" accept="application/pdf,image/png,image/jpeg" class="form-control" name="company_size_certificate" />
        <!-- VUE: @change="handleFileUpload3('company_size_certificate', $event)" -->
      </div>
    </div>
   <!--  <div class="col-12 col-md-6 col-lg-2">
      <div class="mb-3">
     
      </div>
    </div> -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label for="number_of_employees" class="form-label">Número de empleados <span>*</span></label>
        <input type="number" class="form-control" id="number_of_employees" name="number_of_employees" min="1" required />
      </div>
    </div>
  </div>

  <div class="row gx-0 p-0 align-items-center mb-2">
    <div class="col-3">
      <span class="text-lg text-slate-800 font-medium">
        Redes
      </span>
    </div>
    <div class="col-9">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="website" class="form-label">Página web</label>
        <input type="text" class="form-control" id="website" name="website" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label class="form-label">Brochure</label>
        <input type="file" accept="application/pdf,image/png,image/jpeg" class="form-control" name="brochure" />
        <!-- VUE: @change="handleFileUpload3('brochure', $event)" -->
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
    </div>


  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Facebook</label>
        <input type="text" class="form-control" name="facebook" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Instagram</label>
        <input type="text" class="form-control" name="instagram" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">X (Twitter)</label>
        <input type="text" class="form-control" name="twitter" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Linkedin</label>
        <input type="text" class="form-control" name="linkedin" />
      </div>
    </div>
  </div>

  <div class="row gx-0 p-0 align-items-center mb-2">
    <div class="col-3">
      <span class="text-lg text-slate-800 font-medium">
        Palabras claves para búsqueda
      </span>
    </div>
    <div class="col-9">
      <hr>
    </div>
  </div>
  <div class="row">




    <div class="col-md-2 mt-7">
      <!-- VUE: supplier.brochure -->
      <!-- <a class="btn bg-blue text-white rounded-0" href="/storage/..." target="_blank"><i class="fa-solid fa-download"></i> Descargar</a> -->
    </div>



    <div class="col-md-2 mt-7">
      <!-- VUE: supplier.company_size_certificate -->
      <!-- <a class="btn bg-blue text-white rounded-0" href="/storage/..." target="_blank"><i class="fa-solid fa-download"></i> Descargar</a> -->
    </div>
  </div>

  <div class="col-md-12">
    <div class="mb-3">
      <label for="keywords" class="form-label">Palabras clave para la busqueda (escribe palabras o frases que esten relacionadas con los productos o servicios de la empresa, deben estar separadas por coma, ej: "autopartes, repuestos, mantenimiento de automoviles".</label>
      <textarea class="form-control" id="keywords" name="keywords"></textarea>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">Guardar Información del Proveedor</button>
  </div>
</form>