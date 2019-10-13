<?php 
// alter table imagedata add column taxStatus varchar(20) null;
include "utility.php";
require "../includes/artsiteConfig.php";
require "../includes/artsiteConnect.php";
global $db;
$imageId=$_GET['imageId'];
$taxStatusResult = mysqli_query($db, "SELECT taxStatus FROM imageData WHERE imgId=$imageId");
if($taxStatusResult) {
    $taxStatus = mysqli_fetch_assoc($taxStatusResult)['taxStatus'];
    if($taxStatus == null) {
        $result = mysqli_query($db, "UPDATE imageData set taxStatus = 'paid' WHERE imgId=$imageId");
        if($result) {
            echo 1;
        } else {
            echo 0;
        }
    } elseif($taxStatus == 'paid') {
        $result = mysqli_query($db, "UPDATE imageData set taxStatus = null WHERE imgId=$imageId");
        if($result) {
            echo 1;
        } else {
            echo 0;
        }
    }
} else {
    echo 0;
}

?>