<?php
/**
 * Created by PhpStorm.
 * User: salmeron
 * Date: 20/11/19
 * Time: 16:32
 */

class Cart
{

    private $db;

    public function __construct()
    {
        $this->db = MySQLdb::getInstance()->getDatabase();
    }

    public function verifyProduct($product_id, $user_id)
    {
        $sql = 'SELECT * FROM carts WHERE product_id=:product_id AND user_id=:user_id';

        $query = $this->db->prepare($sql);
        $params = [
            ':product_id' => $product_id,
            ':user_id' => $user_id
        ];
        $query->execute($params);


        return $query->rowCount();
    }

    public function addProduct($product_id, $user_id)
    {
        $sql1 = 'SELECT * FROM products WHERE id=:id';
        $query1 = $this->db->prepare($sql1);
        $query1->execute([':id' => $product_id]);
        $product = $query1->fetch();

        $sql = 'INSERT INTO carts(state, user_id, product_id, quantity, discount, send, date)
                  VALUES(0, :user_id, :product_id, :quantity, :discount, :send, :date)';

        $query = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user_id,
            ':product_id' => $product_id,
            ':quantity' => 1,
            ':discount' => $product->discount,
            ':send' => $product->send,
            ':date' => date('Y-m-d H:i:s')
        ];
        $query->execute($params);
        return $query->rowCount();
    }

    public function getCart($user_id)
    {
        $sql = 'SELECT c.id, c.user_id as user, c.product_id as product, c.quantity as quantity,
              c.send as send, c.discount as discount, p.price as price, p.image as image,
              p.name as name, p.description as description
              FROM carts c, products p WHERE c.user_id = :user_id AND c.product_id = p.id';
        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $user_id]);
        return $query->fetchAll();
    }

    public function update($user, $product, $quantity)
    {
        $sql = 'UPDATE carts SET quantity=:quantity WHERE user_id = :user_id AND product_id = :product_id';
        $query = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user,
            ':product_id' => $product,
            ':quantity' => $quantity
        ];
        return $query->execute($params);
    }

    public function delete($product, $user)
    {
        $sql = 'DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id';

        $query = $this->db->prepare($sql);
        $params = [
            ':product_id' => $product,
            ':user_id' => $user
        ];
        return $query->execute($params);
    }

}