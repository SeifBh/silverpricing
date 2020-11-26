<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../inc/geocoding.inc.php";

use DiDom\Document;

class Residence {
    public $title;
    public $link;
}

function residence_mgmt_scrapping() {
    set_time_limit(0);
    //residence_mgmt_page_detail_scrapping();
    residence_mgmt_page_scrapping(973);
}

function residence_mgmt_page_scrapping($departmentNumber = null) {

    $currentUrl = "https://www.pour-les-personnes-agees.gouv.fr/annuaire-ehpad-en-hebergement-permanent/" . $departmentNumber . "/0";
    $currentDepartment = new Document($currentUrl, true);
    $residencesTotal = $currentDepartment->first('#cnsa_results-total b')->getNode()->nodeValue;
    $currentPage = 0;

    $residences = array();

    do {

        $currentDepartment = new Document( $currentUrl . '?page=' . $currentPage, true);
        $residencesList = $currentDepartment->find('#cnsa_results-list .cnsa_results-item .cnsa_results-titlecol');

        foreach( $residencesList as $r ) {
            $residence = new Residence();

            if( $r->has('a') ) {
                $link = $r->first('a')->getNode();
                $residence->link = $link->getAttribute('href');
                $residences[] = residence_mgmt_page_detail_scrapping($residence->link);
            }

            $title = $r->first('h3.cnsa_results-tags1')->getNode();
            $residence->title = $title->nodeValue;

        }

        //break;

        $currentPage++;

    } while( count($residences) < $residencesTotal );

    return $residences;
}

function residence_mgmt_page_detail_scrapping($currentUrl = null) {
    /*Angular generated content expose new API Path :: https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/010008571*/

    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $headers = get_headers($currentUrl);
    $urlExist = $headers && strpos( $headers[0], '200');
    if( !$urlExist ) {
        return null;
    }

    $residence = new StdClass();

    $currentResidence = new Document();
    $currentResidence->loadHtmlFile($currentUrl);#
    $currentResidence->getDocument()->saveHTMLFile('recup.html');
    #$recup=$currentResidence->document->gettextContent();file_put_contents('recup.html',$recup);
    $content = $currentResidence->first('#cnsa_search_item');

    $title = $content->first('#cnsa_search_item-title h1');
    $itemCenter = $content->first('#cnsa_search_item-center');
    $itemLeft = $content->first('#cnsa_search_item-left-inside');
    $tarifTables = $itemCenter->find('table');

    $residence->urlSource = $currentUrl;
    $residence->title = $title->getNode()->nodeValue;
    $residence->gestionnaire = trim(str_replace('Gestionnaire :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut')->getNode()->nodeValue));
    $residence->statut = trim(str_replace('Statut juridique :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut2')->getNode()->nodeValue));
    $residence->address = $itemLeft->first('.fiche-box .cnsa_search_item-addr')->getNode()->nodeValue;
    $residence->address = trim( preg_replace('/\s+/', ' ', str_replace("Adresse :", "", $residence->address)));
    if( $itemLeft->has('.fiche-box .cnsa_search_item-tel') ) {
        $residence->phone = trim(str_replace('Téléphone', '', $itemLeft->first('.fiche-box .cnsa_search_item-tel')->getNode()->nodeValue));
    }
    if( $itemLeft->has('.fiche-box .cnsa_search_item-courriel') ) {
        $residence->email = trim($itemLeft->first('.fiche-box .cnsa_search_item-courriel')->getNode()->nodeValue);
    }
    if( $itemLeft->has('.fiche-box .cnsa_search_item-site a') ) {
        $residence->website = $itemLeft->first('.fiche-box .cnsa_search_item-site a')->getNode()->getAttribute('href');
    }

    foreach( $tarifTables as $type => $tarifTable ) {
        foreach( $tarifTable->find('tr') as $tarif ) {
            $tarifKey = preg_replace('/[^A-Za-z0-9-*]+/', '-', $tarif->first('td.text-left')->getNode()->nodeValue);
            $tarifValue = str_replace("€/jour", "", $tarif->first('td.text-right')->getNode()->nodeValue);
            $residence->tarif[$type][strtolower($tarifKey)] = str_replace(",", ".", $tarifValue);
        }
    }

    if( $itemCenter->has('span.title-detail') ) {
        $modificationDate = trim(str_replace('mis à jour le ', '', $itemCenter->first('span.title-detail')->getNode()->nodeValue));
        $modificationDate = date_create_from_format('d/m/Y', $modificationDate);
        $residence->modificationDate = date('Y-m-d H:i:s', $modificationDate->getTimestamp());
    } else {
        $residence->modificationDate = date('Y-m-d H:i:s');
    }


    return $residence;
}
