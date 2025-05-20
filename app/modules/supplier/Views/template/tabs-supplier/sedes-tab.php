<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="locations-form" class="supplier-register-form form-bx">
  <!-- Vue: @submit.prevent="submitLocations" -->

  <!-- Vue: v-if="esPruebas" -->
  <div class="text-end mb-2" style="display: none;" id="section-progress-location">
    Haz completado el <span class="completitud" id="completitud9">-%</span> de esta sección
  </div>

  <!-- Contenedor donde se renderizarán las sedes con JS -->
  <div id="locations-container">
    <!-- Este bloque debe clonarse dinámicamente con JS por cada sede -->
    <!-- Vue: v-for="(location, index) in locations" :key="index" -->
    <div class="location-item mb-3">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label class="form-label">Nombre de la sede <span>*</span></label>
            <input type="text" class="form-control" name="location_name[]" required />
            <!-- Vue: v-model="location.name" -->
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label class="form-label">Dirección <span>*</span></label>
            <input type="text" class="form-control" name="location_address[]" required />
            <!-- Vue: v-model="location.address" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label class="form-label">Teléfono <span>*</span></label>
            <input type="text" class="form-control" name="location_mobile_phone[]" required />
            <!-- Vue: v-model="location.mobile_phone" -->
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="mb-3">
            <label class="form-label">País<span>*</span></label>
            <select class="form-control" name="location_country[]" required disabled>
              <option value="" disabled selected>Seleccione un país</option>
              <!-- Vue: v-for="state in getStates()" -->
              <!-- <option :value="state.name">{{ state.name }}</option> -->
            </select>
            <!-- Vue: v-model="location.state" :disabled="!supplier.country" -->
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="mb-3">
            <label class="form-label">Departamento/Estado <span>*</span></label>
            <select class="form-control" name="location_state[]" required disabled>
              <option value="" disabled selected>Seleccione un estado</option>
              <!-- Vue: v-for="state in getStates()" -->
              <!-- <option :value="state.name">{{ state.name }}</option> -->
            </select>
            <!-- Vue: v-model="location.state" :disabled="!supplier.country" -->
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="mb-3">
            <label class="form-label">Ciudad <span>*</span></label>
            <select class="form-control" name="location_city[]" required disabled>
              <option value="" disabled selected>Seleccione una ciudad</option>
              <!-- Vue: v-for="city in getCities_exp(supplier.country,location.state)" -->
              <!-- <option :value="city.name">{{ city.name }}</option> -->
            </select>
            <!-- Vue: v-model="location.city" :disabled="!location.state" -->
          </div>
        </div>



        <div class="col-12 col-md-2 d-none">
          <div class="mb-3">
            <label class="form-label"></label><br />
            <button class="btn bg-blue text-white mt-2" type="button">
              Editar Cobertura
            </button>
            <!-- Vue: @click.prevent="openModal(index)" -->
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 py-3 pt-4">
      <div class="row align-items-center">
        <div class="col-4 pe-0">
          <span class="text-lg text-slate-800 font-medium">Cobertura Georgráfica</span>
        </div>
        <div class="col-8">
          <hr>
        </div>
      </div>
    </div>


    <button type="button" class="btn btn-danger mb-3 text-white remove-location">
      Eliminar Sede
      <!-- Vue: @click="removeLocation(index)" -->
    </button>
    <hr />
  </div>


  <button type="button" class="btn btn-secondary mb-3 text-white" id="add-location-btn">
    Agregar Sede
    <!-- Vue: @click="addLocation" -->
  </button>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar Sedes
    </button>
  </div>
</form>