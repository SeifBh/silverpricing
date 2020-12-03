<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <style type="text/css">

            body {
                font-family: "Times New Roman", Georgia, Serif;
            }

            #content table.table {
                width: 100%;
                font-size: 12px;
                text-align: center;
                border-collapse: collapse;
            }

            #content table.table td, #content table.table th {
                border: 1px solid #000;
            }

            .tx-success {
                color: #10b759;
            }

            .tx-danger {
                color: #dc3545;
            }

        </style>
    </head>
    <body>
        <div id="content">

            <div class="information">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <td>Code commune</td>
                            <td>Nom commune</td>
                            <td>Résidences</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $historyResult->response->communesParsed->features as $feature ): ?>
                        <tr>
                            <td><?php echo $feature->properties->code; ?></td>
                            <td><?php echo $feature->properties->nom; ?></td>
                            <td><?php echo count($feature->properties->residences); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="dvf-wrapper">
                <h2>Demande de valeur foncière</h2>
                <table class="table table-sm table-hover">
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
                        <?php $historyResult->response->dvf = json_decode($historyResult->response->dvf); ?>
                        <?php foreach( $historyResult->response->dvf as $dvf ): ?>
                        <tr>
                            <td><?php echo $dvf->id_mutation; ?></td>
                            <td><?php echo $dvf->date_mutation; ?></td>
                            <td><?php echo $dvf->nom_commune; ?></td>
                            <td><?php echo $dvf->code_postal; ?></td>
                            <td><?php echo $dvf->nature_mutation; ?></td>
                            <td><?php echo $dvf->type_local; ?></td>
                            <td><?php echo $dvf->surface_reelle_bati; ?></td>
                            <td><?php echo $dvf->nature_culture; ?></td>
                            <td><?php echo $dvf->surface_terrain; ?></td>
                            <td><?php echo $dvf->valeur_fonciere; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
