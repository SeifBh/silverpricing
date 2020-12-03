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
      <a href="" class="avatar"><img src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/img/user-default.png" class="rounded-circle" alt=""></a>
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

  <ul class="nav nav-aside">
    <li class="nav-label">Navigation Principale</li>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_DASHBOARD') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "dashboard" ) ? "active" : "" ?>"><a href="/dashboard" class="nav-link">
        <i data-feather="home"></i> <span>Tableau de bord</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_DEPARTEMENTS') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "departements" ) ? "active" : "" ?>"><a href="/departements" class="nav-link">
        <i data-feather="shopping-bag"></i> <span>Départements</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_GROUPES') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "groupes" ) ? "active" : "" ?>"><a href="/groupes" class="nav-link">
        <i data-feather="git-branch"></i> <span>Groupes</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_RESIDENCES') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "recherche-silverex" ) ? "active" : "" ?>"><a href="/recherche-silverex" class="nav-link">
        <i data-feather="globe"></i> <span>Résidences</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_MES_RESIDENCES') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "mes-residences" ) ? "active" : "" ?>"><a href="/mes-residences" class="nav-link">
        <i data-feather="pie-chart"></i> <span>Mes Résidences</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_MES_GROUPES') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "mes-groupes" ) ? "active" : "" ?>"><a href="/mes-groupes" class="nav-link">
        <i data-feather="pie-chart"></i> <span>Mes Groupes</span></a>
    </li>
    <?php endif; ?>
    <?php if( residence_mgmt_user_plan_has_access('PAGE_DEVELOPPEMENT_TOOLS') ): ?>
    <li class="nav-item <?php echo ( $currentMenu == "development-tools" ) ? "active" : "" ?>"><a href="/development-tools" class="nav-link">
        <i data-feather="map"></i> <span>Développement Tools</span></a>
    </li>
    <?php endif; ?>
  </ul>
</div>
