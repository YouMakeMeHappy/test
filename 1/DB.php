<?php

class DB
{
    /**
     * @var PDO
     */
    private $_pdo;

    public function __construct(array $config)
    {
        $this->_pdo = new PDO(
            $config['dsn'],
            $config['user'],
            $config['password'],
            $config['options']
        );
    }

    public function query($query)
    {
        return $this->_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, array $data)
    {
        try {
            $keys = implode(', ', array_keys($data));
            $names = ':' . implode(', :', array_keys($data));

            $query = $this->_pdo->prepare("insert into {$table} ({$keys}) VALUES({$names})");

            foreach ($data as $name => $value) {
                $query->bindValue(":{$name}", $value);
            }

            $query->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertMulti($table, array $data)
    {
        foreach ($data as $_row) {
            $this->insert($table, $_row);
        }
    }
}