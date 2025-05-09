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
    plugins: [
      "lists",
    ],
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
document.addEventListener("DOMContentLoaded", function () {
  const originalImageSrc = document.getElementById("preview-avatar").src;

  window.previewImage = function (input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById("preview-avatar").src = e.target.result;
        document.getElementById("cancel-btn-container").style.display = "block";
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  window.cancelImage = function () {
    const input = document.getElementById("image");
    input.value = "";
    document.getElementById("preview-avatar").src = originalImageSrc;
    document.getElementById("cancel-btn-container").style.display = "none";
  };
});

document.addEventListener("DOMContentLoaded", function () {
  const nitInput = document.getElementById("identification_nit");
  const nitType = document.getElementById("nit_type");
  const nitError = document.getElementById("nit-error");

  // Activa o desactiva el input según selección
  nitType.addEventListener("change", function () {
    if (this.value) {
      nitInput.disabled = false;
    } else {
      nitInput.disabled = true;
      nitInput.value = "";
      nitError.classList.add("d-none");
      nitError.innerText = "";
    }

    // 👉 Valida solo si ya hay texto escrito
    if (nitInput.value.trim() !== "") {
      validateNIT();
    }
  });

  // Validación reutilizable
  window.validateNIT = function () {
    let value = nitInput.value.replace(/[^0-9-]/g, "");
    nitInput.value = value;

    nitError.classList.add("d-none");
    nitError.innerText = "";

    if (!value) return;

    if (nitType.value === "colombian" && !/^\d+-\d$/.test(value)) {
      nitError.innerText =
        'El NIT de Colombia debe tener el formato "12345678-9".';
      nitError.classList.remove("d-none");
    } else if (nitType.value === "foreign" && !/^\d+$/.test(value)) {
      nitError.innerText = "El NIT extranjero debe contener solo números.";
      nitError.classList.remove("d-none");
    }
  };
});
document.addEventListener("DOMContentLoaded", function () {
  const countrySelect = document.getElementById("country");
  const stateSelect = document.getElementById("state");
  const citySelect = document.getElementById("city");

  const stateWrapper = document.getElementById("state-wrapper");
  const cityWrapper = document.getElementById("city-wrapper");

  countrySelect.addEventListener("change", function () {
    const selectedCountryId = parseInt(this.value);
    const country = countriesData.find((c) => c.id === selectedCountryId);

    // Limpia y oculta selects dependientes
    stateSelect.innerHTML = '<option value="">Seleccione...</option>';
    citySelect.innerHTML = '<option value="">Seleccione...</option>';
    stateWrapper.classList.add("d-none");
    cityWrapper.classList.add("d-none");

    if (country && Array.isArray(country.states)) {
      country.states.forEach((state) => {
        const option = document.createElement("option");
        option.value = state.id;
        option.textContent = state.name;
        stateSelect.appendChild(option);
      });

      stateWrapper.classList.remove("d-none");
    }
  });

  stateSelect.addEventListener("change", function () {
    const selectedCountryId = parseInt(countrySelect.value);
    const selectedStateId = parseInt(this.value);

    const country = countriesData.find((c) => c.id === selectedCountryId);
    const state = country?.states.find((s) => s.id === selectedStateId);

    citySelect.innerHTML = '<option value="">Seleccione...</option>';
    cityWrapper.classList.add("d-none");

    if (state && Array.isArray(state.cities)) {
      state.cities.forEach((city) => {
        const option = document.createElement("option");
        option.value = city.name;
        option.textContent = city.name;
        citySelect.appendChild(option);
      });

      cityWrapper.classList.remove("d-none");
    }
  });
});
