<?php
/**
 * User Model
 * Handles user data and operations
 */
class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $userId): ?array
    {
        $sql = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        $user = $statement->fetch();

        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $user = $statement->fetch();

        return $user ?: null;
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function create(string $fullName, string $email, string $password, string $role = 'student'): int
    {
        $allowedRole = in_array($role, ['student', 'admin'], true) ? $role : 'student';
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO users (full_name, email, password_hash, role, status)
            VALUES (:full_name, :email, :password_hash, :role, :status)
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'full_name' => $fullName,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => $allowedRole,
            'status' => 'active',
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "
            UPDATE users
            SET password_hash = :password_hash, updated_at = CURRENT_TIMESTAMP
            WHERE user_id = :user_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':password_hash', $passwordHash);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    public function createPasswordResetToken(int $userId, string $tokenHash, string $expiresAt): bool
    {
        $sql = "
            INSERT INTO password_resets (user_id, token_hash, expires_at)
            VALUES (:user_id, :token_hash, :expires_at)
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':token_hash', $tokenHash);
        $statement->bindValue(':expires_at', $expiresAt);

        return $statement->execute();
    }

    public function findValidResetToken(string $tokenHash): ?array
    {
        $sql = "
            SELECT
                pr.reset_id,
                pr.user_id,
                pr.token_hash,
                pr.expires_at,
                pr.used_at,
                pr.created_at,
                u.email,
                u.full_name
            FROM password_resets pr
            INNER JOIN users u ON pr.user_id = u.user_id
            WHERE pr.token_hash = :token_hash
              AND pr.used_at IS NULL
              AND pr.expires_at > NOW()
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':token_hash', $tokenHash);
        $statement->execute();

        $reset = $statement->fetch();

        return $reset ?: null;
    }

    public function markResetTokenAsUsed(int $resetId): bool
    {
        $sql = "
            UPDATE password_resets
            SET used_at = NOW()
            WHERE reset_id = :reset_id
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':reset_id', $resetId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount() > 0;
    }
}
?>
