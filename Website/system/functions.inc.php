<?php
SESSION_START();

function getDisplayName($UID) {
    global $db;
    $sql = "SELECT USERNAME FROM BENUTZER WHERE UID = $UID";
    $sth = $db->prepare($sql);
    $sth->execute();
    $array = $sth->fetchAll();

    return $array["0"]["USERNAME"];
}

function getAvatar($UID) {
    global $db;
    $sql = "SELECT AVATAR FROM BENUTZER WHERE UID = $UID";
    $sth = $db->prepare($sql);
    $sth->execute();
    $array = $sth->fetchAll();

    return $array["0"]["AVATAR"];
}

function redirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

function getResolutionNiceName($resolution) {
    $niceResolution = [
        "day"   => "Täglich",
        "month" => "Monatlich",
        "year"  => "Jährlich"
    ];
    return $niceResolution[$resolution];
}

function getAnkuenfteDataMonthly($landkreis, $monat, $jahr) {
    global $db;
    $sql = "SELECT ankuenfte FROM TOURISMUS WHERE landkreis = $landkreis AND jahr = $jahr AND monat = $monat";
    $sth = $db->prepare($sql);
    $sth->execute();
    $array = $sth->fetchAll();

    if(!$sth) {
        return "0";
    } else {
        if(isset($array["0"]["ankuenfte"])) {
            return $array["0"]["ankuenfte"];
        } else {
            return "0";
        }

    }
}

function getUebernachtungenDataMonthly($landkreis, $monat, $jahr) {
    global $db;
    $sql = "SELECT uebernachtungen FROM TOURISMUS WHERE landkreis = $landkreis AND jahr = $jahr AND monat = $monat";
    $sth = $db->prepare($sql);
    $sth->execute();
    $array = $sth->fetchAll();

    if(!$sth) {
        return "0";
    } else {
        return $array["0"]["uebernachtungen"];
    }

}

function getLandKreisID($lkname) {
    global $db;
    $sql = "SELECT rs FROM LANDKREISE WHERE name = '$lkname'";
    $sth = $db->prepare($sql);
    $sth ->execute();
    $array = $sth->fetchAll();

    return $array["0"]["rs"];
}

function getRandomColorName() {
    global $colorArray;
    $arraySize = count($colorArray);
    $rand = rand("0", $arraySize);
    return $colorArray[$rand];
}

function getNewestYearByState($stateid) {
    global $db;
    $sql = "SELECT jahr FROM TOURISMUS WHERE landkreis = $stateid ORDER BY jahr DESC";
    $sth = $db->prepare($sql);
    $sth ->execute();
    $array = $sth->fetchAll();
    return $array["0"]["jahr"];
}

function getNewestMonthByState($stateid, $year) {
    global $db;
    $sql = "SELECT monat FROM TOURISMUS WHERE landkreis = $stateid AND jahr = $year ORDER BY monat DESC";
    $sth = $db->prepare($sql);
    $sth ->execute();
    $array = $sth->fetchAll();
    return $array["0"]["monat"];
}
?>