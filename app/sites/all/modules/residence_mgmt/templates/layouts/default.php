<?php
#define("MODULE_PATH", "/sites/all/modules/residence_mgmt"); ?>
<!DOCTYPE html>
<html lang="fr" id="a"><head>
    <script type="text/javascript"><?php
        $json=[];
        if(isset($GLOBALS['user']->uid)){$json=array_merge($json,['uid'=>$GLOBALS['user']->uid,'uname'=>$GLOBALS['user']->name]);}
        if(isset($_POST)){$json=array_merge($json,['post'=>$_POST]);}
        if(isset($_GET)){$json=array_merge($json,['get'=>$_GET]);}
        if(isset($_SESSION['public'])){$json=array_merge($json,['session'=>$_SESSION['public']]);}

        echo "var json=".json_encode($json).";for(var i in json){window[i]=json[i];}";
        $a=$user->uid.'-'.$user->name;
        ?>
    </script>
    <link id="gcss" rel="stylesheet" href="/z/global.css?a=<?=filemtime($_SERVER['DOCUMENT_ROOT'].'z/global.css')?>" title="/z/global.css" />
    <script id="gjs" src="/z/global.js?a=<?=filemtime($_SERVER['DOCUMENT_ROOT'].'z/global.js')?>" title="/z/global.js" ></script>
    <script async src="https://code.iconify.design/1/1.0.7/iconify.min.js#rendersExcel"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="SilverPricing : Residence Management">
    <meta name="author" content="SilverPricing">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/misc/favicon.ico">

    <title>SilverPricing | Résidence Management </title>

    <?php require RESIDENCE_MGMT_PATH . "/templates/partial/header.inc.php"; ?>

  </head>
  <body id="b"><div id="dashCap"></div>

    <aside class="aside aside-fixed minimize">
        <?php require RESIDENCE_MGMT_PATH . "/templates/partial/aside.inc.php"; ?>
    </aside>

    <div class="content ht-100v pd-0">
      <div class="content-header">
              <div class="content-search"></div>

              <div class="navbar-brand">
                  <a href="/dashboard" class="df-logo">Silver<span>Pricing</span></a>
              </div>
              <nav class="nav"></nav>

              <div class="navbar-right">

              <div class="dropdown dropdown-profile">
                  <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                      <div class="avatar avatar-sm"><img src="/sites/all/modules/residence_mgmt/assets/img/user-default.png"
                              class="rounded-circle" alt=""></div>
                  </a><!-- dropdown-link -->
                  <div class="dropdown-menu dropdown-menu-right tx-13">
                      <div class="avatar avatar-lg mg-b-15">
                          <img src="/sites/all/modules/residence_mgmt/assets/img/user-default.png" class="rounded-circle" alt="">
                      </div>
                      <h6 class="tx-semibold mg-b-5"><?php echo ( $user != null ) ? $user->name : "" ?></h6>
                      <p class="mg-b-25 tx-12 tx-color-03"><?php echo ( $user != null ) ? $user->roles[3] : "" ?></p>

                      <a href="/profile/<?php echo $user->uid; ?>" data-toggle="tooltip" title="Profile" class="dropdown-item"><i data-feather="user"></i> Mon compte</a>

                      <a href="/histories" data-toggle="tooltip" title="Historique" class="dropdown-item"><i data-feather="activity"></i> Historique</a>

                      <?php if( residence_mgmt_user_plan_has_access('PAGE_MES_GROUPES') ): ?>
                      <a href="/mes-groupes" data-toggle="tooltip" title="Mes groupes" class="dropdown-item"><i data-feather="settings"></i> Mes groupes</a>
                      <?php endif; ?>

                      <?php if( residence_mgmt_user_plan_has_access('PAGE_MES_RESIDENCES') ): ?>
                      <a href="/mes-residences" data-toggle="tooltip" title="Mes résidences" class="dropdown-item"><i data-feather="settings"></i> Mes résidences</a>
                      <?php endif; ?>

                      <div class="dropdown-divider"></div>
                      <a href="/user/logout" data-toggle="tooltip" title="Déconnexion" class="dropdown-item" ><i data-feather="log-out"></i> Déconnexion</a>

                  </div><!-- dropdown-menu -->
              </div><!-- dropdown -->
      </div>

      </div><!-- content-header -->

      <div class="content-body">
        <div class="container-fluid pd-x-0">
            <!-- <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sales Monitoring</li>
                </ol>
              </nav>
              <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
            </div>
            <div class="d-none d-md-block">
              <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail" class="wd-10 mg-r-5"></i> Email</button>
              <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer" class="wd-10 mg-r-5"></i> Print</button>
              <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file" class="wd-10 mg-r-5"></i> Generate Report</button>
            </div>
          </div> -->

          <?php echo $content; ?>

        </div><!-- container -->
      </div>
    </div>

    <?php require RESIDENCE_MGMT_PATH . "/templates/partial/footer.inc.php"; ?>

  </body>
</html>
