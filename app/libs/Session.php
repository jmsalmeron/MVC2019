<?php

/**
 * Clase para las sesiones
 */
class Session
{
	private $login = false;
	private $user;
	private $cartTotal;
	
	function __construct()
	{
		session_start();
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
			$this->login = true;
			if(isset($this->user->id))
            {
                $_SESSION['cartTotal'] = $this->cartTotal();
                $this->cartTotal = $_SESSION['cartTotal'];
            }
		} else {
			unset($this->user);
			$this->login = false;
		}
	}

	public function login($user)
	{
		$this->user = $user;
		$_SESSION['user'] = $user;
		$this->login = true;
	}

	public function logout()
	{
		unset($_SESSION['user']);
		unset($this->user);
		session_destroy();
		$this->login = false;
	}

	public function getLogin()
	{
		return $this->login;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getUserId()
    {
        return $this->user->id;
    }

    public function cartTotal()
    {
        $db = MySQLdb::getInstance()->getDatabase();
        $sql = 'SELECT SUM(p.price * c.quantity) - SUM(c.discount) + SUM(c.send) as total 
                FROM products p, carts c WHERE p.id = c.product_id AND c.user_id = :user AND state = 0';

        $query = $db->prepare($sql);
        $query->execute([':user' => $this->getUserId()]);
        $data = $query->fetch();
        //$db->close();
        return ($data->total ?? 0);
    }
}








