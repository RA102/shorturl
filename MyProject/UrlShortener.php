<?php

namespace MyProject;

use MyProject\Database;

class UrlShortener
{
    private $db;
    private $url;
    private $shortCode;
    private function connect()
    {
        $this->db = new Database();
    }

    public function shorten($url)
    {
        $this->url = $url;
        $this->shortCode = $this->generateShortCode();

        $result = $this->selectShortCode();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        $this->db->closeConnect();

        $params = [
            $this->url, $this->shortCode
        ];

        $sql = "INSERT INTO links (url, short_code, created_at) VALUES (?, ?, NOW())";
        $this->connect();
        $result = $this->db->query($sql, $params);

        return $result;

    }

    private function generateShortCode()
    {
        // генерируем случайный короткий код
        $shortCode = substr(md5($this->url), 0, 6);
        return $shortCode;
    }

    public function selectShortCode()
    {
        $sql = "SELECT * FROM links WHERE short_code = ?";
        $params = [
            $this->shortCode
        ];
        $this->connect();
        $result = $this->db->query($sql, $params);
        return $result->get_result();
    }

    public function stats($shortCode)
    {
        $this->shortCode = $shortCode;
        $sql = "UPDATE links SET click = click + 1 WHERE short_code = ?";
        $params = [
            $shortCode
        ];
        $this->connect();
        $result = $this->db->query($sql, $params);
        return $result;
    }
}