<section class="nearby-residences-updated-section">
  <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="lh-5 mg-b-0">Nearby residences updated</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
                <div class="col-md-12">
                    <table id="nearby-residences-updated-table" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Notre résidence</th>
                                <th>Concurrent résidence</th>
                                <th>Département</th>
                                <th>Distance</th>
                                <th>Notre tarif</th>
                                <th>Ancien tarif</th>
                                <th>Nouveau tarif</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $nearbyResidencesUpdated as $nearbyResidence ): ?>
                                <tr>
                                    <td><a href="<?php echo '/residence/' . $nearbyResidence->primary_nid; ?>"><?php echo $nearbyResidence->notre_residence_name; ?></a></td>
                                    <td><a href="<?php echo '/residence/' . $nearbyResidence->residence_nid; ?>"><?php echo $nearbyResidence->concurrent_residence_name; ?></a></td>
                                    <td><?php echo $nearbyResidence->department_name; ?></td>
                                    <td><?php echo number_format($nearbyResidence->distance, 2); ?> KM</td>
                                    <td><?php echo $nearbyResidence->notre_tarif; ?> €</td>
                                    <td><?php echo $nearbyResidence->old_price; ?> €</td>
                                    <td><?php echo $nearbyResidence->new_price; ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
