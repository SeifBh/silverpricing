<?php

function median($tarifs){
    if( $tarifs ){
        $count = count($tarifs);
        sort($tarifs);
        $mid = floor(($count-1)/2);
        return ($tarifs[$mid]+$tarifs[$mid+1-$count%2])/2;
    }

    return 0;
}

function moyen($tarifs){
    if( $tarifs ){
        return array_sum($tarifs) / count($tarifs);
    }

    return 0;
}

// if(polygon[0] != polygon[polygon.length-1])
//         polygon[polygon.length] = polygon[0];
//     let j = 0;
//     let oddNodes = false;
//     let x = point[1];
//     let y = point[0];
//     let n = polygon.length;
//     for (let i = 0; i < n; i++)
//     {
//         j++;
//         if (j == n)
//         {
//             j = 0;
//         }
//         if (((polygon[i][0] < y) && (polygon[j][0] >= y)) || ((polygon[j][0] < y) && (polygon[i][0] >=
//             y)))
//         {
//             if (polygon[i][1] + (y - polygon[i][0]) / (polygon[j][0] - polygon[i][0]) * (polygon[j][1] -
//                 polygon[i][1]) < x)
//             {
//                 oddNodes = !oddNodes;
//             }
//         }
//     }
//     return oddNodes;

function isPointInsidePolygon( $point = null, $polygon = null ) {

    $result = false;

    for( $i = 0 ; $i < count($polygon) ; $i++ ) {



    }

    return $result;

}

function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {

    $earth_radius = 6371;

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return $d;

}
