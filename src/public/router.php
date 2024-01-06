<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|mp4|mp3|ico)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // retourne la requête telle quelle.
} else {
    require_once 'index.php';
}