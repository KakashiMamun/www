<?php
$db = new PDO('cassandra:host=127.0.0.1;port=9160');
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
print_r(var_dump($db));
echo '<br>';
//$db->exec ("CREATE KEYSPACE twissandra WITH strategy_class = SimpleStrategy AND strategy_options:replication_factor = 1;");

$db->exec ("CREATE KEYSPACE Twissaandra
           WITH replication = {'class': 'SimpleStrategy', 'replication_factor' : 1};");
print_r( $db->errorInfo());

$db->exec ("USE twissandra");
print_r( $db->errorInfo());

$db->exec ("CREATE TABLE user (
		username text PRIMARY KEY,
		password text );");
print_r( $db->errorInfo());

print_r($db->getAvailableDrivers());
print_r($db->getAttribute(PDO::ATTR_DRIVER_NAME,PDO::ATTR_SERVER_INFO,PDO::ATTR_SERVER_VERSION));

echo '<br>';
$stmt = $db->prepare ("INSERT INTO user (username, password) VALUES (:username, :password);");


$stmt->execute (array (':username' => 'meg', ':password' => 's3krt3t' ));
print_r($stmt->errorInfo());

echo '<br>';

//$stmt = $db->prepare ("SELECT password  FROM user WHERE username = :key;");
//$stmt->bindValue (':key', 'meg');
//$stmt->execute ();

//var_dump ($stmt->fetchAll ());


