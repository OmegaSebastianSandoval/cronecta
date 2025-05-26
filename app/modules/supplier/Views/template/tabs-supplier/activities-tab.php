<div class="row">
  <div class="col-12">
    <div class="interests-bx1">
      <div class="col-12">
        <span class="text-lg font-medium text-slate-600">Tus intereses:</span>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div class="col-12">
      <div class="d-flex justify-content-center">
        <div class="col-md-6">
          <!-- Boton de buscar -->

          <form action="/supplier/profile/additem" method="post">

            <div class="row my-3">
              <div class="col-lg-1 d-none">
                <button class="input-group-text" id="basic-addon1">
                  <i class="fas fa-search"></i>
                </button>
              </div>
              <div class="col-lg-8">
                <select class="form-control select2" name="buscador" id="buscador" placeholder="Buscar" required>
                  <option value="">Buscar</option>
                </select>
              </div>
              <div class="col-lg-1">
                <button type="submit" class="btn btn-primary">Agregar</button>
              </div>

            </div>

          </form>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 mt-5">

    <div class="caja_azul">

      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Sector</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#industry_modal"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
      </div>


    </div>

    <div class="caja_gris">
      <?php foreach ($this->selectedSectors as $interest) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
          <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>

  </div>

  <div class="col-md-12">

    <div class="caja_azul">

      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Segmentos</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#segment_modal"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
      </div>


    </div>

    <div class="caja_gris">
      <?php foreach ($this->selectedSegment as $interest) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
          <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>
  </div>

  <div class="col-md-12">

    <div class="caja_azul">

      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Familia</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#family_modal"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
      </div>


    </div>

    <div class="caja_gris">
      <?php foreach ($this->selectedFamily as $interest) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
          <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>

  </div>

  <div class="col-md-12">

    <div class="caja_azul">

      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Clase</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#class_modal"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
      </div>


    </div>

    <div class="caja_gris">
      <?php foreach ($this->selectedClass as $interest) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
          <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>

  </div>


  <div class="col-md-12">

    <div class="caja_azul">

      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Producto</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#product_modal"><i class="fa-solid fa-pen-to-square"></i></button>
        </div>
      </div>

    </div>

    <div class="caja_gris">
      <?php foreach ($this->selectedProduct as $interest) { ?>
        <span
          class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
          <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
        </span>
      <?php } ?>
    </div>

  </div>


</div>


<!-- MODALS -->
<div class="modal fade" id="industry_modal" tabindex="-1" role="dialog" aria-labelledby="industry_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">

        <div class="text-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar sectores de interes</h2>
        </div>

        <div class="caja_gris">
          <div class="row mt-2">
            <?php foreach ($this->sectors as $key => $sector) { ?>
              <div class="col-lg-4 mb-4">
                <label><input class="form-check-input" type="checkbox" id="sector<?php echo $key; ?>" value="<?php echo $sector->id; ?>_<?php echo $sector->name; ?>"> <?php echo $sector->name; ?></label>
              </div>
            <?php } ?>
          </div>

          <div align="center" class="mt-5 mb-2">
            <button type="button" class="btn btn-primary" onclick="add_sector();">Agregar</button>
          </div>

        </div>


        <div class="caja_azul mt-3">
          <h2 class="form-label">Sectores seleccionados</h2>
        </div>

        <div class="caja_gris min60">
          <div id="div_industrias" class="mt-2">
            <?php foreach ($this->selectedSectors as $interest) { ?>
              <div class="interest1 badge rounded-pill interest1 text-dark border-info">
                <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
              </div>
            <?php } ?>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="segment_modal" tabindex="-1" role="dialog" aria-labelledby="segment_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar segmentos de interes</h2>
        </div>

        <div class="caja_gris">

          <div class="input-group my-3">
            <button class="input-group-text" onclick="buscar_segmento();"><i class="fas fa-search"></i></button><input type="text" class="form-control py-2" placeholder="Buscar" id="input_segmento" onkeyup="buscar_segmento();">
          </div>

          <div class="row mt-2" id="seccion_segmento">

            <?php foreach ($this->segments_filtro as $key => $segment) { ?>
              <div class="col-lg-6 mb-4">
                <label><input class="form-check-input" type="checkbox" id="segment<?php echo $key; ?>" value="<?php echo $segment->segment_code; ?>_<?php echo $segment->segment_name; ?>"> <?php echo $segment->segment_name; ?></label>
              </div>
            <?php } ?>
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" onclick="add_segment();">Agregar</button>
          </div>


        </div>


        <div class="caja_azul mt-3">
          <h2 class="form-label">Segmentos seleccionados</h2>
        </div>
        <div class="caja_gris min60">


          <div id="div_segmentos" class="mt-2">
            <?php foreach ($this->selectedSegment as $interest) { ?>
              <div class="interest1 badge rounded-pill interest1 text-dark border-info interest<?php echo $interest->id; ?>">
                <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
              </div>
            <?php } ?>
          </div>

        </div>




      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="family_modal" tabindex="-1" role="dialog" aria-labelledby="family_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar familia de interes</h2>
        </div>

        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" onclick="buscar_familia()"><i class="fas fa-search"></i></button><input type="text" class="form-control py-2" placeholder="Buscar" id="input_familia" onkeyup="buscar_familia()">
          </div>

          <div class="row mt-2" id="seccion_familia">

            <?php foreach ($this->family_filtro as $key => $family) { ?>
              <div class="col-lg-6 mb-4">
                <label><input class="form-check-input" type="checkbox" id="family<?php echo $key; ?>" value="<?php echo $family->family_code; ?>_<?php echo $family->family_name; ?>"> <?php echo $family->family_name; ?></label>
              </div>
            <?php } ?>

          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" onclick="add_family()">Agregar</button>
          </div>

        </div>


        <div class="caja_azul mt-3">
          <h2 class="form-label">Familias seleccionadas</h2>
        </div>
        <div class="caja_gris min60">
          <div id="div_familias" class="mt-2">
            <?php foreach ($this->selectedFamily as $interest) { ?>
              <span
                class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
                <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
              </span>
            <?php } ?>
          </div>
        </div>



      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="class_modal" tabindex="-1" role="dialog" aria-labelledby="class_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar clase de interes</h2>
        </div>

        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" onclick="buscar_clase()"><i class="fas fa-search"></i></button><input type="text" class="form-control py-2" placeholder="Buscar" id="input_clase" onkeyup="buscar_clase()">
          </div>

          <div class="row mt-2" id="seccion_clase">

            <?php foreach ($this->class_filtro as $key => $class1) { ?>
              <div class="col-lg-6 mb-4">
                <label><input class="form-check-input" type="checkbox" id="class<?php echo $key; ?>" value="<?php echo $class1->class_code; ?>_<?php echo $class1->class_name; ?>"> <?php echo $class1->class_name; ?></label>
              </div>
            <?php } ?>
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" onclick="add_class()">Agregar</button>
          </div>
        </div>




        <div class="caja_azul mt-3">
          <h2 class="form-label">Clases seleccionadas</h2>
        </div>
        <div class="caja_gris min60">

          <div id="div_familias" class="mt-2">
            <?php foreach ($this->selectedClass as $interest) { ?>
              <span
                class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
                <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
              </span>
            <?php } ?>
          </div>

        </div>



      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="product_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar producto de interes</h2>
        </div>
        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" onclick="buscar_producto()"><i class="fas fa-search"></i></button><input type="text" class="form-control py-2" placeholder="Buscar" id="input_producto" onkeyup="buscar_producto()">
          </div>

          <div class="row mt-2" id="seccion_producto">

            <?php foreach ($this->product_filtro as $key => $product) { ?>
              <div class="col-lg-6 mb-4">
                <label><input class="form-check-input" type="checkbox" id="product<?php echo $key; ?>" value="<?php echo $product->product_code; ?>_<?php echo $product->product_name; ?>"> <?php echo $product->product_name; ?></label>
              </div>
            <?php } ?>

          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" onclick="add_product()">Agregar</button>
          </div>
        </div>
        <div class="caja_azul mt-3">
          <h2 class="form-label">Productos seleccionados</h2>
        </div>
        <div class="caja_gris min60">
          <div id="div_productos" class="mt-2">
            <?php foreach ($this->selectedProduct as $interest) { ?>
              <span
                class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest<?php echo $interest->id; ?>">
                <?php echo $interest->name; ?> <i class="fa fa-times" onclick="removeInterest('<?php echo $interest->id; ?>')"></i>
              </span>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  function add_sector() {
    var sectores = '';
    var valor = '';
    <?php foreach ($this->sectors as $key => $sector) { ?>
      if ($("#sector<?php echo $key; ?>").is(':checked')) {
        valor = $("#sector<?php echo $key; ?>").val();
        if (valor != "") {
          sectores += valor + ',';
        }
      }
    <?php } ?>

    $.post("/supplier/profile/addinterest/", {
      "valores": sectores,
      "nivel": 1,
      "supplier_id": '<?php echo $_SESSION['supplier']->id; ?>'
    }, function(res) {
      window.location = "/supplier/profile/?tab=11";
    });

  }

  function add_segment() {
    var segmentos = '';
    var valor = '';
    <?php foreach ($this->segments_filtro as $key => $sector) { ?>
      if ($("#segment<?php echo $key; ?>").is(':checked')) {
        valor = $("#segment<?php echo $key; ?>").val();
        if (valor != "") {
          segmentos += valor + ',';
        }
      }
    <?php } ?>

    $.post("/supplier/profile/addinterest/", {
      "valores": segmentos,
      "nivel": 2,
      "supplier_id": '<?php echo $_SESSION['supplier']->id; ?>'
    }, function(res) {
      window.location = "/supplier/profile/?tab=11";
    });

  }

  function add_family() {
    var familias = '';
    var valor = '';
    <?php foreach ($this->family_filtro as $key => $sector) { ?>
      if ($("#family<?php echo $key; ?>").is(':checked')) {
        valor = $("#family<?php echo $key; ?>").val();
        if (valor != "") {
          familias += valor + ',';
        }
      }
    <?php } ?>

    $.post("/supplier/profile/addinterest/", {
      "valores": familias,
      "nivel": 3,
      "supplier_id": '<?php echo $_SESSION['supplier']->id; ?>'
    }, function(res) {
      window.location = "/supplier/profile/?tab=11";
    });

  }

  function add_class() {
    var clases = '';
    var valor = '';
    <?php foreach ($this->class_filtro as $key => $sector) { ?>
      if ($("#class<?php echo $key; ?>").is(':checked')) {
        valor = $("#class<?php echo $key; ?>").val();
        if (valor != "") {
          clases += valor + ',';
        }
      }
    <?php } ?>

    $.post("/supplier/profile/addinterest/", {
      "valores": clases,
      "nivel": 4,
      "supplier_id": '<?php echo $_SESSION['supplier']->id; ?>'
    }, function(res) {
      window.location = "/supplier/profile/?tab=11";
    });

  }

  function add_product() {
    var productos = '';
    var valor = '';
    <?php foreach ($this->product_filtro as $key => $sector) { ?>
      if ($("#product<?php echo $key; ?>").is(':checked')) {
        valor = $("#product<?php echo $key; ?>").val();
        if (valor != "") {
          productos += valor + ',';
        }
      }
    <?php } ?>

    $.post("/supplier/profile/addinterest/", {
      "valores": productos,
      "nivel": 5,
      "supplier_id": '<?php echo $_SESSION['supplier']->id; ?>'
    }, function(res) {
      window.location = "/supplier/profile/?tab=11";
    });

  }

  function removeInterest(id) {
    $.post("/supplier/profile/removeinterest/", {
      "id": id
    }, function(res) {

    });
    if (id != "") {
      $(".interest" + id).hide();
    }

  }


  function buscar_segmento() {
    var input, filter, section, div, h1, i;
    input = document.getElementById("input_segmento");
    filter = input.value.toUpperCase();
    filter = normalizar(filter);
    section = document.getElementById("seccion_segmento");
    div = section.getElementsByTagName("div");



    for (i = 0; i < div.length; i++) {
      h1 = div[i].getElementsByTagName("label")[0];
      if (h1) {
        var palabrasEnFiltro = filter.split(' ');
        var hallado = 0;
        for (var filtro of palabrasEnFiltro) {
          var aux = h1.innerHTML.toUpperCase();
          aux = normalizar(aux);
          if (aux.indexOf(filtro) > -1) {
            hallado++;
          }
        }

        if (hallado === palabrasEnFiltro.length) {
          div[i].style.display = "";
        } else {
          div[i].style.display = "none";
        }

      }
    }

  }

  function buscar_familia() {
    var input, filter, section, div, h1, i;
    input = document.getElementById("input_familia");
    filter = input.value.toUpperCase();
    filter = normalizar(filter);
    section = document.getElementById("seccion_familia");
    div = section.getElementsByTagName("div");



    for (i = 0; i < div.length; i++) {
      h1 = div[i].getElementsByTagName("label")[0];
      if (h1) {
        var palabrasEnFiltro = filter.split(' ');
        var hallado = 0;
        for (var filtro of palabrasEnFiltro) {
          var aux = h1.innerHTML.toUpperCase();
          aux = normalizar(aux);
          if (aux.indexOf(filtro) > -1) {
            hallado++;
          }
        }

        if (hallado === palabrasEnFiltro.length) {
          div[i].style.display = "";
        } else {
          div[i].style.display = "none";
        }

      }
    }

  }

  function buscar_clase() {
    var input, filter, section, div, h1, i;
    input = document.getElementById("input_clase");
    filter = input.value.toUpperCase();
    filter = normalizar(filter);
    section = document.getElementById("seccion_clase");
    div = section.getElementsByTagName("div");



    for (i = 0; i < div.length; i++) {
      h1 = div[i].getElementsByTagName("label")[0];
      if (h1) {
        var palabrasEnFiltro = filter.split(' ');
        var hallado = 0;
        for (var filtro of palabrasEnFiltro) {
          var aux = h1.innerHTML.toUpperCase();
          aux = normalizar(aux);
          if (aux.indexOf(filtro) > -1) {
            hallado++;
          }
        }

        if (hallado === palabrasEnFiltro.length) {
          div[i].style.display = "";
        } else {
          div[i].style.display = "none";
        }

      }
    }

  }

  function buscar_producto() {
    var input, filter, section, div, h1, i;
    input = document.getElementById("input_producto");
    filter = input.value.toUpperCase();
    filter = normalizar(filter);
    section = document.getElementById("seccion_producto");
    div = section.getElementsByTagName("div");



    for (i = 0; i < div.length; i++) {
      h1 = div[i].getElementsByTagName("label")[0];
      if (h1) {
        var palabrasEnFiltro = filter.split(' ');
        var hallado = 0;
        for (var filtro of palabrasEnFiltro) {
          var aux = h1.innerHTML.toUpperCase();
          aux = normalizar(aux);
          if (aux.indexOf(filtro) > -1) {
            hallado++;
          }
        }

        if (hallado === palabrasEnFiltro.length) {
          div[i].style.display = "";
        } else {
          div[i].style.display = "none";
        }

      }
    }

  }

  function normalizar(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
  }

  $(document).ready(function() {
    $('#buscador').select2({
      placeholder: 'Buscar',
      allowClear: true,
      minimumInputLength: 2,
      ajax: {
        url: '/supplier/profile/searchItems',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term
          };
        },
        processResults: function(data) {
          return {
            results: data.results
          };
        },
        cache: true
      }
    });
  });
</script>


<style>
  .interests-bx {
    padding: 15px;
    border: 1px solid #20469730;
    border-radius: 5px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
  }

  .interest {
    background-color: #20469730;
    color: #204697;
    border: 1px solid #204697;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: 300ms ease;
  }

  .interest i:hover {
    color: red;
    cursor: pointer;
    transition: 300ms ease;
  }


  .form-select option {
    padding: 10px 10px;
  }

  .btn-orange {
    color: #f77904;
    color: #FFFFFF;
    margin-top: -1px;
  }

  .btn-orange i {
    font-size: 20px;
  }

  .btn-primary {
    background: #23366c;
    color: #FFFFFF;
  }

  .form-check-input {
    margin-top: 0px;
  }

  .border-info {
    --bs-border-opacity: 1;
    /*border-color: rgba(var(--bs-info-rgb),var(--bs-border-opacity)) !important;*/
    border: solid 2px;
    margin-right: 5px;
  }

  .top4 {
    top: 4px !important;
  }

  .ancho100 {
    max-width: 97%;
  }

  .interest1 {
    background-color: #20469730 !important;
    color: #204697 !important;
    border: 1px solid #204697 !important;
  }

  .interest1 i {
    vertical-align: text-bottom;
    font-size: 14px;
  }

  .swal2-confirm,
  .swal2-deny,
  .swal2-cancel {
    color: #FFFFFF !important;
  }

  .caja_azul {
    border: 1px solid #f77904;
    background: #f77904;
    color: #FFFFFF;
    padding: 0px 10px;
    height: 33px;
  }

  .caja_azul .form-label {
    color: #FFFFFF;
    margin-top: 3px;
  }

  .caja_gris {
    border: 1px solid #e2e8f0;
    /*gris*/
    padding: 5px 10px;
    margin-bottom: 20px;
    min-height: 46px;
    padding-top: 10px;
    color: #575555;
  }

  .min60 {
    min-height: 60px;
  }

  .cv-modal .modal-content .modal-body .btn-close {
    top: 20px;
  }

  .form-check-input {
    margin-top: 4px;
  }
</style>