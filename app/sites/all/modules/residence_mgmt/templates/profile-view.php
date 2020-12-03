<?php define("MODULE_PATH", "/sites/all/modules/residence_mgmt"); ?>
<div class="media d-block d-lg-flex">
    <div class="profile-sidebar pd-lg-r-25">
        <div class="row">
            <div class="col-sm-3 col-md-2 col-lg">
                <div class="avatar avatar-xxl avatar-online"><img
                        src="<?php echo MODULE_PATH; ?>/assets/img/user-default.png" class="rounded-circle" alt="">
                </div>
            </div><!-- col -->
            <div class="col-sm-8 col-md-7 col-lg mg-t-20 mg-sm-t-0 mg-lg-t-25">
                <h5 class="mg-b-2 tx-spacing--1"><?php echo ( $account != null ) ? $account->name : "" ?></h5>
                <p class="tx-color-03 mg-b-25"><?php echo ( $account != null ) ? $account->mail : "" ?></p>

                <div class="d-flex">
                    <div class="profile-skillset flex-fill">
                        <h4><?php echo count($account->field_acces_groupes["und"]); ?></h4>
                        <label>Groupes</label>
                    </div>
                    <div class="profile-skillset flex-fill">
                        <h4><?php echo count($residences); ?></h4>
                        <label>Résidences</label>
                    </div>
                </div>
            </div><!-- col -->

        </div><!-- row -->

    </div><!-- profile-sidebar -->
    <div class="media-body mg-t-40 mg-lg-t-0 pd-lg-x-10">

        <div class="card mg-b-25">
            <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                <h6 class="tx-uppercase tx-semibold mg-b-0">Général</h6>
            </div><!-- card-header -->
            <div class="card-body pd-25">
                <div class="row">
                    <div class="col-sm col-lg-12 col-xl">
                        <div class="media">
                            <div
                                class="wd-45 ht-45 bg-primary rounded d-flex align-items-center justify-content-center">
                                <i data-feather="pocket" class="tx-white-7 wd-20 ht-20"></i>
                            </div>
                            <div class="media-body pd-l-25">
                                <h6 class="tx-color-01 tx-uppercase mg-b-5">Crédit</h6>
                                <span class="tx-12"><?php echo $account->field_balance["und"][0]["value"]; ?></span>
                            </div>
                        </div><!-- media -->
                    </div><!-- col -->

                    <div class="col-sm col-lg-12 col-xl">
                        <div class="media">
                            <div
                                class="wd-45 ht-45 bg-primary rounded d-flex align-items-center justify-content-center">
                                <i data-feather="shield" class="tx-white-7 wd-20 ht-20"></i>
                            </div>
                            <div class="media-body pd-l-25">
                                <h6 class="tx-color-01 tx-uppercase mg-b-5">Plan</h6>
                                <span class="tx-12"><?php echo $plan->name; ?></span>
                            </div>
                        </div><!-- media -->
                    </div><!-- col -->

                </div><!-- row -->
            </div><!-- card-body -->
        </div><!-- card -->

        <div class="card mg-b-25">
            <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                <h6 class="tx-uppercase tx-semibold mg-b-0">Mes résidences</h6>
            </div><!-- card-header -->
            <div class="card-body pd-y-15 pd-x-10">
                <table id="profile-residences-table" class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Résidence</th>
                            <th scope="col">Gestionnaire</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Tarif</th>
                            <th scope="col">Nbre de lits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rows = 0; ?>
                        <?php foreach( $residences as $residence ): ?>
                        <tr>
                            <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                            <td><?php echo $residence->field_gestionnaire_value; ?></td>
                            <td><?php echo $residence->field_location_locality; ?></td>
                            <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                            <td><?php echo $residence->field_capacite_value; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- media-body -->

</div><!-- media -->
