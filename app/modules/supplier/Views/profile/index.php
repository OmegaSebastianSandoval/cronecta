<script>
  const countriesData = <?= json_encode($this->list_country) ?>;
</script>
<div class="container-fluid">
  <div class="section-title">
    <h5>
      <i class="fa-regular fa-address-card"></i>
      Tu perfil
    </h5>
  </div>
  <div class="position-relative">
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
          class="nav-link active"
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
          class="nav-link"
          id="pills-empresa-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-empresa"
          type="button"
          role="tab"
          aria-controls="pills-empresa"
          aria-selected="false">
          Información de la empresa
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
          Industrias y segmentos
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
          Certificados, accionistas y representación legal
        </button>
      </li>

      <!-- <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-certificados-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-certificados"
          type="button"
          role="tab"
          aria-controls="pills-certificados"
          aria-selected="false">
          Certificados y documentos legales
        </button>
      </li> -->

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-sedes-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-sedes"
          type="button"
          role="tab"
          aria-controls="pills-sedes"
          aria-selected="false">
          Sedes y cobertura geográfica
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-experiencia-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-experiencia"
          type="button"
          role="tab"
          aria-controls="pills-experiencia"
          aria-selected="false">
          Experiencia comercial
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-bancaria-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-bancaria"
          type="button"
          role="tab"
          aria-controls="pills-bancaria"
          aria-selected="false">
          Información bancaria
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-financiera-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-financiera"
          type="button"
          role="tab"
          aria-controls="pills-financiera"
          aria-selected="false">
          Información financiera y tributaria
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-certificaciones-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-certificaciones"
          type="button"
          role="tab"
          aria-controls="pills-certificaciones"
          aria-selected="false">
          Certificaciones
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-sgsst-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-sgsst"
          type="button"
          role="tab"
          aria-controls="pills-sgsst"
          aria-selected="false">
          SG-SST / Accidentalidad
        </button>
      </li>

      <!-- <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-accionistas-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-accionistas"
          type="button"
          role="tab"
          aria-controls="pills-accionistas"
          aria-selected="false">
          Accionistas y participación accionaria
        </button>
      </li>
 -->
      <li class="nav-item d-none" role="presentation">
        <button
          class="nav-link"
          id="pills-documentacion-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-documentacion"
          type="button"
          role="tab"
          aria-controls="pills-documentacion"
          aria-selected="false">
          Documentación
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-actividades-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-actividades"
          type="button"
          role="tab"
          aria-controls="pills-actividades"
          aria-selected="false">
          Mis actividades económicas
        </button>
      </li>
    </ul>
    <div class="tab-content p-4" id="pills-tabContent">
      <div
        class="tab-pane fade show active"
        id="pills-general"
        role="tabpanel"
        aria-labelledby="pills-general-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/information-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-empresa"
        role="tabpanel"
        aria-labelledby="pills-empresa-tab"
        tabindex="0">
<script src="/skins/supplier/js/tabs/information-company-tab.js"></script>

        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/information-company-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-industrias"
        role="tabpanel"
        aria-labelledby="pills-industrias-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/segments-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-representante"
        role="tabpanel"
        aria-labelledby="pills-representante-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/certificates-shareholders-legalrepresentative-tab.php'); ?>
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
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/sedes-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-experiencia"
        role="tabpanel"
        aria-labelledby="pills-experiencia-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/commercial-experience-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-bancaria"
        role="tabpanel"
        aria-labelledby="pills-bancaria-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/bank-info-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-financiera"
        role="tabpanel"
        aria-labelledby="pills-financiera-tab"
        tabindex="0">
          <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/financial-and-tax-information-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-certificaciones"
        role="tabpanel"
        aria-labelledby="pills-certificaciones-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/certificates-tab.php'); ?>
      </div>

      <div
        class="tab-pane fade"
        id="pills-sgsst"
        role="tabpanel"
        aria-labelledby="pills-sgsst-tab"
        tabindex="0">
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/sgsst-tab.php'); ?>
      </div>

      <!--  <div
        class="tab-pane fade"
        id="pills-accionistas"
        role="tabpanel"
        aria-labelledby="pills-accionistas-tab"
        tabindex="0">
        Contenido: Accionistas y participación accionaria
      </div> -->

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
        <?php echo $this->getRoutPHP('modules/supplier/Views/template/tabs-supplier/activities-tab.php'); ?>
      </div>
    </div>


  </div>
</div>

<style>
  /* Opcional: oculta la barra nativa en WebKit */
  #div_scroll::-webkit-scrollbar {
    display: none;
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
    nav.addEventListener('wheel', (e) => {
      if (e.deltaY !== 0) {
        e.preventDefault();
        nav.scrollBy({
          left: e.deltaY * 5,
          behavior: 'smooth'
        });
      }
    }, {
      passive: false
    });
    // Init
    updateButtons();
  });
</script>