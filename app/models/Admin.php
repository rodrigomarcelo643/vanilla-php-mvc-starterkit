<?php

class Admin extends Model
{
    public function getAll()
    {
        return $this->db->query("SELECT id, name, email, status, created_at FROM admins ORDER BY created_at DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row['role'] = 'admin';
        }
        return $row;
    }

    public function updatePassword(int $id, string $password): void
    {
        $stmt = $this->db->prepare('UPDATE admins SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
    }

    public function updateAvatar(int $id, string $avatarUrl): void
    {
        $stmt = $this->db->prepare('UPDATE admins SET avatar = ? WHERE id = ?');
        $stmt->execute([$avatarUrl, $id]);
    }

    public function updateProfile(int $id, string $name, string $email): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM admins WHERE email = ? AND id != ? LIMIT 1');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) return false;

        $this->db->prepare('UPDATE admins SET name = ?, email = ? WHERE id = ?')
                 ->execute([$name, $email, $id]);
        return true;
    }

    public function verifyPassword(int $id, string $password): bool
    {
        $stmt = $this->db->prepare('SELECT password FROM admins WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && password_verify($password, $row['password']);
    }

    public function update(int $id, string $name, string $email, string $status): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM admins WHERE email = ? AND id != ? LIMIT 1');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) return false;
        $this->db->prepare('UPDATE admins SET name = ?, email = ?, status = ? WHERE id = ?')
                 ->execute([$name, $email, $status, $id]);
        return true;
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM admins WHERE id = ?')->execute([$id]);
    }

    public function adminCreate(string $name, string $email, string $password, string $status): int|false
    {
        $stmt = $this->db->prepare('SELECT id FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) return false;
        $stmt = $this->db->prepare('INSERT INTO admins (name, email, password, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $status]);
        return (int) $this->db->lastInsertId();
    }
}
