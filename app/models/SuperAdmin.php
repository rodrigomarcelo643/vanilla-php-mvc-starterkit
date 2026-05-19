<?php

class SuperAdmin extends Model
{
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM super_admins WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row['role'] = 'superadmin';
        }
        return $row;
    }

    public function getAll(): array
    {
        return $this->db->query("SELECT id, name, email, status, created_at FROM super_admins ORDER BY created_at DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->db->prepare('UPDATE super_admins SET password = ? WHERE id = ?')
                 ->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
    }

    public function updateAvatar(int $id, string $avatarUrl): void
    {
        $this->db->prepare('UPDATE super_admins SET avatar = ? WHERE id = ?')
                 ->execute([$avatarUrl, $id]);
    }

    public function updateProfile(int $id, string $name, string $email): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM super_admins WHERE email = ? AND id != ? LIMIT 1');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) return false;

        $this->db->prepare('UPDATE super_admins SET name = ?, email = ? WHERE id = ?')
                 ->execute([$name, $email, $id]);
        return true;
    }

    public function verifyPassword(int $id, string $password): bool
    {
        $stmt = $this->db->prepare('SELECT password FROM super_admins WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && password_verify($password, $row['password']);
    }
}
