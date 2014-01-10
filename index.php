<?php 
error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

include_once('functions.php');
getHead("index.php"); 


?>

	<div class="container start">	    
    	<div class="row">
	     	<div class="span4" style="text-align: center">
	    		<img src="img/book.png" />
	      	</div> 
	      	<div class="span8">
	      		<h1 class="headline">HXL Documentation</h1>
		        <p class="punchline">The official guide to the Humanitarian eXchange Language.<br />Learn how to <a href="queries.php">get data out of HXL</a> and how to <a href="produce.php">produce, publish, and manage HXL data</a> yourself.</p>	     
	      	</div>
	  	</div>
	        
        <div class="row">
	      <div class="span4">
	        <h2><a href="queries.php">Querying HXL.</a></h2>
	        <p>HXL is built around the idea of <a href="http://linkeddata.org/">Linked Data</a>, using Semantic Web standards to annotate and publish humanitarian data, and make them queriable. If you don't know anything about RDF, SPARQL and the likes, we'll show you what you need to know to <a href="queries.php">query</a> HXL and work with the data.</p>
	      </div>
	      <div class="span4">
	        <h2><a href="produce.php">Producing HXL.</a></h2>
	        <p>If you have humanitarian data that you would like to annotate with the HXL vocabulary and publish as Linked Data, this <a href="produce.php">tutorial</a> shows you how to do that. A little more advanced than the querying tutorial, so if you have not read that one yet, please do so first.</p>
	      </div>
	      <div class="span4">
	        <h2><a href="http://hxl.humanitarianresponse.info/ns/">The Vocabulary.</a></h2>
	        <p>The <a href="http://hxl.humanitarianresponse.info/ns/">technical documentation</a> for the Humanitarian eXchange Language situation and response standard, covering the definitions of all classes and properties in plain English and as a machine-readable RDF vocabulary.</p>
	      </div>
	    </div>

    </div>	   
    


<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>