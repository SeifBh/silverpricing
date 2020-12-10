<section class="section-residences">

    <div class="row">
        <div class="col-md-4">

            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="lh-5 mg-b-0">Requête</h5>
                </div>
                <div class="card-body pd-y-15 pd-x-10">

                    <div>
                        <h6 class="mg-b-5">Adresse : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->adresse; ?></p>
                    </div>

                    <div>
                        <h6 class="mg-b-5">Latitude : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->latitude; ?></p>
                    </div>

                    <div>
                        <h6 class="mg-b-5">Longitude : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->longitude; ?></p>
                    </div>

                    <div>
                        <h6 class="mg-b-5">Statut : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->statut; ?></p>
                    </div>

                    <div>
                        <h6 class="mg-b-5">Périmetre : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->perimetre; ?></p>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-body pd-y-15 pd-x-10">
                    <div id="map-recherche-silverex" class="heremap"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="card mg-t-10 mg-b-10">
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
                <?php foreach( $requete_statistiques as $title => $statistique ): ?>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-database"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $title ?></span>
                            <span class="info-box-number"><?php echo $statistique ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <table id="residences-result-table" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Résidence</th>
                                        <th scope="col">Code postal</th>
                                        <th scope="col">Ville</th>
                                        <!-- <th scope="col">Gestionnaire</th> -->
                                        <th scope="col">Département</th>
                                        <th scope="col">Distance</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Tarif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rows = 0; ?>
                                    <?php foreach( $historyBody->response as $k=>$residence ): ?>
                                    <tr>
                                        <td><a
                                                href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo ($k+1).' '. $residence->title ?></a>
                                        </td>
                                        <td><?php echo $residence->field_location_postal_code; ?></td>
                                        <td><?php echo $residence->field_location_locality; ?></td>
                                        <!-- <td><?php //echo $residence->field_gestionnaire_value; ?></td> -->
                                        <td><?php echo $residence->name; ?></td>
                                        <td><?php echo round($residence->distance, 2); ?> KM</td>
                                        <td><?php echo $residence->field_statut_value; ?></td>
                                        <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
