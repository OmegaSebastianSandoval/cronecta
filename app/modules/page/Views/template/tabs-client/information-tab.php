<script src="/skins/page/js/profile-submit-form.js"></script>



          <div class="row w-100">
            <div class="col-md-6 ms-auto text-end d-none">
              <!-- % de completitud del perfil -->
              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: <?php echo floatval($this->completenessPercentage); ?>px;"
                  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <small>
                Tu perfil está <?php echo floatval($this->completenessPercentage); ?>% completo
              </small>
            </div>
          </div>
          <div class="row w-100">
            <div class="col-12">
              <div class="alert alert-warning py-2" role="alert">
                Todos los campos con (*) son obligatorios
              </div>
            </div>
          </div>

          <div class="row client-profile-form">
            <form action="/page/profile/save" method="post" enctype="multipart/form-data"  data-bs-toggle="validator" id="profileForm">
              <div class="row">
                <div class="col-12 pb-3">
                  <div class="row align-items-center">
                    <div class="col-3">
                      <span class="text-lg text-slate-800 font-medium">Perfil de usuario</span>
                    </div>
                    <div class="col-9">
                      <hr>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="" class="form-label">Tipo de Documento <span>*</span></label>
                    <select class="form-control" name="documentType" readonly>
                      <option value="CC" <?php if($this->content->documentType=="CC"){ echo 'selected'; } ?> >Cédula de Ciudadanía</option>
                      <option value="CE" <?php if($this->content->documentType=="CE"){ echo 'selected'; } ?> >Cédula de Extranjería</option>
                      <option value="DNI" <?php if($this->content->documentType=="DNI"){ echo 'selected'; } ?>>Documento Nacional de identidad</option>
                      <option value="PAS" <?php if($this->content->documentType=="PAS"){ echo 'selected'; } ?>>Pasaporte</option>
                      <option value="PEP" <?php if($this->content->documentType=="PEP"){ echo 'selected'; } ?>>Permiso especial de Permanencia</option>
                    </select>
                  </div>
                </div>
                <!-- Campo NIT -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nit" class="form-label">No de documento <span>*</span></label>
                    <input name="nit" type="text" id="nit" name="nit" class="form-control" value="<?php echo $this->content->nit; ?>" readonly />
                  </div>
                </div>

                <!-- Campo Nombre -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="name" class="form-label">Nombre <span>*</span></label>
                    <input name="name" type="text" id="name" name="name" class="form-control"
                      value="<?php echo $this->content->name; ?>" required />
                    <small class="error-msg text-danger "></small>
                  </div>
                </div>

                <!-- Campo Apellido -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="lastname" class="form-label">Apellido <span>*</span></label>
                    <input name="lastname" type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $this->content->lastname; ?>"
                      required />
                    <small class="error-msg text-danger "></small>
                  </div>
                </div>
                <!-- Campo Email Personal -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico personal <span>*</span></label>
                    <input name="email" type="email" id="email" name="email" class="form-control" value="<?php echo $this->content->email; ?>"
                      readonly />
                  </div>
                </div>

                <!-- Campo Email de Negocio -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bussinesEmail" class="form-label">Correo electrónico de negocio <span>*</span></label>
                    <input name="bussinesEmail" type="email" id="bussinesEmail" name="bussinesEmail" value="<?php echo $this->content->bussinesEmail; ?>"
                      class="form-control" readonly />
                  </div>
                </div>

                  <!-- Campo Teléfono -->
                <!-- WhatsApp -->
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">WhatsApp <span>*</span></label>
                    <input type="tel" class="form-control" name="whatsapp" id="whatsapp" value="<?php echo $this->content->whatsapp; ?>"></input>
                    <small class="error-msg text-danger "></small>
                  </div>
                </div>

                <!-- Teléfono -->
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Teléfono <span>*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $this->content->phone; ?>"></input>
                    <small class="error-msg text-danger "></small>
                  </div>
                </div>


                <div class="col-12 col-md-6 col-lg-4 form-group">
                  <label class="form-label">País <span>*</span></label>
                  <select class="form-control select2" name="country" id="country">
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->list_country as $value) { ?>
                      <option value="<?= $value['name'] ?>" <?php if($this->content->country==$value['name']){ echo 'selected'; } ?>><?= $value["name"] ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="col-12 col-md-6 col-lg-4 form-group d-none" id="state-wrapper">
                  <label class="form-label">Departamento / Estado <span>*</span></label>
                  <select class="form-control" name="state" id="state">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <div class="col-12 col-md-6 col-lg-4 form-group d-none" id="city-wrapper">
                  <label for="city" class="form-label">Ciudad <span>*</span></label>
                  <select class="form-control" name="city" id="city">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <div class="col-12 py-3 pt-4">
                  <div class="row align-items-center">
                    <div class="col-3 pe-0">
                      <span class="text-lg text-slate-800 font-medium">Información empresarial</span>
                    </div>
                    <div class="col-9">
                      <hr>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Nacionalidad de la empresa <span>*</span></label>
                    <select name="nit_type" class="form-control" readonly>
                      <option value="" disabled>Seleccione...</option>
                      <option value="colombian" <?php if($this->content->nit_type=="colombian"){ echo 'selected'; }?> >NIT - Colombiano</option>
                      <option value="foreign" <?php if($this->content->nit_type=="foreign"){ echo 'selected'; }?> >ID - Extranjero</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Tax ID o NIT <span>*</span></label>
                    <input type="text" class="form-control" id="empresa" name="company_nit"
                       readonly value="<?php echo $this->content->company_nit; ?>" />
                      <small class="error-msg text-danger "></small>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="company" class="form-label">Empresa <span>*</span></label>
                  <input name="company" type="text" id="company" name="company" class="form-control" value="<?php echo $this->content->company; ?>"
                    required />
                </div>

                <!-- industria de la empresa -->
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Industria de la empresa <span>*</span></label>
                    <select class="form-control" name="industry_id" required>
                      <option value="" selected disabled>Seleccione...</option>
                      <?php foreach ($this->list_industry as $key => $value) { ?>
                        <option value="<?= $key ?>" <?php if($this->content->industry_id==$key){ echo 'selected'; } ?>><?= $value ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>


                <div class="col-12 col-md-6 col-lg-3 form-group">
                  <label class="form-label">País empresa<span>*</span></label>
                  <select class="form-control" name="company_country" id="company_country">
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->list_country as $value) { ?>
                      <option value="<?= $value['name'] ?>" <?php if($this->content->country==$value['name']){ echo 'selected'; } ?>><?= $value["name"] ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="col-12 col-md-6 col-lg-3 form-group d-none1" id="company-state-wrapper">
                  <label class="form-label">Departamento / Estado <span>*</span></label>
                  <select class="form-control" name="company_state" id="company_state">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <div class="col-12 col-md-6 col-lg-3 form-group d-none1" id="company-city-wrapper">
                  <label for="city" class="form-label">Ciudad <span>*</span></label>
                  <select class="form-control" name="company_city" id="company_city">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <!-- Cargo en la empresa -->
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Cargo <span>*</span></label>
                    <input type="text" class="form-control" name="position" placeholder="Cargo" required value="<?php echo $this->content->position; ?>" />
                  </div>
                </div>

                <!-- Área en la empresa -->
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Departamento al que pertenece <span>*</span></label>
                    <select class="form-control" name="area" required>
                      <option value="" disabled>Seleccione...</option>
                      <option <?php if($this->content->area=="Auditoría Interna"){ echo 'selected'; } ?> value="Auditoría Interna">Auditoría Interna</option>
                      <option <?php if($this->content->area=="Calidad"){ echo 'selected'; } ?> value="Calidad">Calidad</option>
                      <option <?php if($this->content->area=="Cadena de Suministro"){ echo 'selected'; } ?> value="Cadena de Suministro">Cadena de Suministro</option>
                      <option <?php if($this->content->area=="Categoría y desarrollo de negocio"){ echo 'selected'; } ?> value="Categoría y desarrollo de negocio">Categoría y desarrollo de negocio</option>
                      <option <?php if($this->content->area=="Compras y abastecimiento"){ echo 'selected'; } ?> value="Compras y abastecimiento">Compras y abastecimiento</option>
                      <option <?php if($this->content->area=="Comunicaciones corporativas"){ echo 'selected'; } ?> value="Comunicaciones corporativas">Comunicaciones corporativas</option>
                      <option <?php if($this->content->area=="Finanzas"){ echo 'selected'; } ?> value="Finanzas">Finanzas</option>
                      <option <?php if($this->content->area=="Gestión de proveedores"){ echo 'selected'; } ?> value="Gestión de proveedores">Gestión de proveedores</option>
                      <option <?php if($this->content->area=="Growth"){ echo 'selected'; } ?> value="Growth">Growth</option>
                      <option <?php if($this->content->area=="Infraestructura"){ echo 'selected'; } ?> value="Infraestructura">Infraestructura</option>
                      <option <?php if($this->content->area=="Ingeniería"){ echo 'selected'; } ?> value="Ingeniería">Ingeniería</option>
                      <option <?php if($this->content->area=="Innovación y desarrollo"){ echo 'selected'; } ?> value="Innovación y desarrollo">Innovación y desarrollo</option>
                      <option <?php if($this->content->area=="Inventarios y Almacén"){ echo 'selected'; } ?> value="Inventarios y Almacén">Inventarios y Almacén</option>
                      <option <?php if($this->content->area=="Legal"){ echo 'selected'; } ?> value="Legal">Legal</option>
                      <option <?php if($this->content->area=="Logistica y Distribución"){ echo 'selected'; } ?> value="Logistica y Distribución">Logistica y Distribución</option>
                      <option <?php if($this->content->area=="Mantenimiento industrial"){ echo 'selected'; } ?> value="Mantenimiento industrial">Mantenimiento industrial</option>
                      <option <?php if($this->content->area=="Marketing"){ echo 'selected'; } ?> value="Marketing">Marketing</option>
                      <option <?php if($this->content->area=="Operaciones"){ echo 'selected'; } ?> value="Operaciones">Operaciones</option>
                      <option <?php if($this->content->area=="Planeación de la demanda"){ echo 'selected'; } ?> value="Planeación de la demanda">Planeación de la demanda</option>
                      <option <?php if($this->content->area=="Producción"){ echo 'selected'; } ?> value="Producción">Producción</option>
                      <option <?php if($this->content->area=="Proyectos"){ echo 'selected'; } ?> value="Proyectos">Proyectos</option>
                      <option <?php if($this->content->area=="Recursos humanos"){ echo 'selected'; } ?> value="Recursos humanos">Recursos humanos</option>
                      <option <?php if($this->content->area=="Responsabilidad social"){ echo 'selected'; } ?> value="Responsabilidad social">Responsabilidad social</option>
                      <option <?php if($this->content->area=="Salud y Seguridad Laboral"){ echo 'selected'; } ?> value="Salud y Seguridad Laboral">Salud y Seguridad Laboral</option>
                      <option <?php if($this->content->area=="Servicio al cliente"){ echo 'selected'; } ?> value="Servicio al cliente">Servicio al cliente</option>
                      <option <?php if($this->content->area=="Administración y Servicios Generales"){ echo 'selected'; } ?> value="Administración y Servicios Generales">Administración y Servicios Generales</option>
                      <option <?php if($this->content->area=="Sostenibilidad"){ echo 'selected'; } ?> value="Sostenibilidad">Sostenibilidad</option>
                      <option <?php if($this->content->area=="Tecnología"){ echo 'selected'; } ?> value="Tecnología">Tecnología</option>
                      <option <?php if($this->content->area=="Transporte"){ echo 'selected'; } ?> value="Transporte">Transporte</option>
                      <option <?php if($this->content->area=="Unidad de negocio"){ echo 'selected'; } ?> value="Unidad de negocio">Unidad de negocio</option>
                      <option <?php if($this->content->area=="Ventas"){ echo 'selected'; } ?> value="Ventas">Ventas</option>
                    </select>
                  </div>
                </div>

              </div>
              <!-- Botón para enviar el formulario de perfil -->
              <div class="form-group form-submit wk-right">
                <button type="submit" id="btnSubmit" class="bg-orange text-white px-4 py-2">
                  Actualizar Perfil
                </button>
              </div>
            </form>
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