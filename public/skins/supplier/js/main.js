var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  $(".file-image").fileinput({
    maxFileSize: 10000,
    previewFileType: "image",
    allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "ico"],
    browseClass: "btn  btn-verde",
    showUpload: false,
    showRemove: false,
    browseIcon: '<i class="fas fa-image"></i> ',
    browseLabel: "Imagen",
    language: "es",
    dropZoneEnabled: false,
  });

  $(".file-document").fileinput({
    maxFileSize: 2048,
    previewFileType: "image",
    browseLabel: "Archivo",
    browseClass: "btn  btn-cafe",
    allowedFileExtensions: ["pdf", "xlsx", "xls", "doc", "docx", "ico"],
    showUpload: false,
    showRemove: false,
    browseIcon: '<i class="fas fa-folder-open"></i> ',
    language: "es",
    dropZoneEnabled: false,
  });


  const maxChars = 700;
  const commercialActivity = document.getElementById('commercial_activity');
  const charCount = document.getElementById('char-count');
  
  // Initial character count on page load
  if (commercialActivity && charCount) {
    const content = commercialActivity.value;
    charCount.innerText = `${content.length}/${maxChars}`;
  }



  tinymce.init({
    selector: "textarea.tinyeditor-simple",
    plugins: ["lists"],
    menubar: false, // 👈 esto oculta el menú superior
    toolbar: "bold italic underline | bullist numlist | removeformat",
    paste_as_text: true, // 👈 fuerza pegar como texto plano
    language: "es",
    browser_spellcheck: true,
    contextmenu: false,
    skin: "oxide-dark",
    content_css: "tinymce-5",
    setup: function (editor) {
      

      editor.on('init', function() {
        const content = editor.getContent({ format: 'text' });
        charCount.innerText = `${content.length}/${maxChars}`;
      });

      editor.on("input", function () {
        const content = editor.getContent({ format: "text" });
        if (content.length > maxChars) {
          editor.setContent(content.substring(0, maxChars)); // corta el texto si se pasa
          alert(`Máximo ${maxChars} caracteres permitidos.`);
        }
        document.getElementById(
          "char-count"
        ).innerText = `${content.length}/${maxChars}`;
      });
      editor.on("change keyup", () => {
        tinymce.triggerSave(); // sincroniza contenido en el <textarea>
        // validateCommercialActivity(false); // re­valida sin pintar errores
        // toggleSubmit(); // y habilita/deshabilita el botón
      });
    },
  });

  $(".selec-multiple").select2({
    width: "100%",
    tags: true,
    placeholder: "Seleccione uno o más segmentos",
  });

  $(".selec-search").select2({
    width: "100%",
    placeholder: "Busca una industria",
    // allowClear: true,
  });
});

/**
 * Muestra una alerta usando SweetAlert2.
 *
 * @param {Object} opts
 * @param {string} [opts.title='']         — Título de la alerta.
 * @param {string} [opts.text='']          — Texto/descrición.
 * @param {('success'|'error'|'warning'|'info'|'question')} [opts.icon='info']
 * @param {boolean} [opts.showCancel=false]        — Mostrar botón de cancelar.
 * @param {string} [opts.confirmButtonText='OK']   — Texto del botón de confirmar.
 * @param {string} [opts.cancelButtonText='Cancelar'] — Texto del botón de cancelar.
 * @param {number|null} [opts.timer=null]           — Auto‐cerrar tras ms (null = no auto).
 * @param {string|null} [opts.redirect=null]        — URL a la que redirigir si confirman.
 * @returns {Promise<SweetAlertResult>}
 */
function showAlert(opts = {}) {
  const {
    title = "",
    text = "",
    icon = "info",
    showCancel = false,
    confirmButtonText = "OK",
    cancelButtonText = "Cancelar",
    confirmButtonColor = "#204697",
    timer = null,
    redirect = null,
    allowOutsideClick = false,
    html = null,
  } = opts;

  return Swal.fire({
    title,
    text,
    icon,
    showCancelButton: showCancel,
    confirmButtonColor: confirmButtonColor,
    cancelButtonText,
    timer,
    allowOutsideClick: allowOutsideClick,
    confirmButtonText,
    html,
    // opcional: estilos, posicion, etc.
    // position: 'top',
    // customClass: { popup: 'my-popup' },
  }).then((result) => {
    if (result.isConfirmed && redirect) {
      window.location = redirect;
    }
    return result;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.getElementById("toggle-btn");
  const sidebar = document.getElementById("sidebar");
  const body = document.body;
  const headerInfoContainer = document.getElementById("header-info-container");

 /*  const mainGeneral = document.getElementById("main-general");
  const footer = document.querySelector("footer"); */
  // console.log(footer);

  function toggleSidebar() {
    sidebar.classList.toggle("close");
    toggleButton.classList.toggle("rotate");
    body.classList.toggle("expanded");
    headerInfoContainer.classList.toggle("expanded");
    /* mainGeneral.classList.toggle("expanded");
    footer.classList.toggle("expanded"); */
    closeAllSubMenus();
  }

  function toggleSubMenu(btn) {
    if (!btn.nextElementSibling.classList.contains("show")) {
      closeAllSubMenus();
    }
    btn.nextElementSibling.classList.toggle("show");
    btn.classList.toggle("rotate");
    if (sidebar.classList.contains("close")) {
      sidebar.classList.toggle("close");
      toggleButton.classList.toggle("rotate");
    }
  }

  function closeAllSubMenus() {
    Array.from(sidebar.querySelectorAll(".sub-menu.show")).forEach((ul) => {
      ul.classList.remove("show");
      ul.previousElementSibling.classList.remove("rotate");
    });
  }

  // Bindear eventos
  toggleButton.addEventListener("click", toggleSidebar);
  sidebar
    .querySelectorAll(".dropdown-btn")
    .forEach((btn) => btn.addEventListener("click", () => toggleSubMenu(btn)));
});
