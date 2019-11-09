<?php
/**
 * Created by PhpStorm.
 * User: salmeron
 * Date: 7/11/19
 * Time: 16:02
 */

class AdminProduct
{

    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function getProducts()
    {
        $sql = "SELECT * FROM products WHERE deleted = 0";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getConfig($type)
    {
        $sql = 'SELECT * FROM config WHERE type = :type ORDER BY value';
        $query = $this->db->prepare($sql);
        $query->execute([':type' => $type]);
        return $query->fetchAll();
    }

    public function getCatalogue()
    {
        $sql = "SELECT id, name, type FROM products WHERE deleted = 0 AND status != 0 ORDER BY type, name";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}