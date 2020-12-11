<section class="histories-section">
  <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Historiques</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
              <div class="col-md-12">
                <table id="histories-table" class="table table-hover table-sm">
                  <thead>
                      <tr>
                          <th scope="col">Recherche</th>
                          <th scope="col">Détails de la recherche</th>
                          <th scope="col">Crédit utilisés</th>
                          <th scope="col">Créé le</th>
                          <th scope="col">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $a=1;
                      foreach( $histories as $h => $history ): ?>
                          <tr>
                              <td><?php echo ($history->field_name_value) ? $history->field_name_value : $history->title; ?></td>
                              <td>
                                <p><?php
                                    $currentHistory = json_decode($history->body_value);
                                    if( $currentHistory->request->adresse ) {
                                        unset($currentHistory->request->adresse);
                                    }
                                    echo json_encode($currentHistory->request);
                                ?></p>
                              </td>
                              <td><?php echo $history->field_balance_consumed_value; ?></td>
                              <td><?php echo date( "d-m-Y H:i:s", $history->created); ?></td>
                              <td nowrap>
                                  <a class="btn btn-sm btn-primary btn-icon" href="<?php echo "/ged/" . $account->uid . "/document/" . $history->nid ; ?>" title="Télécharger"><i data-feather="download"></i></a>
                                  <?php if($history->title == "RESIDENCES_REQUEST"){?>
                                  <a class="btn btn-sm btn-primary btn-icon" href="<?php echo "/history/" . $history->nid ; ?>" title="Consulter"><i data-feather="eye"></i></a>
                                  <?php if($history->field_excel_value){?><a class="btn btn-sm btn-primary btn-icon" href="<?php echo $history->field_excel_value;?>" title="excel"><span class="iconify" data-icon="fe-file-excel" data-inline="false"></span></a><?}}#?>
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
