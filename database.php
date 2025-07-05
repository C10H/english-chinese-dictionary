<?php
class Database {
    private $db;
    
    public function __construct($dbFile = 'dictionary.db') {
        try {
            $this->db = new PDO('sqlite:' . $dbFile);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function searchWord($word) {
        $stmt = $this->db->prepare("SELECT translation FROM dictionary WHERE word = ?");
        $stmt->execute([strtolower(trim($word))]);
        return $stmt->fetchColumn();
    }
    
    public function addWord($word, $translation) {
        $stmt = $this->db->prepare("INSERT OR REPLACE INTO dictionary (word, translation) VALUES (?, ?)");
        return $stmt->execute([strtolower(trim($word)), trim($translation)]);
    }
    
    public function deleteWord($word) {
        $stmt = $this->db->prepare("DELETE FROM dictionary WHERE word = ?");
        return $stmt->execute([strtolower(trim($word))]);
    }
    
    public function getAllWords() {
        $stmt = $this->db->query("SELECT * FROM dictionary ORDER BY word");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function authenticateUser($username, $password) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetchColumn() !== false;
    }
}
?>