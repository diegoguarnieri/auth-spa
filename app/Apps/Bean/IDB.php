<?php

namespace App\Apps\Bean;

interface IDB {

    public function select($query, $fields);

    public function insert($table, $fields);

    public function insertGetId($table, $fields, $idName);

    public function update($table, $fields, $conditions);

    public function delete($table, $conditions);

    public function query($query);

    public function save($table, $fields, $conditions, $idName);

}
