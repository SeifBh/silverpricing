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
                                <a href="<?php echo '/maquette/' . $maquette->n_nid; ?>" class="badge badge-primary">Voir la maquette</a>
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
