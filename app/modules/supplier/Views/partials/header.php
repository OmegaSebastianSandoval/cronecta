<nav id="sidebar">
  <ul class="sidebar-menu">

    <?php if (ESPRUEBAS) { ?>
      <li class="<?= $this->botonpanel == 1 ? 'active' : '' ?>">
        <a href="/supplier/dashboard">
          <i class="fa-solid fa-gauge"></i>
          <span>Panel de control</span>
        </a>
      </li>
    <?php } ?>
    <?php if (ESPRUEBAS) { ?>

      <li>
        <button class="dropdown-btn">
          <i class="fa-solid fa-list-check"></i>
          <span>Licitaciones en curso</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
          </svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li class="<?= $this->botonpanel == 2 ? 'active' : '' ?>"><a href="/supplier/requests"><i class="fa-solid fa-address-book"></i>Solicitudes de compra</a></li>
            <li class="<?= $this->botonpanel == 3 ? 'active' : '' ?>"><a href="/supplier/plan"><i class="fa-solid fa-cart-shopping"></i>Planes de compra</a></li>

          </div>
        </ul>
      </li>
    <?php } ?>

    <!-- <li>
      <button onclick=toggleSubMenu(this) class="dropdown-btn">
        <i class="fa-regular fa-address-card"></i>

        <span>Tu perfi</span>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
        </svg>
      </button>
     <ul class="sub-menu">
        <div>
          <li><a href="#">Work</a></li>
          <li><a href="#">Private</a></li>
          <li><a href="#">Coding</a></li>
          <li><a href="#">Gardening</a></li>
          <li><a href="#">School</a></li>
        </div>
      </ul> 
    </li>-->
    <li class="<?= $this->botonpanel == 4 ? 'active' : '' ?>">
      <a href="/supplier/profile">
        <i class="fa-regular fa-address-card"></i>
        <span>Tu perfil</span>
      </a>
    </li>
    <li class="<?= $this->botonpanel == 5 ? 'active' : '' ?>">
      <a href="/supplier/account">
        <i class="fa-solid fa-user"></i>
        <span>Tu cuenta</span>
      </a>
    </li>
    <!-- <li>
      <a href="profile.html">
      
        <span>Profile</span>
      </a>
    </li> -->
  </ul>

  <section class="section-header">
    <div class="position-absolute h-100 d-flex align-items-center start-0 z-10 d-none">
      <button id="toggle-btn">
        <i class="fa-solid fa-bars"></i>
      </button>

    </div>
    <!--  <div class="header-info-container ps-4 <?= $this->userSession ? 'expanded' : '' ?>" id="header-info-container"> -->
    <div class="header-info-container ps-4 <?= $this->userSession ? '' : '' ?>" id="header-info-container">
      <div class="container-fluid d-flex justify-content-end justify-content-md-between align-items-center gap-1 gap-md-5 ">
        <img src="/assets/estrategia-cardinal.png" alt="Logo Cronecta" class="logo-cronecta-small" />
        <h1 class="head-title d-md-block d-none">Proveedores</h1>
        <div class="d-block d-lg-flex gap-2 align-items-center">
          <div class="user-info">
            <span class="capitalize">
              <?= $this->userSession->name . " " . $this->userSession->lastname  ?>
            </span>
            <div class="d-none d-lg-block vr h-50 m-auto"></div>
          </div>
          <div class="capitalize user-info-company">

            <span>
              <?= $this->userSession->supplierSessionInfo->position ?>

            </span>

            <div class="vr h-50 m-auto"></div>

            <span>
              <strong>
                <?= $this->userSession->supplierSessionInfo->company_name ?>
              </strong>
            </span>
          </div>
          <div class="d-none d-lg-block">
            <a class="nav-link" data-toggle="dropdown" href="/supplier/login/logout">
              <i class="fa-solid fa-right-from-bracket"></i>
            </a>
          </div>
        </div>
        <div class="d-block d-lg-none">
          <a class="nav-link" data-toggle="dropdown" href="/supplier/login/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
</nav>