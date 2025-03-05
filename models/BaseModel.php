
<?php
class BaseModel
{

    protected $pdo;

    public function __construct($pdo)
    {

        $this->pdo = $pdo;
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (Exception $e) {

            die("database Error" . $e->getMessage());
        }
    }
    public function fetchall($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            die("database Error in fetchall" . $e->getMessage());
        }
    }
    public function fetchone($sql, $params = [])
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

            die("database Error in fetch one" . $e->getMessage());
        }
    }
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } catch (Exception $e) {

            die("database Error in execution" . $e->getMessage());
        }
    }
}
