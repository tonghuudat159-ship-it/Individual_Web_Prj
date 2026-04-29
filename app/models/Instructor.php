<?php
/**
 * Instructor Model
 * Handles instructor data and operations
 */
class Instructor
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getInstructorById(int $id): ?array
    {
        $sql = "SELECT * FROM instructors WHERE instructor_id = :instructor_id LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['instructor_id' => $id]);

        $instructor = $statement->fetch();

        return $instructor ?: null;
    }
}
?>
