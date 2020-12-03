<section class="edit-residence">
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h4 class="lh-5 mg-b-0">Modifier la résidence: <?php echo $chambre->title; ?></h4>
                </div>
                <div class="card-body pd-y-15 pd-x-10">

                    <form action="" method="POST">

                        <fieldset class="form-fieldset">
                            <legend>Gestion des tarifs chambres</legend>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_simple" class="d-block">Tarif Chambre Simple</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_simple" id="tarif_chambre_simple" value="<?php echo $chambre->field_tarif_chambre_simple['und'][0]['value']; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_double" class="d-block">Tarif Chambre Double</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_double" id="tarif_chambre_double" value="<?php echo $chambre->field_tarif_chambre_double['und'][0]['value']; ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_simple_temporaire" class="d-block">Tarif Chambre Simple Temporaire</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_simple_temporaire" id="tarif_chambre_simple_temporaire" value="<?php echo $chambre->field_tarif_chambre_simple_tempo['und'][0]['value']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_double_temporaire" class="d-block">Tarif Chambre Double Temporaire</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_double_temporaire" id="tarif_chambre_double_temporaire" value="<?php echo $chambre->field_tarif_chambre_double_tempo['und'][0]['value']; ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_simple_aide_sociale" class="d-block">Tarif Chambre Simple "aide sociale"</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_simple_aide_sociale" id="tarif_chambre_simple_aide_sociale" value="<?php echo $chambre->field_tarif_cs_aide_sociale['und'][0]['value']; ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tarif_chambre_double_aide_sociale" class="d-block">Tarif Chambre Double "aide sociale"</label>
                                    <input type="number" step="0.01" min="0" lang="en" class="form-control" name="tarif_chambre_double_aide_sociale" id="tarif_chambre_double_aide_sociale" value="<?php echo $chambre->field_tarif_cd_aide_sociale['und'][0]['value']; ?>">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-fieldset mg-t-10">
                            <legend>Gestion des chambres</legend>

                            <fieldset class="form-fieldset mg-t-10">
                                <legend>Chambres Simples</legend>

                                <div class="form row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_entree_de_gamme" class="d-block">Nombre de chambres "entrée de gamme"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_entree_de_gamme" id="nombre_cs_entree_de_gamme" value="<?php echo $chambre->field_nombre_cs_entre_de_gamme['und'][0]['value']; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_standard" class="d-block">Nombre de chambres "standard"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_standard" id="nombre_cs_standard" value="<?php echo $chambre->field_nombre_cs_standard['und'][0]['value']; ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_superieur" class="d-block">Nombre de chambres "supérieur"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_superieur" id="nombre_cs_superieur" value="<?php echo $chambre->field_nombre_cs_superieur['und'][0]['value']; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_luxe" class="d-block">Nombre de chambres "luxe"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_luxe" id="nombre_cs_luxe" value="<?php echo $chambre->field_nombre_cs_luxe['und'][0]['value']; ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_alzheimer" class="d-block">Nombre de chambres "alzheimer"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_alzheimer" id="nombre_cs_alzheimer" value="<?php echo $chambre->field_nombre_cs_alzheimer['und'][0]['value']; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nombre_cs_aide_sociale" class="d-block">Nombre de chambres "aide sociale"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cs_aide_sociale" id="nombre_cs_aide_sociale" value="<?php echo $chambre->field_nombre_cs_aide_sociale['und'][0]['value']; ?>">
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="form-fieldset mg-t-10">
                                <legend>Chambres Doubles</legend>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_cd_standard" class="d-block">Nombre de chambres "standard"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cd_standard" id="nombre_cd_standard" value="<?php echo $chambre->field_nombre_cd_standard['und'][0]['value']; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nombre_cd_aide_sociale" class="d-block">Nombre de chambres "aide sociale"</label>
                                        <input type="number" step="1" min="0" lang="en" class="form-control" name="nombre_cd_aide_sociale" id="nombre_cd_aide_sociale" value="<?php echo $chambre->field_nombre_cd_aide_sociale['und'][0]['value']; ?>">
                                    </div>
                                </div>

                            </fieldset>
                        </fieldset>

                        <fieldset class="form-fieldset mg-t-10">
                            <div class="form-row">
                                <button type="submit" class="btn btn-primary pd-x-50">Enregistrer</button>
                            </div>
                        </fieldset>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
