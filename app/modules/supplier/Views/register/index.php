<script>
  const countriesData = <?= json_encode($this->list_country) ?>;
</script>

<div class="container">

  <h2 class="title title-2 primary">
    <?php echo $this->titlesection; ?>
  </h2>
  <?php
  /* echo "<pre>";
  print_r($this->list_country);
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
    <form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
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

                  <select class="form-control" name="is_legal_entity" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->list_is_legal_entity as $key => $value) { ?>
                      <option <?php if ($this->getObjectVariable($this->content, "is_legal_entity") == $key) {
                                echo "selected";
                              } ?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
                    <?php } ?>
                  </select>
                </label>
                <div class="help-block with-errors"></div>
              </div>

              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label for="company_name" class="control-label">Raz&oacute;n Social <span>*</span></label>
                <label class="input-group">

                  <input type="text" value="<?= $this->content->company_name; ?>" name="company_name" id="company_name" class="form-control" required>
                </label>
                <div class="help-block with-errors"></div>
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
                <div class="help-block with-errors"></div>
              </div>
              <div class="col-6 col-md-4 col-lg-3 form-group">
                <label for="nit_type" class="control-label">Nacionalidad NIT / Tax Id <span>*</span></label>
                <select name="nit_type" id="nit_type" class="form-control" required>
                  <option value="" disabled selected>Seleccione...</option>
                  <option value="colombian">Colombiano</option>
                  <option value="foreign">Extranjero</option>
                </select>
                <div class="help-block with-errors"></div>
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
                <div class="help-block with-errors"></div>
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
            <div class="help-block with-errors"></div>

          </div>
      </div>
      <div class="row mt-3">

        <div id="industry-groups-container">
          <!-- Grupo inicial -->
          <?php $index = 0; ?>
          <div class="industry-group mb-3" data-index="<?= $index ?>">
            <div class="row">
              <div class="col-md-5 form-group">
                <label class="control-label">Industria <span>*</span></label>
                <select name="groups[<?= $index ?>][industry]" class="form-control industry-select" required>
                  <option value="" selected disabled>Selecciona una opción</option>
                  <?php foreach ($this->list_industry as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-5 form-group">
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







































      <div class="row d-none">


        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="filling_date" class="control-label">filling_date</label>
          <label class="input-group">

            <input type="text" value="<?php if ($this->content->filling_date) {
                                        echo $this->content->filling_date;
                                      } else {
                                        echo date('Y-m-d');
                                      } ?>" name="filling_date" id="filling_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="counterparty_type" class="control-label">counterparty_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->counterparty_type; ?>" name="counterparty_type" id="counterparty_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="supplier_type" class="control-label">supplier_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->supplier_type; ?>" name="supplier_type" id="supplier_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="primary_email" class="control-label">primary_email</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->primary_email; ?>" name="primary_email" id="primary_email" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="economic_activity" class="control-label">economic_activity</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->economic_activity; ?>" name="economic_activity" id="economic_activity" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="ciiu_code" class="control-label">ciiu_code</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->ciiu_code; ?>" name="ciiu_code" id="ciiu_code" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>

        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="website" class="control-label">website</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->website; ?>" name="website" id="website" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="main_address" class="control-label">main_address</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->main_address; ?>" name="main_address" id="main_address" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_type" class="control-label">company_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_type; ?>" name="company_type" id="company_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>


        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="landline" class="control-label">landline</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->landline; ?>" name="landline" id="landline" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="mobile_phone" class="control-label">mobile_phone</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->mobile_phone; ?>" name="mobile_phone" id="mobile_phone" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="trade_registry">trade_registry</label>
          <input type="file" name="trade_registry" id="trade_registry" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('trade_registry');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="legal_representative_id">legal_representative_id</label>
          <input type="file" name="legal_representative_id" id="legal_representative_id" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('legal_representative_id');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="rut_certificate">rut_certificate</label>
          <input type="file" name="rut_certificate" id="rut_certificate" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('rut_certificate');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="financial_statements">financial_statements</label>
          <input type="file" name="financial_statements" id="financial_statements" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('financial_statements');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="tax_declaration">tax_declaration</label>
          <input type="file" name="tax_declaration" id="tax_declaration" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('tax_declaration');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="tax_declaration_year" class="control-label">tax_declaration_year</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->tax_declaration_year; ?>" name="tax_declaration_year" id="tax_declaration_year" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="tax_declaration_udate" class="control-label">tax_declaration_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->tax_declaration_udate; ?>" name="tax_declaration_udate" id="tax_declaration_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="number_of_employees" class="control-label">number_of_employees</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->number_of_employees; ?>" name="number_of_employees" id="number_of_employees" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_date" class="control-label">company_date</label>
          <label class="input-group">

            <input type="text" value="<?php if ($this->content->company_date) {
                                        echo $this->content->company_date;
                                      } else {
                                        echo date('Y-m-d');
                                      } ?>" name="company_date" id="company_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="representative_name" class="control-label">representative_name</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->representative_name; ?>" name="representative_name" id="representative_name" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_type" class="control-label">document_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_type; ?>" name="document_type" id="document_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_number" class="control-label">document_number</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_number; ?>" name="document_number" id="document_number" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_issue_place" class="control-label">document_issue_place</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_issue_place; ?>" name="document_issue_place" id="document_issue_place" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="nationality" class="control-label">nationality</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->nationality; ?>" name="nationality" id="nationality" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_issue_date" class="control-label">document_issue_date</label>
          <label class="input-group">

            <input type="text" value="<?php if ($this->content->document_issue_date) {
                                        echo $this->content->document_issue_date;
                                      } else {
                                        echo date('Y-m-d');
                                      } ?>" name="document_issue_date" id="document_issue_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="birthdate" class="control-label">birthdate</label>
          <label class="input-group">

            <input type="text" value="<?php if ($this->content->birthdate) {
                                        echo $this->content->birthdate;
                                      } else {
                                        echo date('Y-m-d');
                                      } ?>" name="birthdate" id="birthdate" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="birth_country" class="control-label">Pa&iacute;s de residencia</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->birth_country; ?>" name="birth_country" id="birth_country" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="birth_city" class="control-label">Ciudad</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->birth_city; ?>" name="birth_city" id="birth_city" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="birth_state" class="control-label">Departamento/Estado</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->birth_state; ?>" name="birth_state" id="birth_state" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="manages_public_funds" class="control-label">manages_public_funds</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->manages_public_funds; ?>" name="manages_public_funds" id="manages_public_funds" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="public_recognition" class="control-label">public_recognition</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->public_recognition; ?>" name="public_recognition" id="public_recognition" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="relationship_with_publicly_exposed_person" class="control-label">relationship_with_publicly_exposed_person</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->relationship_with_publicly_exposed_person; ?>" name="relationship_with_publicly_exposed_person" id="relationship_with_publicly_exposed_person" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="resource_origin" class="control-label">resource_origin</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->resource_origin; ?>" name="resource_origin" id="resource_origin" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="currency_type" class="control-label">currency_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->currency_type; ?>" name="currency_type" id="currency_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="liabilities" class="control-label">liabilities</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->liabilities; ?>" name="liabilities" id="liabilities" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="income" class="control-label">income</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->income; ?>" name="income" id="income" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="other_income" class="control-label">other_income</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->other_income; ?>" name="other_income" id="other_income" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="other_income_concept" class="control-label">other_income_concept</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->other_income_concept; ?>" name="other_income_concept" id="other_income_concept" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_transactions" class="control-label">foreign_transactions</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_transactions; ?>" name="foreign_transactions" id="foreign_transactions" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_transactions_details" class="control-label">foreign_transactions_details</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_transactions_details; ?>" name="foreign_transactions_details" id="foreign_transactions_details" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_financial_products" class="control-label">foreign_financial_products</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_financial_products; ?>" name="foreign_financial_products" id="foreign_financial_products" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_financial_products_details" class="control-label">foreign_financial_products_details</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_financial_products_details; ?>" name="foreign_financial_products_details" id="foreign_financial_products_details" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="declarations" class="control-label">declarations</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->declarations; ?>" name="declarations" id="declarations" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="is_active" class="control-label">is_active</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->is_active; ?>" name="is_active" id="is_active" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="subscription_expiry_date" class="control-label">subscription_expiry_date</label>
          <label class="input-group">

            <input type="text" value="<?php if ($this->content->subscription_expiry_date) {
                                        echo $this->content->subscription_expiry_date;
                                      } else {
                                        echo date('Y-m-d');
                                      } ?>" name="subscription_expiry_date" id="subscription_expiry_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="created_at" class="control-label">created_at</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->created_at; ?>" name="created_at" id="created_at" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="updated_at" class="control-label">updated_at</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->updated_at; ?>" name="updated_at" id="updated_at" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="activity_type" class="control-label">activity_type</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->activity_type; ?>" name="activity_type" id="activity_type" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="keywords" class="control-label">keywords</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->keywords; ?>" name="keywords" id="keywords" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="info_state" class="control-label">info_state</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->info_state; ?>" name="info_state" id="info_state" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="assets" class="control-label">assets</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->assets; ?>" name="assets" id="assets" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="expenses" class="control-label">expenses</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->expenses; ?>" name="expenses" id="expenses" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="equity" class="control-label">equity</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->equity; ?>" name="equity" id="equity" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="other_expenses" class="control-label">other_expenses</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->other_expenses; ?>" name="other_expenses" id="other_expenses" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="income_origin" class="control-label">income_origin</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->income_origin; ?>" name="income_origin" id="income_origin" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="assets_total" class="control-label">assets_total</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->assets_total; ?>" name="assets_total" id="assets_total" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="liabilities_total" class="control-label">liabilities_total</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->liabilities_total; ?>" name="liabilities_total" id="liabilities_total" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="income_other" class="control-label">income_other</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->income_other; ?>" name="income_other" id="income_other" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="eeff" class="control-label">eeff</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->eeff; ?>" name="eeff" id="eeff" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="eeff_year" class="control-label">eeff_year</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->eeff_year; ?>" name="eeff_year" id="eeff_year" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="eeff_udate" class="control-label">eeff_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->eeff_udate; ?>" name="eeff_udate" id="eeff_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="expenses_other" class="control-label">expenses_other</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->expenses_other; ?>" name="expenses_other" id="expenses_other" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="income_total" class="control-label">income_total</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->income_total; ?>" name="income_total" id="income_total" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="expenses_total" class="control-label">expenses_total</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->expenses_total; ?>" name="expenses_total" id="expenses_total" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="utility" class="control-label">utility</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->utility; ?>" name="utility" id="utility" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="utility_total" class="control-label">utility_total</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->utility_total; ?>" name="utility_total" id="utility_total" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="financial_expenses" class="control-label">financial_expenses</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->financial_expenses; ?>" name="financial_expenses" id="financial_expenses" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="income_other_concept" class="control-label">income_other_concept</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->income_other_concept; ?>" name="income_other_concept" id="income_other_concept" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>


        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="policy" class="control-label">policy</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->policy; ?>" name="policy" id="policy" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="visibility_status" class="control-label">visibility_status</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->visibility_status; ?>" name="visibility_status" id="visibility_status" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="facebook" class="control-label">facebook</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->facebook; ?>" name="facebook" id="facebook" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="instagram" class="control-label">instagram</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->instagram; ?>" name="instagram" id="instagram" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="twitter" class="control-label">twitter</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->twitter; ?>" name="twitter" id="twitter" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="linkedin" class="control-label">linkedin</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->linkedin; ?>" name="linkedin" id="linkedin" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="slug" class="control-label">slug</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->slug; ?>" name="slug" id="slug" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="position" class="control-label">Cargo</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->position; ?>" name="position" id="position" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="ip" class="control-label">ip</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->ip; ?>" name="ip" id="ip" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="representative_name2" class="control-label">representative_name2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->representative_name2; ?>" name="representative_name2" id="representative_name2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_type2" class="control-label">document_type2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_type2; ?>" name="document_type2" id="document_type2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_number2" class="control-label">document_number2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_number2; ?>" name="document_number2" id="document_number2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_issue_place2" class="control-label">document_issue_place2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_issue_place2; ?>" name="document_issue_place2" id="document_issue_place2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="document_issue_date2" class="control-label">document_issue_date2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->document_issue_date2; ?>" name="document_issue_date2" id="document_issue_date2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="representative_birth_country" class="control-label">representative_birth_country</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->representative_birth_country; ?>" name="representative_birth_country" id="representative_birth_country" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="representative_birth_country2" class="control-label">representative_birth_country2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->representative_birth_country2; ?>" name="representative_birth_country2" id="representative_birth_country2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="legal_representative_id2" class="control-label">legal_representative_id2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->legal_representative_id2; ?>" name="legal_representative_id2" id="legal_representative_id2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="certificate_issue_date" class="control-label">certificate_issue_date</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->certificate_issue_date; ?>" name="certificate_issue_date" id="certificate_issue_date" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_validity" class="control-label">company_validity</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_validity; ?>" name="company_validity" id="company_validity" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_validity2" class="control-label">company_validity2</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_validity2; ?>" name="company_validity2" id="company_validity2" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="registry_state" class="control-label">registry_state</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->registry_state; ?>" name="registry_state" id="registry_state" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="registry_city" class="control-label">registry_city</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->registry_city; ?>" name="registry_city" id="registry_city" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="incorporation_certificate">incorporation_certificate</label>
          <input type="file" name="incorporation_certificate" id="incorporation_certificate" class="form-control  file-document" data-buttonName="btn-primary" onchange="validardocumento('incorporation_certificate');" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="trade_registry_udate" class="control-label">trade_registry_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->trade_registry_udate; ?>" name="trade_registry_udate" id="trade_registry_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="incorporation_certificate_udate" class="control-label">incorporation_certificate_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->incorporation_certificate_udate; ?>" name="incorporation_certificate_udate" id="incorporation_certificate_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="rut_certificate_udate" class="control-label">rut_certificate_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->rut_certificate_udate; ?>" name="rut_certificate_udate" id="rut_certificate_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="brochure" class="control-label">brochure</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->brochure; ?>" name="brochure" id="brochure" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_size" class="control-label">company_size</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_size; ?>" name="company_size" id="company_size" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_size_certificate" class="control-label">company_size_certificate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_size_certificate; ?>" name="company_size_certificate" id="company_size_certificate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="company_size_certificate_udate" class="control-label">company_size_certificate_udate</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->company_size_certificate_udate; ?>" name="company_size_certificate_udate" id="company_size_certificate_udate" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_currency" class="control-label">foreign_currency</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_currency; ?>" name="foreign_currency" id="foreign_currency" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="which_foreign_currency" class="control-label">which_foreign_currency</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->which_foreign_currency; ?>" name="which_foreign_currency" id="which_foreign_currency" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="foreign_products" class="control-label">foreign_products</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->foreign_products; ?>" name="foreign_products" id="foreign_products" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="which_foreign_products" class="control-label">which_foreign_products</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->which_foreign_products; ?>" name="which_foreign_products" id="which_foreign_products" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="tax_liabilities" class="control-label">tax_liabilities</label>
          <label class="input-group">

            <input type="text" value="<?= $this->content->tax_liabilities; ?>" name="tax_liabilities" id="tax_liabilities" class="form-control">
          </label>
          <div class="help-block with-errors"></div>
        </div>
        <div class="col-6 col-md-4 col-lg-3 form-group">
          <label for="nontaxable_agent" class="form-label">nontaxable_agent</label>
          <textarea name="nontaxable_agent" id="nontaxable_agent" class="form-control tinyeditor" rows="10"><?= $this->content->nontaxable_agent; ?></textarea>
          <div class="help-block with-errors"></div>
        </div>

      </div>
  </div>
  <div class="botones-acciones">
    <button class="btn btn-guardar" type="submit">Guardar</button>
    <a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
  </div>
  </form>
</div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let groupIndex = 1;

    window.addIndustryGroup = function() {
      const container = document.getElementById("industry-groups-container");
      const newGroup = document.createElement("div");
      newGroup.classList.add("industry-group", "mb-3");
      newGroup.setAttribute("data-index", groupIndex);

      newGroup.innerHTML = `
      <div class="row">
        <div class="col-md-5 form-group">
          <label class="control-label">Industria <span>*</span></label>
          <select name="groups[${groupIndex}][industry]" class="form-control industry-select" required>
            <option value="" selected disabled>Selecciona una opción</option>
            <?php foreach ($this->list_industry as $key => $value) { ?>
              <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-5 form-group">
          <label class="control-label">Segmentos <span>*</span></label>
          <select name="groups[${groupIndex}][segments][]" multiple class="form-control segment-select selec-multiple"  required>
           
          </select>
        </div>
      </div>
    `;

      container.appendChild(newGroup);
      groupIndex++;
      const segmentSelect = newGroup.querySelector('.segment-select');
      $(segmentSelect).select2({
        width: '100%'
      });
      attachIndustryChangeHandlers(newGroup); // 👈 importante
    };

    function attachIndustryChangeHandlers(scope) {
      const industrySelect = scope.querySelector('.industry-select');
      const segmentSelect = scope.querySelector('.segment-select');
      
      if ($(segmentSelect).hasClass('selec-multiple')) {
        if ($(segmentSelect).hasClass("select2-hidden-accessible")) {
          $(segmentSelect).select2('destroy'); // Solo si ya está aplicado
        }
        $(segmentSelect).select2({
          width: '100%',
          tags: true,
          placeholder: "Seleccione uno o más segmentos",

        });
      }
      industrySelect.addEventListener('change', async function() {
        const industryId = this.value;

        // Limpia los segmentos antes de cargar
        segmentSelect.innerHTML = '<option value="">Cargando...</option>';

        if (!industryId) {
          segmentSelect.innerHTML = '';
          return;
        }

        try {
          const response = await fetch(`/supplier/register/getsegments/?industryId=${industryId}`);
          const segments = await response.json();

          segmentSelect.innerHTML = '';
          segments.forEach(segment => {
            const option = document.createElement('option');
            option.value = segment.id;
            option.textContent = segment.name;
            segmentSelect.appendChild(option);
          });

          // Si usas select2 o similar, reinicialízalo aquí
          if ($(segmentSelect).hasClass('selec-multiple')) {
            $(segmentSelect).select2(); // o la que estés usando
          }

        } catch (error) {
          console.error('Error al cargar los segmentos:', error);
          segmentSelect.innerHTML = '<option value="">Error al cargar</option>';
        }
      });
    }

    // Inicializa el primer grupo que ya está en el DOM
    const firstGroup = document.querySelector('.industry-group');
    if (firstGroup) {
      attachIndustryChangeHandlers(firstGroup);
    }
  });
</script>