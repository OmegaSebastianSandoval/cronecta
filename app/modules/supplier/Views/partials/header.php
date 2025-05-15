<nav id="sidebar">
  <ul class="sidebar-menu">

    <li class="active">
      <a href="index.html">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
      </a>
    </li>
    <li>
      <a href="dashboard.html">
        <i class="fa-solid fa-gauge"></i>
        <span>Panel de control</span>
      </a>
    </li>
    <li>
      <button onclick=toggleSubMenu(this) class="dropdown-btn">
        <i class="fa-solid fa-list-check"></i>
        <span>Licitaciones en curso</span>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z" />
        </svg>
      </button>
      <ul class="sub-menu">
        <div>
          <li><a href="#"><i class="fa-solid fa-address-book"></i>Solicitudes de compra</a></li>
          <li><a href="#"><i class="fa-solid fa-cart-shopping"></i>Planes de compra</a></li>

        </div>
      </ul>
    </li>
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
    <li>
      <a href="calendar.html">
        <i class="fa-regular fa-address-card"></i>
        <span>Tu perfi</span>
      </a>
    </li>
    <li>
      <a href="calendar.html">
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
    <div>

      <button onclick=toggleSidebar() id="toggle-btn">
        <i class="fa-solid fa-bars"></i>
      </button>
      <img src="/assets/estrategia-cardinal.png" alt="Logo Cronecta" class="logo-cronecta-small" />
    </div>
    <div class="container d-flex justify-content-between align-items-center">

      <h1 class="head-title d-md-block d-none">Proveedores</h1>
      <div class="d-flex gap-2 align-items-center">
        <span class="capitalize">
          <?= $this->userSession->name . " " . $this->userSession->lastname  ?>
        </span>

        <div class="vr h-50 m-auto"></div>

        <span>
          <?= $this->userSession->supplierSessionInfo->position ?>

        </span>

        <div class="vr h-50 m-auto"></div>

        <span>
          <strong>
            <?= $this->userSession->supplierSessionInfo->company_name ?>
          </strong>
        </span>
        <a class="nav-link" data-toggle="dropdown" @click="logout">
          <i class="fa-solid fa-right-from-bracket"></i>
        </a>
      </div>

    </div>
  </section>
</nav>
<script>
  const toggleButton = document.getElementById('toggle-btn')
  const sidebar = document.getElementById('sidebar')

  function toggleSidebar() {
    sidebar.classList.toggle('close')
    toggleButton.classList.toggle('rotate')

    closeAllSubMenus()
  }

  function toggleSubMenu(button) {

    if (!button.nextElementSibling.classList.contains('show')) {
      closeAllSubMenus()
    }

    button.nextElementSibling.classList.toggle('show')
    button.classList.toggle('rotate')

    if (sidebar.classList.contains('close')) {
      sidebar.classList.toggle('close')
      toggleButton.classList.toggle('rotate')
    }
  }

  function closeAllSubMenus() {
    Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
      ul.classList.remove('show')
      ul.previousElementSibling.classList.remove('rotate')
    })
  }
</script>