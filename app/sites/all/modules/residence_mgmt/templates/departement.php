<div class="departement">
<h3 class="mg-b-0 tx-spacing--1 text-uppercase"><?php echo $departement->name; ?></h3>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
        <li class="breadcrumb-item"><a href="/departements">départements</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $departement->name ?></li>
      </ol>
</nav>

<div class="row <?php echo ( count($_POST) > 0 ) ? '' : 'd-none' ?>">
    <div class="col-md-12">
        <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapse_global_info" role="button" aria-expanded="true">Tous les residences</a>
    </div>
</div>

<div class="collapse mg-t-5 <?php echo ( count($_POST) > 0 ) ? '' : 'show' ?>" id="collapse_global_info">

    <div class="row">
        <div class="col-md-4">
            <div class="card mg-t-10 mg-b-10">
                  <div class="card-body pd-y-15 pd-x-10">
                    <div id="french-residences-map" class="heremap"></div>
                  </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-body pd-y-15 pd-x-10">

                    <div class="row">

                      <div class="col-md-4">

                          <div class="media mg-t-15 mg-b-15">
                              <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>                            </div>
                              <div class="media-body">
                                <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Nbre de +75 ans sur le dep</h6>
                                <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo $totalPopulation; ?></h4>
                              </div>
                          </div>

                          <div class="media mg-t-15 mg-b-15">
                              <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>                            </div>
                              <div class="media-body">
                                <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Nbre de lits (Département)</h6>
                                <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo $capaciteDepartement->nombre_lits; ?></h4>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-8">

                          <div class="row">

                              <div class="col-md-4 mg-t-15 mg-b-15">
                                  <h6 class="mg-0 tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold text-center">Nbre de lits / Nbre de lits Dep</h6>
                                  <div id="pression_concurrentielle" class="tx-sans tx-10 tx-uppercase tx-spacing-1 tx-color-03 tx-semibold"></div>
                              </div>

                              <div class="col-md-4 mg-t-15 mg-b-15">
                                  <h6 class="mg-0 tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold text-center">Nbre de résidences / population</h6>
                                  <div id="pression_concurrentielle_2" class="tx-sans tx-10 tx-uppercase tx-spacing-1 tx-color-03 tx-semibold"></div>
                              </div>

                              <div class="col-md-4 mg-t-15 mg-b-15">
                                  <h6 class="mg-0 tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold text-center">Nbre de lits Dep / population</h6>
                                  <div id="pression_lits" class="tx-sans tx-10 tx-uppercase tx-spacing-1 tx-color-03 tx-semibold"></div>
                              </div>
                          </div>

                          <!-- <div class="col-md-6 mg-t-15 mg-b-15">
                              <div id="pression_concurrentielle"></div>
                              <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192" width="32" height="32" fill="#fff"><g id="_06-speed" data-name="06-speed"><path d="M96,0A96.014,96.014,0,0,0,15.53,148.369a8,8,0,0,0,6.7,3.631H169.769a8,8,0,0,0,6.7-3.631A96.014,96.014,0,0,0,96,0Zm69.3,136H26.7a79.543,79.543,0,0,1-10.3-32H32V88H16.4a79.344,79.344,0,0,1,6.687-24.858l13.486,7.786,8-13.856L31.108,49.3A80.66,80.66,0,0,1,49.3,31.108l7.775,13.466,13.856-8L63.142,23.088A79.344,79.344,0,0,1,88,16.4V32h16V16.4a79.344,79.344,0,0,1,24.858,6.687l-7.786,13.486,13.856,8L142.7,31.108A80.66,80.66,0,0,1,160.892,49.3l-13.466,7.775,8,13.856,13.486-7.786A79.344,79.344,0,0,1,175.6,88H160v16h15.6A79.543,79.543,0,0,1,165.3,136Z"/><path d="M113.14,59.884l-12.356,20.6A24.04,24.04,0,1,0,114.5,88.724L126.86,68.116ZM96,112a8,8,0,1,1,8-8A8.009,8.009,0,0,1,96,112Z"/></g></svg>
                              </div>
                              <div class="media-body">
                                <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Pression concurrentielle</h6>
                                <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo round( ($mesLits / $capaciteDepartement->nombre_lits) * 100 , 2); ?>%</h4>
                              </div>
                          </div>

                          <div class="col-md-6 mg-t-15 mg-b-15">
                              <div id="pression_lits"></div>
                              <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192" width="32" height="32" fill="#fff"><g id="_06-speed" data-name="06-speed"><path d="M96,0A96.014,96.014,0,0,0,15.53,148.369a8,8,0,0,0,6.7,3.631H169.769a8,8,0,0,0,6.7-3.631A96.014,96.014,0,0,0,96,0Zm69.3,136H26.7a79.543,79.543,0,0,1-10.3-32H32V88H16.4a79.344,79.344,0,0,1,6.687-24.858l13.486,7.786,8-13.856L31.108,49.3A80.66,80.66,0,0,1,49.3,31.108l7.775,13.466,13.856-8L63.142,23.088A79.344,79.344,0,0,1,88,16.4V32h16V16.4a79.344,79.344,0,0,1,24.858,6.687l-7.786,13.486,13.856,8L142.7,31.108A80.66,80.66,0,0,1,160.892,49.3l-13.466,7.775,8,13.856,13.486-7.786A79.344,79.344,0,0,1,175.6,88H160v16h15.6A79.543,79.543,0,0,1,165.3,136Z"/><path d="M113.14,59.884l-12.356,20.6A24.04,24.04,0,1,0,114.5,88.724L126.86,68.116ZM96,112a8,8,0,1,1,8-8A8.009,8.009,0,0,1,96,112Z"/></g></svg>

                              </div>
                              <div class="media-body">
                                <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8">Pression lits par +75 ans</h6>
                                <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo round( ( $capaciteDepartement->nombre_lits / $totalPopulation ) * 100 , 2 ); ?>%</h4>
                              </div>
                          </div> -->

                      </div>

                </div>

                <div class="row">
                    <?php
                        $colors = array("Privé" => "#48a3b9", "Associatif" => "#eb9b6c", "Public" => "#836982");
                    ?>
                    <?php foreach( $statistique_globale as $title =>  $statistique ): ?>
                        <div class="media col-md-3 mg-t-15 mg-b-15">
                            <div style="background: <?php echo (array_key_exists($title, $colors)) ? $colors[$title]:"#f10075"; ?>" class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>                            </div>
                            <div class="media-body">
                              <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><?php echo $title ?></h6>
                              <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo $statistique ?><?php echo (in_array($title, array( "Tarif moyen", "Tarif médian", "Tarif plus bas", "Tarif plus haut" ))) ? "€": ""; ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mg-t-10 mg-b-10">
                  <div class="card-header d-sm-flex align-items-start justify-content-between">
                      <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Nombre de résidences et prix moyens par ville</h5>
                  </div>
                  <div class="card-body pd-y-15 pd-x-10">
                      <canvas id="bar_chart_canvas" height="400"></canvas>
                  </div>
            </div>

        </div>
    </div>

</div>

<?php if( residence_mgmt_user_plan_has_access('PAGE_DEPARTEMENT_SECTION_RECHERCHE') ):  ?>
<section class="section-residences mg-t-5">

    <div class="row">
      <div class="col-md-8">

          <div class="card">
              <div class="card-header d-sm-flex align-items-start justify-content-between">
                  <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Requête</h6>
              </div>
              <div class="card-body pd-y-15 pd-x-10">
                  <form method="POST" id="residence-filtre">

                      <div class="form-row">

                          <div class="form-group col-md-12">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-h-square"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="residence" name="residence" placeholder="Résidence" value="<?php echo (!empty($_POST['residence'])) ? $_POST['residence'] : '' ?>" />
                              </div>
                          </div>

                          <div class="form-group col-md-12">
                              <?php $statuses = array('Privé', 'Public', 'Associatif'); ?>
                              <select id="statut" name="statut[]" class="form-control form-control-sm select2" multiple>
                                  <option value="">Statut</option>
                                  <?php foreach( $statuses as $status ): ?>
                                      <option value="<?php echo $status; ?>" <?php echo (  !empty($_POST['statut']) && in_array($status, $_POST['statut'])) ? "selected" : "" ?>><?php echo $status; ?></option>
                                  <?php endforeach; ?>
                              <select>
                          </div>

                          <div class="form-group col-md-6">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-street-view"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="code_postale" name="code_postale" placeholder="Code Postal"  value="<?php echo (!empty($_POST['code_postale'])) ? $_POST['code_postale'] : '' ?>"/>
                              </div>
                          </div>

                          <div class="form-group col-md-6">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville"  value="<?php echo (!empty($_POST['ville'])) ? $_POST['ville'] : '' ?>"/>
                              </div>
                          </div>

                          <div class="form-group col-md-6">
                              <input type="number" class="form-control form-control-sm" min="0" id="tarif_min" name="tarif_min" placeholder="Tarif Min"  value="<?php echo (!empty($_POST['tarif_min'])) ? $_POST['tarif_min'] : '' ?>"/>
                          </div>

                          <div class="form-group col-md-6">
                              <input type="number" class="form-control form-control-sm" min="0" id="tarif_max" name="tarif_max" placeholder="Tarif Max"  value="<?php echo (!empty($_POST['tarif_max'])) ? $_POST['tarif_max'] : '' ?>"/>
                          </div>

                          <div class="form-group col-md-2 pull-right">
                              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Filtrer</button>
                          </div>

                      </div>
                  </form>

              </div>
          </div>

      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body pd-y-15 pd-x-10">
                  <div id="french-residences-map-result" class="heremap"></div>
              </div>
          </div>
      </div>
    </div>

    <div class="card mg-t-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Résultats de la requête:</h6>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
              <div class="row">
                  <?php
                      $colors = array("Privé" => "#48a3b9", "Associatif" => "#eb9b6c", "Public" => "#836982");
                  ?>
                  <?php foreach( $requete_statistique as $title => $statistique ): ?>
                      <div class="media col-md-3 mg-t-15 mg-b-15">
                          <div style="background: <?php echo (array_key_exists($title, $colors)) ? $colors[$title]:"#0168fa"; ?>" class="wd-40 wd-md-50 ht-40 ht-md-50 tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                          </div>
                          <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold mg-b-5 mg-md-b-8"><?php echo $title ?></h6>
                            <h4 class="tx-18 tx-sm-16 tx-md-20 tx-normal tx-rubik mg-b-0"><?php echo $statistique ?><?php echo (in_array($title, array( "Tarif moyen", "Tarif médian", "Tarif plus bas", "Tarif plus haut" ))) ? "€": ""; ?></h4>
                          </div>
                      </div>
                <?php endforeach; ?>
              </div>

              <div class="row">
                    <div class="col-md-12">

                        <table id="request-table" class="table table-hover table-sm no-footer">
                        <thead>
                            <tr><th scope="col">Groupe</th>
                            <th scope="col">Résidences</th>
                            <th scope="col">Code Postal</th>
                            <th scope="col">Villes</th>
                            <th scope="col">Nombre de lits</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tarifs</th>
                            <th scope="col">Dif tarifs moy dep</th>
                            <th scope="col">Dif tarifs moy requête</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rows = 0; foreach( $residences as $residence ):
                                $difTarifsMoyDep = round($residence->field_tarif_chambre_simple_value - $statistique_globale["Tarif moyen"], 2);
                                $difTarifsMoyRequete = round($residence->field_tarif_chambre_simple_value - $requete_statistique["Tarif moyen"], 2);
                            ?>
                            <tr>
                                <td><?php if( isset($residence->field_logo_fid) ) {echo theme('image', array('path' => file_create_url(file_load($residence->field_logo_fid)->uri), 'width' => 32));} ?></td>
                                <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                                <td><?php echo $residence->field_location_postal_code;# ?></td>
                                <td><?php echo $residence->field_location_locality; ?></td>
                                <td><?php echo $residence->field_capacite_value; ?></td>
                                <td><?php echo $residence->field_statut_value; ?></td>
                                <td><?php echo $residence->field_tarif_chambre_simple_value; ?>€</td>
                                <td class="<?php echo ($difTarifsMoyDep > 0) ? "tx-success":" tx-danger"; ?>">
                                    <?php echo $difTarifsMoyDep; ?>€
                                </td>
                                <td class="<?php echo ($difTarifsMoyRequete > 0) ? "tx-success":" tx-danger"; ?>">
                                    <?php echo $difTarifsMoyRequete; ?>€
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
              </div>
        </div>
    </div>
</section>
<?php endif; ?>
</div>
