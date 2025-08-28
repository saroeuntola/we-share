
<?php

function dbConn()
{
   $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "weshare";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function dbClose(&$conn)
{
    $conn = null;
}

function dbSelect($table, $column = "*", $criteria = "", $clause = "")
{
    if (empty($table)) return false;

    $sql = "SELECT $column FROM $table";
    if (!empty($criteria)) $sql .= " WHERE $criteria";
    if (!empty($clause)) $sql .= " $clause";

    $conn = dbConn();
    try {
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        dbClose($conn);
        return $result;
    } catch (PDOException $e) {
        echo "Error in selecting data: " . $e->getMessage();
        return false;
    }
}

function dbInsert($table, $data = array())
{
    if (empty($table) || empty($data)) return false;

    $conn = dbConn();
    $fields = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
        dbClose($conn);
        return true;
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
        return false;
    }
}

function dbUpdate($table, $data = array(), $criteria = "")
{
    if (empty($table) || empty($data) || empty($criteria)) return false;

    $conn = dbConn();
    $setClause = "";
    foreach ($data as $key => $val) {
        $setClause .= "$key = :$key, ";
    }
    $setClause = rtrim($setClause, ", ");
    $sql = "UPDATE $table SET $setClause WHERE $criteria";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
        dbClose($conn);
        return true;
    } catch (PDOException $e) {
        echo "Error updating data: " . $e->getMessage();
        return false;
    }
}

function dbDelete($table, $criteria)
{
    if (empty($table) || empty($criteria)) return false;

    $sql = "DELETE FROM $table WHERE $criteria";
    $conn = dbConn();

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        dbClose($conn);
        return true;
    } catch (PDOException $e) {
        echo "Error deleting data: " . $e->getMessage();
        return false;
    }
}

function dbCount($table = "", $criteria = "")
{
    if (empty($table)) return false;

    $sql = "SELECT COUNT(*) as count FROM $table";
    if (!empty($criteria)) $sql .= " WHERE $criteria";

    $conn = dbConn();
    try {
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        dbClose($conn);
        return $result['count'];
    } catch (PDOException $e) {
        echo "Error counting data: " . $e->getMessage();
        return false;
    }
}

?>
