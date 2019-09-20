<?php

class Post {

    // DB Stuff
    private $conn;
    private $table = 'posts';


    // Post Properties (from Post Structure);

    public $id;
    public $category_id;
    public $category_name;   //From Category Structure
    public $title;
    public $body;
    public $author;
    public $created_at;


    // Constructor with DB - to run automatically when object is instantiated from class

    // Pass in database object
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts
    public function read(){
        //Create query

        // Join Category Table to Post Table to associate each Post's Category ID to Category Table's ID
        $query = 'SELECT 
                
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                
                FROM  
                    ' .$this->table . ' p 
                LEFT JOIN 
                    categories c ON p.category_id = c.id

                ORDER BY
                    p.created_at DESC';
                  
        //Prepared statement
        $stmt = $this->conn->prepare($query);


        //Execute query
        $stmt->execute();

        return $stmt;
    }



    //Get Single Post
    public function single_post(){

        // Allow user to enter positional query paramter (limit 1) for id of post
        $query = 'SELECT 
                
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        
        FROM  
            ' .$this->table . ' p 
        LEFT JOIN 
            categories c ON p.category_id = c.id

        WHERE
            p.id = ?
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID (1st parameter should bind to id)
        $stmt->bindParam(1, $this->id);

        //Execute Query
        $stmt->execute();

        // Fetch the array returned by query which is one single record instead
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        // Set Properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['category_id'];
        $this->category = $row['category_name'];

    }


    // Create Post
    public function create() {

        //Create query

        $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

        
        //Prepare Statement

        $stmt = $this->conn->prepare($query);


        //Clean data before inputting into our data base by using HTML and TAG cleans

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));


        //Bind Data based on title of data not position
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);


        //Execute Query

        if ($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong

        printf("Error: %s", $stmt->err);
        return false;
    }
}