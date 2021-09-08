<?php

namespace App\Apps\Bean;

use Illuminate\Support\Facades\DB as Database;

class DB implements IDB {

    public function select($query, $fields = []) {
        return Database::select($query, $fields);
    }

    public function insert($table, $fields) {
        foreach ($fields as $key => $value){
            if (empty($value)) unset($fields[$key]);
        }
        return Database::table($table)->insert($fields);
    }

    public function insertGetId($table, $fields, $idName) {
        foreach ($fields as $key => $value){
            if (empty($value)) unset($fields[$key]);
        }
        return Database::table($table)->insertGetId($fields, $idName);
    }

    public function update($table, $fields, $conditions) {
        $query = Database::table($table);

        foreach($conditions as $key => $value) {
            $query->where($key, $value);
        }

        $query->update($fields);
    }

    public function delete($table, $conditions) {
        $query = Database::table($table);

        foreach($conditions as $key => $value) {
            $query->where($key, $value);
        }

        $query->delete();
    }

    public function query($query) {
        return Database::select($query);
    }

    /**
     * ['email' => 'john@example.com', 'name' => 'John'],
     * ['votes' => '2']
     */
    /*public function save($table, $fields, $conditions) {
        DB::table($table)
            ->updateOrInsert(
                $fields,
                $conditions         
            );
        return DB::getPdo()->lastInsertId();
    }*/

    public function save($table, $fields, $conditions, $idName) {
        $query = Database::table($table);

        foreach($conditions as $key => $value) {
            $query->where($key, $value);
        }

        $res = $query->get();

        if(count($res) > 0) {
            //update
            $this->update($table, $fields, $conditions);

            return isset($conditions[$idName]) ? $conditions[$idName] : null;
        } else {
            //insert
            return $this->insertGetId($table, $fields, $idName);
        }
    }
}
