<section class="dashboard-section">
    <div class="row">
        <div class="col-lg-5 col-xl-5 mg-t-10">
            <div class="card">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Quik wins</h5>
                </div>
                <div class="card-body">

                    <table id="dashboard-quick-win-table" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <td>Résidence</td>
                                <td>Tarif</td>
                                <td>Moyenne concurrence directe</td>
                                <td>Différence</td>
                                <td>Ranking</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $quickWins as $residence ): ?>
                                <tr>
                                    <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                                    <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                                    <td><?php echo $residence->tarif_concurrence_direct; ?> €</td>
                                    <td><?php echo number_format($residence->difference, 2 ); ?> €</td>
                                    <td><?php echo $residence->ranking_direct; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <a href="/quick_win" class="btn btn-primary btn-sm btn-block mg-10">Voir tous mes quick wins</a>

                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-7 mg-t-10">
            <div class="card">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Mes maquettes</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="search-form">
                                <input type="search" class="form-control" placeholder="Recherche résidence" id="recherche-residence">
                                <button class="btn" type="button"><i data-feather="search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-t-15">
                        <div class="col-md-12">
                            <table id="dashboard-mes-maquettes-table" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <td>Favoris</td>
                                        <td></td>
                                        <td>Résidence</td>
                                        <td>Département</td>
                                        <td>Tarif a partir de</td>
                                        <td>Diff tarif actuel</td>
                                        <td>TMH</td>
                                        <td>Date</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $maquettes as $maquette ):# ?>
                                    <tr>
                                      <td><?php echo ( $maquette->field_favoris_value == 0 ) ? '<i class="far fa-star"></i>':'<i class="fas fa-star"></i>'; ?></td>
                                      <td><a href="<?php echo '/maquette/' . $maquette->n_nid;?>" class="sb" title="Consulter maquette" ><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                      </td><td>
                                        <a href="<?php echo '/residence/' . $maquette->nid; ?>"><?php echo $maquette->title ?></a>
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

                            <a href="/mes_maquettes" class="btn btn-primary btn-sm btn-block mg-10">Voir toutes mes maquettes</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xl-12 mg-t-10">

            <div class="card">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Mes résidences:</h5>
                </div>
                <div class="card-body">

                    <div class="row mg-b-15">
                        <div class="col-md-3 col-xs-3">
                            <div class="card card-body mg-8 pd-15">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MOYEN</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 request-tarif-moyen"><?php echo $dashboardStatistics["Tarif moyen"]; ?> €</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-3">
                            <div class="card card-body mg-8 pd-15">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MIN</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 request-tarif-min"><?php echo $dashboardStatistics["Tarif plus bas"]; ?> €</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-3">
                            <div class="card card-body mg-8 pd-15">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MAX</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 request-tarif-max"><?php echo $dashboardStatistics["Tarif plus haut"]; ?> €</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-3">
                            <div class="card card-body mg-8 pd-15">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">TARIF MEDIAN</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 request-tarif-median"><?php echo $dashboardStatistics["Tarif médian"]; ?> €</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-lg-4 col-md-4">

                            <form method="POST" id="residence-filtre">

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-h-square"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="residence" name="residence" placeholder="Résidence" value="<?php echo (!empty($_POST['residence'])) ? $_POST['residence'] : '' ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <select id="departements-field" name="departements[]" class="form-control form-control-sm select2" multiple>
                                            <option value="">Departements</option>
                                            <?php foreach( $departements as $departement ): ?>
                                                <option value="<?php echo $departement->tid; ?>" <?php echo ( !empty($_POST['departement']) && in_array($departement->tid, $_POST['departement'])) ? "selected" : "" ?>><?php echo $departement->name; ?></option>
                                            <?php endforeach; ?>
                                        <select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="gestionnaire" name="gestionnaire" placeholder="Gestionnaire"  value="<?php echo (!empty($_POST['gestionnaire'])) ? $_POST['gestionnaire'] : '' ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Filtrer</button>
                                    </div>

                                </div>
                            </form>

                          </div>

                          <div class="col-lg-8 col-md-8">
                              <div id="dashboard-map-result" class="heremap"></div><?#?>
                          </div>
                    </div>


                    <!-- TABLE : REQUEST RESULT -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 mg-t-10">
                            <table id="mes-residences-table" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Résidences</th>
                                        <th scope="col">Départments</th>
                                        <th scope="col">Villes</th>
                                        <th scope="col">Gestionnaires</th>
                                        <th scope="col">Manager</th>
                                        <th scope="col">Position départementale</th>
                                        <th scope="col">Position concurrentielle</th>
                                        <th scope="col">Tarifs</th>
                                        <th scope="col">Nbre de lits</th>
                                        <th scope="col">Date maj</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
/*
<th scope="col">Status</th>
<td><?php /*echo $residence->field_statut_value;?></td>
*/
foreach( $residences as $residence ){ ?>
<tr>
<td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
<td><?php echo substr($residence->field_location_postal_code,0,2); ?></td>
<td><?php echo $residence->field_location_locality; ?></td>
<td><?php echo $residence->field_gestionnaire_value; ?></td>
<td><?php echo $residence->field_manager_value; ?></td>
<td><?php echo $residence->ranking['departement']; ?></td>
<td><?php echo $residence->ranking['concurrence_directe']; ?></td>
<td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
<td><?php echo $residence->field_capacite_value; ?></td>
<td><?php echo date('Y/m/d H:i:s',$residence->changed); #?></td>
</tr>
<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </row>

                </div>
            </div>

        </div>
    </div>

</section>
