<section class="quick-win-section">
  <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="lh-5 mg-b-0">Quick win</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
                <div class="col-md-12">
                    <table id="quick-win-table" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <td>Résidence</td>
                                <td>Département</td>
                                <td>Position concurrence directe</td>
                                <td>Tarif</td>
                                <td>Moyenne concurrence directe</td>
                                <td>Différence</td>
                                <td>Recommendation de tarif à partir de</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $quickWins as $residence ): ?>
                                <tr>
                                    <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                                    <td><?php echo $residence->departement ?></td>
                                    <td><?php echo $residence->ranking_direct; ?></td>
                                    <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                                    <td><?php echo $residence->tarif_concurrence_direct; ?> €</td>
                                    <td><?php echo number_format( $residence->difference, 2 ); ?> €</td>
                                    <td>
                                      <!-- ( (b-a)/6 or (b+5a)/6 ) -->
                                      <?php echo number_format( ($residence->tarif_concurrence_direct + 5 * $residence->field_tarif_chambre_simple_value ) / 6, 2 ); ?> €
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
