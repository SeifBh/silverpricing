<?php
$a='https://ehpad.home/ged/1/document/48165';?>
<!DOCTYPE HTML>
<html id="h">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            table{border-collapse:collapse;}
            table td,table th{text-align:left;verticali-align:top;}
            .nowrap{white-space:nowrap;}
            .results tr:nth-child(even){background:#EEEEEE;}
            #h #b #content tr.black,.black{background:#DDD;color:#000;}

            img{max-height:30vh}
            body {font-family: "Times New Roman", Georgia, Serif;}

            #header {
              margin-bottom: 25px;
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

        </style>
    </head>
    <body id="b">
      <table id="header">
            <tr><td>
            <div>
                <p><strong>Adresse : </strong><?php echo $historyResult->request->adresse; ?></p>
            </div>

            <div>
                <p><strong>Latitude : </strong><?php echo $historyResult->request->latitude; ?></p>
            </div>

            <div>
                <p><strong>Longitude : </strong><?php echo $historyResult->request->longitude; ?></p>
            </div>

            <div>
                <p><strong>Statut : </strong><?php echo $historyResult->request->statut; ?></p>
            </div>

            <div>
                <p><strong>Périmetre : </strong><?php echo $historyResult->request->perimetre; ?></p>
            </div>
                    </td><td>
                        <?php
                        if(isset($history->field_map["und"][0]["value"])){
                            echo"<img src='".$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$history->field_map["und"][0]["value"]."'>";
                        }
                        ?>
                    </td></tr><table>

        <div id="content">
            <table class="table table-sm table-hover results">
                <thead>
                <tr class="black">
                    <th scope="col">Id</th>
                    <th scope="col">Résidence</th>
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
                    foreach( $historyResult->response as $k=>$residence ): ?>
                    <tr>
                        <td><?php echo $k+1 ?></td>
                        <td><?php echo $residence->title ?></td>
                        <td><?php echo $residence->field_location_postal_code; ?></td>
                        <td><?php echo $residence->field_location_locality; ?></td>
                        <td><?php echo $residence->name; ?></td>
                        <td><?php echo round($residence->distance, 2); ?> KM</td>
                        <td><?php echo $residence->field_statut_value; ?></td>
                        <td class="nowrap"><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
