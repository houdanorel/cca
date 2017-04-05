<?php

require_once('Globals.php');


function displayFile($fname,$rodeo_id,$loc,$date,$category)    
{
    
    $char = chr(9);
    $st="";
    $count=0;
    $st.= "<h1 class='maintitle'>".$loc ." (".$date.")</h1>";
    $st.="<table id=\"filterable".$rodeo_id."\" class=\"hover\" cellspacing=\"0\" width=\"100%\"   > ";  
  
    $f = fopen($fname, "r");
    while (($lines = fgets($f)) !== false) { 
        $lines = rtrim ($lines);
        $lines =  nl2br($lines); // replace line breaks with <br />    
        $lines = preg_replace('/\s\s+/', ' ', $lines); // replace multiple spaces with single spaces 
        if (COUNT(FILE($fname)) <= 1){
             $st.= "<thead><tr> <th ></th></tr></thead>";
             $st.= "<tbody><tr> ";
             $st.= "<td >NO DATA AVAILABLE</td>";
             $st.= "</tr></tbody>";
        }
        else
        {
            if( strlen (rtrim ($lines)) > 0)
            {

                $parts = explode('<br>', $lines); 
                
                foreach ($parts as $str) 
                {  
                    $count++; 
                    //$c = count(explode("|", $str));
                    if($count==1)
                    {
                        $st.="<h2 style=color:red>".$str." </h2>";
                    }
                    else if(substr_count($str, "Performance") == 1){
                        $st.= "<p>". $str ."</p>";
                    }
                    else if(substr_count($str, "EVENT") == 1)
                    {
                        $st.= "<thead>";
                        $st.= "<tr> ";
                        if($category == 'DRAW')
                        {
                        list($Event,$CCA ,$Member_name, $locale, $StkName_Desc) = array_pad(explode("|", $str, 5), 5, null);
                        $st.= "<th >".$Event."</th>";
                        //$st.= "<th >".$CCA."</th> ";
                        $st.= "<th >MEMBER NAME</th> ";
                        $st.= "<th >LOCALE</th> "; 
                        $st.= "<th >STOCK NAME/DESCRIPTION</th> ";
                        }
                        else
                        {
                        list($Event,$CCA ,$PL,$Member_name, $Stock ,$Mark_Time,$Money_WON,$GND_Money,$TTL_Money) = array_pad(explode("|", $str, 9), 9, null);
                        $st.= "<th >".$Event."</th>";
                        //$st.= "<th >".$CCA."</th> ";
                        $st.= "<th >PL</th>";
                        $st.= "<th >MEMBER NAME</th> ";
                        $st.= "<th >STOCK</th> "; 
                        $st.= "<th >MARK/TIME</th> ";
                        $st.= "<th >MONEY WON</th> ";
                        $st.= "<th >GND MONEY</th> ";
                        $st.= "<th >TTL MONEY</th> ";
                        }
                        $st.= "</tr>";
                        $st.= "</thead>"; 
                    }
                    else
                    {
                        $st.= "<tr>";
                        // Split string by | into an array 
                        if($category == 'DRAW')  {
                            list($Event, $CCA ,$Member_name,$locale , $StkName_Desc) = array_pad(explode("|", $str, 5), 5, null);
                            if($Member_name == NULL || $Member_name == " " ) { $st.= "<td></td><td></td><td></td><td></td>"; } 
                            else{
                                $st.= "<td >".$Event."</td>";
                               // $st.= "<td >".$CCA."</td> ";
                                if(substr_count($Member_name, "PERFORMANCE") == 1)   { $st.= "<td >".$Member_name."</td> "; } 
                                else {
                                    $n = $CCA;  
                                    $st.= "<td ><a class='simple-ajax-popup' href='dialog.php?id=$n'>".$Member_name."</a></td> "; 
                                }
                                $st.= "<td >".$locale."</td> ";
                                $st.= "<td >".$StkName_Desc."</td> ";
                            }
                        }
                        else
                        {
                            list($Event,$CCA ,$Pl,$Member_name, $Stock ,$Mark_Time,$Money_WON,$GND_Money,$TTL_Money) = array_pad(explode("|", $str, 9), 9, null); 
                           // if($Member_name == NULL || $Member_name == " " ) { $st.= "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; }  
                          //  else
                          //  {
                                $st.= "<td >".$Event."</td>";
                               // $st.= "<td >".$CCA."</td> ";
                                $st.= "<td >".$PL."</td>";
                                $st.= "<td ><a class='simple-ajax-popup' href='dialog.php?id=$CCA'>".$Member_name."</a></td> "; 
                                $st.= "<td >".$Stock."</td> ";
                                $st.= "<td >".$Mark_Time."</td> ";
                                $st.= "<td >".$Money_WON."</td> "; 
                                $st.= "<td >".$GND_Money."</td> "; 
                                $st.= "<td >".$TTL_Money."</td> "; 
                                
                           // }
                        }
                        
                        
                         
                        $st.="</tr>";
                    }             
                } 
                                
            }
        }   
    }  
    $st.="</tbody>";  
    $st.= "</table>";                            
    return $st;   
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
    <meta content="text/html; charset=utf-8" http-equiv="Content-type">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <title>Canadian Cowboys Standings</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.dataTables.css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" language="javascript" src="js/dataTables.responsive.js"></script> 
    <script type="text/javascript" src="js/jquery.smartmenus.js"></script> 
     <script type="text/javascript" src="js/ajax.js"></script>
     <script type="text/javascript" src="js/jquery.magnific-popup.js"></script> 
    <script type="text/javascript" >
        $(document).ready(function() {
            $('.hover').DataTable({"bSort": false,"bLengthChange": false,"paging": false,"bInfo": true, "retrieve": true, "responsive":true});
            $(window).scroll(function(){ 
                if ($(this).scrollTop() > 100) { 
                    $('#scroll').fadeIn(); 
                } else { 
                    $('#scroll').fadeOut(); 
                } 
                }); 
            $('#scroll').click(function(){ 
                    $("html, body").animate({ scrollTop: 0 }, 600); 
                    return false; 
                }); 
                
            $('.simple-ajax-popup').magnificPopup({
                type: 'ajax',
                overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump 
            });
        });
        
        
      
    </script>
    <!-- SmartMenus jQuery init -->
    <script type="text/javascript">
        $(function() {
            $('#main-menu').smartmenus({
                subMenusSubOffsetX: 1,
                subMenusSubOffsetY: -8
            });
        });
    </script> 
</head>
<body id="view">
<div id="whitewrap">
	<!-- Header -->
	<?php   include("templates/header.php"); ?>
	<!-- Navigation -->
    <?php   include("templates/navmenu.php"); ?> 
	<!-- Content -->
	<div id="main-wrapper" class="wrapper wrapper-fixed wrapper-fixed-grid responsive-grid" >
		<div class="grid-container clearfix">
			<section class="row row-1">
				<section class="column column-1 grid-left-0 grid-width-16">
					<div id="main-blk" class="block block-type-content block-fluid-height" data-alias="">
						<div class="block-content">
                        <div class="loop">
                            <article id="mcontent" class="mcontent">
                                <div class="maincontent" itemprop="text">
                            
                                 <div id = "result">
                                 <?php 
                                if(isset($_REQUEST['rodeo_id'])) {    
                                      $rodeo_id = $_REQUEST['rodeo_id'];
                                      $folder_path = $_REQUEST['folder_path'];
                                      $pref_f = $_REQUEST['pref_f'];
                                      $category =  $_REQUEST['category']; 
                                      $gr = $_REQUEST['gr'];
                                      $loc = $_REQUEST['rodeo_loc'];
                                      $dates =   $_REQUEST['dates'];
                                      $file = array();
                                      $f = fopen(Globals::$rodeo_groups, "r");
                                      while (($lines = fgets($f)) !== false) { 
                                            $lines = rtrim ($lines);
                                            $lines =  nl2br($lines);    
                                            $lines = preg_replace('/\s\s+/', ' ', $lines); 
                                            $parts = explode('<br>', $lines);   
                                            foreach ($parts as $str)  
                                            {
                                                $file[] =  explode("|", $str); 
                                            }
                                      }
                                      
                                      echo "<table class='titles'><tr><td>"; 
                                      foreach($file as $val)
                                      {
                                           if( $val[5] == $gr && $val[2] != $loc)
                                           {
                                               $id= $val[0];
                                               $d = $val[3].'-'.$val[4];
                                               $fname = $folder_path.$id.".txt"; 
                                               echo '<a href="#" onClick="Submit(\''.$id.'\',\''.$val[2].'\',\''.$d.'\',\''.$val[5].'\')">'.$val[2].' ('.$dates.',\''.$category.'\') </a> | ';
                                           }
                                          
                                      } 
                                      echo "</td></tr></table>";
                                     
                                      
                                     $fname = $folder_path.$pref_f."_".$rodeo_id.".txt";
                                     if (!file_exists($fname)) {
                                        echo "<h1 class='maintitle'>".$loc ." (".$dates.")</h1>"; 
                                        echo "<table id=\"filterable".$rodeo_id."\" class=\"hover\" cellspacing=\"0\" width=\"100%\"   > ";  
                                        echo "<thead><tr> <th ></th></tr></thead>";
                                        echo "<tbody><tr> ";
                                        echo "<td >NO DATA AVAILABLE</td>";
                                        echo "</tr></tbody></table>";
                                    }
                                    else
                                    {
                                     echo displayFile($fname,$rodeo_id,$loc,$dates,$category );
                                    }
                                }    
                                   
                                     
                                 ?>
                                 </div>
                                </div>
                            </article>
                        
                        
                        
                         </div> 
						</div>
					</div>
				</section>
			</section>
		</div>
	</div>

	<!-- Footer -->
	<?php include("templates/footer.php"); ?>
    <!-- BackToTop Button -->
    <a href="#" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
</div>

<script type="text/javascript">
function Submit(id,loc,dates,gr) { 
  
    //alert(id);
    var folder = "<?php echo $folder_path; ?>";
    $('body .maincontent').append('<form id="myform"></form>');
    $('#myform').attr('action','view.php');
    $('#myform').attr('method','post');
    $('#myform').append('<input type="hidden" name="rodeo_id" id="rodeo_id" value="'+id+'">');
    $('#myform').append('<input type="hidden" name="rodeo_loc" id="rodeo_loc" value="'+loc+'">');
    $('#myform').append('<input type="hidden" name="dates" id="dates" value="'+dates+'">');
    $('#myform').append('<input type="hidden" name="gr" id="gr" value="'+gr+'">');
    $('#myform').append('<input type="hidden" name="folder_path" id="folder_path" value="'+folder+'">'); 
    $('#myform').append('<input type="hidden" name="category" id="category" value="'+category+'">');
    $('#myform').submit();
    return false; 
};
</script>


</body>
</html>