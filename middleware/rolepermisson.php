<?php
require_once 'models/BaseModel.php';

class RolesPermission extends BaseModel
{
    protected $requiredRole;
    protected $requiredPermission;

    public function __construct($requiredRole = null, $requiredPermission = [])
    {
        $this->requiredRole = $requiredRole;
        $this->requiredPermission = $requiredPermission;
    }

    public function handle()
    {
        $RolesPermission = [
            '/admin' => [
                'manage_users' => true,
                'manage_stock' => true,
                'manage_stock_items' => true,
                'manage_sales' => true,
                'manage_roles' => true
            ],

            '/super_admin' => [

                'manage_users' => true,
                'manage_stock' => true,
                'manage_stock_items' => true,
                'manage_sales' => true,
                'manage_roles' => true

            ],

            'users' => [

                'manage_users' => false,
                'manage_stock' => true,
                'manage_stock_items' => true,
                'manage_sales' => true,
                'manage_roles' => false

            ]

        ];

        if (!array_key_exists($this->requiredRole, $RolesPermission)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'Error',
                'message' => "Access denied:Role '{$this->requiredRole}' is not found",
            ]);
        }


        $RolesPermission = $RolesPermission[$this->requiredRole];
        foreach ($this->requiredPermission as $permission) {
            if (!isset($RolesPermission[$permission]) || !$RolesPermission[$permission]) {
                http_response_code(403);
                echo json_encode([
                    'status' => 'Error',
                    'message' => "Access denied:Role '{$this->requiredRole}' lacks the given permission '{$permission}' ",
                ]);
                return false;
            }
        }

        echo json_encode([
            'status' => "success",
            'message' => "Access granted"
        ]);
        return true;
    }

    public function check_role($user_id, $requiredPermission)
    {

        $sql  = "SELECT COUNT(*) FROM users INNER JOIN roles ON users.role_id = roles.role_id
        INNER JOIN role_permissions ON  roles.role_id = role_permissions.role_id
        INNER JOIN permissions ON role_permissions.permission_id = permissions.permission_id
        WHERE users.user_id = :user_id AND permissions.name = :name";
        return $this->execute($sql, [
            'user_id' => $user_id,
            'name' => $requiredPermission

        ]);
    }
}
