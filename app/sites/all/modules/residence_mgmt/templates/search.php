<?php $a=1;?>
<section class="section-residences">

    <div class="row">
        <div class="col-md-4">

            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Recherche</h5>
                </div>
                <div class="card-body pd-y-15 pd-x-10">
                    <form method="POST" id="search-form" >

                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse"  value="<?php echo (!empty($_POST['adresse'])) ? $_POST['adresse'] : '' ?>"/>
                            </div>
                        </div>

                        <div class="form-group col-md-12 d-none">
                            <input type="text" class="form-control form-control-sm" id="latitude" name="latitude" placeholder="Latitude"  value="<?php echo (!empty($_POST['latitude'])) ? $_POST['latitude'] : '' ?>"/>
                        </div>

                        <div class="form-group col-md-12 d-none">
                            <input type="text" class="form-control form-control-sm" id="longitude" name="longitude" placeholder="Longitude"  value="<?php echo (!empty($_POST['longitude'])) ? $_POST['longitude'] : '' ?>"/>
                        </div>

                        <div class="form-group col-md-12">
                            <?php $statuses = array('Privé', 'Public', 'Associatif'); ?>
                            <select id="statut" name="statut" class="form-control form-control-sm">
                                <option value="aucun">Statut</option>
                                <?php foreach( $statuses as $status ): ?>
                                    <option value="<?php echo $status; ?>" <?php echo ( !empty($_POST['statut']) && $_POST['statut'] == $status) ? "selected" : "" ?>><?php echo $status; ?></option>
                                <?php endforeach; ?>
                            <select>
                        </div>

                        <div class="form-group col-md-12">
                            <input type="number" class="form-control form-control-sm" id="perimetre" name="perimetre" placeholder="Périmetre" min="1" value="<?php echo (!empty($_POST['perimetre'])) ? $_POST['perimetre'] : 5 ?>"/>
                        </div>

                        <div class="form-group col-md-12">
                            <select id="categories" name="categories[]" multiple class="form-control form-control-sm">
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->code_categorie; ?>" <?php echo ( in_array($category->code_categorie, $_POST['categories']) ) ? "selected":""; ?>><?php echo $category->lib_categorie; ?></option>
                                <?php endforeach; ?>
                            <select>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Rechercher</button>
                        </div>

                        </form>
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
                                  <span class="info-box-number"><?php echo $statistique ?><?php echo (in_array($title, array( "Tarif moyen", "Tarif médian", "Tarif plus bas", "Tarif plus haut" ))) ? "€": ""; ?></span>
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
                            <th scope="col">Groupe</th>
                            <th scope="col">Code postal</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Département</th>
                            <th scope="col">Distance</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tarif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rows = 0;
                            foreach( $residences as $k=>$residence ): ?>
                            <tr>
                                <td>
                                    <?php
                                        if( isset($residence->field_logo_fid) ) {
                                            echo theme('image', array(
                                              'path' => file_create_url(file_load($residence->field_logo_fid)->uri),
                                              'width' => 16
                                            ));
                                        }
                                    ?>
                                    <a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a>
                                </td>
                                <td>#<?php echo ($k+1).' '.$residence->grp_term_name; ?></td>
                                <td><?php echo $residence->field_location_postal_code; ?></td>
                                <td><?php echo $residence->field_location_locality; ?></td>
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
<script>
if(typeof post['latitude']!='undefined'){
    defer(captureMap,function(){return (toload.length==0 && typeof window['hereMap']=='object' && typeof  window['jQuery']=='function');});
}
</script>
