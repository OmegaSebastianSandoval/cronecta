<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="financialForm" method="POST" action="#" class="supplier-register-form form-bx">
  <div class="row">

    <div class="col-12 py-3 pt-4">
      <div class="row align-items-center">
        <div class="col-4 pe-0">
          <span class="text-lg text-slate-800 font-medium">Información financiera</span>
        </div>
        <div class="col-8">
          <hr>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="mb-3">
        <label class="form-label">Origen de los recursos <span>*</span></label>
        <input type="text" class="form-control" name="income_origin" required />
        <!-- v-model="financial.income_origin" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="currency_type" class="form-label">Tipo de moneda <span>*</span></label>
        <select class="form-control" id="currency_type" name="currency_type" required>
          <option value="COP">COP</option>
          <option value="USD">USD</option>
          <option value="EUR">EUR</option>
        </select>
        <!-- v-model="financial.currency_type" -->
      </div>
    </div>

  <!--   <div class="col-md-6">
      <div class="mb-3">
        <label for="equity" class="form-label">Patrimonio en pesos colombianos <span>*</span></label>
        <input type="number" class="form-control" id="equity" name="equity" required />
      
      </div>
    </div> -->

    <div class="col-md-6">
      <div class="mb-3">
        <label for="assets" class="form-label">Activos corrientes <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="assets" name="assets" required />
        <!-- v-model="financial.assets" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="liabilities" class="form-label">Pasivos corrientes <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="liabilities" name="liabilities" required />
        <!-- v-model="financial.liabilities" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="assets_total" class="form-label">Activos totales <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="assets_total" name="assets_total" required />
        <!-- v-model="financial.assets_total" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="liabilities_total" class="form-label">Pasivos totales <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="liabilities_total" name="liabilities_total" required />
        <!-- v-model="financial.liabilities_total" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income" class="form-label">Ingresos <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="income" name="income" required />
        <!-- v-model="financial.income" @blur="formatNumber" -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses" class="form-label">Egresos operacionales <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="expenses" name="expenses" required />
        <!-- v-model="financial.expenses" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income_other" class="form-label">Otros ingresos <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="income_other" name="income_other" required />
        <!-- v-model="financial.income_other" @blur="formatNumber" -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses_other" class="form-label">Otros egresos <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="expenses_other" name="expenses_other" required />
        <!-- v-model="financial.expenses_other" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income_total" class="form-label">Total ingresos <span>*</span></label>
        <input type="number" class="form-control only_numbers" id="income_total" name="income_total" required />
        <!-- v-model="financial.income_total" @blur="formatNumber" -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses_total" class="form-label">Total egresos <span>*</span></label>
        <input type="number" class="form-control only_numbers" id="expenses_total" name="expenses_total" required />
        <!-- v-model="financial.expenses_total" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="utility" class="form-label">Utilidad operacional <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="utility" name="utility" required />
        <!-- v-model="financial.utility" @blur="formatNumber" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="utility_total" class="form-label">Utilidad neta antes de impuestos <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="utility_total" name="utility_total" required />
        <!-- v-model="financial.utility_total" @blur="formatNumber" -->
      </div>
    </div> 

    <div class="col-md-6">
      <div class="mb-3">
        <label for="financial_expenses" class="form-label">Gastos intereses financieros <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="financial_expenses" name="financial_expenses" required />
        <!-- v-model="financial.financial_expenses" @blur="formatNumber" -->
      </div>
    </div>  

    <div class="col-md-12">
      <div class="mb-3">
        <label for="income_other_concept" class="form-label">Concepto otros ingresos</label>
        <input type="text" class="form-control" id="income_other_concept" name="income_other_concept" />
        <!-- v-model="financial.income_other_concept" -->
      </div>
    </div>                                                            

    <div class="col-md-4">
      <div class="mb-3">
        <label class="form-label">Documento adjunto estados financieros</label>
        <input type="file" name="eeff" accept="application/pdf, image/png, image/jpeg" class="form-control" />
        <!-- @change="handleFileUpload6('eeff', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <a class="btn bg-blue text-white rounded-0" href="#" target="_blank" style="display: none;" id="downloadEeff">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
      <!-- v-if="financial.eeff" :href="'/storage/'+financial.eeff" -->
    </div>              

    <div class="col-md-3">
      <div class="mb-3">
        <label for="eeff_year" class="form-label">Año de los estados financieros</label>
        <input type="date" class="form-control" id="eeff_year" name="eeff_year" min="2000" max="2100" />
        <!-- v-model="financial.eeff_year" -->
      </div>
    </div>  

  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Operaciones internacionales</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>      

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">¿Realiza operaciones en moneda extranjera? <span>*</span></label>
        <select class="form-control" name="foreign_currency" required>
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
        <!-- v-model="financial.foreign_currency" -->
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="which_foreign_currency" class="form-label">¿Cuál?</label>
        <input type="text" class="form-control" id="which_foreign_currency" name="which_foreign_currency" />
        <!-- v-model="financial.which_foreign_currency" -->
      </div>
    </div> 

    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">¿Posee productos financieros en el exterior y/o cuentas en moneda extranjera? <span>*</span></label>
        <select class="form-control" name="foreign_products" required>
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
        <!-- v-model="financial.foreign_products" -->
      </div>
    </div>   

    <div class="col-md-6">
      <div class="mb-3">
        <label for="which_foreign_products" class="form-label">¿Cuál?</label>
        <input type="text" class="form-control" id="which_foreign_products" name="which_foreign_products" />
        <!-- v-model="financial.which_foreign_products" -->
      </div>
    </div>                         
  </div>    

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Responsabilidades tributarias</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div> 

  <div class="row">
    <div class="col-md-12">
      <div class="mb-3">
        <label for="tax_liabilities" class="form-label"></label>
        <!-- 
        Vue multiselect component - would need to implement separately in plain JS
        <select class="form-control" v-model="financial.tax_liabilities">
          <option value="" disabled selected>Seleccione un estado</option>
          <option v-for="res in dian_responsabilities" :key="res.codigo" :value="res.codigo">{{ res.codigo }} {{ res.nombre }}</option>
        </select>
        
        <Multiselect v-model="financial.tax_liabilities" mode="tags" :options="dian_responsabilities" track-by="nombre" label="nombre" :searchable="true" placeholder="Buscar" :clear-on-select="true" :value="financial.tax_liabilities">
        </Multiselect>
        -->
        <input type="text" class="form-control" id="tax_liabilities" name="tax_liabilities" placeholder="Responsabilidades tributarias" />
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Agente de retencion exento <span>*</span></span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div> 

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label"></label>
        <select class="form-control" name="nontaxable_agent" required>
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
        <!-- v-model="financial.nontaxable_agent" -->
      </div>
    </div>              
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Responsabilidad de ICA</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>       

  <div class="row" id="icaLiabilitiesContainer">
    <!-- Dynamic ICA liabilities would be added here -->
    <!-- 
    Vue template for dynamic ica liabilities:
    <div v-for="(ica_liability, index) in ica_liabilities" :key="index" class="mb-3">
      <div class="row">
        <div class="col-md-3">
          <div class="mb-3">
            <label for="state" class="form-label">Departamento/Estado <span>*</span></label>
            <select class="form-control" v-model="ica_liability.state" :disabled="!supplier.country" required>
              <option value="" disabled selected>Seleccione un estado</option>
              <option v-for="state in getStates()" :key="state.id" :value="state.name">{{ state.name }}</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="city" class="form-label">Ciudad <span>*</span></label>
            <select class="form-control" v-model="ica_liability.city" :disabled="!ica_liability.state">
              <option value="" disabled selected>Seleccione una ciudad</option>
              <option v-for="city in getCities()" :key="city.id" :value="city.name">{{ city.name }}</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Código ICA</label>
            <input type="text" class="form-control" v-model="ica_liability.code" required />
          </div>
        </div>

        <div class="col-md-3">
          <div class="mb-3">
            <label for="fee" class="form-label">Tarifa <span></span></label>
            <input type="number" class="form-control" v-model="ica_liability.fee" required />
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white" @click="removeIcaliability(index)">Eliminar responsabilidad ICA</button>
      <hr />
    </div>
    -->
    
    <div class="col-md-3">
      <button type="button" class="btn btn-secondary mb-3 text-white" id="addIcaLiability">Agregar responsabilidad ICA</button>
      <!-- @click="addIcaliability" -->
    </div>
  </div>   

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Ley o Régimen Tributario Especial</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div> 

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label"></label>
        <select class="form-control" name="tax_regime">
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        <!-- v-model="financial.tax_regime" -->
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Declaración de renta</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div> 

  <div class="row">
    <div class="col-md-3">
      <div class="mb-3">
        <label for="tax_declaration_year" class="form-label">Año de la declaración de renta</label>
        <input type="date" class="form-control" id="tax_declaration_year" name="tax_declaration_year" min="2000" max="2100" />
        <!-- v-model="financial.tax_declaration_year" -->
      </div>
    </div> 

    <div class="col-md-4">
      <div class="mb-3">
        <label class="form-label">Declaración de renta</label>
        <input type="file" name="tax_declaration" accept="application/pdf, image/png, image/jpeg" class="form-control" />
        <!-- @change="handleFileUpload6('tax_declaration', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <a class="btn bg-blue text-white rounded-0" href="#" target="_blank" style="display: none;" id="downloadTaxDeclaration">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
      <!-- v-if="financial.tax_declaration" :href="'/storage/'+financial.tax_declaration" -->
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">Guardar Información Financiera</button>
    <!-- Original: @submit.prevent="submitFinancialInfo" -->
  </div>
</form>

<script>
// Basic implementation for dynamic ICA liabilities
document.getElementById('addIcaLiability').addEventListener('click', function() {
  const container = document.getElementById('icaLiabilitiesContainer');
  const newIndex = document.querySelectorAll('.ica-liability').length;
  
  const liabilityDiv = document.createElement('div');
  liabilityDiv.className = 'ica-liability mb-3';
  liabilityDiv.innerHTML = `
    <div class="row">
      <div class="col-md-3">
        <div class="mb-3">
          <label for="state_${newIndex}" class="form-label">Departamento/Estado <span>*</span></label>
          <select class="form-control" name="ica_liabilities[${newIndex}][state]" required>
            <option value="" disabled selected>Seleccione un estado</option>
            <!-- States would need to be populated via AJAX or server-side -->
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="mb-3">
          <label for="city_${newIndex}" class="form-label">Ciudad <span>*</span></label>
          <select class="form-control" name="ica_liabilities[${newIndex}][city]" disabled required>
            <option value="" disabled selected>Seleccione una ciudad</option>
            <!-- Cities would need to be populated via AJAX based on state selection -->
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="mb-3">
          <label for="code_${newIndex}" class="form-label">Código ICA</label>
          <input type="text" class="form-control" name="ica_liabilities[${newIndex}][code]" required />
        </div>
      </div>

      <div class="col-md-3">
        <div class="mb-3">
          <label for="fee_${newIndex}" class="form-label">Tarifa <span></span></label>
          <input type="number" class="form-control only_numbers" name="ica_liabilities[${newIndex}][fee]" required />
        </div>
      </div>
    </div>

    <button type="button" class="btn btn-danger mb-3 text-white remove-ica-liability">Eliminar responsabilidad ICA</button>
    <hr />
  `;
  
  // Insert before the "Add" button
  container.insertBefore(liabilityDiv, this.parentNode);
  
  // Add event listener for the remove button
  liabilityDiv.querySelector('.remove-ica-liability').addEventListener('click', function() {
    liabilityDiv.remove();
  });
});

// Basic form submission handler
document.getElementById('financialForm').addEventListener('submit', function(e) {
  e.preventDefault();
  // Form submission logic would go here
  console.log('Form submitted - implement AJAX or regular form submission');
  // Original Vue method: submitFinancialInfo()
});

// Note: For a complete implementation you would need to:
// 1. Handle file uploads properly
// 2. Implement the multiselect functionality
// 3. Add dynamic state/city loading
// 4. Add number formatting on blur
// 5. Add validation
</script>