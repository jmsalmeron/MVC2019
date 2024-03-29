<?php

/**
 *  Clase Shop
 */
class Shop
{
	private $db;
	
	function __construct()
	{
		$this->db = MySQLdb::getInstance()->getDatabase();
	}

	public function getMostSold()
    {
        $sql = 'SELECT * FROM products WHERE mostSold = 1 AND deleted = 0 LIMIT 8';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getNews()
    {
        $sql = 'SELECT * FROM products WHERE mostSold = 0 AND deleted = 0 AND new = 1 LIMIT 8';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getProductById($id)
    {
        $sql = 'SELECT * FROM products WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function sendEmail($name, $email, $message)
    {
        $msg = $name . ' Ha enviado un mensaje nuevo.<br>';
        $msg.='Su correo es ' .$email . '<br>';
        $msg .= 'Mensaje:<br>' .message;
        $headers = 'MIME-Version: 1.0\r\n';
        $headers.= 'Content-type:text/html; charset=UTF-8\r\n';
        $headers.= 'From: '. $name .'\r\n';
        $headers.= 'Reply-to:' .$email. '\r\n';

        $subject = 'Mensaje del usuario ' .$name;

        return mail('info@shopmvc.local', $subject, $msg, $headers);
    }
}