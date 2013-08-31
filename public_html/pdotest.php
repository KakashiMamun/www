<?php

if (!extension_loaded("pdo_cassandra")) die("skip Module not loaded");

?>

<?php
// DSN to use for tests
$dsn = 'cassandra:host=127.0.0.1;port=9160;cqlversion=2.0.0';

// set username and password to null for no authentication
$username = null;
$password = null;

// Warning: the keyspace will be truncated during tests
$keyspace = "phptests";

// Initialise the keyspace
function pdo_cassandra_init ($db, $keyspace = null)
{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($keyspace)
    {
        try {
            $db->exec ("DROP KEYSPACE $keyspace");
        } catch (PDOException $e) {}

        $db->exec ("CREATE KEYSPACE $keyspace with strategy_class = 'SimpleStrategy' and strategy_options:replication_factor=1;");
        $db->exec ("USE $keyspace");
        $db->exec ("CREATE COLUMNFAMILY users (
                        my_key varchar PRIMARY KEY,
                        full_name varchar );");

        $stmt = $db->prepare ("INSERT INTO users (my_key, full_name) VALUES (:key, :full_name);");
        $stmt->execute (array (':key' => 'mikko', ':full_name' => 'Mikko K' ));
        $stmt->execute (array (':key' => 'john', ':full_name' => 'John Doe'));
	
    }
}

function pdo_cassandra_done ($db, $keyspace)
{
    $db->query ("DROP KEYSPACE $keyspace;");
}

?>
<?php


$db = new PDO($dsn, $username, $password);

pdo_cassandra_init($db, 'testKeyspace');

echo "OK";

?>
