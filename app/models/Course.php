<?php
/**
 * Course Model
 * Handles course data and operations
 */
class Course
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFeaturedCourses(int $limit = 8): array
    {
        $limit = (int) $this->normalizeLimit($limit, 8);

        $sql = "
            SELECT
                c.course_id,
                c.title,
                c.slug,
                c.short_description,
                c.thumbnail,
                c.price,
                c.level,
                c.duration_hours,
                c.language,
                c.rating,
                c.total_students,
                c.is_featured,
                c.created_at,
                cat.name AS category_name,
                cat.slug AS category_slug,
                i.full_name AS instructor_name
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE c.status = :status AND c.is_featured = :is_featured
            ORDER BY c.rating DESC, c.total_students DESC
            LIMIT :limit
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', 'published');
        $statement->bindValue(':is_featured', 1, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getCourses(?string $categorySlug = null, string $sort = 'newest', int $page = 1, int $limit = 8): array
    {
        $page = max(1, (int) $page);
        $limit = (int) $this->normalizeLimit($limit, 8);
        $offset = (int) (($page - 1) * $limit);

        $sortMap = [
            'newest' => 'c.created_at DESC',
            'price_asc' => 'c.price ASC',
            'price_desc' => 'c.price DESC',
            'rating_desc' => 'c.rating DESC',
            'title_asc' => 'c.title ASC',
            'popular' => 'c.total_students DESC',
        ];

        $orderBy = $sortMap[$sort] ?? $sortMap['newest'];

        $sql = "
            SELECT
                c.course_id,
                c.title,
                c.slug,
                c.short_description,
                c.thumbnail,
                c.price,
                c.level,
                c.duration_hours,
                c.language,
                c.rating,
                c.total_students,
                c.is_featured,
                c.created_at,
                cat.name AS category_name,
                cat.slug AS category_slug,
                i.full_name AS instructor_name
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE c.status = :status
        ";

        $params = ['status' => 'published'];

        if ($categorySlug !== null && $categorySlug !== '') {
            $sql .= " AND cat.slug = :category_slug";
            $params['category_slug'] = $categorySlug;
        }

        $sql .= " ORDER BY {$orderBy} LIMIT :limit OFFSET :offset";

        $statement = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countCourses(?string $categorySlug = null): int
    {
        $sql = "
            SELECT COUNT(*) AS total_courses
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            WHERE c.status = :status
        ";

        $params = ['status' => 'published'];

        if ($categorySlug !== null && $categorySlug !== '') {
            $sql .= " AND cat.slug = :category_slug";
            $params['category_slug'] = $categorySlug;
        }

        $statement = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        $statement->execute();

        return (int) $statement->fetchColumn();
    }

    public function getCourseBySlug(string $slug): ?array
    {
        $sql = "
            SELECT
                c.*,
                cat.name AS category_name,
                cat.slug AS category_slug,
                i.full_name AS instructor_name,
                i.bio AS instructor_bio,
                i.expertise AS instructor_expertise,
                i.avatar AS instructor_avatar
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE c.status = :status AND c.slug = :slug
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'status' => 'published',
            'slug' => $slug,
        ]);

        $course = $statement->fetch();

        return $course ?: null;
    }

    public function getCourseById(int $courseId): ?array
    {
        $sql = "
            SELECT
                c.course_id,
                c.title,
                c.slug,
                c.status
            FROM courses c
            WHERE c.course_id = :course_id
              AND c.status = :status
            LIMIT 1
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->bindValue(':status', 'published');
        $statement->execute();

        $course = $statement->fetch();

        return $course ?: null;
    }

    public function getCourseLessons(int $courseId): array
    {
        $sql = "
            SELECT
                lesson_id,
                title,
                duration_minutes,
                is_preview,
                sort_order
            FROM course_lessons
            WHERE course_id = :course_id
            ORDER BY sort_order ASC, lesson_id ASC
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getCourseLocations(int $courseId): array
    {
        $sql = "
            SELECT
                l.location_id,
                l.name,
                l.address,
                l.city,
                l.type,
                l.google_maps_url,
                cl.support_type,
                cl.availability_note
            FROM course_locations cl
            INNER JOIN locations l ON cl.location_id = l.location_id
            WHERE cl.course_id = :course_id
            ORDER BY l.type ASC, l.name ASC
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getRelatedCourses(int $courseId, int $categoryId, int $limit = 4): array
    {
        $limit = (int) $this->normalizeLimit($limit, 4);

        $sql = "
            SELECT
                c.course_id,
                c.title,
                c.slug,
                c.short_description,
                c.thumbnail,
                c.price,
                c.rating,
                c.total_students,
                c.is_featured,
                cat.name AS category_name,
                cat.slug AS category_slug,
                i.full_name AS instructor_name
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE c.status = :status
              AND c.category_id = :category_id
              AND c.course_id != :course_id
            ORDER BY c.rating DESC, c.total_students DESC
            LIMIT :limit
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', 'published');
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function searchCourses(string $keyword, int $limit = 8): array
    {
        $limit = (int) $this->normalizeLimit($limit, 8);
        $searchTerm = '%' . trim($keyword) . '%';

        $sql = "
            SELECT
                c.title,
                c.slug,
                c.thumbnail,
                c.price,
                c.rating,
                i.full_name AS instructor_name,
                cat.name AS category_name
            FROM courses c
            INNER JOIN categories cat ON c.category_id = cat.category_id
            INNER JOIN instructors i ON c.instructor_id = i.instructor_id
            WHERE c.status = :status
              AND (
                    c.title LIKE :keyword1
                    OR c.short_description LIKE :keyword2
                    OR c.description LIKE :keyword3
                    OR cat.name LIKE :keyword4
                    OR i.full_name LIKE :keyword5
              )
            ORDER BY c.rating DESC, c.total_students DESC
            LIMIT :limit
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':status', 'published');
        $statement->bindValue(':keyword1', $searchTerm);
        $statement->bindValue(':keyword2', $searchTerm);
        $statement->bindValue(':keyword3', $searchTerm);
        $statement->bindValue(':keyword4', $searchTerm);
        $statement->bindValue(':keyword5', $searchTerm);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    private function normalizeLimit(int $limit, int $default = 8): int
    {
        if ($limit < 1) {
            return $default;
        }

        return min($limit, 50);
    }
}
?>
