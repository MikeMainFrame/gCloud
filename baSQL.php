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
        $statement = $pdo->prepare("SELECT * FROM trxs WHERE text like ? ORDER BY date desc LIMIT 9999");      
        $statement->bindValue(1, $search, PDO::PARAM_INT);
        $statement->execute();
        $rows = array();
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          array_push($rows, $row);
        }

        return  $rows;
    }

    public function read($id)    {
        $pdo = $this->newConnection();
        $statement = $pdo->prepare('SELECT * FROM trxs WHERE id = ?');
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($trx)    {
        $pdo = $this->newConnection();
        $statement = $pdo->prepare("UPDATE trxs SET date = ?, text = ?, amount = ? WHERE id = ?");
        $statement->bindValue(1, $trx->date, PDO::PARAM_STR);
        $statement->bindValue(2, $trx->text, PDO::PARAM_STR);        
        $statement->bindValue(3, $trx->amount, PDO::PARAM_INT);        
        $statement->bindValue(4, $trx->id, PDO::PARAM_INT);                
        
        return $statement->execute();
    }

    public function delete($id)    {
        $pdo = $this->newConnection();
        $statement = $pdo->prepare('DELETE FROM trxs WHERE id = ?');
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->execute();
        // row count is the only info - not raw data ....
        return $statement->rowCount();
    }


   }
