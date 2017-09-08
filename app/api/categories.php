<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App as App;


$app = new \Slim\App;

$app->get('/api/categories', function(Request $request, Response $response){
	
	$sql = "SELECT * FROM categories";
	$connection = new Connect();
	$database = $connection->connect();

	try {
		
		$statement = $database->query($sql);
		$categories = $statement->fetchAll(PDO::FETCH_OBJ);
		
		echo json_encode($categories);

	} catch (PDOException $e) {
		echo json_encode(['message' => $e]);
	}
});

$app->post('/api/categories', function(Request $request, Response $response){
	
	$categoryName = $request->getParam('category_name');
	
	$sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
	$connection = new Connect();
	$database = $connection->connect();

	try {
		$statement = $database->prepare($sql);
		$statement->bindParam(":category_name" , $categoryName);
		$statement->execute();

		echo json_encode(['message' => 'Category Added !']);
	} catch (Exception $e) {
		echo json_encode(['message' => $e]);
	}

});

$app->get('/api/category/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');
	$sql = "SELECT * FROM categories WHERE id = $id";
	$connection = new Connect();
	$database = $connection->connect();

	try {
		
		$statement = $database->query($sql);
		$category = $statement->fetchAll(PDO::FETCH_OBJ);
		
		echo json_encode($category);

	} catch (PDOException $e) {
		echo json_encode(['message' => $e]);
	}
});

$app->put('/api/category/{id}', function(Request $request, Response $response){
	
	$id = $request->getAttribute('id');
	$categoryName = $request->getParam('category_name');

	
	$sql = "UPDATE categories SET category_name = :category_name WHERE id = :id";
	$connection = new Connect();
	$database = $connection->connect();

	try {
		$statement = $database->prepare($sql);
		$statement->bindParam(":category_name" , $categoryName);
		$statement->bindParam(":id" , $id);
		$statement->execute();

		echo json_encode(['message' => 'Category ' . $id .'  Updated']);
	} catch (Exception $e) {
		echo json_encode(['message' => $e]);
	}
});

$app->delete('/api/category/{id}', function(Request $request, Response $response){
	
	$id = $request->getAttribute('id');
	$sql  = "DELETE FROM categories WHERE id = :id";

	$connection = new Connect();
	$database = $connection->connect();

	try {
		$statement = $database->prepare($sql);
		$statement->bindParam(":id" , $id);
		$statement->execute();

		echo json_encode(['message' => 'Category ' . $id .'  Deleted!']);
	} catch (Exception $e) {
		echo json_encode(['message' => $e]);
	}

});