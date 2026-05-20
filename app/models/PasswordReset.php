<?php

class PasswordReset extends Model
{
    // Create Token
    public function createToken(string $email): string
    {
        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Remove any existing token for this email first
        $this->deleteByEmail($email);

        $stmt = $this->db->prepare(
            'INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)'
        );
        $stmt->execute([$email, $token, $expiresAt]);

        return $token;
    }
    // Find By Token
    public function findByToken(string $token): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1'
        );
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Delete By Email
    public function deleteByEmail(string $email): void
    {
        $this->db->prepare('DELETE FROM password_resets WHERE email = ?')->execute([$email]);
    }
    // Delete By Token
    public function deleteByToken(string $token): void
    {
        $this->db->prepare('DELETE FROM password_resets WHERE token = ?')->execute([$token]);
    }
}