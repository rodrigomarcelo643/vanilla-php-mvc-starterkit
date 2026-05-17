<?php

class User extends Model
{
    public function getAll()
    {
        return $this->db->query("SELECT id, name, email, role, status, avatar, created_at FROM users ORDER BY created_at DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT id, name, email, role, status, created_at FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $name, string $email, string $password): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT)]);
        return (int) $this->db->lastInsertId();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function updatePassword(int $id, string $password): void
    {
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
    }

    public function updateAvatar(int $id, string $avatarUrl): void
    {
        $stmt = $this->db->prepare('UPDATE users SET avatar = ? WHERE id = ?');
        $stmt->execute([$avatarUrl, $id]);
    }

    public function updateProfile(int $id, string $name, string $email): bool
    {
        // Check email not taken by another user
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) return false;

        $this->db->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?')
                 ->execute([$name, $email, $id]);
        return true;
    }

    public function verifyPassword(int $id, string $password): bool
    {
        $stmt = $this->db->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && password_verify($password, $row['password']);
    }

    public function update(int $id, string $name, string $email, string $role, string $status): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) return false;
        $this->db->prepare('UPDATE users SET name = ?, email = ?, role = ?, status = ? WHERE id = ?')
                 ->execute([$name, $email, $role, $status, $id]);
        return true;
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    }

    public function adminCreate(string $name, string $email, string $password, string $role, string $status): int|false
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) return false;
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $role, $status]);
        return (int) $this->db->lastInsertId();
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
