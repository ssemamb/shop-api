<?php


class StockItemsModel extends BaseModel
{

    public function store($stock_id, $name, $item_price, $quantity)
    {
        $sql = "INSERT INTO stock_items(stock_id,name,item_price,quantity) VALUES (:stock_id,:name,:item_price,:quantity)";
        return $this->execute($sql, [

            'stock_id' => $stock_id,
            'name' => $name,
            'item_price' => $item_price,
            'quantity' => $quantity
        ]);
    }
    public function show()
    {
        $sql = "SELECT * FROM stock_items";
        return $this->fetchall($sql);
    }
    public function put($stock_items_id, $data)
    {
        $sql = "UPDATE stock_items SET stock_id=:stock_id,name = :name,item_price = :item_price,quantity = :quantity WHERE stock_items_id = :stock_items_id";
        return $this->execute($sql, [
            'stock_items_id' => $stock_items_id,
            'stock_id' => $data['stock_id'],
            'name' => $data['name'],
            'item_price' => $data['item_price'],
            'quantity' => $data['quantity']
        ]);
    }
    public function destroy($stock_items_id)
    {
        $sql = "DELETE FROM stock_items WHERE stock_items_id = :stock_items_id";
        return $this->execute($sql, ['stock_items_id' => $stock_items_id]);
    }

    public function search($query)
    {
        $sql = "SELECT * FROM stock_items WHERE name LIKE :name OR item_price LIKE :item_price";
        $params = [
            'name' => "%$query",
            'item_price' => "%$query"
        ];
        return $this->fetchall($sql, $params);
    }
}
