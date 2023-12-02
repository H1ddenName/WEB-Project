<?php 

    error_reporting(E_ALL);
    ini_set('display_error', 1);

    // Headers

    Header('Access-Control-Allow-Origin: *');
    Header('Content-Type: application/json');
    Header('Access-Control-Allow-Method: POST');

    // Including required files.
    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    // Connection with Database

    $database = new Database;
    $db =  $database->connect();

    $post = new Post($db);
    
    if (isset($_GET['id'])) {
        $data = $post->read_details_post($_GET['id']);
        if ($data->rowCount()) 
        {
         $posts = [];

         while ($row = $data->fetch(PDO::FETCH_OBJ)) 
         {
            $posts[$row->id] = [
                'id' => $row->id,
                'categoryName' => $row->category,
                'description' => $row->description,
                'title' => $row->title,
                'created_at' => $row->created_at,
            ];
         }
        }
        echo json_encode($posts);
    } else {
        echo json_encode(['message' => 'No posts Found']);
    }
