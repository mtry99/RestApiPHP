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

//GET ID (query param) from URL 

// if param exists than set id = to param value, else kill the request (die)
$post->id = isset($_GET['id']) ? $_GET['id'] : die();


//Get post
$post->single_post();

//Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

// Convert to JSON

print_r(json_encode($post_arr));


