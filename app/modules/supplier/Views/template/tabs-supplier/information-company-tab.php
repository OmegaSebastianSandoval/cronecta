<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>


<form method="post" enctype="multipart/form-data" id="submitSupplierInfo" class="supplier-register-form form-bx" action="/supplier/profile/updatecompanyinfo"> <!-- VUE: @submit.prevent="submitSupplierInfo" -->
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div class="row">
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="is_legal_entity" class="form-label">Tipo de entidad <span>*</span></label>
        <select class="form-control" id="is_legal_entity" name="is_legal_entity" required>
          <option value="" disabled selected>Seleccione...</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "is_legal_entity") == 1) {
                    echo "selected";
                  } ?> value="1">Persona Natural</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "is_legal_entity") == 2) {
                    echo "selected";
                  } ?> value="2">Persona Jurídica</option>
        </select>

      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label for="counterparty_type" class="form-label">Tipo de contraparte <span>*</span></label>
        <select class="form-control" id="counterparty_type" name="counterparty_type" required>
          <option value="">Seleccione...</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "counterparty_type") == 1) {
                    echo "selected";
                  } ?> value="1">Colombiano</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "counterparty_type") == 2) {
                    echo "selected";
                  } ?> value="2">Extranjero</option>
        </select>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <?php
        $companyType = html_entity_decode($this->supplier->company_type, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        ?>

        <label for="company_type" class="form-label">Tipo de empresa <span>*</span></label>
        <select class="form-control" id="company_type" name="company_type" required>
          <option value="" <?= $companyType === "" ? "selected" : "" ?>>Seleccione...</option>
          <option value="Público" <?= $companyType === "Público" ? "selected" : "" ?>>Público</option>
          <option value="Privado" <?= $companyType === "Privado" ? "selected" : "" ?>>Privado</option>
          <option value="Mixto" <?= $companyType === "Mixto" ? "selected" : "" ?>>Mixto</option>
        </select>

      </div>
    </div>




    <div class="col-md-4">
      <div class="mb-3">
        <label for="activity_type" class="form-label">Tipo de actividad <span>*</span></label>
        <select id="activity_type" class="form-control" name="activity_type" required>
          <option value="" selected>Seleccione...</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "activity_type") == "Industrial") {
                    echo "selected";
                  } ?> value="Industrial">Industrial</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "activity_type") == "Comercial") {
                    echo "selected";
                  } ?> value="Comercial">Comercial</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "activity_type") == "Servicios") {
                    echo "selected";
                  } ?> value="Servicios">Servicios</option>
        </select>
      </div>
    </div>
    <div class="col-md-8">
      <div class="mb-3">
        <label for="main_address" class="form-label">Dirección principal <span>*</span></label>
        <input type="text" class="form-control" id="main_address" name="main_address" required value="<?= $this->supplier->main_address ?>" />
      </div>
    </div>
  </div>
  <script>
    
    const selectedCountry = decodeHtml("<?= $this->supplier->country ?>");
    const selectedState = decodeHtml("<?= $this->supplier->state ?>");
    const selectedCity = decodeHtml("<?= $this->supplier->city ?>");
  </script>
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="country" class="form-label">País <span>*</span></label>
        <select class="form-control select2" id="country-information" name="country" required>
          <option value="">Seleccione un país</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="col-md-4 d-none" id="state-wrapper-information">
      <div class="mb-3">
        <label for="state" class="form-label">Departamento/Estado <span>*</span></label>
        <select class="form-control select2" id="state-information" name="state">
          <option value="" disabled selected>Seleccione...</option>
        </select>
      </div>
    </div>

    <div class="col-md-4 d-none" id="city-wrapper-information">
      <div class="mb-3">
        <label for="city" class="form-label">Ciudad <span>*</span></label>
        <select class="form-control select2" id="city-information" name="city">
          <option value="" disabled selected>Seleccione...</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="mb-3">
        <label for="mobile_phone" class="form-label">Teléfono Corporativo / de la empresa <span>*</span></label>
        <!-- VUE: <vue-tel-input v-model="supplier.mobile_phone" @input="onMobileChange" /> -->
        <input type="tel" class="form-control is_phone" id="mobile_phone" name="mobile_phone" value="<?= $this->supplier->mobile_phone ?>" required />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="mb-3">
        <label for="primary_email" class="form-label">Correo electrónico del área contable <span>*</span></label>
        <input type="email" class="form-control ajax-validate is_email"
          id="primary_email"
          name="primary_email"
          data-validate="primary_email"
          data-id="<?= $this->supplier->id ?? '' ?>"
          value="<?= $this->supplier->primary_email ?>"
          required />
        <div class="invalid-feedback d-none" id="error-primary_email"></div>

      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Tamaño de la empresa <span>*</span></label>
        <select class="form-control" name="company_size" required>
          <option value="" disabled selected>Seleccione...</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "company_size") == "1") {
                    echo "selected";
                  } ?> value="1">Micro</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "company_size") == "2") {
                    echo "selected";
                  } ?> value="2">Pequeña</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "company_size") == "3") {
                    echo "selected";
                  } ?> value="3">Mediana</option>
          <option <?php if ($this->getObjectVariable($this->supplier, "company_size") == "4") {
                    echo "selected";
                  } ?> value="4">Grande</option>
        </select>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label class="form-label">Certificado de tamaño de la empresa</label>
        <input type="file" accept="application/pdf,image/png,image/jpeg" class="form-control" name="company_size_certificate" />

      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-2">
      <div class="mb-3" id="company-size-certificate-download-container">
        <?php if ($this->supplier->company_size_certificate && file_exists(FILE_PATH . $this->supplier->company_size_certificate)) { ?>
          <a href="<?= FILE_PATH . $this->supplier->company_size_certificate ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4"><i class="fa-solid fa-download"></i> Descargar</a>
        <?php } ?>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="mb-3">
        <label for="number_of_employees" class="form-label">Número de empleados <span>*</span></label>
        <input type="number" class="form-control only_numbers" id="number_of_employees" name="number_of_employees" min="1" max="1000000" required value="<?= $this->supplier->number_of_employees ?>" />
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
      <label for="website" class="form-label">Página web</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">https://</span>
        <input type="text" class="form-control ajax-validate" id="website" name="website" data-validate="website" data-id="<?= $this->supplier->id ?? '' ?>" value="<?= removeHttpPrefix($this->supplier->website) ?>" />
        <div class="invalid-feedback d-none" id="error-website"></div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="mb-3">
        <label class="form-label">Brochure</label>
        <input type="file" accept="application/pdf,image/png,image/jpeg" class="form-control" name="brochure" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
      <div id="brochure-download-container" class="mb-3">
        <?php if ($this->supplier->brochure && file_exists(FILE_PATH . $this->supplier->brochure)) { ?>
          <a href="<?= FILE_PATH . $this->supplier->brochure ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>

    </div>


  </div>
  <div class="row">

    <div class="col-12 col-md-6 col-lg-3">
      <label class="form-label">Facebook</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon2">https://</span>
        <input type="text" class="form-control" id="facebook" name="facebook" value="<?= removeHttpPrefix($this->supplier->facebook) ?>" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <label class="form-label">Instagram</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon3">https://</span>
        <input type="text" class="form-control" id="instagram" name="instagram" value="<?= removeHttpPrefix($this->supplier->instagram) ?>" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <label class="form-label">X (Twitter)</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon4">https://</span>
        <input type="text" class="form-control" id="twitter" name="twitter" value="<?= removeHttpPrefix($this->supplier->twitter) ?>" />
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <label class="form-label">Linkedin</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon5">https://</span>
        <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?= removeHttpPrefix($this->supplier->linkedin) ?>" />
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
    <div class="col-md-12">
      <div class="mb-3">
        <label for="keywords" class="form-label">Palabras clave para la busqueda (escribe palabras o frases que esten relacionadas con los productos o servicios de la empresa, deben estar separadas por coma, ej: "autopartes, repuestos, mantenimiento de automoviles".</label>
        <textarea class="form-control" id="keywords" name="keywords"><?= $this->supplier->keywords ?></textarea>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0" id="btnSubmitSupplierInfo">Guardar Información del Proveedor</button>
  </div>
</form>