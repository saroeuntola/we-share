<?php
class Category
{
    private $db;
    private $lang;

    public function __construct($lang = 'en')
    {
        $this->db = dbConn();
        $this->lang = in_array($lang, ['en', 'kh']) ? $lang : 'en';
    }

    private function generateSlug($string)
    {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9\- ]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        $baseSlug = $slug;
        $i = 1;
        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }
        return $slug;
    }

    private function slugExists($slug)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn() > 0;
    }

    public function createCategory($name_en, $name_kh = null)
    {
        $slug = $this->generateSlug($name_en);
        $stmt = $this->db->prepare("INSERT INTO categories (name, name_kh, slug) VALUES (:name, :name_kh, :slug)");
        return $stmt->execute([
            'name' => $name_en,
            'name_kh' => $name_kh,
            'slug' => $slug
        ]);
    }

    // GET all categories
    public function getCategories()
    {
        $sql = "SELECT *,
                CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                FROM categories
                ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lang', $this->lang, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET category by ID or slug
    public function getCategory($identifier)
    {
        if (is_numeric($identifier)) {
            $sql = "SELECT *,
                    CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                    FROM categories
                    WHERE id = :id
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $identifier, PDO::PARAM_INT);
        } else {
            $sql = "SELECT *,
                    CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                    FROM categories
                    WHERE slug = :slug
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':slug', $identifier, PDO::PARAM_STR);
        }
        $stmt->bindValue(':lang', $this->lang, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $newName_en, $newName_kh = null)
    {
        $slug = $this->generateSlug($newName_en);
        $stmt = $this->db->prepare("
            UPDATE categories SET 
                name = :name_en, 
                name_kh = :name_kh, 
                slug = :slug,
               
            WHERE id = :id
        ");
        return $stmt->execute([
            'name_en' => $newName_en,
            'name_kh' => $newName_kh,
            'slug' => $slug,
            'id' => $id
        ]);
    }

    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteCatBySlug($slug)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE slug = :slug");
        return $stmt->execute(['slug' => $slug]);
    }
}
