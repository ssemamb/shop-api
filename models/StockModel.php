<?php

class  StockModel extends BaseModel
{

    public function store($user_id, $name, $quantity, $stock_price)
    {

        $sql = "INSERT INTO stock (user_id,name,quantity,stock_price)
        VALUES(:user_id,:name,:quantity,:stock_price)";
        return $this->execute($sql, [
            'user_id' => $user_id,
            'name' => $name,
            'quantity' => $quantity,
            'stock_price' => $stock_price,

        ]);
    }

    public function show()
    {
        $sql = "SELECT * FROM stock";
        return $this->fetchall($sql);
    }

    public function put($stock_id, $data)
    {
        try {
            $sql = "UPDATE stock SET user_id = :user_id,name = :name,quantity = :quantity,stock_price = :stock_price,created_at = :created_at,updated_at = :updated_at WHERE stock_id = :stock_id";
            return $this->execute($sql, [

                'stock_id' => $stock_id,
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'stock_price' => $data['stock_price'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ]);
        } catch (Exception $e) {
            echo json_encode(['database Error', 'details' => $e->getMessage()]);
        }
    }

    public function destroy($stock_id)
    {
        $sql = "DELETE FROM stock WHERE stock_id = :stock_id";
        return $this->execute($sql, ['stock_id' => $stock_id]);
    }


    public function search_stock($query)
    {

        $sql = "SELECT * FROM stock WHERE name LIKE :name OR stock_price LIKE :stock_price";
        $params = [
            ':name' => "%$query%",
            ':stock_price' => "%$query%"
        ];
        return $this->fetchall($sql, $params);
    }
}
