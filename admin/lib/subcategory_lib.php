<?php
class Subcategory
{
    private $db;
    private $lang;

    public function __construct($lang = 'en')
    {
        $this->db = dbConn();
        $this->lang = in_array($lang, ['en', 'kh']) ? $lang : 'en';
    }

    // GET all subcategories
    public function getAllSubcategory($lang = 'en')
    {
        $lang = in_array($lang, ['en', 'kh']) ? $lang : 'en';

        $sql = "SELECT s.*, 
                   CASE WHEN :lang = 'kh' THEN s.name_kh ELSE s.name END AS name,
                   c.name AS category_name
            FROM subcategories s
            INNER JOIN categories c ON s.category_id = c.id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lang', $lang, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM subcategories WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn() > 0;
    }

    // CREATE subcategory
    public function createSubcategory($category_id, $name_en, $name_kh = null, $added_by = null)
    {
        $slug = $this->generateSlug($name_en);
        $stmt = $this->db->prepare("
            INSERT INTO subcategories (category_id, name, name_kh, slug, added_by)
            VALUES (:category_id, :name_en, :name_kh, :slug, :added_by)
        ");
        return $stmt->execute([
            'category_id' => $category_id,
            'name_en' => $name_en,
            'name_kh' => $name_kh,
            'slug' => $slug,
            'added_by' => $added_by
        ]);
    }

    // GET subcategories by category ID
    public function getSubcategoriesByCategory($category_id)
    {
        $sql = "SELECT *,
                CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                FROM subcategories
                WHERE category_id = :category_id
                ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':lang', $this->lang, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET subcategories by category slug
    public function getSubcategoriesByCategorySlug($category_slug)
    {
        $sql = "SELECT s.*,
                CASE WHEN :lang = 'kh' THEN s.name_kh ELSE s.name END AS name
                FROM subcategories s
                INNER JOIN categories c ON s.category_id = c.id
                WHERE c.slug = :slug
                ORDER BY s.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $category_slug, PDO::PARAM_STR);
        $stmt->bindValue(':lang', $this->lang, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET single subcategory by ID or slug
    public function getSubcategory($identifier)
    {
        if (is_numeric($identifier)) {
            $sql = "SELECT *,
                    CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                    FROM subcategories
                    WHERE id = :id
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $identifier, PDO::PARAM_INT);
        } else {
            $sql = "SELECT *,
                    CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name
                    FROM subcategories
                    WHERE slug = :slug
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':slug', $identifier, PDO::PARAM_STR);
        }

        $stmt->bindValue(':lang', $this->lang, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE subcategory
    public function updateSubcategory($identifier, $newName_en = null, $newName_kh = null, $newCategoryId = null, $newAdded_by = null)
    {
        $sub = $this->getSubcategory($identifier);
        if (!$sub) return false;

        $slug = $newName_en ? $this->generateSlug($newName_en) : $sub['slug'];

        $sql = "UPDATE subcategories SET name = :name_en, name_kh = :name_kh, slug = :slug";
        $params = [
            'name_en' => $newName_en ?? $sub['name'],
            'name_kh' => $newName_kh ?? $sub['name_kh'],
            'slug' => $slug,
            'id' => $sub['id']
        ];

        if ($newCategoryId !== null) {
            $sql .= ", category_id = :category_id";
            $params['category_id'] = $newCategoryId;
        }

        if ($newAdded_by !== null) {
            $sql .= ", added_by = :added_by";
            $params['added_by'] = $newAdded_by;
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // DELETE subcategory
    public function deleteSubcategory($identifier)
    {
        $sub = $this->getSubcategory($identifier);
        if (!$sub) return false;

        $stmt = $this->db->prepare("DELETE FROM subcategories WHERE id = :id");
        return $stmt->execute(['id' => $sub['id']]);
    }
}
