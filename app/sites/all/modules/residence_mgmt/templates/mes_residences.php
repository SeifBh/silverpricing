<section class="mes-residences">
    <div class="row">
        <div class="col-md-12">

            <div class="card mg-t-10 mg-b-10">
                  <div class="card-header d-sm-flex align-items-start justify-content-between">
                      <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Mes résidences</h6>
                  </div>
                  <div class="card-body pd-y-15 pd-x-10">
                      <table id="mes-residences-table" class="table table-sm table-hover">
                          <thead>
                              <tr>
                                  <th scope="col"><input type="checkbox" class="all-residenceId"/></th>
                                  <th scope="col">Résidence</th>
                                  <th scope="col">Ville</th>
                                  <th scope="col">Gestionnaire</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Tarif</th>
                                  <th scope="col">Nbre de lits</th>
                                  <th scope="col">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php $rows = 0; ?>
                              <?php foreach( $residences as $residence ): ?>
                              <tr>
                                  <td><input type="checkbox" value="<?php echo $residence->nid ?>" class="residenceId" /></td>
                                  <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                                  <td><?php echo $residence->field_location_locality; ?></td>
                                  <td><?php echo $residence->field_gestionnaire_value; ?></td>
                                  <td><?php echo $residence->field_statut_value; ?></td>
                                  <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                                  <td><?php echo $residence->field_capacite_value; ?></td>
                                  <td><a href="<?php echo "/edit-residence/$residence->nid"; ?>" class="btn btn-primary btn-sm btn-icon"><i data-feather="edit"></i></a></td>
                              </tr>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                  </div>
            </div>

        </div>
    </div>

</section>
