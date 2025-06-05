<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.css">

<script>
  window.countriesData = <?= json_encode($this->list_country) ?>;
</script>
<script>
  const industriesList = <?= json_encode($this->list_industry) ?>;
</script>
<script src="/skins/page/js/profile-form-validations.js"></script>


<script>
  const decodeHtml = (html) => {
    const txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
  };
  const selectedCountry = decodeHtml("<?= $this->content->country ?>");
  const selectedState = decodeHtml("<?= $this->content->state ?>");
  const selectedCity = decodeHtml("<?= $this->content->city ?>");
  const selectedCountry2 = decodeHtml("<?= $this->content->company_country ?>");
  const selectedState2 = decodeHtml("<?= $this->content->company_state ?>");
  const selectedCity2 = decodeHtml("<?= $this->content->company_city ?>");  
</script>


<div class="container-fluid">
  <div class="section-title">
    <h5>
      <i class="fa-regular fa-address-card"></i>
      Tu perfil
    </h5>
  </div>
  <div class="position-relative">

    <div class="pestanas">
      <!-- Botón scroll anterior -->
      <button
        id="scroll-prev"
        class="btn btn-sm btn-secondary position-absolute start-0  opacity-100 z-10 ms-1"
        type="button"
        aria-label="Anterior pestañas">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Botón scroll siguiente -->
      <button
        id="scroll-next"
        class="btn btn-sm btn-secondary position-absolute end-0 opacity-100 z-10 me-1"
        type="button"
        aria-label="Siguientes pestañas">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <!-- Contenedor scrollable con todas las pestañas -->
      <ul
        id="div_scroll"
        class="nav pills-supplier nav-pills flex-nowrap overflow-auto"
        style="scroll-behavior: smooth;"
        role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link <?php if($_GET['tab']==""){ echo 'active'; }?>"
            id="pills-general-tab"
            data-bs-toggle="pill"
            data-bs-target="#pills-general"
            type="button"
            role="tab"
            aria-controls="pills-general"
            aria-selected="true">
            Información de general
          </button>
        </li>

        <li class="nav-item" role="presentation">
          <button
            class="nav-link <?php if($_GET['tab']==2){ echo 'active'; }?>"
            id="pills-empresa-tab"
            data-bs-toggle="pill"
            data-bs-target="#pills-empresa"
            type="button"
            role="tab"
            aria-controls="pills-empresa"
            aria-selected="false">
            Mis intereses
          </button>
        </li>

        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="pills-industrias-tab"
            data-bs-toggle="pill"
            data-bs-target="#pills-industrias"
            type="button"
            role="tab"
            aria-controls="pills-industrias"
            aria-selected="false">
            Documentación corporativa
          </button>
        </li>

        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="pills-representante-tab"
            data-bs-toggle="pill"
            data-bs-target="#pills-representante"
            type="button"
            role="tab"
            aria-controls="pills-representante"
            aria-selected="false">
            Cambio de contraseña
          </button>
        </li>

      </ul>

    </div>

    <div class="tab-content p-4" id="pills-tabContent">
      <div
        class="tab-pane fade <?php if($_GET['tab']==""){ echo 'show active'; }?>"
        id="pills-general"
        role="tabpanel"
        aria-labelledby="pills-general-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/page/Views/template/tabs-client/information-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade <?php if($_GET['tab']=="2"){ echo 'show active'; }?>"
        id="pills-empresa"
        role="tabpanel"
        aria-labelledby="pills-empresa-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/page/Views/template/tabs-client/interests-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-industrias"
        role="tabpanel"
        aria-labelledby="pills-industrias-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/page/Views/template/tabs-client/documentation-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-representante"
        role="tabpanel"
        aria-labelledby="pills-representante-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/page/Views/template/tabs-client/change-password-tab.php'); ?>
      </div>

     <!--  <div
        class="tab-pane fade"
        id="pills-certificados"
        role="tabpanel"
        aria-labelledby="pills-certificados-tab"
        tabindex="0">
        Contenido: Certificados y documentos legales
      </div> -->

      <div
        class="tab-pane fade"
        id="pills-sedes"
        role="tabpanel"
        aria-labelledby="pills-sedes-tab"
        tabindex="0">
        Contenido: Sedes y cobertura geográfica
      </div>

      <div
        class="tab-pane fade"
        id="pills-experiencia"
        role="tabpanel"
        aria-labelledby="pills-experiencia-tab"
        tabindex="0">
        Contenido: Experiencia comercial
      </div>

      <div
        class="tab-pane fade"
        id="pills-bancaria"
        role="tabpanel"
        aria-labelledby="pills-bancaria-tab"
        tabindex="0">
        Contenido: Información bancaria
      </div>

      <div
        class="tab-pane fade"
        id="pills-financiera"
        role="tabpanel"
        aria-labelledby="pills-financiera-tab"
        tabindex="0">
        Contenido: Información financiera y tributaria
      </div>

      <div
        class="tab-pane fade"
        id="pills-certificaciones"
        role="tabpanel"
        aria-labelledby="pills-certificaciones-tab"
        tabindex="0">
        Contenido: Certificaciones
      </div>

      <div
        class="tab-pane fade"
        id="pills-sgsst"
        role="tabpanel"
        aria-labelledby="pills-sgsst-tab"
        tabindex="0">
        Contenido: SG-SST / Accidentalidad
      </div>

      <div
        class="tab-pane fade"
        id="pills-accionistas"
        role="tabpanel"
        aria-labelledby="pills-accionistas-tab"
        tabindex="0">
        Contenido: Accionistas y participación accionaria
      </div>

      <div
        class="tab-pane fade"
        id="pills-documentacion"
        role="tabpanel"
        aria-labelledby="pills-documentacion-tab"
        tabindex="0">
        Contenido: Documentación
      </div>

      <div
        class="tab-pane fade"
        id="pills-actividades"
        role="tabpanel"
        aria-labelledby="pills-actividades-tab"
        tabindex="0">
        Contenido: Mis actividades económicas
      </div>
    </div>


  </div>
</div>

<style>
  /* Opcional: oculta la barra nativa en WebKit */
  #div_scroll::-webkit-scrollbar {
    display: none;
  }

select[readonly] option, select[readonly] optgroup {
    display: none;
}
select[readonly]{
  pointer-events:none;
}  

input[readonly], select[readonly]{
    background-color: #f1f1f1;  
}

</style>

<script>
  // Plain JS. Si usas Vue, pon esto dentro de `mounted()`.
  document.addEventListener('DOMContentLoaded', () => {
    const nav = document.getElementById('div_scroll');
    const btnPrev = document.getElementById('scroll-prev');
    const btnNext = document.getElementById('scroll-next');
    const scrollAmount = 150; // px por clic

    // Función para desplazar
    const doScroll = (delta) => {
      nav.scrollBy({
        left: delta,
        behavior: 'smooth'
      });
    };

    // Estado habilitado/deshabilitado de flechas
    const updateButtons = () => {
      btnPrev.disabled = nav.scrollLeft <= 0;
      btnNext.disabled = nav.scrollLeft + nav.clientWidth >= nav.scrollWidth;
    };

    // Eventos
    btnPrev.addEventListener('click', () => doScroll(-scrollAmount));
    btnNext.addEventListener('click', () => doScroll(+scrollAmount));
    nav.addEventListener('scroll', updateButtons);

    // Init
    updateButtons();
  });
</script>

