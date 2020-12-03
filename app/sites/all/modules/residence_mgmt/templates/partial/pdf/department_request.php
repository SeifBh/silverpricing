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
            <table class="table table-hover table-sm no-footer">
                <thead>
                    <tr>
                    <th scope="col">Résidence</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Groupe</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tarif</th>
                    <th scope="col">Dif tarifs moy dep</th>
                    <th scope="col">Dif tarifs moy requête</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rows = 0; ?>
                    <?php foreach( $historyResult->response->residences as $residence ): ?>
                    <?php
                        $statistique_globale = json_decode( json_encode($historyResult->response->statistique_globale), true);
                        $requete_statistique = json_decode( json_encode($historyResult->response->requete_statistique), true);
                        $difTarifsMoyDep = round($residence->field_tarif_chambre_simple_value - $statistique_globale["Tarif moyen"], 2);
                        $difTarifsMoyRequete = round($residence->field_tarif_chambre_simple_value - $requete_statistique["Tarif moyen"], 2);
                    ?>
                    <tr>
                        <td><?php echo $residence->title ?></td>
                        <td><?php echo $residence->field_location_locality; ?></td>
                        <td><img src="<?php echo file_create_url(file_load($residence->field_logo_fid)->uri); ?>" width="32" /></td>
                        <td><?php echo $residence->field_statut_value; ?></td>
                        <td><?php echo $residence->field_tarif_chambre_simple_value; ?>€</td>
                        <td class="<?php echo ($difTarifsMoyDep > 0) ? "tx-success":" tx-danger"; ?>">
                            <?php echo $difTarifsMoyDep; ?>€
                        </td>
                        <td class="<?php echo ($difTarifsMoyRequete > 0) ? "tx-success":" tx-danger"; ?>">
                            <?php echo $difTarifsMoyRequete; ?>€
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
