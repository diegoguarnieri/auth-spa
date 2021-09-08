<?php

namespace App\Apps\Factory;

class Factory {

    public static function create($class, $db = null, $logger = null, $id = null) {
        $className = 'App\\Apps\\' . $class;

        if(is_null($db) && is_null($logger) && is_null($id)) {
            return new $className();

        } elseif(!is_null($db) && !is_null($logger) && !is_null($id)) {
            return new $className($db, $logger, $id);

        } else {
            return new $className($db, $logger);
        }
    }

}