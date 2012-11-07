<?php

// generates the head for all pages, including highlighting of the activr page in the nav bar
function getHead($activePage = "index.php"){  

$links = array("index.php" => "HXL Documentation", 
			   "queries.php" => "Querying HXL",
         "produce.php" => "Producing HXL",
			   "http://hxl.humanitarianresponse.info/ns/" => "HXL Vocabulary"); 


echo'<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Humanitarian eXchange Language Documentation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- disable cache -->
    <meta http-equiv="expires" content="0"> 
    <meta http-equiv="pragma" content="no-cache"> 

    <link href="css/hxl.css" rel="stylesheet">
  
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" href="img/favicon.ico">
  </head>

  <body data-spy="scroll" data-target=".navspy">
	<div class="container">
	<div class="navbar">
        <div class="container">
          <div class="nav-hxlator">
          <span class="brand" style="padding-top: 0"><img src="img/logo.png"></span>        
            <ul class="nav" id="topnav">
'; 

foreach($links as $link => $text){
	if($link === $activePage){
		echo'
			<li class="active"><a href="'.$link.'">'.$text.'</a></li>';
	}else{
		echo'
			<li><a href="'.$link.'">'.$text.'</a></li>';	
	}
}

echo'           
            </ul>
          </div>
      </div>
    </div>    

'; 

} 


// creates the footer for the page, including the JS to load
// $extraJS can point to any extra js plugins in the /js folder 
// that are required by the page that loads this header
// amd an option to include an inline $script
function getFoot(){ 
?>
	</div> <!-- /container -->
	<!-- <div class="container>
    <div class="row">
      <p align="center"><a href="http://hxl.humanitarianresponse.info/">Powered by HXL</a></p>
    </div>
  </div> -->
  <div class="container footer">
		<div class="row">
		  <div class="span3"><strong>Contact</strong><br />
		  This site is part of the HumanitarianResponse network. Write to 
		  <a href="mailto:info@humanitarianresponse.info">info@humanitarianresponse.info</a> for more information.</div>
		  <div class="span3"><strong>Links</strong><br />
		  <a href="https://sites.google.com/site/hxlproject/">HXL Project</a><br />
		  <a href="http://hxl.humanitarianresponse.info/">HXL Standard</a></div>
		  <div class="span3"><strong>Follow HXL</strong><br />
		  <span class="label label-warning">TBD</span></div>
		  <div class="span3"><strong>Legal</strong><br />
		  &copy; 2012 UNOCHA</div>
		</div>
	</div>
	  <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script> 
  </body>
</html>

<?php } ?>