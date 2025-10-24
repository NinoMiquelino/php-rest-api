<?php
require_once 'Database.php'; 

class BookController {
    private PDO $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getConnection();
    }
    
    // --- CREATE ---
    public function createBook(array $data): array {
        if (empty($data['title']) || empty($data['author'])) {
            throw new Exception("Title and author are required.", 400);
        }
        
        $stmt = $this->pdo->prepare(
            "INSERT INTO books (title, author, isbn) VALUES (:title, :author, :isbn)"
        );
        
        // Statements preparados: Segurança contra SQL Injection
        $stmt->execute([
            ':title' => $data['title'],
            ':author' => $data['author'],
            ':isbn' => $data['isbn'] ?? null 
        ]);
        
        $id = $this->pdo->lastInsertId();
        return $this->getBookById($id);
    }

    // --- READ (Single) ---
    public function getBookById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            throw new Exception("Book not found.", 404);
        }
        return $book;
    }
    
    // --- READ (All) ---
    public function getAllBooks(): array {
        $stmt = $this->pdo->query("SELECT * FROM books ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- UPDATE ---
    public function updateBook(int $id, array $data): array {
        // Verifica se o livro existe primeiro
        $this->getBookById($id); 

        if (empty($data['title']) && empty($data['author']) && empty($data['isbn'])) {
            throw new Exception("No data provided for update.", 400);
        }

        // Construção dinâmica da query para UPDATE
        $fields = [];
        $params = [':id' => $id];

        if (isset($data['title'])) {
            $fields[] = "title = :title";
            $params[':title'] = $data['title'];
        }
        if (isset($data['author'])) {
            $fields[] = "author = :author";
            $params[':author'] = $data['author'];
        }
        if (isset($data['isbn'])) {
            $fields[] = "isbn = :isbn";
            $params[':isbn'] = $data['isbn'];
        }

        $sql = "UPDATE books SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->getBookById($id);
    }

    // --- DELETE ---
    public function deleteBook(int $id): bool {
        // Verifica se o livro existe primeiro
        $this->getBookById($id); 
        
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
