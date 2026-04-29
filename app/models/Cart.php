<?php
/**
 * Cart Model
 * Handles shopping cart data and operations
 */
class Cart
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCartItemsByUser(int $userId): array
    {
        $sql = "
            SELECT
                ci.cart_item_id,
                c.course_id,
                c.title,
                c.slug,
                c.short_description,
                c.thumbnail,
                c.price,
                c.rating,
                c.total_students,
                i.full_name AS instructor_name,
                cat.name AS category_name,
                cat.slug AS category_slug,
                ci.added_at
            FROM cart_items ci
            INNER JOIN courses c ON ci.course_id = c.course_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            INNER JOIN categories cat ON c.category_id = cat.category_id
            WHERE ci.user_id = :user_id
              AND c.status = :status
            ORDER BY ci.added_at DESC
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':status', 'published');
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countCartItems(int $userId): int
    {
        $sql = "
            SELECT COUNT(*) AS total_items
            FROM cart_items
            WHERE user_id = :user_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        return (int) $statement->fetchColumn();
    }

    public function isCourseInCart(int $userId, int $courseId): bool
    {
        $sql = "
            SELECT 1
            FROM cart_items
            WHERE user_id = :user_id
              AND course_id = :course_id
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn() !== false;
    }

    public function addItem(int $userId, int $courseId): bool
    {
        if ($this->isCourseInCart($userId, $courseId)) {
            return false;
        }

        $sql = "
            INSERT INTO cart_items (user_id, course_id)
            VALUES (:user_id, :course_id)
        ";

        $statement = $this->pdo->prepare($sql);

        try {
            return $statement->execute([
                'user_id' => $userId,
                'course_id' => $courseId,
            ]);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                return false;
            }

            throw $exception;
        }
    }

    public function removeItem(int $userId, int $courseId): bool
    {
        $sql = "
            DELETE FROM cart_items
            WHERE user_id = :user_id
              AND course_id = :course_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    public function removeItemById(int $userId, int $cartItemId): bool
    {
        $sql = "
            DELETE FROM cart_items
            WHERE user_id = :user_id
              AND cart_item_id = :cart_item_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':cart_item_id', $cartItemId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    public function clearCart(int $userId): bool
    {
        $sql = "
            DELETE FROM cart_items
            WHERE user_id = :user_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function getCartTotal(int $userId): float
    {
        $sql = "
            SELECT COALESCE(SUM(c.price), 0) AS cart_total
            FROM cart_items ci
            INNER JOIN courses c ON ci.course_id = c.course_id
            WHERE ci.user_id = :user_id
              AND c.status = :status
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':status', 'published');
        $statement->execute();

        return (float) $statement->fetchColumn();
    }
}
?>
