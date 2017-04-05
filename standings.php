<?php

require_once('Globals.php');
//$maintitle = "STANDINGS"; 
//$folder_path = Globals::$standings_path;

if(isset($_REQUEST['y']) && $_REQUEST['y']=="2016" )
{
    $y = '2016';
    $maintitle = "2016 STANDINGS";
    $folder_path = Globals::$standings_path_2016;      
}
else
{
    $y = '2017';
    $maintitle = "STANDINGS";
    $folder_path = Globals::$standings_path; 
}
 
function displayFile() {    
    if(isset($_REQUEST['y']) && $_REQUEST['y'] == "2016"   ) 
    { 
        $y = $_REQUEST['y'];
        $folder_path  = Globals::$standings_path_2016;
        $xml_profiles = Globals::$profiles_2016;
        $pictures_path = Globals::$pictures_path_2016;
    } 
    else 
    { 
        $y ="2017";
        $folder_path  = Globals::$standings_path;
        $xml_profiles = Globals::$profiles;
        $pictures_path = Globals::$pictures_path;  
    }     
    if(isset($_REQUEST['filename'])) { $filename = $_REQUEST['filename']; } else { $filename =$folder_path."RM5012_1.txt"; }  
    if(isset($_REQUEST['standings'])) { $standings = $_REQUEST['standings']; } else { $standings = "PEAVEY MART WEST TOUR"; }       
    if(isset($_REQUEST['sid'])) { $sid = $_REQUEST['sid']; } else { $sid = 1; }  
    $count=0;
    $st="";   
    $f = fopen($filename, "r");
    $st.= "<table id=\"filterable".$sid."\" class=\"hover\" cellspacing=\"0\" width=\"100%\"> ";     
    while (($lines = fgets($f)) !== false) { 
        $lines = rtrim ($lines);
        $lines =  nl2br($lines); // replace line breaks with <br />    
        $lines = preg_replace('/\s\s+/', ' ', $lines); // replace multiple spaces with single spaces 
        if (COUNT(FILE($filename)) <= 1){
             $st.= "<thead><tr><th></th></tr></thead>";
             $st.= "<tbody><tr> ";
             $st.= "<td>NO DATA AVAILABLE</td>";
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
                  if($count==1)
                  {
                    $st.= "<h2 style=color:red>".$str." </h2>";
                  }
                  else if($count <= 4 ){
                    $st.=  "<p>". $str ."</p>";
                  }
                  else  if(substr_count($str, "EVENT") == 1)
                  {
                    $st.= "<thead>";
                    $st.= "<tr> ";
                    if ($standings ==  "ALL RODEOS") { list($Event,$POS, $CCA ,$NAME,$RODEO_COMPETED, $LOCALE, $POINTS) = array_pad(explode("|", $str, 7), 7, null);  }  
                    else {list($Event,$POS, $CCA ,$NAME, $LOCALE, $POINTS) = array_pad(explode("|", $str, 6), 6, null);  }
                    $st.= "<th>".$Event."</th>";
                    $st.= "<th>POSITION</th> ";
                    //$st.= "<th>".$CCA."</th> "; 
                    $st.= "<th>".$NAME."</th> " ;
                    // $st.= "<th>".$RODEO_COMPETED."</th> " ;
                    $st.= "<th>".$LOCALE."</th> "; 
                    $st.= "<th>".$POINTS."</th> ";
                    $st.= "</tr>";
                    $st.= "</thead>"; 
                  }
                  else
                  {
                     $st.= "<tr>";
                     if ( $standings ==  "ALL RODEOS") { list($Event,$POS, $CCA ,$NAME,$RODEO_COMPETED, $LOCALE, $POINTS) = array_pad(explode("|", $str, 7), 7, null);  }  
                     else {list($Event,$POS, $CCA ,$NAME, $LOCALE, $POINTS) = array_pad(explode("|", $str, 6), 6, null);  } 
                     $st.="<td>".$Event."</td>";
                     $st.= "<td>".$POS."</td>";
                     // $st.= "<td >".$CCA."</td> ";
                     $st.= "<td><a class='simple-ajax-popup' href='dialog.php?id=$CCA&profiles=$xml_profiles&pics=$pictures_path'>".$NAME."</a></td>";   
                     // $st.= "<th >".$RODEO_COMPETED."</th> " ;
                     $st.= "<td>".$LOCALE."</td>"; 
                     $st.= "<td>".$POINTS."</td>"; 
                     $st.= "</tr>";   
                  } 
               }
                
                
            }
        }
    } 
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
<div id="whitewrap" class="idx standings">
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

                                  <?php
                                 foreach (glob($folder_path.Globals::$ext) as $filename) { 
                                    $file_n =  basename($filename, ".txt").PHP_EOL; //  returns the filename from a path without extension
                                    $st = explode("_",$file_n);
                                    if ($st[1] == 1) { $standings = "PEAVEY MART WEST TOUR "; $sid=1;} 
                                    else if ($st[1] == 2) {$standings = "PEAVEY MART EAST TOUR"; $sid=2;} 
                                    else {$standings = "ALL RODEOS"; $sid=3;} 
                                    echo '<a  class="stlink"  id=\'link'.$sid.'\' href="#" onClick="postdata(\''.$filename.'\',\''.$standings.'\',\''.$sid.'\')" data-name="'.$filename.'" >'.$standings.'</a> | ';
                                }     
                                echo displayFile() ;  
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
    <!-- BackToTop Button -->
    <a href="#" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
</div>

<script type="text/javascript">
function postdata(filename,standings,sid) { 
  
    //alert(id);
    var folder = "<?php echo $folder_path; ?>";
    var y = "<?php echo $y; ?>";
    $('body .maincontent').append('<form id="myform"></form>');
    $('#myform').attr('action','standings.php');
    $('#myform').attr('method','post');
    $('#myform').append('<input type="hidden" name="filename" id="filename" value="'+filename+'">');
    $('#myform').append('<input type="hidden" name="folder_path" id="folder_path" value="'+folder+'">'); 
    $('#myform').append('<input type="hidden" name="y" id="y" value="'+y+'">');
    $('#myform').append('<input type="hidden" name="standings" id="standings" value="'+standings+'">');  
    $('#myform').append('<input type="hidden" name="sid" id="sid" value="'+sid+'">'); 
    $('.hover').DataTable({"bSort": false,"bLengthChange": false,"paging": false,"bInfo": true, "retrieve": true, "responsive":true});
    $('#myform').submit();
    return false; 
};
</script>


</body>
</html>