<script src="/skins/supplier/js/form-validations.js"></script>
<script>
  const countriesData = <?= json_encode($this->list_country) ?>;
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
          Información corporativa
        </span>
      </div>
      <div class="col-9">
        <hr>
      </div>
    </div>
    <form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator" id="supplierForm">
      <div class="content-dashboard">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
        <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
        <?php if ($this->content->id) { ?>
          <input type="hidden" name="id" id="id" value="<?= $this->content->id; ?>" />
        <?php } ?>

        <d class="row">
          <div class="col-6 col-md-3 col-lg-3 form-group">
            <div class="form-group text-center">
              <label for="image" class="d-block"></label>
              <input type="file" name="image" id="image" class="d-none" accept="image/gif, image/jpg, image/jpeg, image/png" onchange="previewImage(this)">
              <label for="image" class="avatar-upload mx-auto">
                <img id="preview-avatar" src="<?= $this->content->image ? '/images/' . $this->content->image : '/assets/default.png' ?>" class="avatar-image " alt="Avatar">
              </label>
              <div id="cancel-btn-container" style="display: none;" class="mt-2">
                <button type="button" class="btn btn-warning btn-sm" onclick="cancelImage()">Cancelar imagen</button>
              </div>


            </div>

          </div>
          <div class="col-6 col-md-9 col-lg-9">
            <div class="row">
              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label class="control-label">Tipo de Persona <span>*</span></label>
                <label class="input-group">

                  <select class="form-control" name="is_legal_entity" id="is_legal_entity" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->list_is_legal_entity as $key => $value) { ?>
                      <option <?php if ($this->getObjectVariable($this->content, "is_legal_entity") == $key) {
                                echo "selected";
                              } ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
                    <?php } ?>
                  </select>
                </label>
                <small class="error-msg"></small>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label for="company_name" class="control-label">Raz&oacute;n Social <span>*</span></label>
                <label class="input-group">

                  <input type="text" value="<?= $this->content->company_name; ?>" name="company_name" data-validate="companyName" id="company_name" class="form-control" required>
                </label>
                <small class="error-msg"></small>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label class="control-label">Tipo de sociedad <span>*</span></label>
                <label class="input-group">

                  <select class="form-control" name="supplier_soc_type" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->list_supplier_soc_type as $key => $value) { ?>
                      <option <?php if ($this->getObjectVariable($this->content, "supplier_soc_type") == $key) {
                                echo "selected";
                              } ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
                    <?php } ?>
                  </select>
                </label>
                <small class="error-msg"></small>
              </div>
              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label for="nit_type" class="control-label">Nacionalidad NIT / Tax Id <span>*</span></label>
                <select name="nit_type" id="nit_type" class="form-control" required>
                  <option value="" disabled selected>Seleccione...</option>
                  <option value="colombian">Colombiano</option>
                  <option value="foreign">Extranjero</option>
                </select>
                <small class="error-msg"></small>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label for="identification_nit" class="control-label">NIT / Tax Id <span>*</span></label>
                <input type="text"
                  value="<?= $this->content->identification_nit; ?>"
                  name="identification_nit"
                  id="identification_nit"
                  class="form-control"
                  oninput="validateNIT()"
                  required
                  disabled>
                <small id="nit-error" class="text-danger d-none"></small>
                <small class="error-msg"></small>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label class="control-label">País <span>*</span></label>
                <select class="form-control" name="country" id="country">
                  <option value="">Seleccione...</option>
                  <?php foreach ($this->list_country as $value) { ?>
                    <option value="<?= $value['id'] ?>"><?= $value["name"] ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group d-none" id="state-wrapper">
                <label class="control-label">Departamento / Estado <span>*</span></label>
                <select class="form-control" name="state" id="state">
                  <option value="">Seleccione...</option>
                </select>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group d-none" id="city-wrapper">
                <label for="city" class="control-label">Ciudad <span>*</span></label>
                <select class="form-control" name="city" id="city">
                  <option value="">Seleccione...</option>
                </select>
              </div>


            </div>
          </div>
          <div class="col-12  form-group">
            <label for="commercial_activity" class="form-label">Descripci&oacute;n de la actividad comercial</label>
            <textarea name="commercial_activity" id="commercial_activity" class="form-control tinyeditor-simple" rows="10"><?= $this->content->commercial_activity; ?></textarea>
            <small class="w-100 d-block text-end" id="char-count">0/700</small>
            <small class="error-msg"></small>

          </div>
      </div>
      <div class="row mt-3">

        <div id="industry-groups-container">
          <!-- Grupo inicial -->
          <?php $index = 0; ?>
          <div class="industry-group mb-3" data-index="<?= $index ?>">
            <div class="row">
              <div class="col-md-4 form-group">
                <label class="control-label">Industria <span>*</span></label>
                <select name="groups[<?= $index ?>][industry]" class="form-control industry-select" required>
                  <option value="" selected disabled>Selecciona una opción</option>
                  <?php foreach ($this->list_industry as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label class="control-label">Segmentos <span>*</span></label>
                <select name="groups[<?= $index ?>][segments][]" multiple class="form-control segment-select selec-multiple" required>

                </select>
              </div>

            </div>
          </div>
        </div>

        <!-- Botón para agregar más -->
        <div class="col-12">
          <button type="button" class="btn bg-slate-900 rounded-0 my-2 text-white" onclick="addIndustryGroup()">
            Agregar industria <i class="fa-solid fa-circle-plus ms-2"></i>
          </button>
        </div>

      </div>

      <div class="row mt-3  gx-0 p-0 align-items-center">
        <div class="col-3">
          <span class="text-lg text-slate-800 font-medium">
            Información de contacto
          </span>
        </div>
        <div class="col-9">
          <hr>
        </div>
      </div>
      <div class="row mt-3">

        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="name" class="control-label">Nombre (Contacto comercial) <span>*</span></label>
          <label class="input-group">

            <input type="text" name="name" id="name" class="form-control" required>
          </label>
          <small class="error-msg"></small>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="lastname" class="control-label">Apellido (Contacto comercial) <span>*</span>
          </label>
          <label class="input-group">

            <input type="text" name="lastname" id="lastname" class="form-control" required>
          </label>
          <small class="error-msg"></small>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="email" class="control-label">Correo electrónico <span>*</span></label>
          <label class="input-group">

            <input type="text" name="email" id="email" class="form-control" required>
          </label>
          <small class="error-msg"></small>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="email_confirmation" class="control-label">Correo electrónico <span>*</span></label>
          <label class="input-group">

            <input type="text" name="email_confirmation" id="email_confirmation" class="form-control" required>
          </label>
          <small class="error-msg"></small>
        </div>


        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="phone" class="control-label">Teléfono <span>*</span></label>
          <label class="input-group">

            <input type="text" name="phone" id="phone" class="form-control" required>
          </label>
          <small class="error-msg"></small>
        </div>

        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="position" class="control-label">Cargo <span>*</span></label>
          <label class="input-group">

            <input type="text" name="position" id="position" class="form-control">
          </label>
          <small class="error-msg"></small>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="area" class="control-label">Departamento al que pertenece <span>*</span>
          </label>
          <label class="input-group">
            <select type="text" name="area" id="area" class="form-control" required>
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
          </label>

          <small class="error-msg"></small>
        </div>

        <div class="col-6 col-md-4 col-lg-3 form-group position-relative">
          <label for="password" class="control-label">Contraseña <span>*</span></label>
          <input
            type="password"
            name="password"
            id="password"
            class="form-control toggle-password"
            required>
          <div class="password-eye"><i class="far fa-eye"></i></div>

        </div>

        <div class="col-6 col-md-4 col-lg-3 form-group position-relative">
          <label for="password_confirmation" class="control-label">Confirma la contraseña <span>*</span></label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control toggle-password"
            required>

          <div class="password-eye"><i class="far fa-eye"></i></div>

        </div>

        <div class="col-6 col-md-4 col-lg-3  form-group">
          <label for="birth_country" class="control-label">País de residencia <span>*</span></label>
          <select id="birth_country" name="birth_country" class="form-control">
            <option value="">Seleccione...</option>
            <?php foreach ($this->list_country as $c): ?>
              <option <?= $this->content->birth_country == $c['id'] ? 'selected' : '' ?>
                value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div id="birth-state-wrapper" class=" col-6 col-md-4 col-lg-3  form-group d-none">
          <label for="birth_state" class="control-label">Departamento/Estado <span>*</span></label>
          <select id="birth_state" name="birth_state" class="form-control">
            <option value="">Seleccione...</option>
          </select>
        </div>

        <div id="birth-city-wrapper" class="col-6 col-md-4 col-lg-3 form-group d-none">
          <label for="birth_city" class="control-label">Ciudad <span>*</span></label>
          <select id="birth_city" name="birth_city" class="form-control">
            <option value="">Seleccione...</option>
          </select>
        </div>
        <div class="col-md-12 mt-2">

          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkDefault" name="policy">
            <label class="form-check-label" for="checkDefault">
              Acepto el
              <span
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault1"
                role="button">Tratamiento de datos</span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkChecked2" name="policy2">
            <label class="form-check-label" for="checkChecked2">
              Acepto las
              <span
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault2"
                role="button">Politicas de privacidad</span>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkChecked3" name="policy3">
            <label class="form-check-label" for="checkChecked3">
              Acepto el
              <span
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault3"
                role="button">Declaración de lavado de activos</span>
            </label>
          </div>
        </div>

        <div class="col-md-12 mt-2">
          <div class="alert alert-info text-center">
            Al enviar el formulario aceptas el envío de mensajes por parte de
            Cronecta
          </div>
        </div>
        <div class="col-12 gap-2 d-flex justify-content-end">
          <button
            type="submit"
            class="btn-add-supplier"
            id="btnSubmit"
            disabled>
            Registrar proveedor
          </button>

          <a href="/"
            class="btn-login btn-add-supplier btn-secondary">
            Cancelar
          </a>
        </div>


      </div>
      <div class="col-12 d-flex justify-content-center">
        <p class="text-center mt-3">
          ¿Ya tienes una cuenta?
          <a href="/supplier/login"><strong>Inicia sesión aquí</strong></a>
        </p>
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
