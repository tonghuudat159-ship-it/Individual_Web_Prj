<?php
/**
 * Category Model
 * Handles course category data and operations
 */
class Category
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCategories(): array
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function getCategoryBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['slug' => $slug]);

        $category = $statement->fetch();

        return $category ?: null;
    }
}
?>
