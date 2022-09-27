<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-1" href="index.html"><img style="height: 45px;" src="assets/svg/nuol_ico_1.svg" class="mr-2" alt="logo"/></a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img style="height: 45px; width:50px;" src="assets/svg/nuol_ico.svg" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center none-select none-outline nav-btn" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown notosans">
          <?php
            if(!empty($_SESSION["user_admin_login"])){
              echo $user_data['fullname'];
            }
          ?>
          &nbsp;&nbsp;
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="assets/svg/user.svg" alt="profile"/>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item user-menu notosans">
              <i class="ti-settings text-primary"></i>
              Settings
            </a>
            <a class="dropdown-item user-menu notosans" data-bs-toggle="modal" data-bs-target="#confirmModal">
              <i class="ti-power-off text-primary"></i>
              ອອກຈາກລະບົບ
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
</nav>