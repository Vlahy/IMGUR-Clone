<?php
require __DIR__ . '/../vendor/autoload.php';

use Config\Database;

class ChangeDatabase
{

    private Database $conn;

    protected string $password = 'test1234';
    protected string $imageUrl = 'https://loremflickr.com/320/240';

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function passwordHash(): string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function changePassword()
    {
        $db = $this->conn->getConnection();
        $query = "SELECT * FROM user";

        $getUsers = $db->prepare($query);

        $getUsers->execute();

        $users = $getUsers->fetchAll();

        foreach ($users as $user){
            $id = $user['id'];
            $changeUsersPassword = $db->prepare("UPDATE user SET password = :password WHERE id = :id");
            $changeUsersPassword->bindValue(':password', $this->passwordHash());
            $changeUsersPassword->bindValue(':id', $id);
            $changeUsersPassword->execute();
        }
    }

    public function changeImgFilePath()
    {
        $db = $this->conn->getConnection();

        $query = "SELECT id, file_name FROM image WHERE user_id = 1";

        $getImages = $db->prepare($query);

        $getImages->execute();

        $images = $getImages->fetchAll();

        foreach ($images as $image){
            $id = $image['id'];
            $changeUsersPassword = $db->prepare("UPDATE image SET file_name = :file_name WHERE id = :id");
            $changeUsersPassword->bindValue(':file_name', $this->imageUrl);
            $changeUsersPassword->bindValue(':id', $id);
            $changeUsersPassword->execute();
        }
    }

}

$database = new ChangeDatabase();

echo 'Changing password...' . PHP_EOL;
$database->changePassword();
echo 'Done. Password is changed.' . PHP_EOL;
echo 'Changing images url...' . PHP_EOL;
$database->changeImgFilePath();
echo 'Done. Image url is changed.' . PHP_EOL;