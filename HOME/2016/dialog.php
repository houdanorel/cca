<?php 
require_once('Globals.php'); 
$xml_file = Globals::$profiles;
if (file_exists($xml_file)) 
{
    $xml = simplexml_load_file($xml_file);
   // print_r($xml);
} 
else 
{
    exit('Failed to open the xml file.');
} 
if(isset($_REQUEST['id']) ) 
{ 
    $id = $_REQUEST['id'];
}

?>
<div id="custom-content" class="white-popup-block" style="max-width:800px; margin: 20px auto;">
    
    <div class="row1">
        <div class="col-sm-6 col-md-4">
            <?php 
            
              $pictures_path = Globals::$pictures_path;
              $images = glob($pictures_path."*.jpg");
              
              $img = $pictures_path.$id.".jpg";
              if(in_array($img, $images))
              {
                 echo '<img class="img-rounded img-responsive" alt="" src="'.$img.'" > '; 
              }
              else
              {
                echo '<img class="img-rounded img-responsive" alt="" src="http://placehold.it/380x500"> ';
              } 
            ?>
        
            
        </div>
        <div class="col-sm-6 col-md-8">  
<?php


$c_members = count($xml->MEMBER);


for($i = 0; $i < $c_members ; $i++) {
    
    if(trim($xml->MEMBER[$i]->MEMBER_ID) == trim($id) ) 
    {

        echo "<h4>". $xml->MEMBER[$i]->MEMBER_NAME ."</h4>"; 
        echo "<small><cite>" .$xml->MEMBER[$i]->HOME_TOWN . "<i class='fa fa-map-marker'></i></cite></small>";
        //events
        echo "<h2 class='events'> EVENTS </h2>";
        $count_events = count($xml->MEMBER[$i]->EVENTS->EVENT);
        echo "<table id='popup_table' class='hover' cellspacing='0' width='100%'   >";
        echo "<thead>";
        echo "<tr>";
        echo "<th> EVENT NAME</th>";  
        echo "<th> STANDINGS </th>";
        echo "<th> RODEO COUNT</th>";
        echo "</tr></thead>"; 
        for($k = 0; $k <  $count_events ; $k++) {
            echo "<tr>";      
            echo "<td class='title'>".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->EVENT_NAME."</td>";  
            echo "<td class='title'>".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->CCA_STANDING."</td>"; 
            echo "<td class='title'>".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->RODEO_COUNT."</td>";
            echo "</tr>";
        }    
        echo "</table>";
        //results
        for($k = 0; $k <  $count_events ; $k++) {
            
             $count_rodeos = count($xml->MEMBER[$i]->EVENTS->EVENT[$k]->EVENT_RODEO_NAME);   
             if ($count_rodeos > 0)
             { 
                 echo "<table id='popup_table2' class='hover' cellspacing='0' width='100%'  >"; 
                 echo "<thead><tr><th colspan='2'><h2 class='results'> RESULTS: ".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->EVENT_NAME."</h2></th><th></th></tr></thead>";  
                 echo "<tr class='event_name'><td>LOCATION</td><td>AMOUNT</td></tr>";
                    for($j = 0; $j <  $count_rodeos ; $j++) { 
                       echo "<tr>";  
                       echo "<td>".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->EVENT_RODEO_NAME[$j] ."</td>"; 
                       echo "<td>".$xml->MEMBER[$i]->EVENTS->EVENT[$k]->EVENT_RODEO_AMT[$j]."</td>";
                       echo "</tr>";  
                    } 
             }
        } 
        echo "</table>";  
        
   }
  
    
} 


?>
         </div> 
     </div>   
</div>

