<section class="mes-maquettes-section">
  <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="lh-5 mg-b-0">Mes maquettes</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
              <div class="col-md-12">
                  <table id="mes-maquettes-table" class="table table-sm table-hover">
                      <thead>
                          <tr>
                              <td>Favoris</td>
                              <td>Résidence</td>
                              <td>Voir</td>
                              <td>Département</td>
                              <td>Tarif a partir de</td>
                              <td>Diff tarif actuel</td>
                              <td>TMH</td>
                              <td>Date</td>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach( $maquettes as $maquette ): ?>
                          <tr>
                            <td><?php echo ( $maquette->field_favoris_value == 0 ) ? '<i class="far fa-star"></i>':'<i class="fas fa-star"></i>'; ?></td>
                            <td>
                                <a href="<?php echo '/residence/' . $maquette->nid; ?>"><?php echo $maquette->title ?></a>
                            </td>
                            <td>
                                <button data-url="/maquette/<?=$maquette->n_nid;?>" class="btn btn-sm btn-primary mg-t-10 maquettePopin" data-toggle="modal" data-target="#maquettePopin"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                            </td>
                            <td><?php echo $maquette->name; ?></td>
                            <td><?php echo $maquette->field_tarif_chambre_simple_value; ?> €</td>
                            <td><?php echo round(($maquette->field_cs_entree_de_gamme_tarif_value - $maquette->field_tarif_chambre_simple_value), 2); ?> €</td>
                            <td><?php echo $maquette->field_tmh_value; ?> €</td>
                            <td><?php echo date('d-m-Y', $maquette->created); ?></td>
                          </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
    </div>
</section>

<div id="maquettePopin" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;"><div class="modal-dialog modal-dialog-centered modal-xl inside" role="document"></div></div>

<script>
    $(function() {
        $('.maquettePopin').on('click', function (event) {
            var url=this.getAttribute('data-url');
            cl('ev',url);
            $.ajax(url, {
                    method: 'GET',
                    success: function (response, status, xhr) {
                        //cl(response);
                        $('.inside').html(response);
                    }
                }
            );
        });
    });
</script>
<?return;?>


<a onlick="window.open('/maquette/'<?=$maquette->n_nid;?>','webcam','width=320,height=240');" href="#<?php echo '/maquette/' . $maquette->n_nid; ?>" class="badge badge-primary"></a>
