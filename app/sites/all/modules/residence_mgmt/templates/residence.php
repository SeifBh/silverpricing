<?php /*
 https://ehpad.home/residence/40233
 js img modal popup

$("#pop").on("click", function() {
   $(this).modal();
});
 */
$cs=$chambre->field_tarif_chambre_simple['und'][0]['value'];
$images=[];
$imp='/sites/default/files/ehpad/';
$tnp='/sites/default/styles/thumbnail/public/ehpad/';

if(isset($residence->field_images['und'][0])){foreach($residence->field_images["und"] as $t){
    #$images[]=file_create_url($t['uri']);
    $images[]=$t['filename'];
    /*+thumbnail
    https://ehpad.home/sites/default/files/ehpad/590804613-be24ab601d9f9dfed47df2ef35d2a824.jpg
    */
}}

if($images){?>
    <link rel="stylesheet" type="text/css" href="/z/glider.min.css">
    <script src="/z/glider.min.js"></script>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>Fermer</button>
                    <!--<h4 class="modal-title" id="myModalLabel"></h4>-->
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<div class="row">
<table class="t1300"><tr><td>
    <h3 class="mg-b-0 tx-spacing--1 residence-name">
        <?php
        if( isset($groupe->field_logo['und'][0]['fid']) ) {
            echo theme('image', array(
                'path' => file_create_url(file_load($groupe->field_logo['und'][0]['fid'])->uri),
                'width' => 32
            ));
        }
        ?>
        <?php echo $residence->title; ?>
    </h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="/departement/<?php echo $departement->tid; ?>-<?php echo str_replace(' ','',$departement->name); ?>"><?php echo $departement->name; ?></a></li>
            <li class="breadcrumb-item"><a href="#"><?php echo $residence->field_statut['und'][0]['value'] ?></a></li>
            <?php if( $groupe != null ): ?>
                <li class="breadcrumb-item"><a href="/groupe/<?php echo $groupe->tid; ?>"><?php echo $groupe->name; ?></a></li>
            <?php endif; ?>
        </ol>
    </nav>
</td>
<td class="p 2 middle">
<?php if($images){?>
    <div class="gl1_ p30">
        <div class="glider-contain">
            <div class="glider">
                <?foreach($images as $f)echo"<div><a class='zoom' data-img='$imp$f'><img src='$tnp$f'></a></div>";?>
            </div>
            <button aria-label="Previous" class="glider-prev">«</button>
            <button aria-label="Next" class="glider-next">»</button>
            <div role="tablist" class="dots"></div>
        </div>
    </div>
    <script>
        var nbs=4;if(window.innerWidth<500){nbs=2;}
        //window.addEventListener('load', function(){
        new Glider(document.querySelector('.glider'), {
            slidesToShow: nbs, slidesToScroll: nbs,
            dots: '.dots',draggable: false,/*click*/
            arrows: {prev: '.glider-prev', next: '.glider-next'}
        });
//jquery loaded at footer, not async relatively strange ..
        window.addEventListener('load', function(){
            $(document).ready(function(){
                $('.zoom').on('click', function() {
                    x=this.getAttribute('data-img');
                    cl(x);
                    $('#imagepreview').attr('src',x);
                    $('#imagemodal').modal('show');
                });
            });
        });
    </script>
<?php }?>
</td><td class="td3 3" nowrap="nowrap">
    <div class="mg-t-10 mg-b-10" style="text-align: right">
        <?php if( strlen($residence->field_site['und'][0]['value']) >= 5 ): ?>
            <a href="<?php echo $residence->field_site['und'][0]['value']; ?>" target="_blank" class="btn btn-sm btn-white btn-uppercase pd-x-15"><i data-feather="globe"></i>
                Site Internet</a>
        <?php endif; ?>
        <a href="mailto:<?php echo $residence->field_email['und'][0]['value']; ?>" class="btn btn-sm btn-white btn-uppercase pd-x-15 mg-t-5 mg-sm-t-0 mg-sm-l-5"><i data-feather="send"></i>
            Email</a>
        <!-- <a href="<?php //echo $residence->field_telephone['und'][0]['value']; ?>" class="btn btn-sm btn-white btn-uppercase pd-x-15 mg-t-5 mg-sm-t-0 mg-sm-l-5"><i data-feather="share-2"></i>
      Téléphone</a> -->
    </div>

<span class="text-left"><?php echo $residence->field_telephone['und'][0]['value']; ?></span>
<span class="text-left">
  <?php echo ( isset($residence->field_location['und'][0]["thoroughfare"]) ) ? $residence->field_location['und'][0]["thoroughfare"]:""; ?>
  <?php echo ",<br> " . $residence->field_location['und'][0]['postal_code']; ?>
  <?php echo ", " . $residence->field_location['und'][0]['locality']; ?>
</span>

</td>
</tr></table>
</div>
<div class="row pt-3">
    <div class="col-md-6">
      <div class="card mg-t-10 mg-b-10">
        <div class="card-body pd-y-15 pd-x-10">

          <div class="mg-t-0 mg-b-35">
            <table class="table table-borderless">
              <thead class="bd-b">
                <tr>
                  <td colspan="4"><h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Tarifs</h6></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="tx-semibold">Chambre Simple</td>
                  <td>: <?php
                      echo $cs; ?> €</td>
                  <td class="tx-semibold">Chambre Simple Temporaire</td>
                  <td>: <?php echo $chambre->field_tarif_chambre_simple_tempo['und'][0]['value']; ?> €</td>
                </tr>
                <tr>
                  <td class="tx-semibold">Chambre Double</td>
                  <td>: <?php echo $chambre->field_tarif_chambre_double['und'][0]['value']; ?> €</td>
                  <td class="tx-semibold">Chambre Double Temporaire</td>
                  <td>: <?php echo $chambre->field_tarif_chambre_double_tempo['und'][0]['value']; ?> €</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mg-t-45 mg-b-45">
            <h6 class="tx-8rem tx-uppercase tx-bold mg-b-10 pd-b-5 bd-b">Ranking</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="info-box">
                  <?php if( $residenceRanking['departement'] <= 10 ): ?>
                    <span class="info-box-icon bg-success"><i class="fa fa-trophy tx-white"></i></span>
                  <?php elseif( $residenceRanking['departement'] <= 20 ): ?>
                    <span class="info-box-icon bg-orange"><i class="fa fa-trophy tx-white"></i></span>
                  <?php else: ?>
                    <span class="info-box-icon bg-danger"><i class="fa fa-trophy tx-white"></i></span>
                  <?php endif; ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Position dans le departement</span>
                    <span class="info-box-number"><?php echo $residenceRanking['departement']; ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <?php if( $residenceRanking['concurrence_directe'] <= 3 ): ?>
                    <span class="info-box-icon bg-success"><i class="fa fa-trophy tx-white"></i></span>
                  <?php elseif( $residenceRanking['concurrence_directe'] <= 7 ): ?>
                    <span class="info-box-icon bg-orange"><i class="fa fa-trophy tx-white"></i></span>
                  <?php else: ?>
                    <span class="info-box-icon bg-danger"><i class="fa fa-trophy tx-white"></i></span>
                  <?php endif; ?>
                  <div class="info-box-content">
                    <span class="info-box-text">Position concurrence direct</span>
                    <span class="info-box-number"><?php echo $residenceRanking['concurrence_directe']; ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mg-t-35 mg-b-25">
            <h6 class="tx-8rem tx-uppercase tx-bold mg-b-10 pd-b-5 bd-b">Possibilités d'évolution tarifaire <small>(tarif à partir de)</small></h6>
            <table class="table table-sm table-borderless">
              <tr class="text-center tx-12">
                <td class="tx-uppercase tx-bold">Tarifs</td>
                <td><?php echo $tmhOptimisation["tarif_min"]; ?>€</td>
                <td><?php echo round($tmhOptimisation["tarif_max"] * 0.9, 2); ?>€</td>
                <td><?php echo round($tmhOptimisation["tarif_max"] * 0.95, 2); ?>€</td>
                <td><?php echo round($tmhOptimisation["tarif_max"] * 0.97, 2); ?>€</td>
                <td><?php echo $tmhOptimisation["tarif_max"]; ?>€</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="5">
                  <div class="tarif-evolution-chart"></div>
                </td>
              </tr>
              <tr class="text-center tx-12">
                <td class="tx-uppercase tx-bold">T.O</td>
                <td>80%</td>
                <td>90%</td>
                <td>95%</td>
                <td>97%</td>
                <td>100%</td>
              </tr>
            </table>
          </div>


        </div>
      </div>
    </div>
    <div class="col-md-6">
        <div class="card mg-t-10 mg-b-10">
            <div class="card-header d-sm-flex align-items-start justify-content-between">
                <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Situation concurrentielle a date</h6>
            </div>
            <div class="card-body pd-y-15 pd-x-10">
                <div id="situation-concurrentielle" class="row pd-10">
                    <div class="col-sm-4">
                        <h3 class="sc-residence tx-semibold tx-rubik tx-spacing--2 mg-b-5" style="color: #f3407a">NA €</h3>
                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10">Résidence</h6>
                    </div>
                    <div class="col-sm-4">
                        <h3 class="sc-departement tx-semibold tx-rubik tx-spacing--2 mg-b-5" style="color: #6fdce1">NA €</h3>
                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10">Département</h6>
                    </div>
                    <div class="col-sm-4">
                        <h3 class="sc-concurrence-direct tx-semibold tx-rubik tx-spacing--2 mg-b-5" style="color: #68a3fd">NA €</h3>
                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-10">10 concurrents les plus proches</h6>
                    </div>
                </div>
                <div class="mg-t-10 mg-b-10" style="height:350px">
                    <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-10 pd-b-5 bd-b">Evolution mensuelle des tarifs</h6>
                    <canvas id="evolution-line-chart" height="300"></canvas><?#bonobo-rouge?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(0){ ?>
<div class="row pt-3">
  <div class="col-md-6">
    <div class="card mg-t-10 mg-b-10">
      <div class="card-header d-sm-flex align-items-start justify-content-between">
        <h5 class="lh-5 mg-b-0">Informations sur la résidence</h5>
      </div>
      <div class="card-body pd-y-15 pd-x-10">
        <table class="table table-sm table-borderless">
          <tbody>
            <tr>
              <th>FINESS</th>
              <td>: <?php echo $residence->field_finess['und'][0]['value']; ?></td>
            </tr>
            <tr>
              <th>Gestionnaire</th>
              <td>: <?php echo $residence->field_gestionnaire['und'][0]['value']; ?></td>
            </tr>
            <tr>
              <th>Groupe</th>
              <td>: <?php echo ( $groupe != null ) ? $groupe->name:""; ?></td>
            </tr>
            <tr>
              <th>Statut</th>
              <td>: <?php echo $residence->field_statut['und'][0]['value'] ?></td>
            </tr>
            <tr>
              <th>Adresse</th>
              <td>:
                <?php echo ( isset($residence->field_location['und'][0]["thoroughfare"]) ) ? $residence->field_location['und'][0]["thoroughfare"]:""; ?>
                <?php echo ", " . $residence->field_location['und'][0]['postal_code']; ?>
                <?php echo ", " . $residence->field_location['und'][0]['locality']; ?>
              </td>
            </tr>
            <tr>
              <th>Site Internet</th>
              <td>: <?php echo $residence->field_site['und'][0]['value']; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td>: <?php echo $residence->field_email['und'][0]['value']; ?></td>
            </tr>
            <tr>
              <th>Téléphone</th>
              <td>: <?php echo $residence->field_telephone['und'][0]['value']; ?></td>
            </tr>
            <tr>
              <th>Chambre Simple</th>
              <td>: <?php echo $chambre->field_tarif_chambre_simple['und'][0]['value']; ?> €</td>
            </tr>
            <tr>
              <th>Chambre Double</th>
              <td>: <?php echo $chambre->field_tarif_chambre_double['und'][0]['value']; ?> €</td>
            </tr>
            <tr>
              <th>Chambre Simple Temporaire</th>
              <td>: <?php echo $chambre->field_tarif_chambre_simple_tempo['und'][0]['value']; ?> €</td>
            </tr>
            <tr>
              <th>Chambre Double Temporaire</th>
              <td>: <?php echo $chambre->field_tarif_chambre_double_tempo['und'][0]['value']; ?> €</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card mg-t-10 mg-b-10">
      <div class="card-header d-sm-flex align-items-start justify-content-between">
        <h5 class="lh-5 mg-b-0">Evolution mensuelle des tarifs</h5>
      </div>
      <div class="card-body pd-y-15 pd-x-10">
        <canvas id="evolution-line-chart" height="450"></canvas>
      </div>
    </div>

  </div>

</div>
<?php }

if( residence_mgmt_user_plan_has_access('OPTIMISATION_RESIDENCE_TMH') ):
    if( in_array($residence->nid, $user_access['field_acces_residences']) || in_array($groupe->tid, $user_access['field_acces_groupes']) ): ?>
<div class="statistics_wrapper mt-5 mb-5">

  <div class="row">
    <div class="col-md-12">
      <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-flex align-items-start justify-content-between">
          <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Optimisation de TMH</h6>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
          <div class="row" style="margin-bottom: 25px;">
            <div class="col-md-6">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Tarif/jour à partir de:</label>
                <div class="col-sm-8">
                  <input type="text" id="tmh_slider" class="form-control" name="tmh_slider"
                    data-min="<?php echo $tmhOptimisation["tarif_min"]; ?>"
                    data-max="<?php echo $tmhOptimisation["tarif_max"]; ?>"
                    data-from="<?php echo $chambre->field_tarif_chambre_simple['und'][0]['value']; ?>" data-step="0.01"
                    data-grid="true" value="<?php echo $chambre->field_tarif_chambre_simple['und'][0]['value']; ?>" />
                </div>
              </div>
            </div>
            <div class="col-md-6">

              <button class="btn btn-sm btn-primary mg-t-10" id="calculer_maquette">
                Calculer la maquette
              </button>

              <div id="historiques_maquettes" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Historiques des maquettes</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table id="table-historiques-maquettes" class="table table-sm text-center">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                              <th scope="col">Date</th>
                              <th scope="col">Utilisateur</th>
                              <th scope="col">TMH</th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_entree_de_gamme)) ? $typesDeChambres->cs_entree_de_gamme : "Entrée de gamme" ?>
                              </th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_standard)) ? $typesDeChambres->cs_standard : "Standard" ?>
                              </th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_superieur)) ? $typesDeChambres->cs_superieur : "Supérieur" ?>
                              </th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_luxe)) ? $typesDeChambres->cs_luxe : "Luxe" ?>
                              </th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_alzheimer)) ? $typesDeChambres->cs_alzheimer : "Alzheimer" ?>
                              </th>
                              <th scope="col">CS
                                <?php echo (!empty($typesDeChambres->cs_aide_sociale)) ? $typesDeChambres->cs_aide_sociale : "Aide Sociale" ?>
                              </th>
                              <th scope="col">CD
                                <?php echo (!empty($typesDeChambres->cd_standard)) ? $typesDeChambres->cd_standard : "Standard" ?>
                              </th>
                              <th scope="col">CD
                                <?php echo (!empty($typesDeChambres->cd_aide_sociale)) ? $typesDeChambres->cd_aide_sociale : "Aide Sociale" ?>
                              </th>
                              <th>Action</td>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <button class="btn btn-sm btn-primary mg-t-10" id="btn-historiques-maquettes" data-toggle="modal"
                data-target="#historiques_maquettes">
                Historique des maquettes <span class="badge badge-dark"><?php echo $nbreMaquettes; ?></span>
              </button>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 maquette-courante d-none">
              <div class="row">
                <div class="col-md-9">
                  <table class="table table-sm">
                    <tr>
                      <th colspan="3">Chambres simples</th>
                    </tr>
                    <tr class="chambres-simples chambres-entree-de-gamme">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_entree_de_gamme)) ? $typesDeChambres->cs_entree_de_gamme : "entrée de gamme" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-standard">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_standard)) ? $typesDeChambres->cs_standard : "standard" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-superieur">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_superieur)) ? $typesDeChambres->cs_superieur : "supérieur" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-luxe">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_luxe)) ? $typesDeChambres->cs_luxe : "luxe" ?>"</td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-alzheimer">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_alzheimer)) ? $typesDeChambres->cs_alzheimer : "alzheimer" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-aide-sociale">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cs_aide_sociale)) ? $typesDeChambres->cs_aide_sociale : "aide-sociale" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr>
                      <th colspan="3">Chambres doubles</th>
                    </tr>
                    <tr class="chambres-doubles chambres-standard">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cd_standard)) ? $typesDeChambres->cd_standard : "standard" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                    <tr class="chambres-doubles chambres-aide-sociale">
                      <td>Chambres
                        "<?php echo (!empty($typesDeChambres->cd_aide_sociale)) ? $typesDeChambres->cd_aide_sociale : "aide-sociale" ?>"
                      </td>
                      <td class="nombre-de-lits">0</td>
                      <td class="tarif-de-chambre">0</td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-3">
                  <div class="tmh-wrapper text-center mg-t-20">
                    <div class="tmh-circle tmh-circle-default">
                      <div class="tmh-circle-header">TMH</div>
                      <div class="tmh-circle-body">0 €</div>
                      <div class="tmh-circle-footer tx-spacing-1 tx-bold tx-12">jour</div>
                    </div>
                    <button class="btn btn-primary btn-100" id="modifier_maquette">
                      Modifier
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 maquette-modifiee d-none">
              <div class="row">
                <div class="col-md-9">
                  <table class="table table-sm">
                    <tr>
                      <th colspan="2">Chambres simples</th>
                      <th class="text-right"><a href="#" class="edit-chambres-simples"><i class="fas fa-edit"></i></a>
                      </th>
                    </tr>
                    <tr class="chambres-simples chambres-entree-de-gamme">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_entree_de_gamme)) ? $typesDeChambres->cs_entree_de_gamme : "entrée de gamme" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-standard">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_standard)) ? $typesDeChambres->cs_standard : "standard" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-superieur">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_superieur)) ? $typesDeChambres->cs_superieur : "supérieur" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-luxe">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_luxe)) ? $typesDeChambres->cs_luxe : "luxe" ?>"</td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-alzheimer">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_alzheimer)) ? $typesDeChambres->cs_alzheimer : "alzheimer" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-simples chambres-aide-sociale">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cs_aide_sociale)) ? $typesDeChambres->cs_aide_sociale : "aide-sociale" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr>
                      <th colspan="2">Chambres doubles</th>
                      <th class="text-right"><a href="#" class="edit-chambres-doubles"><i class="fas fa-edit"></i></a>
                      </th>
                    </tr>
                    <tr class="chambres-doubles chambres-standard">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cd_standard)) ? $typesDeChambres->cd_standard : "standard" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                    <tr class="chambres-doubles chambres-aide-sociale">
                      <td class="align-middle">Chambres
                        "<?php echo (!empty($typesDeChambres->cd_aide_sociale)) ? $typesDeChambres->cd_aide_sociale : "aide-sociale" ?>"
                      </td>
                      <td class="nombre-de-lits align-middle text-right">0</td>
                      <td class="tarif-de-chambre align-middle text-right">0</td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-3">
                  <div class="tmh-wrapper text-center mg-t-20">
                    <?php $totalChambres = $chambre->field_nombre_cs_entre_de_gamme['und'][0]['value'] + $chambre->field_nombre_cs_standard['und'][0]['value']
                                                + $chambre->field_nombre_cs_superieur['und'][0]['value'] + $chambre->field_nombre_cs_luxe['und'][0]['value']
                                                + $chambre->field_nombre_cs_alzheimer['und'][0]['value'] + $chambre->field_nombre_cs_aide_sociale['und'][0]['value']
                                                + $chambre->field_nombre_cd_standard['und'][0]['value'] + $chambre->field_nombre_cd_aide_sociale['und'][0]['value'];
                                          ?>
                    <div class="nombre-de-chambre mg-b-15 tx-bold">Nombre de chambres : <span
                        class="badge badge-success"><?php echo $totalChambres; ?></span> </div>
                    <button class="btn btn-primary btn-100" id="calculer_maquette_modifiee">
                      Calculer
                    </button>
                    <div class="tmh-circle tmh-circle-default">
                      <div class="tmh-circle-header">TMH</div>
                      <div class="tmh-circle-body">0 €</div>
                      <div class="tmh-circle-footer tx-spacing-1 tx-bold tx-12"><span class="maquette_diff">0</span> /
                        jour</div>
                    </div>
                    <button class="btn btn-primary btn-100" id="enregistrer_maquette">
                      Enregistrer
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- MAQUETTE DE MODIFICATION -->
<div id="update-maquette-residence" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier la maquette</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="chambres-simples-fieldsets">
          <h5 class="text-uppercase">Chambres Simples</h5>
          <fieldset class="form-fieldset chambres-entree-de-gamme">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cs_entree_de_gamme)) ? $typesDeChambres->cs_entree_de_gamme : "entrée de gamme" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
          <fieldset class="form-fieldset chambres-standard">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cs_standard)) ? $typesDeChambres->cs_standard : "standard" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control  nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control  tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
          <fieldset class="form-fieldset chambres-superieur">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cs_superieur)) ? $typesDeChambres->cs_superieur : "supérieur" ?>"
            </legend>
            <div class="row">
              <div class="form-group col-md-6 row">
                <label class="col-sm-4 col-form-label">Nombre</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control  nombre-chambres" step="1">
                </div>
              </div>
              <div class="form-group col-md-6 row">
                <label class="col-sm-4 col-form-label">Tarif</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control  tarif-chambres" step="0.01">
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset class="form-fieldset chambres-luxe">
            <legend>Chambres "<?php echo (!empty($typesDeChambres->cs_luxe)) ? $typesDeChambres->cs_luxe : "luxe" ?>"
            </legend>
            <div class="row">
              <div class="form-group col-md-6 row">
                <label class="col-sm-4 col-form-label">Nombre</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control nombre-chambres" step="1">
                </div>
              </div>
              <div class="form-group col-md-6 row">
                <label class="col-sm-4 col-form-label">Tarif</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset class="form-fieldset chambres-alzheimer">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cs_alzheimer)) ? $typesDeChambres->cs_alzheimer : "alzheimer" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
          <fieldset class="form-fieldset chambres-aide-sociale">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cs_aide_sociale)) ? $typesDeChambres->cs_aide_sociale : "aide-sociale" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
        </div>

        <hr />
        <div class="chambres-doubles-fieldsets">
          <h5 class="text-uppercase">Chambres Doubles</h5>
          <fieldset class="form-fieldset chambres-standard">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cd_standard)) ? $typesDeChambres->cd_standard : "standard" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
          <fieldset class="form-fieldset chambres-aide-sociale">
            <legend>Chambres
              "<?php echo (!empty($typesDeChambres->cd_aide_sociale)) ? $typesDeChambres->cd_aide_sociale : "aide-sociale" ?>"
            </legend>
            <div class="row">
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control nombre-chambres" step="1">
                  </div>
                </div>
                <div class="form-group col-md-6 row">
                  <label class="col-sm-4 col-form-label">Tarif</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" class="form-control tarif-chambres" step="0.01">
                  </div>
                </div>
            </div>
          </fieldset>
        </div>

        <button id="submit-updated-maquette" class="btn btn-primary btn-block btn-sm mg-t-15">Appliquer</button>
      </div>
    </div>
  </div>
</div>
<!-- /MAQUETTE DE MODIFICATION -->
<?php endif; ?>
<?php endif; ?>

<div class="row">
  <div class="col-md-6">

    <div class="card mg-t-15 mg-b-15">
      <div class="card-header d-sm-flex align-items-start justify-content-between">
        <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Concurrence directe - 10 Résidences les plus proches*</h6>
      </div>
      <div class="card-body pd-y-15 pd-x-10">

        <div class="row">
          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">
                Tarif max</h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo $statistiques['direct']['tarif_max'] ?>€</h4>
            </div>
          </div>

          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Tarif moyen
              </h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo round($statistiques['direct']['tarif_moyen'], 2) ?>€</h4>
            </div>
          </div>

          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Tarif min
              </h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo $statistiques['direct']['tarif_min'] ?>€</h4>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table id="table-residences-direct" class="table table-sm text-center classement">
            <thead>
              <tr>
                <th scope="col">résidence</th>
                <th scope="col">type</th>
                <th scope="col">ville</th>
                <th scope="col">KM</th>
                <th scope="col">€</th>
                <th scope="col">Lits</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i=0;
              foreach( $residencesConcurrentes['direct'] as $residenceConcurrent ):
                  $s='';if($residenceConcurrent->field_tarif_chambre_simple_value<$cs)$s=' red';
                  ?> <tr class="_r<?php echo $i.$s?>">
                <td class="text-left">
                    <?php echo create_link($residenceConcurrent->title, "/residence/$residenceConcurrent->nid" , residence_mgmt_user_plan_has_access("PAGE_DETAIL_RESIDENCE_CONCURRENTE")); ?>
                </td>
                <td class="text-center"><?php print $residenceConcurrent->field_statut_value ?></td>
                <td class="text-center"><?php print $residenceConcurrent->field_location_locality ?></td>
                <td class="text-center"><?php print round($residenceConcurrent->distance) ?></td>
                <td class="text-center"><?php print $residenceConcurrent->field_tarif_chambre_simple_value ?></td>
                <?php echo'<td class="text-center">'.$residenceConcurrent->cap.'</td>';?>
              </tr>
              <?php $i++;endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="row mt-2 mb-2">

          <div id="residence-concurrente-direct" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Concurrence directe - {10} Résidences les plus proches*</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="residence-concurrente-direct-map" style="height: 400px"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal"
              data-target="#residence-concurrente-direct">Voir sur la carte</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="col-md-6">

    <div class="card mg-t-15 mg-b-15">
      <div class="card-header d-sm-flex align-items-start justify-content-between">
        <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">10 Résidences les plus proches*</h6>
      </div>
      <div class="card-body pd-y-15 pd-x-10">
        <div class="row">
          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">
                Tarif max</h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo $statistiques['indirect']['tarif_max'] ?>€</h4>
            </div>
          </div>

          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-5">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Tarif moyen
              </h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo round($statistiques['indirect']['tarif_moyen'], 2) ?>€</h4>
            </div>
          </div>

          <div class="media col-md-4 mg-t-15 mg-b-15">
            <div
              class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bar-chart-2">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
            </div>
            <div class="media-body">
              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Tarif min
              </h6>
              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0">
                <?php echo $statistiques['indirect']['tarif_min'] ?>€</h4>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table id="table-residences-indirect" class="table table-sm text-center classement">
            <thead>
              <tr>
                <th scope="col">résidence</th>
                <th scope="col">type</th>
                <th scope="col">ville</th>
                <th scope="col">KM</th>
                <th scope="col">€</th>
                <th scope="col">Lits</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; foreach( $residencesConcurrentes['indirect'] as $residenceConcurrent ):

                  $s='';if($residenceConcurrent->field_tarif_chambre_simple_value<$cs)$s=' red';
                  ?>
              <tr class="_r<?php echo $i.$s?>">
                <td class="text-left">
                    <?php echo create_link($residenceConcurrent->title, "/residence/$residenceConcurrent->nid" , residence_mgmt_user_plan_has_access("PAGE_DETAIL_RESIDENCE_CONCURRENTE")); ?>
                </td>
                <td class="text-center"><?php print $residenceConcurrent->field_statut_value ?></td>
                <td class="text-center"><?php print $residenceConcurrent->field_location_locality ?></td>
                <td class="text-center"><?php print round($residenceConcurrent->distance) ?></td>
                <td class="text-center"><?php print $residenceConcurrent->field_tarif_chambre_simple_value ?></td>
                  <?php echo'<td class="text-center">'.$residenceConcurrent->cap.'</td>';?>
              </tr>
              <?php $i++;endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="row mt-2 mb-2">

          <div id="residence-concurrente-indirect" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{10} Résidences les plus proches*</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="residence-concurrente-indirect-map" style="height: 400px"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal"
              data-target="#residence-concurrente-indirect">Voir sur la carte</button>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
<?php return;?>
