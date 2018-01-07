<?php

class DB_class
{
    private $db;
    private $settings;
    private $Connected = false; //this is status

    public function __construct($post_value = null)
    {
        $this->Connect();
    }

    private function Connect()
    {
        $this->settings = parse_ini_file("../config/db.ini.php");
        $dsn = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
        try {
             $this->db = new PDO($dsn, $this->settings["user"], $this->settings["password"],  array(
                PDO::ATTR_EMULATE_PREPARES => false)
             );
            if ($this->db) {
                $this->Connected = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function select($sql, $method = null)
    {
        if($this->Connected == false){
            $this->Connect();
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        switch ($method){
            case 'rowCount' :
                $result = $query->rowCount();
                break;
            case 'float':
                $val = $query->fetchAll(PDO::FETCH_NUM);
                $result =  round($val[0][0] , 2, PHP_ROUND_HALF_UP);
                break;
            default:
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                break;

        }

        if($result == 0) $result = null;

        return  $result;
    }

    public function getCountries($item){
       $q ="SELECT * FROM `Country` WHERE Region = '".$item['Region']."' and Continent = '". $item['Continent']."';";
       $result =   $this->select($q , 'rowCount');
       return $result;
    }


    public function getLifeDuration($item ){
        $q = "SELECT AVG(LifeExpectancy) FROM `Country` WHERE Region = '".$item['Region']."' and Continent = '". $item['Continent']."';";
        $result =   $this->select($q , 'float');
        return $result;
    }

    public function getPopulation($item){
        $q = "SELECT SUM(Population) FROM `Country` WHERE Region = '".$item['Region']."' and Continent = '". $item['Continent']."';";
        $result =   $this->select($q , 'float');
        return $result;
    }


    public function getCities($item){
        $q = "select * from City INNER JOIN (SELECT Code FROM `Country` WHERE Region = '".$item['Region']."' and Continent = '". $item['Continent']."')t1 on t1.Code = City.CountryCode ;";
        $result =   $this->select($q , 'rowCount');
        return $result;
    }

    public function getLanguages($item){
       $q = "select * from CountryLanguage INNER JOIN (SELECT Code FROM `Country` WHERE Region = '".$item['Region']."' and Continent = '". $item['Continent']."')t1 on t1.Code = CountryLanguage.CountryCode ;";
       $result =   $this->select($q , 'rowCount');
       return $result;
    }



     public function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }

    
    public function get_start_data($to_search= null)
    {
        $q ='SELECT DISTINCT Region, Continent FROM `Country` Order by Continent;';
        $rows = $this->select($q);
        $data = array();
        $i=0;
        foreach ($rows as $item){
            $data[$i]['Continent'] = $item['Continent'];
            $data[$i]['Region'] = $item['Region'];
            $data[$i]['Countries'] =  $this->getCountries($item);
            $data[$i]['LifeDuration'] = $this->getLifeDuration($item);
            $data[$i]['Population'] = $this->getPopulation($item);
            $data[$i]['Cities'] = $this->getCities($item);
            $data[$i++]['Languages'] = $this->getLanguages($item);
        }

        if($to_search != null) usort($data, $this->build_sorter($to_search));
        
        return $data;
    }



};



?>