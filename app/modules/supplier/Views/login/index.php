<div class="container h-100 d-flex justify-content-center align-items-center flex-column">
  <div class="row w-100">
    <div class="col-12 col-md-12    mx-auto">
      <div class="row m-0">
        <div class="col-md-5 d-flex flex-column justify-content-center align-items-center">
          <div class="login-title">
            <span class="text-thin">
              Módulo
            </span>
            <span class="text-bold">
              PROVEEDORES
            </span>
            <span class="text-normal">
              BIENVENIDOS
            </span>
            <span class="text-thin-gray">
              Iniciar sesión
            </span>
          </div>
          <form class="login-form">

            <div class="form-group mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
            </div>

            <div class="form-group mb-3 position-relative">
              <input type="password" class="form-control" id="password" name="email" placeholder="Contraseña" required>
              <div class="password-eye"><i class="far fa-eye"></i></div>
            </div>

            <div class=" mb-3">
              <div class="form-check d-flex align-items-center"><input type="checkbox" class="form-check-input checkbox" id="rememberMe"><label class="form-check-label pt-1 ms-2" for="rememberMe">Mantener mi sesion abierta</label></div>
            </div>
            <div class="col-12 d-flex justify-content-center mb-2"></div>

            <button type="submit" class="btn-blue "> Ingresar </button>

            <div class=" text-center mt-2"><a href="/supplier/register" class="login-link"> Registrarse </a>
            </div>
          </form>
          <div class="form-bx">

          </div>
        </div>
        <div class="col-md-7 d-flex justify-content-center align-items-center illustration-login d-none d-md-flex">
          <img src="/assets/undraw_web_search_re_efla2.svg" alt="Illustration"  class="ilustacion-login" />
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const pwdInput = document.getElementById('password');
    const toggle = document.querySelector('.password-eye');
    const icon   = toggle.querySelector('i');

    toggle.addEventListener('click', () => {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        pwdInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  });
</script>