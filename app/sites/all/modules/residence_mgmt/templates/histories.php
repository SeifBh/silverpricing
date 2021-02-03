<style>
#histories-table > thead > tr > th:nth-child(1) > select{
    margin: -49Px 0 0 -28px;
    position: absolute;
    height: 30px;
}
.json{word-break:all}
.btn.btn-sm.btn-primary.btn-icon{padding: 0 5px; margin: 0;font-size:20px}
.btn svg{width:auto;height:auto;}
</style>
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
                          <th scope="col">Type</th>
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
                      foreach( $histories as $h => $history ){
                          $_ex=$history->field_excel_value;
                          $_exo=$history->field_excelorganismes_value;
                          ?>
                          <tr>
                              <td><?php echo $history->title;?></td>
                              <td><?php echo ($history->field_name_value) ? $history->field_name_value : $history->title; ?></td>
                              <td class="json">
                                <?php
                                    if(strpos($_SERVER['HTTP_HOST'],'.home')){
                                        $a=1;
                                    }
                                    $currentHistory = json_decode($history->body_value);
                                    $currentHistory->request=array_filter((array)$currentHistory->request);
                                    if(isset($currentHistory->request['residence']))unset($currentHistory->request['residence']);
                                    if(isset($currentHistory->request['confirm']))unset($currentHistory->request['confirm']);
                                    if(isset($currentHistory->request['adresse']))unset($currentHistory->request['adresse']);
                                    echo json_encode($currentHistory->request);
                                ?>
                              </td>
                              <td><?php echo $history->field_balance_consumed_value; ?></td>
                              <td><?php echo date("Y-m-d H:i:s", $history->created); ?></td>
                              <td nowrap>
                                  <a class="btn btn-sm btn-primary btn-icon" href="<?php echo "/ged/" . $account->uid . "/document/" . $history->nid ; ?>" title="Télécharger pdf"><span class="iconify" data-icon="bx:bxs-file-pdf" data-inline="false"></span></i></a>
                                  <?php if(in_array($history->title,['RESIDENCES_REQUEST','prescripteur'])){?>
                                  <a class="btn btn-sm btn-primary btn-icon" href="<?php echo "/history/" . $history->nid ; ?>" title="Consulter"><span class="iconify" data-icon="clarity:eye-line" data-inline="false"></span></a>
                                  <?php if($_ex){?><a class="btn btn-sm btn-primary btn-icon" href="<?php echo $_ex;?>" title="<?=(in_array($history->title,['RESIDENCES_REQUEST'])?'résidences':'établissements')?>"><span class="iconify" data-icon="<?=(in_array($history->title,['RESIDENCES_REQUEST'])?'fa-solid:home':'fa:hospital-o')?>" data-inline="false"></span></a><?}#?>
                                  <?php if($_exo){?><a title="<?=(in_array($history->title,['RESIDENCES_REQUEST'])?'établissements':'personnes')?>" class="btn btn-sm btn-primary btn-icon" href="<?php echo $_exo;?>"><span class="iconify" data-icon="<?=(in_array($history->title,['RESIDENCES_REQUEST'])?'fa:hospital-o':'fa-regular:id-card')?>" data-inline="false"></span></span></a><?}
                                  }#?>
                              </td>
                          </tr>
                      <?php } ?>
                  </tbody>
              </table>
              </div>
            </div>
        </div>
    </div>
</section>
<script>
p= {"language": {url: frenchDataTables}, "searching": true, "lengthChange": false, "paging": true, "info": false, "pageLength": 10, "order": [[4, "desc"]]
    , "columnDefs": [{"searchable": false, "targets": [3,4,5]}]
    , initComplete: function () {
        this.api().columns([0]).every(function () {
            var column = this, select = $('<select><option value="">Tous</option></select>');
            column.data().unique().sort().each(function (d, j) {
                if (!d) return;
                select.append('<option value="' + d + '">' + d + '</option>')
            });
            select
                .appendTo($(column.header()))
                //.appendTo($(column.footer()))//.empty()
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });
        });
    }
};
$('#histories-table').DataTable(p);
</script>
