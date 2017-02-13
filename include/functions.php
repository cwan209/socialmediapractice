<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 11/02/2017
 * Time: 11:53 PM
 */

function redirect_to( $location = null) {
    if ($location != null) {
        header("Location: {$location}");
        exit;
    }
}

