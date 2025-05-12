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
      const maxChars = 700;

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
    },
  });

  $(".selec-multiple").select2({
    tags: true,
    placeholder: "Seleccione uno o más segmentos",
  });
});
