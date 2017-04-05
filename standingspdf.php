<?php

require_once('Globals.php');
$maintitle = "STANDINGS"; 
$folder_path = Globals::$standings_path;


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
                                <?php
                                  echo "<header><h1 class='maintitle'>".$maintitle ."</h1></header>"; 
                                ?>
                                <div class="maincontent" itemprop="text">
                                 <iframe src="http://docs.google.com/gview?url=http://canadiancowboys.ca/cca/HOME/2016/STANDINGS/STANDINGS.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>                                                    
                            
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



</body>
</html>