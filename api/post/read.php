<?php

// Header function to send a raw HTTP (used to manipulate info sent to the client or browser by the Web Server) header

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//Connect DB
include_once '../../config/database.php';
include_once '../../models/Post.php';

// Instantiate DB & Connect

$database = new Database();
$db = $database->connect();

// Instantiate blog post object

//Pass in db object to Post class constructor
$post = new Post($db);

// Blog post query
$result = $post->read();

// Get row count
$num = $result->rowCount();

//Check if any posts
if ($num > 0) {

    // Post Array
    $posts_arr = array();

    //Instead of return just JSON object return in an array so that in future you can add other info besides data like version control
    $posts_arr['data'] = array();


    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
     
        extract($row); //to give titles to properties of the post

        //Create Post Item for each post
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body), //Body can have HTML Design
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    //Turn from PHP Array to JSON and Output

    echo json_encode ($posts_arr);

    //If there is no posts
} else {

    // No Posts
    echo json_encode(
        array('message' => 'No Posts Found' )
    );
}
