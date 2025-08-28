<?php
class Post
{
    private $db;
    public $lang;

    public function __construct($lang = 'en')
    {
        $this->db = dbConn();
        $this->lang = in_array($lang, ['en', 'kh']) ? $lang : 'en';
    }

    private function getLangFields()
    {
        return [
            'name' => $this->lang === 'en' ? 'name' : 'name_kh',
            'description' => $this->lang === 'en' ? 'description' : 'description_kh'
        ];
    }

    // Get all posts
    public function getPosts($limit = null)
    {
        $fields = $this->getLangFields();
        $sql = "SELECT id, {$fields['name']} AS name, {$fields['description']} AS description, 
               slug, image, category_id, subcategory_id, created_at, added_by, link
        FROM posts 
        ORDER BY created_at DESC";
        if ($limit) $sql .= " LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        if ($limit) $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get posts by category ID
    public function getPostsByCategory($category_id, $limit = null)
    {
        $fields = $this->getLangFields();
        $sql = "SELECT id, {$fields['name']} AS name, {$fields['description']} AS description, 
                       slug, image, category_id, subcategory_id, created_at, link
                FROM posts 
                WHERE category_id = :category_id 
                ORDER BY created_at DESC";
        if ($limit) $sql .= " LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        if ($limit) $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get posts by category slug
    public function getPostsByCategorySlug($category_slug, $limit = null)
    {
        $fields = $this->getLangFields();
        $sql = "SELECT p.id, p.{$fields['name']} AS name, p.{$fields['description']} AS description, 
                       p.slug, p.image, p.category_id, p.subcategory_id, p.created_at
                FROM posts p
                INNER JOIN categories c ON p.category_id = c.id
                WHERE c.slug = :category_slug
                ORDER BY p.created_at DESC";
        if ($limit) $sql .= " LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_slug', $category_slug, PDO::PARAM_STR);
        if ($limit) $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get posts by category + subcategory slug
    public function getPostsByCategoryAndSubcategorySlug($category_slug, $subcategory_slug, $limit = null)
    {
        $fields = $this->getLangFields();
        $sql = "SELECT p.id, p.{$fields['name']} AS name, p.{$fields['description']} AS description, 
                       p.slug, p.image, p.category_id, p.subcategory_id, p.created_at
                FROM posts p
                INNER JOIN categories c ON p.category_id = c.id
                INNER JOIN subcategories s ON p.subcategory_id = s.id
                WHERE c.slug = :category_slug AND s.slug = :subcategory_slug
                ORDER BY p.created_at DESC";
        if ($limit) $sql .= " LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_slug', $category_slug, PDO::PARAM_STR);
        $stmt->bindValue(':subcategory_slug', $subcategory_slug, PDO::PARAM_STR);
        if ($limit) $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Generate unique slug from English name
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn() > 0;
    }

    // CREATE post
    public function createPost($name_en, $category_id, $subcategory_id = null, $description_en = null, $image = null, $name_kh = null, $description_kh = null, $added_by = null, $link = null)
    {
        $slug = $this->generateSlug($name_en);
        $stmt = $this->db->prepare("
            INSERT INTO posts (name, name_kh, slug, category_id, subcategory_id, description, description_kh, image, added_by, link) 
            VALUES (:name_en, :name_kh, :slug, :category_id, :subcategory_id, :description_en, :description_kh, :image, :added_by, :link)
        ");
        return $stmt->execute([
            'name_en' => $name_en,
            'name_kh' => $name_kh,
            'slug' => $slug,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
            'description_en' => $description_en,
            'description_kh' => $description_kh,
            'image' => $image,
            'added_by' => $added_by,
            'link' => $link
        ]);
    }

   
    // GET post by ID
    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePostById($id, $name_en = null, $category_id = null, $subcategory_id = null, $description_en = null, $image = null, $name_kh = null, $description_kh = null)
    {
        $post = $this->getPostById($id);
        if (!$post) return false;

        $newSlug = $name_en ? $this->generateSlug($name_en) : $post['slug'];

        $sql = "UPDATE posts SET name = :name_en, slug = :newSlug, name_kh = :name_kh, description = :description_en, description_kh = :description_kh";
        $params = [
            'name_en' => $name_en ?? $post['name'],
            'newSlug' => $newSlug,
            'name_kh' => $name_kh ?? $post['name_kh'],
            'description_en' => $description_en ?? $post['description'],
            'description_kh' => $description_kh ?? $post['description_kh'],
            'id' => $id
        ];

        if ($category_id !== null) {
            $sql .= ", category_id = :category_id";
            $params['category_id'] = $category_id;
        }
        if ($subcategory_id !== null) {
            $sql .= ", subcategory_id = :subcategory_id";
            $params['subcategory_id'] = $subcategory_id;
        }
        if ($image !== null) {
            $sql .= ", image = :image";
            $params['image'] = $image;
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }





    // GET post by slug
    public function getPostBySlug($slug, $lang = 'en')
    {
        // Validate language
        $lang = in_array($lang, ['en', 'kh']) ? $lang : 'en';

        $sql = "SELECT *,
            CASE WHEN :lang = 'kh' THEN name_kh ELSE name END AS name,
       CASE WHEN :lang = 'kh' THEN description_kh ELSE description END AS description,
       link
            FROM posts
            WHERE slug = :slug
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindValue(':lang', $lang, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // UPDATE post by slug
    public function updatePostBySlug($slug, $name_en = null, $category_id = null, $subcategory_id = null, $description_en = null, $image = null, $name_kh = null, $description_kh = null)
    {
        $post = $this->getPostBySlug($slug);
        if (!$post) return false;

        $newSlug = $name_en ? $this->generateSlug($name_en) : $post['slug'];

        $sql = "UPDATE posts SET name = :name_en, slug = :newSlug, name_kh = :name_kh, description = :description_en, description_kh = :description_kh";
        $params = [
            'name_en' => $name_en ?? $post['name'],
            'newSlug' => $newSlug,
            'name_kh' => $name_kh ?? $post['name_kh'],
            'description_en' => $description_en ?? $post['description'],
            'description_kh' => $description_kh ?? $post['description_kh'],
            'slug' => $slug
        ];

        if ($category_id !== null) {
            $sql .= ", category_id = :category_id";
            $params['category_id'] = $category_id;
        }
        if ($subcategory_id !== null) {
            $sql .= ", subcategory_id = :subcategory_id";
            $params['subcategory_id'] = $subcategory_id;
        }
        if ($image !== null) {
            $sql .= ", image = :image";
            $params['image'] = $image;
        }

        $sql .= " WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // DELETE post by slug
    public function deletePostBySlug($slug)
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE slug = :slug");
        return $stmt->execute(['slug' => $slug]);
    }
}
