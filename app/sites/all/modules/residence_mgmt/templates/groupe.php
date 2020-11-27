<h4>
    <?php
        if( isset($groupe->field_logo['und'][0]['fid']) ) {
            echo theme('image', array(
              'path' => file_create_url(file_load($groupe->field_logo['und'][0]['fid'])->uri),
              'width' => 64
            ));
        }
    ?>
    <?php echo $groupe->name ?>
</h4>

<section class="section-residences mg-t-5">

<div class="row">
        <div class="col-md-4">
            <div class="card mg-t-10 mg-b-10">
                  <div class="card-body pd-y-15 pd-x-10">
                    <div id="residences-map" style="height: 450px"></div>
                  </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-body pd-y-15 pd-x-10">
                    <div class="row">

                        <?php foreach( $statistiques_globales as $title =>  $statistique ): ?>
                            <div class="media col-md-4 mg-t-15 mg-b-15">
                                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-pink tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
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
            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="lh-5 mg-b-0">Historique des tarifs de groupe</h5>
                </div>
                <div class="card-body pd-y-15 pd-x-10">
                    <canvas id="historique-tarifs-chart" height="200"></canvas>
                </div>
            </div>

        </div>
    </div>

    <?php if( residence_mgmt_user_plan_has_access('PAGE_GROUPE_SECTION_RECHERCHE') ):  ?>
    <div class="row">
      <div class="col-md-8">

          <div class="card">
              <div class="card-header d-sm-flex align-items-start justify-content-between">
                  <h6 class="lh-5 mg-b-0 text-uppercase">Requête</h6>
              </div>
              <div class="card-body pd-y-15 pd-x-10">
                  <form method="POST" id="residence-filtre">

                      <div class="form-row">

                          <div class="form-group col-md-12">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="residence" name="residence" placeholder="Résidence" value="<?php echo (!empty($_POST['residence'])) ? $_POST['residence'] : '' ?>" />
                              </div>
                          </div>

                          <div class="form-group col-md-12">
                              <select id="departement-field" name="departement[]" class="form-control form-control-sm select2" multiple>
                                  <option value="">Departements</option>
                                  <?php foreach( $departements as $departement ): ?>
                                      <option value="<?php echo $departement->field_departement_tid; ?>" <?php echo ( !empty($_POST['departement']) && in_array($departement->field_departement_tid, $_POST['departement'])) ? "selected" : "" ?>><?php echo $departement->name; ?></option>
                                  <?php endforeach; ?>
                              <select>
                          </div>

                          <div class="form-group col-md-12">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                                  </div>
                                  <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville"  value="<?php echo (!empty($_POST['ville'])) ? $_POST['ville'] : '' ?>"/>
                              </div>
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
                  <div id="residences-map-result" class="heremap"></div>
              </div>
          </div>
      </div>
    </div>

    <div class="card mg-t-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h6 class="lh-5 mg-b-0">Résultats de la requête:</h6>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
              <div class="row">
                  <?php foreach( $statistiques as $title => $statistique ): ?>
                      <div class="media col-md-4 mg-t-15 mg-b-15">
                          <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-primary tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-4">
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

                        <table id="request-table" class="table dataTable no-footer">
                        <thead>
                            <tr>
                            <th scope="col">Résidence</th>
                            <th scope="col">Departement</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Tarif</th>
                            <th scope="col">Nombre de lits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rows = 0; ?>
                            <?php foreach( $residencesFiltered as $residence ): ?>
                            <tr>
                                <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                                <td><?php echo $residence->name; ?></td>
                                <td><?php echo $residence->field_location_locality; ?></td>
                                <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                                <td><?php echo $residence->field_capacite_value; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
              </div>
        </div>
    </div>
    <?php endif; ?>
  </section>
