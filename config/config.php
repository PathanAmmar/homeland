<?php 

    try {
        // host
        if(!defined('HOSTNAME')) define("HOSTNAME", "localhost");

        // DBNAME
        if(!defined('DBNAME')) define("DBNAME", "homeland");

        // user
        if(!defined('USER')) define("USER", "root");

        // pass
        if(!defined('PASS')) define("PASS", "");

        // --- FIXED URLS BASED ON YOUR STRUCTURE ---
        
        // The main URL of your website
        if(!defined('APPURL')) define("APPURL", "http://localhost/homeland");

      if(!defined('THUMBNAILMURL')) define("THUMBNAILMURL", "http://localhost/homeland/admin-panel/properties-admins/thumbnails/");
if(!defined('GALLERYURL')) define("GALLERYURL", "http://localhost/homeland/admin-panel/properties-admins/images/");
        // ------------------------------------------

        $conn = new PDO("mysql:host=".HOSTNAME.";dbname=".DBNAME.";", USER, PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }