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
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data)) 
    {
        // Deleting the post dari input user
    
        if ($post->update($data->id)) 
        {
            echo json_decode(['message' => 'Post Deleted Successfully']);
        }
         
    }