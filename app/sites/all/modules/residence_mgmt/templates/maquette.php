<section class="ma-maquette">
    <div class="row">
        <div class="col-md-12">

            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h6 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Ma Maquette : <?php echo $maquette->title; ?>
                    </h6>
                </div>

                <div class="card-body pd-y-15 pd-x-10">

                    <div class="row">

                        <div class="col-md-12 maquette-modifiee">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-sm">
                                        <tr>
                                            <th colspan="3">Chambres simples</th>
                                        </tr>
                                        <tr class="chambres-simples chambres-entree-de-gamme">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_entree_de_gamme)) ? $typesDeChambres->cs_entree_de_gamme : "entrée de gamme" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_entree_de_gamme_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_entree_de_gamme_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr class="chambres-simples chambres-standard">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_standard)) ? $typesDeChambres->cs_standard : "standard" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_standard_lits['und'][0]['value']; ?></td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_standard_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr class="chambres-simples chambres-superieur">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_superieur)) ? $typesDeChambres->cs_superieur : "supérieur" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_superieur_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_superieur_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr class="chambres-simples chambres-luxe">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_luxe)) ? $typesDeChambres->cs_luxe : "luxe" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_luxe_lits['und'][0]['value']; ?></td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_luxe_tarif['und'][0]['value']; ?> €</td>
                                        </tr>
                                        <tr class="chambres-simples chambres-alzheimer">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_alzheimer)) ? $typesDeChambres->cs_alzheimer : "alzheimer" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_alzheimer_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_alzheimer_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr class="chambres-simples chambres-aide-sociale">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cs_aide_sociale)) ? $typesDeChambres->cs_aide_sociale : "aide-sociale" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cs_aide_sociale_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cs_aide_sociale_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Chambres doubles</th>
                                        </tr>
                                        <tr class="chambres-doubles chambres-standard">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cd_standard)) ? $typesDeChambres->cd_standard : "standard" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cd_standard_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cd_standard_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                        <tr class="chambres-doubles chambres-aide-sociale">
                                            <td>Chambres
                                                "<?php echo (!empty($typesDeChambres->cd_aide_sociale)) ? $typesDeChambres->cd_aide_sociale : "aide-sociale" ?>"
                                            </td>
                                            <td class="nombre-de-lits">
                                                <?php echo $maquette->field_cd_aide_sociale_lits['und'][0]['value']; ?>
                                            </td>
                                            <td class="tarif-de-chambre">
                                                <?php echo $maquette->field_cd_aide_sociale_tarif['und'][0]['value']; ?> €
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <div class="tmh-wrapper text-center mg-t-20">
                                        <?php
                                              $totalChambres = $maquette->field_cs_entree_de_gamme_lits['und'][0]['value'] + $maquette->field_cs_standard_lits['und'][0]['value']
                                                + $maquette->field_cs_superieur_lits['und'][0]['value'] + $maquette->field_cs_luxe_lits['und'][0]['value']
                                                + $maquette->field_cs_alzheimer_lits['und'][0]['value'] + $maquette->field_cd_aide_sociale_lits['und'][0]['value']
                                                + $maquette->field_cd_standard_lits['und'][0]['value'] + $maquette->field_cd_aide_sociale_lits['und'][0]['value'];

                                          ?>
                                        <div class="nombre-de-chambre mg-b-15 tx-bold">Nombre de chambres : <span
                                                class="badge badge-success"><?php echo $totalChambres; ?></span> </div>
                                        <div class="tmh-circle tmh-circle-default">
                                            <div class="tmh-circle-header">TMH</div>
                                            <div class="tmh-circle-body"><?php echo $maquette->field_tmh['und'][0]['value']; ?> €</div>
                                            <div class="tmh-circle-footer tx-spacing-1 tx-bold tx-12"><span
                                                    class="maquette_diff">0</span> /
                                                jour</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
