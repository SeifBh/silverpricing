<?php
$a='https://ehpad.home/ged/1/document/48165';
#Used by WKhtml2Pdf
use mikehaertl\wkhtmlto\Pdf;
use mikehaertl\tmp\File;
/*
 * Utilisateur => il faut l'avoir
 * crée le encodage pied de page
 * nowrap sur tarifs
alignement des colonnes :
bordures moins noires, alignement toutes à gauches
1 colonne sur deux en bleu ciel
 */

if('header'){ob_start(); ?><!DOCTYPE HTML><html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            body {
                font-family: "Times New Roman", Georgia, Serif;
            }
            #header table.table {
                width: 100%;
                font-size: 12px;
                text-align: center;
                border-collapse: collapse;
            }
            #header table.table td {
                border: 1px solid #000;
            }
            body {
                font-family: "Times New Roman", Georgia, Serif;
            }

            #footer {
                padding-bottom: 50px;
            }

            #footer table {
                width: 100%;
                font-size: 12px;
            }
        </style>
        <script>
            function subst() {
                var vars = {};
                var query_strings_from_url = document.location.search.substring(1).split('&');
                for (var query_string in query_strings_from_url) {
                    if (query_strings_from_url.hasOwnProperty(query_string)) {
                        var temp_var = query_strings_from_url[query_string].split('=', 2);
                        vars[temp_var[0]] = decodeURI(temp_var[1]);
                    }
                }
                var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
                for (var css_class in css_selector_classes) {
                    if (css_selector_classes.hasOwnProperty(css_class)) {
                        var element = document.getElementsByClassName(css_selector_classes[css_class]);
                        for (var j = 0; j < element.length; ++j) {
                            element[j].textContent = vars[css_selector_classes[css_class]];
                        }
                    }
                }
            }
        </script>
    </head>
    <body onload="subst()">
        <div id="header">
            <table class="table">
                <tr>
                    <td colspan="2" style="padding: 5px 5px;">
                        <img src="<?php echo BASE_URL; ?>/sites/all/modules/residence_mgmt/assets/img/logo-silverpricing.png" alt="Silverpricing"/>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span><?php echo "Date de création"; ?></span><br />
                        <?php echo date( "d-m-Y H:i:s", $history->created); ?>
                    </td>

                    <td>
                        <?php /*<span><?php echo 'Utilisateur'; ?></span><br />*/ echo (isset($account->field_firstname))?$account->field_firstname . ' ' . $account->field_lastname:$account->name; ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
<?php }
$header = ob_get_clean();
ob_start();if('footer'){
?><!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<div id="footer">
    <div style="border-top: 1px solid #000;">
        <table>
            <tr>
                <td><?php echo "Crée le" . ' : '. date('Y-m-d H:i:s'); ?></td>
                <td><?php /* echo 'Page'; ?> <span class="page">[page]</span> / <span class="topage">[topage]</span>*/?></td>
            </tr>
        </table>
    </div>
</div>
</body></html>
<?php
}$footer = ob_get_clean();
$option = array(
    'binary' => RESIDENCE_MGMT_WKHTMLTOPDF,
    'page-size' => 'A4',
    'header-html' => $header,
    'header-spacing' => '5',
    'footer-html' => $footer,
    'footer-right' => 'Page : [page]/[toPage]',
    'footer-spacing' => '10',
    'ignoreWarnings' => true,
    'commandOptions' => array('useExec' => true, 'procEnv' => array('LANG' => 'en_US.utf-8',),),
    'javascript-delay' => 1000 /* Laisser s'executer*/
);

$pdf = new Pdf($option);
$pdf->addPage($content);

if (!$pdf->send($generatedFile . ".pdf")) {
    $error = $pdf->getError();
    \Alptech\Wip\fun::dbm([__FILE__.__line__,'wkhtmlerror',$generatedFile],'php500');
    varDebug($error);
}

$ok=1;/*
return;
?>
--footer-center [page]/[topage]
*/
