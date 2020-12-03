<section class="yeelder_tools-section">

    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card ht-lg-100p">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Développement Tools</h6>

                </div><!-- card-header -->
                <div class="card-body pd-0">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row departement-wrapper mg-10">
                                <div class="col-md-12">
                                    <div class="alert alert-warning alert-devtools d-none" role="alert">
                                      <h4 class="alert-heading">Erreur !</h4>
                                      <p>Vous avez atteint votre limite d'envoi Développement tools.</p>
                                    </div>

                                    <div class="alert alert-danger alert-devtools-error d-none" role="alert">
                                      <h4 class="alert-heading">Erreur !</h4>
                                      <p>Merci de vérifier que tous les champs sont bien renseignés et réessayer.</p>
                                    </div>
                                </div>
                                <div class="col-md-12 mg-b-10">
                                    <select id="department-selected" class="custom-select">
                                        <option value="none">Département</option>
                                        <?php foreach( $departements as $number => $name ): ?>
                                            <option value="<?php echo $number; ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- <div class="col-md-12 mg-b-10">
                                    <select id="city-selected" class="custom-select">
                                        <option value="all">Toutes les communes</option>
                                    </select>
                                </div> -->

                                <div class="col-md-12 mg-b-10">
                                    <select id="city-autocomplete" multiple="true" class="form-control form-control-sm custom-select-autocomplete">
                                    </select>
                                </div>

                                <div class="col-md-12 mg-b-10">
                                    <button type="button" id="department-submit" class="btn btn-dark btn-block">Envoyer</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="yeelder-tools-leafletmap" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>

                </div>

                <div class="card-footer devtools-summary">
                    <div class="row row-sm">
                        <div class="col-6 col-sm-4 col-md-3 col-lg resultat-departement">
                          <h4 class="tx-normal tx-rubik mg-b-10 resultat-departement-valeur">0</h4>
                          <h6 class="tx-uppercase tx-spacing-1 tx-semibold tx-10 tx-color-02 mg-b-2">Département</h6>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg resultat-prive">
                          <h4 class="tx-normal tx-rubik mg-b-10 resultat-prive-valeur">0</h4>
                          <h6 class="tx-uppercase tx-spacing-1 tx-semibold tx-10 tx-color-02 mg-b-2">Privé</h6>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg resultat-associatif">
                          <h4 class="tx-normal tx-rubik mg-b-10 resultat-associatif-valeur">0</h4>
                          <h6 class="tx-uppercase tx-spacing-1 tx-semibold tx-10 tx-color-02 mg-b-2">Associatif</h6>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg resultat-public">
                          <h4 class="tx-normal tx-rubik mg-b-10 resultat-public-valeur">0</h4>
                          <h6 class="tx-uppercase tx-spacing-1 tx-semibold tx-10 tx-color-02 mg-b-2">Public</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card ht-lg-100p">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Demandes de valeurs foncières</h6>
                </div><!-- card-header -->
                <div class="card-body">
                    <form id="dvf-form-wrapper" method="post">
                    <div class="row dvf-wrapper">

                        <div class="col-md-3 mg-b-10">
                            <select id="year-selection" class="form-control form-control-sm" required="required">
                                <option>Année</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>

                        <div class="col-md-3 mg-b-10">
                            <select id="dvf-department-selected" class="custom-select">
                                <option value="none">Département</option>
                                <?php foreach( $departements as $number => $name ): ?>
                                    <option value="<?php echo $number; ?>"><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mg-b-10">
                            <select id="city-dvf-autocomplete" multiple="true" placeholder="Villes" class="form-control form-control-sm custom-select-autocomplete">
                            </select>
                        </div>

                        <div class="col-md-2 mg-b-10">
                            <button type="button" id="dvf-submit" class="btn btn-dark btn-block">Envoyer</button>
                        </div>
                    </div>
                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="yeelder-tools-table" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td>ID mutation</td>
                                        <td>Date mutation</td>
                                        <td>Nom commune</td>
                                        <td>Code postal</td>
                                        <td>Nature mutation</td>
                                        <td>Type local</td>
                                        <td>Surface réelle batiment</td>
                                        <td>Nature culture</td>
                                        <td>Surface terrain</td>
                                        <td>Valeur fonciere</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


