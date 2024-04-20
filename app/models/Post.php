<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts()
    {
        $this->db->query("SELECT *,
                                posts.id AS postId,
                                users.id AS userId,
                                posts.created_at AS postCreatedAt
                                FROM posts
                                INNER JOIN users ON posts.user_id = users.id
                                ORDER BY posts.created_at DESC
                                ");
        return $this->db->resultSet();
    }

    public function addPost($data)
    {
        $this->db->query("INSERT INTO posts (title, user_id, body) VALUES (:title, :user_id, :body)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        try {
            if ($this->db->execute()) {
                return true;
            } else
                return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;

        }
    }

    public function updatePost($data)
    {
        $this->db->query("UPDATE posts SET title=:title,body=:body WHERE id=:id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        try {
            if ($this->db->execute()) {
                return true;
            } else
                return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;

        }
    }

    public function getPostById($postId)
    {
        $this->db->query("SELECT * FROM posts WHERE id = :id");
        $this->db->bind(':id', $postId);
        return $this->db->single();
    }

    public function deletePost($postId)
    {
        $this->db->query("DELETE FROM posts WHERE id = :id");
        $this->db->bind(':id', $postId);
        if ($this->db->execute()) {
            return true;
        } else
            return false;
    }
}