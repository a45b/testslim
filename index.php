<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
//use Slim\Slim;
$app = new \Slim\Slim();

// GET route

$app->get('/', function () use ($app) {
	$app->render('../app.php');
});
	
// POST route
$app->get('/movielist', 'getMovieList');
$app->post('/add', 'addMovie');
/*
$app->get('/wines/:id',	'getWine');
$app->get('/wines/search/:query', 'findByName');

$app->put('/wines/:id', 'updateWine');
$app->delete('/wines/:id',	'deleteWine');
*/

$app->run();

function getMovieList() {
	$sql = "SELECT *, DATE_FORMAT(watched_on,'%d %b %Y') watched_on FROM  watchedlist";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);
		$movies = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($movies);
		//echo '{"wine": ' . json_encode($wines) . '}';
	} catch(PDOException $e) {
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function addMovie() {
	$data = array();
	$data['name'] = $_POST['name'];
	$data['genre'] = $_POST['genre'];
	$data['watched_on'] = $_POST['watched_on'];
	$data['medium'] = $_POST['medium'];
	$data['rating'] = $_POST['rating'];
	
	$sql = "INSERT INTO watchedlist (name, genre, watched_on, medium, rating) VALUES (:name, :genre, :watched_on, :medium, :rating)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $data['name']);
		$stmt->bindParam("genre", $data['genre']);
		$stmt->bindParam("watched_on", $data['watched_on']);
		$stmt->bindParam("medium", $data['medium']);
		$stmt->bindParam("rating", $data['rating']);
		$stmt->execute();
		$data['id'] = $db->lastInsertId();
		$db = null;
		echo json_encode($data);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getConnection() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="root";
	$dbname="movielist";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}



