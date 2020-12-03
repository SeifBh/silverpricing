<section class="groupes-section">
  <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Groupes</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
              <div class="col-md-12">
                <table id="groupes-table" class="table table-hover table-sm">
                  <thead>
                      <tr>
                          <th scope="col">Logo</th>
                          <th scope="col">Groupe</th>
                          <th scope="col">Résidence</th>
                          <th scope="col">Lits</th>
                          <th scope="col">Tarif min</th>
                          <th scope="col">Tarif max</th>
                          <th scope="col">Tarif moyen</th>
                          <th scope="col">Tarif médian</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach( $groupes as $groupe ): ?>
                          <tr>
                              <td>
                                  <a href="<?php echo "/groupe/" . $groupe->tid ?>">
                                      <?php
                                          if( isset($groupe->field_logo_fid) ) {
                                              echo theme('image', array(
                                                'path' => file_create_url(file_load($groupe->field_logo_fid)->uri),
                                                'width' => 32
                                              ));
                                          }
                                      ?>
                                  </a>
                              </td>
                              <td><a href="<?php echo "/groupe/" . $groupe->tid ?>"><?php echo $groupe->name; ?></a></td>
                              <td><?php echo $groupe->count; ?></td>
                              <td><?php echo $groupe->nombre_lits; ?></td>
                              <td><?php echo $groupe->tarif_min; ?> €</td>
                              <td><?php echo $groupe->tarif_max; ?> €</td>
                              <td><?php echo $groupe->tarif_moyen; ?> €</td>
                              <td><?php echo $groupe->tarif_median; ?> €</td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
            </div>
        </div>
    </div>
</section>
