<div class="aside-header">
  <a href="/dashboard" class="aside-logo">Silver<span>Pricing</span></a>
  <a href="" class="aside-menu-link">
    <i data-feather="menu"></i>
    <i data-feather="x"></i>
  </a>
</div>

<div class="aside-body">
  <?php global $user; ?>

  <div class="aside-loggedin">

    <div class="d-flex align-items-center justify-content-start">
      <?/*<a href="" class="avatar"><img src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/img/user-default.png" class="rounded-circle" alt=""></a>*/?>
      <div class="aside-alert-link">
          <a href="/user/logout" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
      </div>
    </div>
    <div class="aside-loggedin-user">
      <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
        <h6 class="tx-semibold mg-b-0"><?php echo ( $user != null ) ? $user->name : "" ?></h6>
        <i data-feather="chevron-down"></i>
      </a>
      <p class="tx-color-03 tx-12 mg-b-0"><?php echo ( $user != null ) ? $user->roles[3] : "" ?></p>
    </div>
    <div class="collapse" id="loggedinMenu">
      <ul class="nav nav-aside mg-b-0">
        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
        <li class="nav-item"><a href="/user/logout" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>
      </ul>
    </div>
  </div><!-- aside-loggedin -->

</div>
