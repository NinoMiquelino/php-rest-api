<?php

class Database {
    private string $dbFile = __DIR__ . '/books.sqlite';
    private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("sqlite:" . $this->dbFile);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->initialize();
        } catch (PDOException $e) {
            die(json_encode(['error' => "Erro de conexão com o banco de dados: " . $e->getMessage()]));
        }
    }

    /**
     * Garante que a tabela 'books' exista.
     */
    private function initialize(): void {
        $sql = "CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            author TEXT NOT NULL,
            isbn TEXT UNIQUE
        )";
        $this->pdo->exec($sql);
    }
    
    public function getConnection(): PDO {
        return $this->pdo;
    }
}
