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

  <body data-spy="scroll" data-target=".navspy" onload="prettyPrint()">
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

    <!-- notice about new HXL work -->
    <div class="container alert alert-danger">
    <b>Notice</b>: The material on this web site represents proof-of-concept work undertaken during 2012 and 2013, and is preserved here online for historical reference. Through generous support from the Humanitarian Innovation Fund, OCHA is now engaging with a focused group of partners to gain consensus on technical standards for the exchange of humanitarian operational data, which may differ substantially from those described here. Please follow the HXL <a href="http://hxl.humanitarianresponse.info/blog/">blog</a> and <a href="https://groups.google.com/forum/?fromgroups#!forum/hxlproject">mailing list</a> for updates.
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
		  <div class="span3"><strong>Updates</strong><br />
		  This part of the docs has been last updated on <strong><?php // echo date("M d, Y", filemtime(pathinfo($_SERVER['REQUEST_URI'])['basename']));  ?> Jan 10, 2014</strong> by <a href="http://carsten.io">Carsten Keßler</a>.
      </div>
      <div class="span3"><strong>Elsewhere</strong><br />
      The entire code for HXL and the tools we are building around the standard is available on <a href="https://github.com/hxl-team">GitHub</a>.</div>      
		  <div class="span3"><strong>Legal</strong><br />
		  &copy; 2012 UNOCHA</div>
		</div>
	</div>
	  <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/prettify.js"></script>
  </body>
</html>

<?php } ?>