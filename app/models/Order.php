<?php
/**
 * Order Model
 * Handles order data and operations
 */
class Order
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function generateOrderCode(): string
    {
        return 'DATEDU-' . date('Ymd-His') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
    }

    public function createOrder(int $userId, float $totalAmount, string $status = 'pending'): int
    {
        $status = $this->normalizeStatus($status);
        $orderCode = $this->generateOrderCode();

        $sql = "
            INSERT INTO orders (user_id, order_code, total_amount, status)
            VALUES (:user_id, :order_code, :total_amount, :status)
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':order_code', $orderCode);
        $statement->bindValue(':total_amount', $totalAmount);
        $statement->bindValue(':status', $status);
        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function createOrderItem(int $orderId, int $courseId, float $priceAtPurchase): bool
    {
        $sql = "
            INSERT INTO order_items (order_id, course_id, price_at_purchase)
            VALUES (:order_id, :course_id, :price_at_purchase)
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->bindValue(':price_at_purchase', $priceAtPurchase);

        return $statement->execute();
    }

    public function getOrderByCode(string $orderCode, ?int $userId = null): ?array
    {
        $sql = "
            SELECT
                order_id,
                user_id,
                order_code,
                total_amount,
                status,
                created_at
            FROM orders
            WHERE order_code = :order_code
        ";

        if ($userId !== null) {
            $sql .= " AND user_id = :user_id";
        }

        $sql .= " LIMIT 1";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_code', $orderCode);

        if ($userId !== null) {
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        }

        $statement->execute();
        $order = $statement->fetch();

        return $order ?: null;
    }

    public function getOrderById(int $orderId): ?array
    {
        $sql = "
            SELECT
                order_id,
                user_id,
                order_code,
                total_amount,
                status,
                created_at
            FROM orders
            WHERE order_id = :order_id
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $statement->execute();

        $order = $statement->fetch();

        return $order ?: null;
    }

    public function getOrderItems(int $orderId): array
    {
        $sql = "
            SELECT
                oi.order_item_id,
                c.course_id,
                c.title,
                c.slug,
                c.thumbnail,
                i.full_name AS instructor_name,
                oi.price_at_purchase
            FROM order_items oi
            INNER JOIN courses c ON oi.course_id = c.course_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE oi.order_id = :order_id
            ORDER BY oi.order_item_id ASC
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        $status = $this->normalizeStatus($status);

        $sql = "
            UPDATE orders
            SET status = :status
            WHERE order_id = :order_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);

        return $statement->execute();
    }

    private function normalizeStatus(string $status): string
    {
        $allowedStatuses = ['pending', 'paid', 'cancelled'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException('Invalid order status.');
        }

        return $status;
    }
}
?>
