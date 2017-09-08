<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

//SELECT ALL DATA POSTS
$app->get('/api/posts', function(Request $request, Response $response){

	$sql = "SELECT * FROM posts";
	
	$database = new Connect();
	
	$connection = $database->connect();

	try {
		$statement = $connection->query($sql);
		$posts = $statement->fetchAll(PDO::FETCH_OBJ);
		$database = NULL;
		echo json_encode($posts);
	} catch (PDOException $e) {
		echo json_encode(['message' => "CONNECTION TO DATABASE FAILED"]);
	}

});

// GET POST BY ID
$app->get('/api/post/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM posts WHERE id = $id";
	
	$database = new Connect();
	
	$connection = $database->connect();

	try {
		$statement = $connection->query($sql);
		$post = $statement->fetchAll(PDO::FETCH_OBJ);

		$database = NULL;
		echo json_encode($post);
	} catch (PDOException $e) {
		echo json_encode(['message' => "CONNECTION TO DATABASE FAILED"]);
	}
});

//SAVE POST
$app->post('/api/posts',function(Request $request, Response $response){
	$title = $request->getParam('title');
	$category_id = $request->getParam('category_id');
	$body = $request->getParam('body');

	$database = new Connect();
	
	$connection = $database->connect();

	$sql = "INSERT INTO posts (title,category_id,body) VALUES (:title, :category_id,:body)";
	try {

		//menggunakan parameter binding
		$statement = $connection->prepare($sql);
		$statement->bindParam(':title', $title);
		$statement->bindParam(':category_id', $category_id);
		$statement->bindParam(':body', $body);
		$statement->execute();

		//cetak pesan post added jika berhasil
		echo json_encode(['message' => 'Post Added !']);

	} catch (PDOException $e) {
		echo json_encode(['message' => $e]);
	}
});

//UPDATE POST
$app->put('/api/post/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$title = $request->getParam('title');
	$category_id = $request->getParam('category_id');
	$body = $request->getParam('body');

	$sql = "UPDATE posts SET title=:title, category_id = :category_id, body = :body WHERE id = :id";

	try {

		$database = new Connect();
		$connection = $database->connect();
		//menggunakan parameter binding
		$statement = $connection->prepare($sql);
		$statement->bindParam(':title', $title);
		$statement->bindParam(':category_id', $category_id);
		$statement->bindParam(':body', $body);
		$statement->bindParam(":id", $id);
		$statement->execute();

		//cetak pesan post added jika berhasil
		echo json_encode(['message' => 'Post ' . $id .' Updated !']);

	} catch (PDOException $e) {
		echo json_encode(['message' => $e]);
	}
});

//DELETE POST
$app->delete('/api/post/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$sql = "DELETE FROM posts WHERE id = :id";

	try {
		$database = new Connect();
		$connection = $database->connect();
		//menggunakan parameter binding
		$statement = $connection->prepare($sql);
		$statement->bindParam(":id", $id);
		$statement->execute();

		//cetak pesan post added jika berhasil
		echo json_encode(['message' => 'Post ' . $id .' DELETED !']);
	} catch (PDOException $e) {
		echo json_encode(['message' => $e]);
	}
});