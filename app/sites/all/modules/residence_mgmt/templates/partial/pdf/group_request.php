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
            <table class="table dataTable no-footer">
                <thead>
                    <tr>
                    <th scope="col">Résidence</th>
                    <th scope="col">Departement</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Tarif</th>
                    <th scope="col">Nombre de lits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rows = 0; ?>
                    <?php foreach( $historyResult->response as $residence ): ?>
                    <tr>
                        <td><a href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo $residence->title ?></a></td>
                        <td><?php echo $residence->name; ?></td>
                        <td><?php echo $residence->field_location_locality; ?></td>
                        <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                        <td><?php echo $residence->field_capacite_value; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
