<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">

<script>
  window.countriesData = <?= json_encode($this->list_country) ?>;
</script>
<script>
  const industriesList = <?= json_encode($this->list_industry) ?>;
</script>
<script src="/skins/page/js/form-validations.js"></script>
<script src="/skins/page/js/submit-form.js"></script>

<script>
  const decodeHtml = (html) => {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
  };
  const selectedCountry = decodeHtml("<?= $this->content->country ?>");
  const selectedState = decodeHtml("<?= $this->content->state ?>");
  const selectedCity = decodeHtml("<?= $this->content->city ?>");
</script>


<div class="container">

  <h2 class="title title-2 primary">
    <?php echo $this->titlesection; ?>
  </h2>
  <?php
  /*   echo "<pre>";
  print_r($this->terms);
  echo "</pre>"; */
  ?>
  <div class="alert alert-warning py-1" role="alert"><strong>Nota:</strong> Puedes iniciar sesión con cualquiera de los correos que ingreses. Todos los campos con (*) son obligatorios. </div>

  <div class="supplier-register-form caja_gris p-3">
    <div class="row gx-0 p-0 align-items-center">
      <div class="col-3">
        <span class="text-lg text-slate-800 font-medium">
          Perfil de usuario
        </span>
      </div>
      <div class="col-9">
        <hr>
      </div>
    </div>
    <form class="text-left" enctype="multipart/form-data" method="post" action="/page/register/store" data-bs-toggle="validator" id="supplierForm">
      <div class="content-dashboard">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
        <?php if ($this->content->id) { ?>
          <input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
        <?php } ?>

        <div class="row">


          <!-- Tipo de documento -->
          <div class="col-md-3">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Tipo de documento personal</label>
              <select class="form-control" name="documentType" id="documentType" required @input="validarTipo">
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula de Extranjería</option>
                <option value="DNI">Documento Nacional de identidad</option>
                <option value="PAS">Pasaporte</option>
                <option value="PEP">Permiso especial de Permanencia</option>
              </select>
            </div>
          </div>

          <!-- Documento de identidad -->
          <div class="col-md-3">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Documento de identidad</label>
              <input type="number" class="form-control" id="document" name="nit" placeholder="Documento de Identidad"
                required  />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Nombre -->
          <div class="col-md-3">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Nombres</label>
              <input type="text" class="form-control" id="nombre" name="name" placeholder="Nombre" required
               />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Apellido -->
          <div class="col-md-3">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Apellidos</label>
              <input type="text" class="form-control" id="apellido" name="lastname" placeholder="Apellido" required
                 />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Correo personal -->
          <div class="col-md-6">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Correo personal</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Correo personal"
                required  />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Confirmar correo personal -->
          <div class="col-md-6">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Confirma tu correo personal</label>
              <input type="email" class="form-control" id="email_confirmation" name="confirmEmail"
                placeholder="Confirma tu correo personal" required  />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Correo corporativo -->
          <div class="col-md-6">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Correo corporativo</label>
              <input type="email" class="form-control" id="bussinesEmail" name="bussinesEmail"
                placeholder="Correo corporativo" required  />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Confirmar correo corporativo -->
          <div class="col-md-6">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Confirma tu correo corporativo</label>
              <input type="email" class="form-control" id="confirm-email-corporativo" name="confirmBussinesEmail"
                placeholder="Confirma tu correo corporativo" required  />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- WhatsApp -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> WhatsApp</label>
              <input type="tel" class="form-control" name="whatsapp" id="whatsapp"></input>
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Teléfono -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Teléfono</label>
              <input type="tel" class="form-control" id="phone" name="phone"></input>
              <small class="error-msg text-danger "></small>
            </div>
          </div>


          <div class="col-12 col-md-6 col-lg-4 form-group">
            <label class="control-label">País <span>*</span></label>
            <select class="form-control select2" name="country" id="country">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_country as $value) { ?>
                <option value="<?= $value['name'] ?>"><?= $value["name"] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-4 form-group d-none" id="state-wrapper">
            <label class="control-label">Departamento / Estado <span>*</span></label>
            <select class="form-control" name="state" id="state">
              <option value="">Seleccione...</option>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-4 form-group d-none" id="city-wrapper">
            <label for="city" class="control-label">Ciudad <span>*</span></label>
            <select class="form-control" name="city" id="city">
              <option value="">Seleccione...</option>
            </select>
          </div>

          <!-- Contraseña -->
          <div class="col-md-6">
            <div class="form-group mb-2 position-relative">
              <label for="" class="form-label"><span>*</span> Contraseña</label>
              <input type="password" class="form-control toggle-password" id="password" name="password"
                placeholder="Contraseña" required />
              <div class="password-eye"><i class="far fa-eye"></i></div>
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Confirmar contraseña -->
          <div class="col-md-6">
            <div class="form-group mb-2 position-relative">
              <label for="" class="form-label"><span>*</span> Confirmar contraseña</label>
              <input type="password" class="form-control toggle-password" id="password_confirmation" name="confirmPassword"
                placeholder="Confirmar contraseña" required />
              <div class="password-eye"><i class="far fa-eye"></i></div>
              <small class="error-msg text-danger "></small>
            </div>
          </div>


          
        </div>


        <div class="row gx-0 p-0 align-items-center">
          <div class="col-3">
            <span class="text-lg text-slate-800 font-medium">
              Información empresarial
            </span>
          </div>
          <div class="col-9">
            <hr>
          </div>
        </div>

        <div class="row">

          <!-- Empresa -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Nacionalidad de la empresa</label>
              <select id="nit_type" name="nit_type" class="form-control" required>
                  <option value="" disabled selected>Seleccione...</option>
                  <option value="colombian">NIT - Colombiano</option>
                  <option value="foreign">ID - Extranjero</option>
              </select>
              <small id="nit-error" class="text-danger d-none"></small>
              <small class="error-msg text-danger "></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Tax ID o NIT</label>
              <input type="text" class="form-control" id="identification_nit" name="company_nit" required @input="validateNIT" />
              <small class="error-msg text-danger "></small>
            </div>
          </div>
          <!-- Empresa -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Empresa</label>
              <input type="text" class="form-control" id="company_name" name="company" placeholder="Empresa" required />
                <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- industria de la empresa -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Industria de la empresa</label>
              <select class="form-control" name="industry_id" required>
                <option value="" selected disabled>Seleccione...</option>
                <?php foreach ($this->list_industry as $key => $value) { ?>
                  <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
              </select>
              <small class="error-msg text-danger "></small>
            </div>
          </div>


           <div class="col-12 col-md-6 col-lg-3 form-group">
            <label class="control-label">País empresa<span>*</span></label>
            <select class="form-control" name="company_country" id="company_country">
              <option value="">Seleccione...</option>
              <?php foreach ($this->list_country as $value) { ?>
                <option value="<?= $value['name'] ?>"><?= $value["name"] ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-3 form-group d-none1" id="company-state-wrapper">
            <label class="control-label">Departamento / Estado <span>*</span></label>
            <select class="form-control" name="company_state" id="company_state">
              <option value="">Seleccione...</option>
            </select>
          </div>

          <div class="col-12 col-md-6 col-lg-3 form-group d-none1" id="company-city-wrapper">
            <label for="city" class="control-label">Ciudad <span>*</span></label>
            <select class="form-control" name="company_city" id="company_city">
              <option value="">Seleccione...</option>
            </select>
          </div>

          <!-- Cargo en la empresa -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Cargo</label>
              <input type="text" class="form-control" name="position" placeholder="Cargo" required />
              <small class="error-msg text-danger "></small>
            </div>
          </div>

          <!-- Área en la empresa -->
          <div class="col-md-4">
            <div class="form-group mb-2">
              <label for="" class="form-label"><span>*</span> Departamento al que pertenece</label>
              <select class="form-control" name="area" required>
                <option value="" selected disabled>Seleccione...</option>
                <option value="Auditoría Interna">Auditoría Interna</option>
                <option value="Calidad">Calidad</option>
                <option value="Cadena de Suministro">Cadena de Suministro</option>
                <option value="Categoría y desarrollo de negocio">Categoría y desarrollo de negocio</option>
                <option value="Compras y abastecimiento">Compras y abastecimiento</option>
                <option value="Comunicaciones corporativas">Comunicaciones corporativas</option>
                <option value="Finanzas">Finanzas</option>
                <option value="Gestión de proveedores">Gestión de proveedores</option>
                <option value="Growth">Growth</option>
                <option value="Infraestructura">Infraestructura</option>
                <option value="Ingeniería">Ingeniería</option>
                <option value="Innovación y desarrollo">Innovación y desarrollo</option>
                <option value="Inventarios y Almacén">Inventarios y Almacén</option>
                <option value="Legal">Legal</option>
                <option value="Logistica y Distribución">Logistica y Distribución</option>
                <option value="Mantenimiento industrial">Mantenimiento industrial</option>
                <option value="Marketing">Marketing</option>
                <option value="Operaciones">Operaciones</option>
                <option value="Planeación de la demanda">Planeación de la demanda</option>
                <option value="Producción">Producción</option>
                <option value="Proyectos">Proyectos</option>
                <option value="Recursos humanos">Recursos humanos</option>
                <option value="Responsabilidad social">Responsabilidad social</option>
                <option value="Salud y Seguridad Laboral">Salud y Seguridad Laboral</option>
                <option value="Servicio al cliente">Servicio al cliente</option>
                <option value="Administración y Servicios Generales">Administración y Servicios Generales</option>
                <option value="Sostenibilidad">Sostenibilidad</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Transporte">Transporte</option>
                <option value="Unidad de negocio">Unidad de negocio</option>
                <option value="Ventas">Ventas</option>
              </select>
              <small class="error-msg text-danger "></small>
            </div>
          </div>

        </div>

     
      <div class="col-12 d-flex justify-content-center">
        <p class="text-center mt-3">
          ¿Ya tienes una cuenta?
          <a href="/page/login"><strong>Inicia sesión aquí</strong></a>
        </p>
      </div>


      <div class="col-12 gap-2 d-flex justify-content-end">
        <button
          type="submit"
          class="btn-add-supplier"
          id="btnSubmit"
          disabled>
          Registrar comprador
        </button>

        <a href="/page/login"
          class="btn-login btn-add-supplier btn-secondary">
          Cancelar
        </a>
      </div>


    </form>
  </div>
</div>

<div class="modal fade" id="modalDefault1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h2 class="mb-1">
          <?= $this->terms[1]->title ?>
        </h2>
        <div class="text-justify">
          <?= $this->terms[1]->content ?>
        </div>
      </div>


    </div>
  </div>
</div>
<div class="modal fade" id="modalDefault2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h2 class="mb-1">
          <?= $this->terms[2]->title ?>
        </h2>
        <div class="text-justify">
          <?= $this->terms[2]->content ?>
        </div>
      </div>


    </div>
  </div>
</div>

<div class="modal fade" id="modalDefault3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div v-for="(term, index) in terms" class="mb-3">
          <h2 class="mb-1">
            <?= $this->terms[3]->title ?>
          </h2>
          <div class="text-justify">
            <?= $this->terms[3]->content ?>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<style>
  .password-eye {
    right: 20px;
    top: 37px;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
<script>
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    initialCountry: "co",
    strictMode: true,
    loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
  });

  const input2 = document.querySelector("#whatsapp");
  window.intlTelInput(input2, {
    initialCountry: "co",
    strictMode: true,
    loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
  });  

</script>

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