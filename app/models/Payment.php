<?php
/**
 * Payment Model
 * Handles payment data and operations
 */
class Payment
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createPayment(int $orderId, string $paymentMethod, float $amount, string $status = 'pending'): int
    {
        $paymentMethod = $this->normalizePaymentMethod($paymentMethod);
        $status = $this->normalizeStatus($status);
        $transactionRef = null;
        $paidAt = null;

        if ($status === 'success') {
            $transactionRef = $this->generateTransactionRef($paymentMethod);
            $paidAt = date('Y-m-d H:i:s');
        }

        $sql = "
            INSERT INTO payments (order_id, payment_method, amount, status, transaction_ref, paid_at)
            VALUES (:order_id, :payment_method, :amount, :status, :transaction_ref, :paid_at)
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $statement->bindValue(':payment_method', $paymentMethod);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':transaction_ref', $transactionRef);
        $statement->bindValue(':paid_at', $paidAt);
        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function markAsSuccess(int $paymentId, ?string $transactionRef = null): bool
    {
        $transactionRef = $transactionRef ?: $this->generateTransactionRef('payment');

        $sql = "
            UPDATE payments
            SET status = :status,
                transaction_ref = :transaction_ref,
                paid_at = :paid_at
            WHERE payment_id = :payment_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', 'success');
        $statement->bindValue(':transaction_ref', $transactionRef);
        $statement->bindValue(':paid_at', date('Y-m-d H:i:s'));
        $statement->bindValue(':payment_id', $paymentId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function getPaymentByOrderId(int $orderId): ?array
    {
        $sql = "
            SELECT
                payment_id,
                order_id,
                payment_method,
                amount,
                status,
                transaction_ref,
                paid_at
            FROM payments
            WHERE order_id = :order_id
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $statement->execute();

        $payment = $statement->fetch();

        return $payment ?: null;
    }

    private function normalizePaymentMethod(string $paymentMethod): string
    {
        $allowedMethods = ['credit_card', 'bank_transfer', 'momo'];

        if (!in_array($paymentMethod, $allowedMethods, true)) {
            throw new InvalidArgumentException('Invalid payment method.');
        }

        return $paymentMethod;
    }

    private function normalizeStatus(string $status): string
    {
        $allowedStatuses = ['pending', 'success', 'failed'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException('Invalid payment status.');
        }

        return $status;
    }

    private function generateTransactionRef(string $prefix): string
    {
        $cleanPrefix = strtoupper(str_replace('_', '', $prefix));

        return $cleanPrefix . '-' . date('Ymd-His') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
    }
}
?>
