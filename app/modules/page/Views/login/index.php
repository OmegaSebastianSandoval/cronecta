<div class="container h-100 d-flex justify-content-center align-items-center flex-column">
  <div class="row w-100">
    <div class="col-12 col-md-12    mx-auto">
      <div class="row m-0">
        <div class="col-md-6 col-lg-5 d-flex flex-column justify-content-center align-items-center mt-3">
          <div class="login-title">
            <span class="text-thin">
              Módulo
            </span>
            <span class="text-bold">
              COMPRADORES
            </span>
            <span class="text-normal">
              BIENVENIDOS
            </span>
            <span class="text-thin-gray">
              Iniciar sesión
            </span>
          </div>
          <form class="login-form" action="/page/login/verify" method="post" id="supplierLoginForm">

            <div class="form-group mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
            </div>

            <div class="form-group mb-3 position-relative">
              <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
              <div class="password-eye"><i class="far fa-eye"></i></div>
            </div>

            <div class=" mb-3">
              <div class="g-recaptcha w-100 mt-3 d-flex justify-content-center" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>
            </div>

            <div class=" mb-3">
              <div class="form-check d-flex align-items-center"><input type="checkbox" class="form-check-input checkbox" id="rememberMe" name="remember-me"><label class="form-check-label pt-1 ms-2" for="rememberMe">Mantener mi sesion abierta</label></div>
            </div>
            <div class="col-12 d-flex justify-content-center mb-2"></div>

            <button type="submit" class="btn-blue " id="btnSubmitLogin"> Ingresar </button>

            <div class=" text-center mt-2"><a href="/page/register" class="login-link"> Registrarse </a>
            </div>
          </form>
          <div class="form-bx">

          </div>
        </div>
        <div class="col-md-6 col-log-7 d-flex justify-content-center align-items-center illustration-login d-none d-md-flex">
          <img src="/assets/undraw_web_search_re_efla.svg.svg" alt="Illustration" class="ilustacion-login" />
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/skins/page/js/login.js"></script>


<style>
  body.swal2-height-auto {
    height: 100% !important;
  }
</style>