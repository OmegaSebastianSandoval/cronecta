<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud3">-%</span> de esta sección</div>
<script>
  window.supplierGroupsFromServer = <?= json_encode($this->segmentsIndustries) ?>;
  window.industriesFromServer = <?= json_encode($this->list_industry) ?>;
</script>
<form action="/supplier/profile/savesegments" method="post" class="supplier-register-form form-bx" id="form-segments">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div id="supplierGroupsContainer">

    <!-- Los grupos de industria/segmentos se agregarán dinámicamente aquí -->
  </div>

  <!-- Botón único para agregar nuevas industrias -->
  <div class="row">
    <div class="col-md-5">
      <button type="button" class="btn bg-slate-900 rounded-0 my-2 text-white add-group">
        Agregar industria <i class="fa-solid fa-circle-plus ms-2"></i>
      </button>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0" id="submitFormSegments">
      Guardar Industrias y segmentos
    </button>
  </div>
</form>


<style>
  .completitud {
    color: rgb(55, 122, 190);
    font-weight: bold;
  }

  /* Estilos para Select2 */
  .select2-container {
    width: 100% !important;
    /* margin-bottom: .5rem !important; */
    font-size: 13px !important;

  }

  .select2-container--default .select2-selection--multiple {
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0.375rem !important;
    font-size: 13px !important;

  }

  .select2-selection--multiple {
    min-height: 38px;
    padding: 5px;
    font-size: 13px !important;

  }

  .select2-container .select2-selection--single {
    height: auto !important;
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0.375rem !important;
    font-size: 13px !important;
    padding: 8px 15px;
  }

  /* Estilos para botones */
  .btn.bg-slate-900 {
    background-color: #1e293b;
    color: white;
  }

  .btn.bg-orange {
    background-color: #f97316;
    color: white;
  }

  .btn.rounded-0 {
    border-radius: 0;
  }

  .select2-container--default .select2-search--inline .select2-search__field {
    line-height: auto !important;
  }

.div_completitud{
  position: sticky;
  right: 0;
  top: 200px;
  z-index: 2;
  background-color: white;
}  
</style>


<script type="text/javascript">
  function completitud3(){
    $.post("/supplier/profile/completitud3/",{ },function(res){
      $("#completitud3").html(res.porcentaje+"%");
      array_completitud[3]=res.porcentaje;
      completeness();
    });
  }
  completitud3();
</script>