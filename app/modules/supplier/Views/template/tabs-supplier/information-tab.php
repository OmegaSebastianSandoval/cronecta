<script>
  //window.countriesData = <?= json_encode($this->list_country) ?>;
  window.prefillCountry = '<?= $this->supplier->country ?>';
  window.prefillState = '<?= $this->supplier->state ?>';
  window.prefillCity = '<?= $this->supplier->city ?>';
</script>

<script src="/skins/supplier/js/init-country-state-city.js"></script>
<script src="/skins/supplier/js/logo-preview.js"></script>
<script src="/skins/supplier/js/visibility-toggle.js"></script>

<script src="/skins/supplier/js/tabs-validation.js?v=1.0"></script>
<script src="/skins/supplier/js/submit-form-general-info.js?v=1.00"></script>

<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud1">-%</span> de esta sección</div>

<form id="submit-information-update" action="/supplier/profile/updategeneralinfo" method="POST" class="supplier-register-form form-bx">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div class="row">


    <div class="col-12 col-md-4 col-lg-2">
      <div class="col-12 mb-3 supplier-image-bx">
        <div class="profile-container">
          <div class="progress-circle">
            <svg viewBox="0 0 36 36" class="circular-chart" style="transform:rotate(-180deg)">
              <path class="circle-bg" d="M18 2.0845
                           a 15.9155 15.9155 0 0 1 0 31.831
                           a 15.9155 15.9155 0 0 1 0 -31.831" />
              <path class="circle" stroke-dasharray="<?= $this->profileComplete ?>,100" d="M18 2.0845
                           a 15.9155 15.9155 0 0 1 0 31.831
                           a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
            <label for="supplier_image" class="supplier-image-label">

              <!-- 1) asignamos un id al img para poder referenciarlo -->
              <img
                id="preview-logo"
                src="<?= $this->supplier->image
                        ? '/images/' . $this->supplier->image
                        : '/assets/default.png' ?>"
                alt="Logo del proveedor"
                name="image"
                class="avatar-image" />

            </label>
          </div>

          <input
            type="file"
            accept="image/*"
            class="form-control d-none mb-2"
            id="supplier_image"
            name="image"
            value="<?= $this->supplier->image ?>"
            onchange="previewSupplierLogo(this)" />

          <!-- 2) contenedor para el botón cancelar -->
          <div id="cancel-logo-container" style="display: none;" class="mt-2 text-center">
            <button
              type="button"
              class="btn btn-warning btn-sm"
              onclick="cancelSupplierLogo()">
              Cancelar cambio de logo
            </button>
          </div>
        </div>

      </div>
      <div class="col-12 text-center d-none">
        <small>
          Haz completado el <strong style="color: #377abe;"><?= $this->profileComplete ?>%</strong> de tu perfil.
        </small>
      </div>
    </div>
    <div class="col-12 col-md-8 col-lg-10">
      <div class="row">
        <div class="col-12 d-flex justify-content-end mb-2">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="visibility_status"
              data-value="<?= $this->supplier->visibility_status ?>" value="<?= $this->supplier->visibility_status ?>"
              data-id="<?= $this->supplier->id ?>"
              <?= $this->supplier->visibility_status == 1 ? 'checked' : '' ?>
              id="flexSwitchCheckDefault" name="visibility_status" />
            <label class="form-check-label" for="flexSwitchCheckDefault">
              Visibilidad de tu perfil
              <i class="fa-regular fa-circle-question" data-bs-toggle="tooltip" data-bs-placement="top" title="Si lo desactivas los compradores no podrán ver tu información de contacto en ningún momento, ni cuando envíes propuestas."></i>
            </label>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="mb-2">
            <label for="user_name" class="form-label">
              Nombre (contacto comercial) <span>*</span></label>
            <input type="text" class="form-control" id="user_name" name="name" value="<?= $this->userSupplier->name ?>" required />
            <small class="error-msg text-danger"></small>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="mb-2">
            <label for="user_lastname" class="form-label">
              Apellido (contacto comercial) <span>*</span></label>
            <input type="text" class="form-control" id="user_lastname" name="lastname" value="<?= $this->userSupplier->lastname ?>" required />
            <small class="error-msg text-danger"></small>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="mb-2">
            <label for="user_email" class="form-label">
              Correo electrónico <span>*</span></label>
            <input type="email" class="form-control" id="user_email" name="email" value="<?= $this->userSupplier->email ?>" disabled readonly />
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="mb-2">
            <label for="phone" class="form-label">
              Teléfono de contacto <span>*</span></label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?= $this->userSupplier->phone ?>" required />
            <small class="error-msg text-danger"></small>
          </div>
        </div>


        <div class="col-12 col-md-6 col-lg-4">
          <div class="mb-2">
            <label for="position" class="form-label"> Cargo <span>*</span></label>
            <input
              type="text"
              class="form-control"
              id="position"
              name="position"
              value="<?= $this->supplier->position ?>"
              required />
            <small class="error-msg text-danger"></small>
          </div>
        </div>


        <!-- Área en la empresa -->
        <div class="col-12 col-md-6 col-lg-4">
          <div class="form-group mb-2">
            <label for="area" class="form-label"><span>*</span> Departamento al que pertenece</label>
            <select class="form-control" name="area" id="area" required>
              <option value="" disabled>Seleccione...</option>
              <option <?php if($this->userSupplier->area=="Auditoría Interna"){ echo 'selected'; } ?>  value="Auditoría Interna">Auditoría Interna</option>
              <option <?php if($this->userSupplier->area=="Calidad"){ echo 'selected'; } ?> value="Calidad">Calidad</option>
              <option <?php if($this->userSupplier->area=="Cadena de Suministro"){ echo 'selected'; } ?> value="Cadena de Suministro">Cadena de Suministro</option>
              <option <?php if($this->userSupplier->area=="Categoría y desarrollo de negocio"){ echo 'selected'; } ?> value="Categoría y desarrollo de negocio">Categoría y desarrollo de negocio</option>
              <option <?php if($this->userSupplier->area=="Compras y abastecimiento"){ echo 'selected'; } ?> value="Compras y abastecimiento">Compras y abastecimiento</option>
              <option <?php if($this->userSupplier->area=="Comunicaciones corporativas"){ echo 'selected'; } ?> value="Comunicaciones corporativas">Comunicaciones corporativas</option>
              <option <?php if($this->userSupplier->area=="Dueño/Representante Legal"){ echo 'selected'; } ?> value="Dueño/Representante Legal">Dueño/Representante Legal</option>
              <option <?php if($this->userSupplier->area=="Finanzas"){ echo 'selected'; } ?> value="Finanzas">Finanzas</option>
              <option <?php if($this->userSupplier->area=="Gerente General"){ echo 'selected'; } ?> value="Gerente General">Gerente General</option>
              <option <?php if($this->userSupplier->area=="Gestión de proveedores"){ echo 'selected'; } ?> value="Gestión de proveedores">Gestión de proveedores</option>
              <option <?php if($this->userSupplier->area=="Growth"){ echo 'selected'; } ?> value="Growth">Growth</option>
              <option <?php if($this->userSupplier->area=="Infraestructura"){ echo 'selected'; } ?> value="Infraestructura">Infraestructura</option>
              <option <?php if($this->userSupplier->area=="Ingeniería"){ echo 'selected'; } ?> value="Ingeniería">Ingeniería</option>
              <option <?php if($this->userSupplier->area=="Innovación y desarrollo"){ echo 'selected'; } ?> value="Innovación y desarrollo">Innovación y desarrollo</option>
              <option <?php if($this->userSupplier->area=="Inventarios y Almacén"){ echo 'selected'; } ?> value="Inventarios y Almacén">Inventarios y Almacén</option>
              <option <?php if($this->userSupplier->area=="Legal"){ echo 'selected'; } ?> value="Legal">Legal</option>
              <option <?php if($this->userSupplier->area=="Logistica y Distribución"){ echo 'selected'; } ?> value="Logistica y Distribución">Logistica y Distribución</option>
              <option <?php if($this->userSupplier->area=="Mantenimiento industrial"){ echo 'selected'; } ?> value="Mantenimiento industrial">Mantenimiento industrial</option>
              <option <?php if($this->userSupplier->area=="Marketing"){ echo 'selected'; } ?> value="Marketing">Marketing</option>
              <option <?php if($this->userSupplier->area=="Operaciones"){ echo 'selected'; } ?> value="Operaciones">Operaciones</option>
              <option <?php if($this->userSupplier->area=="Planeación de la demanda"){ echo 'selected'; } ?> value="Planeación de la demanda">Planeación de la demanda</option>
              <option <?php if($this->userSupplier->area=="Producción"){ echo 'selected'; } ?> value="Producción">Producción</option>
              <option <?php if($this->userSupplier->area=="Proyectos"){ echo 'selected'; } ?> value="Proyectos">Proyectos</option>
              <option <?php if($this->userSupplier->area=="Recursos humanos"){ echo 'selected'; } ?> value="Recursos humanos">Recursos humanos</option>
              <option <?php if($this->userSupplier->area=="Responsabilidad social"){ echo 'selected'; } ?> value="Responsabilidad social">Responsabilidad social</option>
              <option <?php if($this->userSupplier->area=="Salud y Seguridad Laboral"){ echo 'selected'; } ?> value="Salud y Seguridad Laboral">Salud y Seguridad Laboral</option>
              <option <?php if($this->userSupplier->area=="Servicio al cliente"){ echo 'selected'; } ?> value="Servicio al cliente">Servicio al cliente</option>
              <option <?php if($this->userSupplier->area=="Administración y Servicios Generales"){ echo 'selected'; } ?> value="Administración y Servicios Generales">Administración y Servicios Generales</option>
              <option <?php if($this->userSupplier->area=="Sostenibilidad"){ echo 'selected'; } ?> value="Sostenibilidad">Sostenibilidad</option>
              <option <?php if($this->userSupplier->area=="Tecnología"){ echo 'selected'; } ?> value="Tecnología">Tecnología</option>
              <option <?php if($this->userSupplier->area=="Transporte"){ echo 'selected'; } ?> value="Transporte">Transporte</option>
              <option <?php if($this->userSupplier->area=="Unidad de negocio"){ echo 'selected'; } ?> value="Unidad de negocio">Unidad de negocio</option>
              <option <?php if($this->userSupplier->area=="Ventas"){ echo 'selected'; } ?> value="Ventas">Ventas</option>

            </select>
            <small class="error-msg text-danger"></small>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            $('#area').val('<?= $this->userSupplier->area ?>');
          });
        </script>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="mb-2">
            <label for="company_name" class="form-label">Razón social <span>*</span></label>
            <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $this->supplier->company_name ?>" data-id="<?= $this->supplier->id ?>"
              required readonly />
            <small class="error-msg text-danger"></small>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
          <div class="mb-2">
            <label for="supplier_soc_type" class="form-label">
              Tipo de sociedad <span>*</span></label>
            <select name="supplier_soc_type" id="supplier_soc_type" class="form-control" required>
              <option value="" disabled>Seleccione...</option>
              <?php foreach ($this->list_supplier_soc_type as $key => $value) { ?>
                <option <?php if ($this->getObjectVariable($this->supplier, "supplier_soc_type") == $key) {
                          echo "selected";
                        } ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
              <?php } ?>
            </select>
            <small class="error-msg text-danger"></small>
          </div>
        </div>



        <div class="col-12 col-md-6 col-lg-3">
          <div class="mb-2">
            <label for="identification_nit" class="form-label">NIT / Tax Id <span>*</span></label>
            <input type="text"
              class="form-control" id="identification_nit" name="identification_nit" disabled required value="<?= $this->supplier->identification_nit ?>" />
          </div>
        </div>
        <script>
          const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
          };
          const selectedCountryInfo = decodeHtml("<?= $this->supplier->birth_country ?>");
          const selectedStateInfo = decodeHtml("<?= $this->supplier->birth_state ?>");
          const selectedCityInfo = decodeHtml("<?= $this->supplier->birth_city ?>");
         
        </script>
        <?php 
        // print_r($this->supplier);
        ?>
        <div class="col-12 col-md-6 col-lg-3 form-group">
          <label for="birth_country" class="form-label">País <span>*</span></label>
          <select class="form-control" id="birth_country" name="birth_country" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
            <?php foreach ($this->list_country as $c): ?>
              <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
          </select>
          <small class="error-msg text-danger"></small>
        </div>

        <div class="col-12 col-md-6 col-lg-3 form-group d-none" id="birth_state-wrapper">
          <label for="birth_state" class="form-label">Departamento / Estado <span>*</span></label>
          <select class="form-control" id="birth_state" name="birth_state">
            <option value="">Seleccione...</option>
          </select>
          <small class="error-msg text-danger"></small>
        </div>

        <div class="col-12 col-md-6 col-lg-3 form-group d-none" id="birth_city-wrapper">
          <label for="birth_city" class="form-label">Ciudad <span>*</span></label>
          <select class="form-control" id="birth_city" name="birth_city">
            <option value="">Seleccione...</option>
          </select>
          <small class="error-msg text-danger"></small>
        </div>

       <!--  <script>
          $(document).ready(function() {
            $('#birth_country').val('<?= $this->supplier->birth_country ?>');
          });
        </script>
 -->


        <div class="col-md-12">
          <div class="mb-2">
            <label for="commercial_activity" class="form-label">Descripción de la actividad comercial
              <span>*</span></label>
            <textarea name="commercial_activity" id="commercial_activity" class="form-control tinyeditor-simple" rows="10" required><?= $this->supplier->commercial_activity; ?></textarea>
            <small class="w-100 d-block text-end" id="char-count">0/700</small>
            <small class="error-msg text-danger "></small>
          </div>
        </div>
        <div class="col-md-12 mt-2">

          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkDefault" name="policy" checked disabled>
            <label class="form-check-label" for="checkDefault">
              Acepto el
              <label
                class="d-inline-grid"
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault1"
                role="button">Tratamiento de datos</label>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkChecked2" name="policy2" checked disabled>
            <label class="form-check-label" for="checkChecked2">
              Acepto las
              <label
                class="d-inline-grid"
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault2"
                role="button">Politicas de privacidad</label>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="checkChecked3" name="policy3" checked disabled>
            <label class="form-check-label" for="checkChecked3">
              Acepto el
              <label
                class="d-inline-grid"
                style="font-weight: bold"
                data-bs-toggle="modal" data-bs-target="#modalDefault3"
                role="button">Declaración de lavado de activos</label>
            </label>
          </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
          <button type="submit" class="bg-orange" id="btnSubmitInfo">
            Actualizar
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
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


<script type="text/javascript">
  function completitud1(){
    $.post("/supplier/profile/completitud1/",{ },function(res){
      $("#completitud1").html(res.porcentaje+"%");
      array_completitud[1]=res.porcentaje;
      completeness();
    });
  }
  completitud1();
</script>

<style>
label.supplier-image-label img {
  position: absolute;
  width: 80%;
  height: 80%;
  object-fit: contain;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  overflow: hidden;
  border-radius: 50%;
}  

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


<style>
.iti {
  width: 100%;
}  
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#phone");
  window.intlTelInput(input, {
    initialCountry: "co",
    strictMode: true,
    loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
  });
 
</script>