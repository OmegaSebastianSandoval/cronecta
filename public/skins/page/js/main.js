var videos = [];
$(document).ready(function () {
  $('.dropdown-toggle').dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      '900': 3,
      '500': 1
    }
  });

  $('.banner-video-youtube').each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr('data-video');
    const idvideo = $(this).attr('id');
    const playerDefaults = {
      'autoplay': 0,
      'autohide': 1,
      'modestbranding': 0,
      'rel': 0,
      'showinfo': 0,
      'controls': 0,
      'disablekb': 1,
      'enablejsapi': 0,
      'iv_load_policy': 3
    };
    const video = {
      'videoId': datavideo,
      'suggestedQuality': 'hd1080'
    };
    videos[videos.length] = new YT.Player(idvideo, {
      'videoId': datavideo,
      'playerVars': playerDefaults,
      'events': {
        'onReady': onAutoPlay,
        'onStateChange': onFinish
      }
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
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

})



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