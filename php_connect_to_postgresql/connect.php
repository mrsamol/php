<?php
    function connectToPostgreSQL($host, $port, $dbname, $user, $password) {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );
        try {
            $pdo = new PDO($dsn, $user, $password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function getDataFromPostgreSQL($pdo, $table) {
        $stmt = $pdo->prepare("SELECT * FROM $table");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }