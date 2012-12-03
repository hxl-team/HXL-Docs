<?php 
error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

include_once('functions.php');
getHead("produce.php", $user_name, $user_organisation); 


?>

    <div class="container start">	    
    	<div class="row">
	     	<div class="span4" style="text-align: center">
	    		<img src="img/upload.png" />
	    		<div class="navspy">
	  				<ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
				          <li><a href="#tools">Toolchain <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#patterns">URI Patterns <i class="icon-chevron-right pull-right"></i></a></li>		          
			        </ul>		
			    </div>	
	      	</div>
	      	<div class="span8">
	      		<h1>Producing HXL</h1>
		        <p class="punchline">This tutorial explains how to produce HXL data from scratch or by conversion from existing data sources, such as relational databases or XML documents.</p>	     

		        <h2 id="tools">Toolchain</h2>

		        Since we will be producing <a href="http://www.w3.org/TR/rdf-concepts/">RDF</a> in this tutorial, some tools for 

		        	<p>Raptor, RDFpad, <a href="http://richard.cyganiak.de/blog/2007/02/debugging-semantic-web-sites-with-curl/">cURL</a>, ...</p>

		        <h2 id="patterns">URI Patterns</h2>
		        <p><a href="http://www.ldodds.com">Leight Dodds</a> and <a href="http://iandavis.com">Ian Davis</a> have put together the excellent <a href="http://patterns.dataincubator.org/book/">Linked Data Patterns</a> book that explains the different kinds of patterns in use very well. You can read the book <a href="http://patterns.dataincubator.org/book/">online</a> for free.</p>

	      	</div>
	  	</div>
	</div>



<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>