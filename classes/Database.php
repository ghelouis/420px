<?php

/*
 * Manage all database access
 */
class Database {

    private $_connection;

    public function __construct()
    {
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $this->_connection = new PDO('mysql:host=localhost;dbname=420px_db', 'root', 'root', $options);
    }

    public function matchUserPwd($username, $pwd)
    {
        $query = $this->_connection->prepare("SELECT pwd_hash FROM users WHERE login=?");
        $query->execute(array($username));
        $result = $query->fetch(PDO::FETCH_OBJ);
        $pwd_hash = $result->pwd_hash;
        return password_verify($pwd, $pwd_hash);
    }

    public function findUser($username)
    {
        $get_user = $this->_connection->prepare("SELECT * FROM users WHERE login=?");
        $get_user->execute(array($username));
        return $get_user->fetch(PDO::FETCH_OBJ);
    }

    public function getAllUsers()
    {
        $get_users = $this->_connection->query("SELECT login FROM users");
        return $get_users->fetchAll(PDO::FETCH_OBJ);
    }

    public function createUser($username, $pwd)
    {
        $create_new_user = $this->_connection->prepare("Insert INTO users (login, pwd_hash) VALUES (?, ?)");
        $pwd_hash = password_hash($pwd, PASSWORD_BCRYPT);
        $create_new_user->execute(array($username, $pwd_hash));
    }

    public function addImage($username, $image)
    {
        $get_user_id = $this->_connection->prepare("SELECT id FROM users WHERE login=?");
        $get_user_id->execute(array($username));
        $id = $get_user_id->fetch(PDO::FETCH_OBJ);
        $create_new_img = $this->_connection->prepare("Insert INTO images (user_id, name) VALUES (?, ?)");
        $create_new_img->execute(array($id->id, $image));
    }

    public function getAllTags()
    {
        $get_tags = $this->_connection->query("SELECT name FROM tags");
        return $get_tags->fetchAll(PDO::FETCH_OBJ);
    }

    public function addTag($tag)
    {
        $create_new_tag = $this->_connection->prepare("Insert INTO tags (name) VALUES (?)");
        $create_new_tag->execute(array($tag));
    }

    public function associateTagWithImage($tag, $image)
    {
        $get_image_id = $this->_connection->prepare("SELECT id FROM images WHERE name=?");
        $get_image_id->execute(array($image));
        $img_id = $get_image_id->fetch(PDO::FETCH_OBJ);
        $get_tag_id = $this->_connection->prepare("SELECT id FROM tags WHERE name=?");
        $get_tag_id->execute(array($tag));
        $tag_id = $get_tag_id->fetch(PDO::FETCH_OBJ);

        $create_new_assoc = $this->_connection->prepare("Insert INTO imagesToTags (id_image, id_tag) VALUES (?, ?)");
        $create_new_assoc->execute(array($img_id->id, $tag_id->id));
    }

    public function deleteImage($image)
    {
        $get_image_id = $this->_connection->prepare("SELECT id FROM images WHERE name=?");
        $get_image_id->execute(array($image));
        $img_id = $get_image_id->fetch(PDO::FETCH_OBJ);
        $delete_assoc = $this->_connection->prepare("DELETE FROM imagesToTags WHERE id_image=?");
        $delete_assoc->execute(array($img_id->id));

        $delete_img = $this->_connection->prepare("DELETE FROM images WHERE id=?");
        $delete_img->execute(array($img_id->id));
    }

    public function getTagsForImage($image)
    {
        $get_image_id = $this->_connection->prepare("SELECT id FROM images WHERE name=?");
        $get_image_id->execute(array($image));
        $img_id = $get_image_id->fetch(PDO::FETCH_OBJ);
        $get_tag_ids = $this->_connection->prepare("SELECT id_tag FROM imagesToTags WHERE id_image=?");
        $get_tag_ids->execute(array($img_id->id));
        $tag_id = $get_tag_ids->fetch(PDO::FETCH_OBJ);
        $tag_ids[] = $tag_id->id_tag;
        while ($tag_id != null)
        {
            $tag_id = $get_tag_ids->fetch(PDO::FETCH_OBJ);
            $tag_ids[] = $tag_id->id_tag;
        }

        $tags = array();
        foreach ($tag_ids as $id)
        {
            $get_tags = $this->_connection->prepare("SELECT name FROM tags WHERE id=?");
            $get_tags->execute(array($id));
            $tags[] = $get_tags->fetch(PDO::FETCH_OBJ);
        }
        array_pop($tags);
        return $tags;
    }

    public function getImagesForTag($tag)
    {
        $get_tag_id = $this->_connection->prepare("SELECT id FROM tags WHERE name LIKE CONCAT('%',?,'%')");
        $get_tag_id->execute(array($tag));
        $tag_id = $get_tag_id->fetch(PDO::FETCH_OBJ);
        $get_img_ids = $this->_connection->prepare("SELECT id_image FROM imagesToTags WHERE id_tag=?");
        $get_img_ids->execute(array($tag_id->id));
        $img_id = $get_img_ids->fetch(PDO::FETCH_OBJ);
        $img_ids[] = $img_id->id_image;
        $img_id = $get_img_ids->fetch(PDO::FETCH_OBJ);
        while ($img_id != null)
        {
            $img_ids[] = $img_id->id_image;
            $img_id = $get_img_ids->fetch(PDO::FETCH_OBJ);
        }

        $imgs = array();
        foreach ($img_ids as $id)
        {
            $get_imgs = $this->_connection->prepare("SELECT name, users.login FROM images INNER JOIN users ON images.user_id=users.id WHERE images.id=? ");
            $get_imgs->execute(array($id));
            $imgs[] = $get_imgs->fetch(PDO::FETCH_OBJ);
        }
        return $imgs;
    }
}