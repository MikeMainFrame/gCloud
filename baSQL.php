<?php
/*
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Samples\trxshelf\DataModel;

use PDO;

/**
 * Class Sql implements the DataModelInterface with a mysql database.
 *
 */
class Sql implements DataModelInterface {
    private $dsn;
    private $user;
    private $password;

    /**
     * Creates the SQL trxs table if it doesn't already exist.
     */
    public function __construct($dsn, $user, $password) {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;

        $columns = array(
            'id int ',
            'text VARCHAR(255)',
            'date date',
            'amount bigint',
        );

        $this->columnNames = array_map(function ($columnDefinition) {
            return explode(' ', $columnDefinition)[0];
        }, $columns);
        $columnText = implode(', ', $columns);
        $pdo = $this->newConnection();
        $pdo->query("CREATE TABLE IF NOT EXISTS trxs ($columnText)");
    }

    /**
     * Creates a new PDO instance and sets error mode to exception.
     */
    private function newConnection()    {
        $pdo = new PDO($this->dsn,
                       $this->user,
                       $this->password);
                       
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function listtrxs($limit = 10, $cursor = null)   {
    
        $pdo = $this->newConnection();
        $query = 'SELECT * FROM trxs ORDER BY id LIMIT 9999';
        $statement = $pdo->prepare($query);
        $statement->execute();
        $rows = array();
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          array_push($rows, $row);
        }

        return  $rows;
    }

    public function create($trx, $id = null)     {
        $this->verifytrx($trx);
        if ($id) $trx['id'] = $id;
        $pdo = $this->newConnection();
        $names = array_keys($trx);
        $placeHolders = array_map(function ($key) {
            return ":$key";
        }, $names);
        $sql = sprintf(
            'INSERT INTO trxs (%s) VALUES (%s)',
            implode(', ', $names),
            implode(', ', $placeHolders)
        );
        $statement = $pdo->prepare($sql);
        $statement->execute($trx);

        return $pdo->lastInsertId();
    }

    public function read($id)    {
        $pdo = $this->newConnection();
        $statement = $pdo->prepare('SELECT * FROM trxs WHERE id = :id');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($trx)    {
        $this->verifytrx($trx);
        $pdo = $this->newConnection();
        $assignments = array_map(
            function ($column) {
                return "$column=:$column";
            },
            $this->columnNames
        );
        $assignmentString = implode(',', $assignments);
        $sql = "UPDATE trxs SET $assignmentString WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $values = array_merge(
            array_fill_keys($this->columnNames, null),
            $trx
        );
        return $statement->execute($values);
    }

    public function delete($id)    {
        $pdo = $this->newConnection();
        $statement = $pdo->prepare('DELETE FROM trxs WHERE id = :id');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
        // row count is important
        return $statement->rowCount();
    }

    public static function getMysqlDsn($dbName, $port, $connectionName = null)    {
        if ($connectionName) {
            return sprintf('mysql:unix_socket=/cloudsql/%s;dbname=%s',
                $connectionName,
                $dbName);
        }

        return sprintf('mysql:host=127.0.0.1;port=%s;dbname=%s', $port, $dbName);
    }

   }
