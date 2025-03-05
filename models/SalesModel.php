<?php

class SalesModel extends BaseModel
{

    public function store($data)
    {
        $sql = "INSERT INTO sales (stock_items_id,user_id,name,quantity,price) VALUES(:stock_items_id,:user_id,:name,:quantity,:price)";
        return $this->execute($sql, [
            'stock_items_id' => $data['stock_items_id'],
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $data['price']
        ]);
    }
    public function show()
    {
        $sql = "SELECT * FROM sales";
        return $this->fetchall($sql);
    }
    public function put($sales_id, $data)
    {
        $sql = "UPDATE sales SET name=:name,quantity=:quantity,price=:price WHERE sales_id =:sales_id";
        return $this->execute($sql, [
            'sales_id' => $sales_id,
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $data['price']
        ]);
    }
    public function destroy($sales_id)
    {
        $sql = "DELETE FROM sales WHERE sales_id = :sales_id";
        return $this->execute($sql, ['sales_id' => $sales_id]);
    }
}
