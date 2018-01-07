<?php

require_once("DB_class.php");

if(isset($_POST["Region"])){
    $to_search ="Region";
}else if(isset($_POST["Continent"])){
    $to_search = "Continent";
}else if(isset($_POST["Countries"])){
    $to_search ="Countries";
}else if(isset($_POST["LifeDuration"])){
    $to_search = "LifeDuration";
}else if(isset($_POST["Population"])){
    $to_search = "Population";
}else if(isset($_POST["Cities"])){
    $to_search ="Cities";
}else if(isset($_POST["Languages"])){
    $to_search = "Languages";
}else{
    $to_search = null;
}
$first= new DB_class();
$data = $first->get_start_data($to_search);
echo json_encode($data);
