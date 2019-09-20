<?php

// Header function to send a raw HTTP (used to manipulate info sent to the client or browser by the Web Server) header

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//Defining how to get input from user
header('Access-Control-Allow-Methods: POST'); //Get data from POST request
header('Acess-Control-Allow-Headers: Acess-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

//Connect DB
include_once '../../config/database.php';
include_once '../../models/Post.php';

// Instantiate DB & Connect

$database = new Database();
$db = $database->connect();

// Instantiate blog post object

//Pass in db object to Post class constructor
$post = new Post($db);


//Get raw posted Data (given in JSON format)

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;


//Create post

if ($post->create()) {
    echo json_encode(   //must encode JSON within PHP (unlike JS where JSON is a defined object)
        array('message' => 'Post Created')
    );
} else {

    echo json_encode(
        array('message' => 'Post Not Created')
    );
}


