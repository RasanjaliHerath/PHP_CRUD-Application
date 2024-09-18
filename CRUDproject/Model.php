<?php
class Model {
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'cruddb';
    private $conn;

    function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            echo 'Connection error: ' . $this->conn->connect_error;
        }
    }

    public function insertRecord($post) {
        $name = $this->conn->real_escape_string($post['name']);
        $email = $this->conn->real_escape_string($post['email']);
        $sql = "INSERT INTO users(name, email) VALUES ('$name', '$email')";
        if ($this->conn->query($sql)) {
            header('Location: index.php?msg=ins');
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    public function updateRecord($post) {
        $name = $this->conn->real_escape_string($post['name']);
        $email = $this->conn->real_escape_string($post['email']);
        $editid = $post['hid'];
        $sql = "UPDATE users SET name='$name', email='$email' WHERE id='$editid'";
        if ($this->conn->query($sql)) {
            header('Location: index.php?msg=ups');
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    public function displayRecord() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return [];
    }

    public function displayRecordById($editid) {
        $sql = "SELECT * FROM users WHERE id='$editid'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    public function deleteRecord($delid) {
        $sql = "DELETE FROM users WHERE id='$delid'";
        if ($this->conn->query($sql)) {
            header('Location: index.php?msg=del');
        } else {
            echo "Error: " . $this->conn->error;
        }
    }
}
?>