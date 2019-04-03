<?php

class Db
{
    private $props = [];
    private static $instance;
    
    private function __contruct() {}
    
    public static function getInstance()
    {
        if ( empty(self::$instance) ){
            echo "New Instance\n";
            self::$instance = new Db();
        }
        echo "Current Instance\n";
        return self::$instance;
    }
    
    public function setProperties($key, $val)
    {
        $this->props[$key] =$val;
    }
    
    public function getProperties($key)
    {
        echo "Properties:\n";
        return $this->props[$key];
    }
    
    public function getAllProperties()
    {
        echo "All properties:\n";
        return $this->props;
    }
    
    public function connect()
    {
        return "Connect to DB...";
    }
    
}

$db = Db::getInstance();
$db->setProperties('dbName', 'MySql');
$db->setProperties('ip', '192.168.20.10');
// print_r($db->getProperties('ip').PHP_EOL);
// print_r($db->getAllProperties());
print_r($db);
echo "Delete link:\n";
unset($db);
echo "Check:\n";
$db2 = Db::getInstance();
print_r($db2->getProperties('ip').PHP_EOL);
print_r($db2);
$db2->setProperties('ip', '192.168.20.0');
print_r($db2);
