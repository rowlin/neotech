<?php include "../template/header.php"; ?>


<section>
<table>
 <thead>
<tr>
 <th><a href="#" data-attr="Continent">Continent</a></th>
 <th><a href="#" data-attr="Region" >Region</a></th>
 <th><a href="#" data-attr="Countries">Countries</a></th>
 <th><a href="#" data-attr="LifeDuration">LifeDuration</a></th>
 <th><a href="#" data-attr="Population">Population</a></th>
 <th><a href="#" data-attr="Cities">Cities</a></th>
 <th><a href="#" data-attr="Languages">Languages</a></th>
 </tr>
 </thead>
 <tbody>
 <?php

 require_once("DB_class.php");


 $first= new DB_class();

    $data = $first->get_start_data();
    foreach ($data as $item) {

        echo "<tr><th data-attr='Continent'>" . $item['Continent'] .
            "</th><th data-attr='Region'> " . $item['Region'] .
            "</th><th data-attr='Countries' class='center'>"  . $item['Countries'] .
            "</th><th data-attr='LifeDuration' class='center'>" . $item['LifeDuration'] .
            "</th><th data-attr='Population'>" . $item['Population'] .
            "</th><th data-attr='Cities' class='center'>" . $item['Cities'] .
            "</th><th data-attr='Languages' class='center'>" . $item['Languages'] .
            "</th></tr>";
    }
 
 

 ?>
 </tbody>
</table>


</section>




<?php include "../template/footer.php"; ?>

 
 
 