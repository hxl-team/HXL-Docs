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
				          <li><a href="#extend">Extending HXL? <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#patterns">URI Patterns <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#conversion">Conversion to HXL <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#fromscratch">Producing HXL from Scratch <i class="icon-chevron-right pull-right"></i></a></li>				          
				          <li><a href="#storage">Storage <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#tldr">TL;DR <i class="icon-chevron-right pull-right"></i></a></li>     
			        </ul>		
			    </div>	
	      	</div>
	      	<div class="span8">
	      		<h1>Producing HXL</h1>
		        <p class="punchline">This tutorial explains how to convert existing data, such as from relational databases or XML documents, into HXL, and how to produce HXL data from scratch.</p>	     

		        <h2 id="tools">Toolchain</h2>

		        <p>Let's start with a short (and by no means complete) overview of the libraries that are handy when producing or validating <a href="http://www.w3.org/TR/rdf-concepts/">RDF</a>. We use most of them on a regular basis when we work on HXL:</p>

		        <ul>
		        	<li><a href="http://librdf.org/raptor/">Raptor</a> is an RDF syntax library for syntax checking and conversion between different RDF serializations.</li>
		        	<li><a href="http://jena.apache.org">Jena</a> is a Java framework for building Semantic Web applications.</li>
		        	<li><a href="http://www.aelius.com/njh/easyrdf/">EasyRDF</a> is a PHP library designed to make it easy to consume and produce RDF.</li>
		        	<li><a href="http://rdfpad.lodum.de">RDFpad</a> is a online tool that reads RDF from public <a href="http://etherpad.org">EtherPad</a> instances; perfect for collborative sketching and validation of RDF.</li>
		        	<li><a href="http://curl.haxx.se">cURL</a> is a command line tool for transferring data with URL syntax, and hence perfect for <a href="http://richard.cyganiak.de/blog/2007/02/debugging-semantic-web-sites-with-curl/">debugging Linked Data setups</a>.</li> 
		        </ul> 
		        	
		        <h2 id="extend">Extending HXL?</h2>

		        <p>The scope of the <a href="http://hxl.humanitarianresponse.info/ns/">HXL vocabulary</a> is still limited and does not cover every need for classes or properties that are relevant in the humanitarian domain. While we aim at extending HXL in the long run, it will be impossible to cover every possible need. After all, this is why we chose RDF for our data model: because it allows to mix and extend the vocabularies used for annotation.</p>

		        <p>In short, if HXL does not cover your need, feel free to extend it and mix it with other vocabularies. It would make sense to <a href="mailto:hendrix@un.org">get in touch with us</a>, though, since we are constantly updating the vocabulary and might hence be working on what you are looking for.</p>

		        <h2 id="patterns">URI Patterns</h2>

		        <p>As URIs are the ties that hold the Web of Data together, the patterns to generate them are crucial to make sure that the same URIs are generated each time for the same thing. Even more important, we have to make sure that <em>different</em> URIs are generated when we are talking about <em>different</em> things, in order not to conflate them into the same URI.</p>

		        <p>To ensure consistent URIs across HXL, we collect our patterns in a <a href="https://docs.google.com/document/d/1-9OoF5vz71qPtPRo3WoaMH4S5J1O41ITszT3arQ5VLs/edit">Google Doc</a>. It is a good idea to follow these patterns when you create your own HXL. The choice of the base URL depends on where you plan to store the generated data; see the <a href="#storage">storage section</a> for the corresponding discussion.</p>

		        <p><a href="http://www.ldodds.com">Leight Dodds</a> and <a href="http://iandavis.com">Ian Davis</a> have put together the excellent <a href="http://patterns.dataincubator.org/book/">Linked Data Patterns</a> book that explains the different kinds of patterns in use very well. You can read the book <a href="http://patterns.dataincubator.org/book/">online</a> for free.</p>

		        <h2 id="conversion">Conversion of Existing Data to HXL</h2>

		        <p>In most cases, the data to be published as HXL already exists in some form, be it a relational database, a collection of XML documents, or some kind of spreadsheet. Depending on the original format and the update frequency, different options can be considered for the translation process. For datasets the are only updated infrequently, a conversion process that requires manual intervention may be acceptable; for datasets that are updated frequently, the goal should be an automatic conversion process.</p>

		        <p>As HXL is based on RDF, we already have a number of tools at hand that support this <em>Extract-Transform-Load</em> (ETL) task. The following table list some options that might be worth a look, depending on your input data:</p>

		        <table class="table table-bordered">
			        <thead>
			          <tr><th>Format</th><th>Tools</th></tr>
			        </thead>
			          <tr>
			            <th>SQL</th>
			        	<td>
			        		<p><strong><a href="http://d2rq.org">D2RQ</a></strong> is a system that does not really translate the data in a relational database, but provides them as a <em>virtual graph</em>. Any queries agains that graph are translated to SQL queries against the original database. This should be the technology of choice in most cases where the source data are in a frequently updated relational database.</p>
			        	</td>
			        </tr>
			        <tr>
			            <th>CSV/XLS</th>
			        	<td>
			        		<p><strong><a href="http://openrefine.org">OpenRefine</a></strong> (formerly <a href="http://code.google.com/p/google-refine/">Google Refine</a>) is a tool for data reconciliation. This should be your choice if your data is messy and contains e.g. lots of spelling variations of the same name.</p>
			        		<p><strong><a href="http://hxl.humanitarianresponse.info/hxlator/">HXLator</a></strong> is our own <a href="https://github.com/hxl-team/HXLator">open-source</a> spreadsheet to HXL converter. It walks you through the process of creating a translator from a given spreadsheet layout to HXL. The translator can be stored and reused when the spreadsheet has been updated with new data, or when a new spreadsheet with the same layout is submitted.</p>
			        	</td>
			        </tr>
			        <tr>
			        	<th>XML</th>
			        	<td>
			        		<p><strong><a href="http://en.wikipedia.org/wiki/Xslt">XSLT</a></strong> (Extensible Stylesheet Language Transformations) can specify translation from one XML format into another. Since RDF can also be encoded as XML, this approach also works for the transformation from XML to RDF. However, depending on the structure of the input format, complex transformations may be required.</p>
			        	</td>
			        </tr>
				</table>

				<p>Moreover, generic ETL tools such as <a href="http://talend.com">Talend Open Studio</a> can also be used for this task, but require a substantial amount of training. Depending on your skillset, it may also be easier to hand-code the ETL process in a programming language of your choice.</p>

		        <h2 id="fromscratch">Producing HXL from Scratch</h2>

		        <p>In the vast majority of use cases, HXL will be produced from existing data sources, as discussed above. However, if you plan to produce HXL from scratch &ndash; e.g., through a web-based forms to be filled in by employees at your organization &ndash; you will need to get a solid understanding of RDF and Semantic Web technologies. Reading through the references provided on this page and playing around with the APIs provided by libraries such as <a href="http://jena.apache.org">Jena</a> or <a href="http://www.aelius.com/njh/easyrdf/">EasyRDF</a> should get you started. Needless to say that a decent programming background does not hurt.

		        <h2 id="storage">Storage</h2>

		        <p>When you have produced your HXL triples, loading them into a triple store makes them queryable in an efficient way. You can either <a href="mailto:hendrix@un.org">get in touch with us</a> to discuss whether it makes sense to load the data into the HXL triple store operated by <a href="http://www.unocha.org">UN OCHA</a>, or you can set up your own triple store. If you decide to set up your own store, there are several options to choose from, both commercial and open source. Lars Marius Garshol has put together <a href="http://www.garshol.priv.no/blog/231.html"></a>a nice comparison of the most well-known triple stores on his blog that can serve as a starting point for your decision. We currently use <a href="http://jena.apache.org/documentation/serving_data/">Fuseki</a> with a TDB backend for the HXL triple store.</p>

		        <p>Where the data is stored also defines the base URI for your <a href="#patterns">patterns</a>, as the URIs should ideally be dereferenceable. If the data is stored on the official HXL store, the URIs should start by <code>http://hxl.humanitarianresponse.info/data</code>. If you set up your own store, the URIs should point to a domain that you control. At the corresponding server, you should set up a system such as <a href="http://wifo5-03.informatik.uni-mannheim.de/pubby/">Pubby</a> that generates web pages from the data and takes care of the <a href="http://linkeddatabook.com/editions/1.0/#htoc11">content negotiation</a>.</p>

		        <h2 id="tldr">TL;DR</h2>

		        <p>Different kinds of structured input formats can be translated into HXL, often by using existing tools. Depending on the contents of the source data, extensions to the HXL vocabulary may be required. In any case, the existing HXL URI patterns should be implemented. The produced RDF can either be stored on the official HXL store, or on your own triple store.</p>
	      	</div>
	  	</div>
	</div>



<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>