<?php 

require_once('app/Connect.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\App as App;

require 'vendor/autoload.php';

$app = new \Slim\App;

//Mendapatkan URI Segment
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

//Memisah bagian alamat URL dengan pembagi '/'
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

// segment 2 adalah nama objek terkait (posts,kategori dll)
if(isset($segments[2])){
	//mendapatkan nama halaman berdasarkan Route endpoint
	$page_name = $segments[2];

	//tampilkan tergantung request alamat URI
	if($page_name == 'categories' || $page_name == 'category'){
		require_once('app/api/categories.php');
	}else if($page_name == 'posts' || $page_name == 'post'){
		require_once('app/api/posts.php');
	}else{
		die("Please Use Valid API endpoint");
	}
}

$app->run();