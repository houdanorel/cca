<?php
require_once('Globals.php');

if(isset($_REQUEST['m']) && $_REQUEST['m']=="results" ) 
{ 
    if(isset($_REQUEST['y']) && $_REQUEST['y']=="2016" )
    {
       $maintitle = "2016 RESULTS"; 
       $folder_path = Globals::$results_path_2016; 
       $pref_f = Globals::$init_results;   
       $rodeo_gr = Globals::$rodeo_groups_2016;
       $xml_profiles = Globals::$profiles_2016;
       $pictures_path = Globals::$pictures_path_2016;   
    }
    else
    {
        $maintitle = "RESULTS"; 
        $folder_path = Globals::$results_path; 
        $pref_f = Globals::$init_results; 
        $rodeo_gr = Globals::$rodeo_groups; 
        $xml_profiles = Globals::$profiles;
        $pictures_path = Globals::$pictures_path;
    } 
}
else if(isset($_REQUEST['m']) && $_REQUEST['m']=="draw" )  
{
    $maintitle = "DRAW"; 
    $folder_path = Globals::$draw_path;
    $pref_f = Globals::$init_draw;
    $rodeo_gr = Globals::$rodeo_groups;
    $xml_profiles = Globals::$profiles;
    $pictures_path = Globals::$pictures_path;
}
else 
{
    if(isset($_REQUEST['y']) && $_REQUEST['y']=="2016" )
    {
       $maintitle = "2016 STANDINGS"; 
       $folder_path = Globals::$standings_path_2016;
       $pref_f = Globals::$init_standings;
       $xml_profiles = Globals::$profiles_2016;
       $pictures_path = Globals::$pictures_path_2016;   
    }
    else
    {
        $maintitle = "STANDINGS"; 
        $folder_path = Globals::$standings_path;
        $pref_f = Globals::$init_standings;
        $xml_profiles = Globals::$profiles;
        $pictures_path = Globals::$pictures_path;
    }
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
    <script type="text/javascript" language="javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" language="javascript" src="js/dataTables.responsive.js"></script>  
    <script type="text/javascript" src="js/jquery.smartmenus.js"></script> 
    <script type="text/javascript" >
        $(document).ready(function() {
                $('#filterable').DataTable({"bSort": false,"bLengthChange": false,"paging": false,"bInfo": true, "retrieve": true, "responsive":true});
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
<body >
<div id="whitewrap" class="idx">
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
                                <header>
                                <h1 class="maintitle"><?php echo $maintitle; ?></h1>
                                </header>
                                <div class="maincontent" itemprop="text">
                                <?php
                                echo '<table id=\'filterable\' class=\'hover\' cellspacing=\'0\' width=\'100%\'  > ';
                                echo '<thead><tr>';
                                echo '<th >Rodeo Location</th>';
                                echo '<th >Dates</th>'; 
                                echo '</tr></thead>';
                                echo '<tbody> ';
                                
                                // Read file into an array
                                $file = array();
                                $f = fopen($rodeo_gr, "r");
                                while (($lines = fgets($f)) !== false) { 
                                    $lines = rtrim ($lines);
                                    $lines =  nl2br($lines); // replace line breaks with <br />    
                                    $lines = preg_replace('/\s\s+/', ' ', $lines); // replace multiple spaces with single spaces 
                                    $parts = explode('<br>', $lines);   
                                    foreach ($parts as $str)  
                                    {
                                        $file[] =  explode("|", $str); 
                                    }
                                }

                                foreach($file as $val)
                                {
                                    $concat = $val['3'].' - '.$val['4']; 
                                    echo '<tr><td><a id="link" href="#" onClick="postdata(\''.$val['0'] .'\',\''.$val['2'] .'\',\''.$concat.'\',\''.$val['5'] .'\');"  >'.$val['2'].'</a></td>';
                                    echo '<td>'.$concat .'</td>';  
                                    echo '</tr>';    
                                       
                                } 
                               
                                echo '</tbody></table>';    
                                ?>
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
</div>

<script type="text/javascript">
function postdata(id,loc,dates,gr) { 
  
    //alert(id);
    var folder = "<?php echo $folder_path; ?>";
    var pref_f = "<?php echo $pref_f; ?>";
    var category =  "<?php echo $maintitle; ?>"; 
    var rodeo_gr =  "<?php echo $rodeo_gr; ?>";
    var xml_profiles =  "<?php echo $xml_profiles; ?>";  
    var pictures_path =  "<?php echo $pictures_path; ?>";  
    
    $('body .maincontent').append('<form id="myform"></form>');
    if(category == 'DRAW') { $('#myform').attr('action','view_draw.php'); }
    else { $('#myform').attr('action','view_results.php'); }    
    $('#myform').attr('method','post');
    $('#myform').append('<input type="hidden" name="rodeo_id" id="rodeo_id" value="'+id+'">');
    $('#myform').append('<input type="hidden" name="rodeo_loc" id="rodeo_loc" value="'+loc+'">');
    $('#myform').append('<input type="hidden" name="dates" id="dates" value="'+dates+'">');
    $('#myform').append('<input type="hidden" name="gr" id="gr" value="'+gr+'">');
    $('#myform').append('<input type="hidden" name="folder_path" id="folder_path" value="'+folder+'">'); 
    $('#myform').append('<input type="hidden" name="pref_f" id="pref_f" value="'+pref_f+'">');
    $('#myform').append('<input type="hidden" name="category" id="category" value="'+category+'">'); 
    $('#myform').append('<input type="hidden" name="rodeo_gr" id="rodeo_gr" value="'+rodeo_gr+'">'); 
    $('#myform').append('<input type="hidden" name="xml_profiles" id="xml_profiles" value="'+xml_profiles+'">');
    $('#myform').append('<input type="hidden" name="pictures_path" id="pictures_path" value="'+pictures_path+'">'); 
     
    $('#myform').submit();
    return false; 
};
</script>
</body>
</html>
