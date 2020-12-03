<section class="departements-section">

    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card ht-lg-100p">
                <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Carte de France</h6>
                </div><!-- card-header -->
                <div class="card-body pd-0 map-wrapper">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="pd-y-10 pd-x-10">
                                <div id="french_vmap" class="ht-200" style="height: 400px"></div>
                            </div>

                            <ul class="list-inline legend text-center mg-12">
                              <li class="list-inline-item label label-1"><span> 0 - 25 </span></li>
                              <li class="list-inline-item label label-2"><span> 26 - 50 </span></li>
                              <li class="list-inline-item label label-3"><span> 51 - 100 </span></li>
                              <li class="list-inline-item label label-4"><span> 101 - 150 </span></li>
                              <li class="list-inline-item label label-5"><span> 151 + </span></li>
                            </ul>
                        </div>
                        <div class="col-md-5 department-info">
                            <h6 class="departement-name text-center pd-10 mg-0 tx-uppercase tx-spacing-1 tx-semibold"></h6>
                            <div class="row no-gutters">
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">NBRE DE MAISONS</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-nbre-maisons">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">NBRE DE LITS</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-nbre-lits">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MIN</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-tarif-min">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MAX</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-tarif-max">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MOYEN</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-tarif-moyen">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card card-body mg-8 pd-15">
                                        <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MEDIAN</h6>
                                        <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                          <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 dep-tarif-median">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dep-info-footer-wrapper pd-10">
                                <a href="#" class="btn btn-primary department-link d-block mx-auto"></a>
                            </div>

                        </div>
                    </div>
                </div><!-- card-body -->
            </div>
        </div>
    </div>

    <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Nombre de résidences par département</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
          <div class="row">
              <div class="col-md-12">
                    <canvas id="bar_chart_canvas" height="450"></canvas>
              </div>
          </div>
        </div>
    </div>

    <div class="card mg-t-10 mg-b-10">
        <div class="card-header d-sm-flex align-items-start justify-content-between">
            <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Départements</h5>
        </div>
        <div class="card-body pd-y-15 pd-x-10">
            <div class="row">
              <div class="col-md-12">
                <table id="department-table" class="table table-hover table-sm">
                  <thead>
                      <tr>
                          <th scope="col">Département</th>
                          <th scope="col">Tarif min</th>
                          <th scope="col">Tarif max</th>
                          <th scope="col">Tarif moyen</th>
                          <th scope="col">Tarif médian</th>
                          <th scope="col">Résidence</th>
                          <th scope="col">Lits</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach( $departements as $departement ):?>
                          <tr>
                              <td><a href="<?php echo "/departement/" . $departement->tid ?>"><?php echo $departement->name; ?></a></td>
                              <td><?php echo $departement->tarif_min; ?> €</td>
                              <td><?php echo $departement->tarif_max; ?> €</td>
                              <td><?php echo $departement->tarif_moyen; ?> €</td>
                              <td><?php echo $departement->tarif_median; ?> €</td>
                              <td><?php echo $departement->count; ?></td>
                              <td><?php echo $departement->nombre_lits; ?></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
            </div>
        </div>
    </div>

</section>

