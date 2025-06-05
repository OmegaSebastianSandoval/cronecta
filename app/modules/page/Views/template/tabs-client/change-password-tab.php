        <form id="change_passwordForm" class="row" method="post" action="/page/profile/change_password">
          <div class="col-md-6 form-group">
            <label for="password">Nueva Contraseña</label>
            <div class="input-wrapper position-relative w-100">
              <input type="password" id="password" name="password"
                class="form-control toggle-password" />
            </div>
            <div class="password-eye"><i class="far fa-eye"></i></div>
            <small class="error-msg text-danger "></small>
          </div>

          <div class="col-md-6 form-group">
            <label for="confirmPassword">Confirmar Nueva Contraseña</label>
            <div class="input-wrapper position-relative w-100">
              <input type="password" id="confirmPassword"
                name="confirmPassword" class="form-control toggle-password" />
            </div>
            <div class="password-eye"><i class="far fa-eye"></i></div>
            <small class="error-msg text-danger "></small>
          </div>

          <div class="form-group form-submit mt-4 wk-right">
            <button type="submit" class="bg-orange text-white px-4 py-2">
              Actualizar Contraseña
            </button>
          </div>
        </form>

<style>
  .password-eye {
    right: 20px;
    top: 31px;
  }
</style>