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
			        </ul>		
			    </div>	
	      	</div>
	      	<div class="span8">
	      		<h1>Producing HXL</h1>
		        <p class="punchline">yadda...</p>	     

		        <h2 id="tools">Toolchain</h2>

		        	<p>Raptor, </p>

	      	</div>
	  	</div>
	</div>



<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>