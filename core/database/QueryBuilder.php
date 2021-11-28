<?php

use App\Models\Product;

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            $last_id = $this->pdo->lastInsertId();

            $statement = $this->pdo->prepare("select * from {$table}");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_CLASS);

            return $result[count($result) - 1]; // last inserted row
        } catch (Exception $e) {
            return'Whoops something went wrong';
        }
    }

    public function delete($table, $ids)
    {
        foreach ($ids as $id) {
            if (!$this->rowExist($table, $id)  || !is_numeric($id)) {
                return [];
            }

            $statement = $this->pdo->prepare("delete from {$table} where id = {$id}");
            $statement->execute();
        }
        return true;
    }

    private function rowExist($table, $id)
    {
        try {
            $s = $this->pdo->prepare("select * from {$table} where id = {$id}");
            $s->execute();
            return count($s->fetchAll(PDO::FETCH_CLASS));
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
