<?php 

    error_reporting(E_ALL);
    ini_set('display', 1);

class Post {
    //Post Properties
    public $id;
    public $category_id;
    public $title;
    public $description;
    public $reg_date;

    // Database Data
    private $connection;
    private $table = 'posts';

    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Metode untuk membaca semua yang tersimpan dalam tabel posts

    public function readPosts()
    {
        // Query untuk membaca dari tabel posts
        $query = 'SELECT
            category.name as category,
            posts.id,
            posts.title,
            posts.description,
            posts.category_id,
            posts.reg_date
            FROM  posts LEFT JOIN
            category ON posts.category_id = category.id
            ORDER BY
                posts.reg_date DESC
        ';

        $post = $this->connection->prepare($query);
        
        $post->execute();

        return $post;
    }

    // Metode untuk membaca satu posts
    public function read_details_post($id)
    {
        $this->id = $id;
        {
            // Query untuk membaca dari tabel posts
            $query = 'SELECT
                category.name as category,
                posts.id,
                posts.title,
                posts.description,
                posts.category_id,
                posts.reg_date
                FROM posts LEFT JOIN
                category ON posts.category_id = category.id
                WHERE posts.id=?
                LIMIT 0,1
            ';
    
            $post = $this->connection->prepare($query);
            
            $post->bindValue(1, $this->id, PDO::PARAM_INT);
            $post->execute();
            return $post;
        }


    }

    // Metode untuk menambahkan record baru
    public function create_new_post($params)
    {
        try 
        {
            // Assigning Values

            $this->title = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];

            // Query to store new post in database

            $query = 'INSERT INTO posts
                SET
                    title = :title,
                    category_id = :category_id,
                    description = :details';
            
                $post = $this->connection->prepare($query);

                $post->bindValue('title', $this->title);
                $post->bindValue('details', $this->description);
                $post->bindValue('category_id', $this->category_id);

                if ($post->execute()) {
                    return true;
                }

                return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Metode untuk update post
    public function update($params)
    {
        try 
        {
            // Assigning Values

            $this->id = $params['id'];
            $this->title = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];

            // Query for updating existing record

            $query = 'UPDATE'. $this->table.'
                SET
                    title = :title,
                    category_id = :category_id,
                    description = :details
                    WHERE id = :id';
            
                $post = $this->connection->prepare($query);

                $post->bindValue('id', $this->id);
                $post->bindValue('title', $this->title);
                $post->bindValue('details', $this->description);
                $post->bindValue('category_id', $this->category_id);
 
                if ($post->execute()) 
                {
                    return true;
                }

                return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Metode untuk menghapus post dari database
    public function destroy_post($id)
    {
        try 
        {
            // Assigning Values

            $this->id = $id;

            // Query for updating existing record

            $query = 'DELETE FROM posts
                    WHERE id = :id';
            
                $post = $this->connection->prepare($query);

                $post->bindValue('id', $this->id);
                
                if ($post->execute()) 
                {
                    return true;
                }

                return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}