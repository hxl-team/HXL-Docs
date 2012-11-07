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
	      	</div>
	      	<div class="span8">
	      		<h1>Producing HXL</h1>
		        <p class="punchline">yadda...</p>	     
	      	</div>
	  	</div>
	</div>



<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>