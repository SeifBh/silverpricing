<?php

function getEstablishementByFiness( $finess = null ) {
    if( $finess == null ) { return null; }

    $urlTarget = RESIDENCE_MGMT_CNSA_API . "/establishment/" . $finess;
    $result = getRequest( $urlTarget );

    return $result;
    
}