<?php

// Connect to database.
$dsn = 'mysql:dbname=;host=127.0.0.1';
$user = '';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Insert values into database.
$name = 'Joshua';
$message = 'Tesdt';

$sql = "INSERT INTO guests (name, message, posted) VALUES (?, ?, NOW())";
$extract = $dbh->prepare($sql);

$extract->execute(array($name, $message));

// Obtain values from entries.
class GuestsEntry {
  public $id, $name, $message, $posted, $entry;

  public function __construct() {
    $this->entry = "{$this->name} posted: {$this->message} on {$this->posted}";
  }
}

$query = $dbh->query('SELECT * FROM guests');
$query->setFetchMode(PDO::FETCH_CLASS, 'GuestsEntry');
while($r = $query->fetch()) {
  echo $r->entry, '<br>';
}
