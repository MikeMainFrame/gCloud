<?php

namespace Google\Cloud\Samples\bookhelf\DataModel;

use PDO;

/**
 * Class Sql implements the DataModelInterface with a mysql database.
 */
class Sql implements DataModelInterface {
    private $dsn;
    private $user;
    private $password;

    public function __construct($dsn, $user, $password) {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;

        $pdo = $this->newConnection();
    }
    private function newConnection()    {
        $pdo = new PDO($this->dsn,
                       $this->user,
                       $this->password);
                       
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function listTrxs($search = "%")   {
    
        $pdo = $this->newConnection();
        $statement = $pdo->prepare("SELECT * FROM trxs WHERE text like :search ORDER BY date desc LIMIT 9999");      
        $statement->bindValue('search', $search, PDO::PARAM_INT);
        $statement->execute();
        $rows = array();
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          array_push($rows, $row);
        }

        return  $rows;
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
