<?php
/**
 * Enrollment Model
 * Handles course enrollment data and operations
 */
class Enrollment
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function isUserEnrolled(int $userId, int $courseId): bool
    {
        $sql = "
            SELECT 1
            FROM enrollments
            WHERE user_id = :user_id
              AND course_id = :course_id
              AND status IN (:status_active, :status_completed)
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->bindValue(':status_active', 'active');
        $statement->bindValue(':status_completed', 'completed');
        $statement->execute();

        return $statement->fetchColumn() !== false;
    }

    public function getUserEnrollments(int $userId): array
    {
        $sql = "
            SELECT
                e.enrollment_id,
                c.course_id,
                c.title,
                c.slug,
                c.short_description,
                c.thumbnail,
                i.full_name AS instructor_name,
                cat.name AS category_name,
                cat.slug AS category_slug,
                e.status AS enrollment_status,
                e.enrolled_at
            FROM enrollments e
            INNER JOIN courses c ON e.course_id = c.course_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            INNER JOIN categories cat ON c.category_id = cat.category_id
            WHERE e.user_id = :user_id
              AND e.status IN (:status_active, :status_completed)
            ORDER BY e.enrolled_at DESC
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':status_active', 'active');
        $statement->bindValue(':status_completed', 'completed');
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createEnrollment(int $userId, int $courseId, int $orderId, string $status = 'active'): bool
    {
        $status = $this->normalizeStatus($status);

        if ($this->isUserEnrolled($userId, $courseId)) {
            return false;
        }

        $sql = "
            INSERT INTO enrollments (user_id, course_id, order_id, status)
            VALUES (:user_id, :course_id, :order_id, :status)
        ";

        $statement = $this->pdo->prepare($sql);

        try {
            return $statement->execute([
                'user_id' => $userId,
                'course_id' => $courseId,
                'order_id' => $orderId,
                'status' => $status,
            ]);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                return false;
            }

            throw $exception;
        }
    }

    private function normalizeStatus(string $status): string
    {
        $allowedStatuses = ['active', 'completed', 'cancelled'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException('Invalid enrollment status.');
        }

        return $status;
    }
}
?>
