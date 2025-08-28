<?php
class User
{
    public $db;
    public function __construct()
    {
        $this->db = dbConn();
    }

    
    function getCurrentUser()
    {
        global $db;
        if (isset($_SESSION['user_id'])) {
            $stmt = $db->prepare("SELECT username FROM users WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['username'] ?? 'Guest';
        }
        return 'Guest';
    }
    public function getusers() {
        $query = "SELECT u.*, r.name AS name 
                  FROM users u
                  JOIN roles r ON u.role_id = r.id 
                  ORDER BY u.created_at DESC";

        try {
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching products: " . $e->getMessage());
        }
    }
    // CREATE a new user
    public function createUser($data)
    {
        // Check for duplicate email
        $quotedEmail = $this->db->quote($data['email']);
        $existing = dbSelect('users', 'id', "email=$quotedEmail");

        if ($existing && count($existing) > 0) {
            return false; // Email already exists
        }

        // Hash password before insert
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return dbInsert('users', $data);
    }

   public function getRoles()
    {
        return dbSelect('roles', '*');
    }
    public function getUser($id)
    {
        $quotedId = $this->db->quote($id);
        $result = dbSelect('users', '*', "id=$quotedId");
        return ($result && count($result) > 0) ? $result[0] : null;
    }
 public function updateProfile($userId, $data) {
        // Assuming you have a database connection in your `db.php`
        global $db;

        $query = "UPDATE users SET username = ?, sex = ?, profile = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssi", $data['username'], $data['sex'], $data['profile'], $userId);

        return $stmt->execute(); // Returns true if update is successful
    }
    // UPDATE a user (password optional)
    public function updateUser($id, $data)
    {
        $user = $this->getUser($id);
        if (!$user) {
            return false;
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        return dbUpdate('users', $data, "id=" . $this->db->quote($id));
    }
    public function getUserById($id)
    {
        if ($id === null) return null;
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // DELETE a user (disallow deleting admin role_id=1)
    public function deleteUser($id)
    {
        $user = $this->getUserById($id); // <-- fixed
        if (!$user) return false;

        $role = (int)($user['role_id'] ?? $user['roles_id'] ?? 0);
        if ($role === 1) {
            // do not delete admins
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
