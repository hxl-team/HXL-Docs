<?php 
error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/London');

include_once('functions.php');
getHead("queries.php"); 


?>

    <div class="container start">	    
    	<div class="row-fluid">
	     	<div class="span4" style="text-align: center">
	    		<img src="img/download.png" />
	    		<div class="navspy">
	  				<ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
				          <li><a href="#ld">Linked Data 101 <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#sparql">SPARQL 101 <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#examples">HXL by Example <i class="icon-chevron-right pull-right"></i></a></li>
				          <li><a href="#geo">Geodata in HXL <i class="icon-chevron-right pull-right"></i></a></li>
			        </ul>		
			    </div>	    
  			</div>
  			<div class="span8">
  				<h1>Querying HXL</h1>
		        <p class="punchline">This tutorial explains how to access HXL data, including crash courses on Linked Data and the SPARQL query language.</p>	     	    


<!--   LINKED DATA 101 SECTION  -->



  			<h2 id="ld">Linked Data 101</h2>

				<p>A <em>very</em> brief introduction to the ideas behind Linked Data, explaining why we followed this approach instead of developing an XML schema or a proprietary API, for example. For more detailed introductions to the topic, take a look at the <a href="#ld-further">reading list</a>. If you are already familiar with the idea of Linked Data, move along, nothing to see here.</p>
  				
				<h3>The four rules</h3>

					<p><a href="http://en.wikipedia.org/wiki/Tim_Berners-Lee">Tim Berners-Lee</a> is not only quoted for developing the basics of the Web as we know it today, he also constantly thinks about the next steps &ndash; one of them being Linked Data. In 2006, he published these four rules, also known as the <em>Linked Data principles</em>, <a href="http://www.w3.org/DesignIssues/LinkedData.html">on his blog</a>:</p>
					
					<ol>
						<li>Use URIs as names for things.</li>
						<li>Use HTTP URIs so that people can look up those names.</li>
						<li>When someone looks up a URI, provide useful information, using the standards (RDF*, SPARQL).</li>
						<li>Include links to other URIs. so that they can discover more things.</li>
					</ol>
					
					<p>In a nutshell, these rules transfer the idea of interlinked, human-readable documents (aka. the Web as we know it), to raw data: Instead of jumping from one web page to the next by clicking links on that page, we have datasets that refer to each other and thus create a <em>Web of Data</em>. Let's take a look at how that works:</p>

				<h3>Statements about resources</h3>

					<p>Linked Data builds on the <a href="http://www.w3.org/RDF/">Resource Description Framework</a> (RDF), a W3C standard for the, err, description of resources. These descriptions come as statements, very much like simple sentences in English, consisting of <em>subject</em>, <em>predicate</em> (or <em>property</em>), and <em>object</em>. Since it's three parts, these statements are often referred to as <em>triples</em>. Let's take a simple example, such as the statement <code>Batman knows Robin</code>. RDF allows us to make this statement machine-readable by replacing all three parts with URLs:</p>

					<pre class="prettyprint linenums">&lt;<a href="http://dbpedia.org/resource/Batman" target="_blank">http://dbpedia.org/resource/Batman</a>&gt; 
		&lt;<a href="http://xmlns.com/foaf/0.1/knows" target="_blank">http://xmlns.com/foaf/0.1/knows</a>&gt; 
		&lt;<a href="http://dbpedia.org/resource/Robin_(comics)" target="_blank">http://dbpedia.org/resource/Robin_(comics)</a>&gt; .</pre>

					<p>With this triple, you can already see Linked Data in Action: Click on the subject (<code>Batman</code>), predicate (<code>knows</code>), or object (<code>Robin</code>), and you will get <em>more data</em> about these things: More data about Batman and Robin, and, in the case of the <code>knows</code> predicate, the documentation of the <a href="http://xmlns.com/foaf/spec/">Friend Of A Friend vocabulary</a> (FOAF). This is what Linked Data is all about: <strong>Sharing and reusing data</strong>. This is achieved by using URLs as identifiers, which not only provide unique IDs, but at the same time provide a location on the Web that contains data about the identified resource. Obviously, these resources cannot only be comic characters, but people, places, books, movies, drugs, events, and so on.</p> 

					<p>Strictly speaking, what you get when you click any of those links is a <em>human-readable representation</em> of the data, since you are accessing it with a browser asking the server for HTML. Going to the same location while asking for RDF in your HTTP header will return the same data as RDF; this mechanism is called <a href="http://linkeddatabook.com/editions/1.0/#htoc11">content negotiation</a>. Since we are talking about tech stuff: RDF is just a model, which can be serialized in <a href="http://en.wikipedia.org/wiki/Resource_Description_Framework#Serialization_formats">different notations</a>. We use the <a href="http://www.w3.org/TR/2011/WD-turtle-20110809/">Turtle syntax</a> here, because it is very easy to read.</p>

					<p>In case you are wondering where those URLs come from: <a href="http://dbpedia.org/About">DBpedia</a> provides facts extracted from Wikipedia as Linked Data, and <a href="http://xmlns.com/foaf/spec/">FOAF</a> is a widely used vocabulary to express relationships between people. You might already guess now where we are going with HXL: Providing a vocabulary and URLs as identifiers for the humanitarian domain.
					
				<h3>Creating a graph by combining statements</h3>

					<p>The concept of the statement becomes really powerful once we start combining several statements. Let's extent our Batman example a bit; in this example, we use prefixes (lines 1&ndash;6) to declare the different name spaces used in the rest of the document, to make the URIs shorter and more readable:</p>

					<pre class="prettyprint linenums">@prefix foaf: 	   &lt;<a href="http://xmlns.com/foaf/0.1/" target="_blank">http://xmlns.com/foaf/0.1/</a>&gt; .
@prefix dbp: 	   &lt;<a href="http://dbpedia.org/resource/" target="_blank">http://dbpedia.org/resource/</a>&gt; .
@prefix dbpprop:   &lt;<a href="http://dbpedia.org/property/" target="_blank">http://dbpedia.org/property/</a>&gt; .
@prefix geonames:  &lt;<a href="http://sws.geonames.org/" target="_blank">http://sws.geonames.org/</a>&gt; .
@prefix gn: 	   &lt;<a href="http://www.geonames.org/ontology#" target="_blank">http://www.geonames.org/#ontology</a>&gt; .
@prefix wgs84_pos: &lt;<a href="http://www.w3.org/2003/01/geo/wgs84_pos#">http://www.w3.org/2003/01/geo/wgs84_pos#</a>&gt; .

<a href="http://dbpedia.org/resource/Batman" target="_blank">dbp:Batman</a> <a href="http://xmlns.com/foaf/0.1/knows" target="_blank">foaf:knows</a> <a href="http://dbpedia.org/resource/Robin_%28comics%29" target="_blank">dbp:Robin_(comics)</a> ;
	<a href="http://dbpedia.org/property/creator" target="_blank">dbpprop:creator</a> <a href="http://dbpedia.org/resource/Bob_Kane" target="_blank">dbp:Bob_Kane</a> .

<a href="http://dbpedia.org/resource/Bob_Kane" target="_blank">dbp:Bob_Kane</a> <a href="http://dbpedia.org/property/birthPlace" target="_blank">dbpprop:birthPlace</a> <a href="http://sws.geonames.org/5128581" target="_blank">gn:5128581</a> .

<a href="http://sws.geonames.org/5128581" target="_blank">gn:5128581</a> <a href="http://www.geonames.org/ontology#name">gn:name     "New York City" ;
	<a href="http://www.w3.org/2003/01/geo/wgs84_pos#lat">wgs84_pos:lat</a>  "40.71427" ;
	<a href="http://www.w3.org/2003/01/geo/wgs84_pos#long">wgs84_pos:long</a> "-74.00597" . </pre>

					<p>In this example, we are combining data from DBpedia (telling us that Batman knows Robin and that he has been created by Bob Kane, as well as Bob Kane's birthplace) with data from the <a href="http://www.geonames.org/">GeoNames gazetteer</a>, which provides us with the name and geocoordinates of Bob Kane's birthplace (New York City). The object of a statement does not always have to be another URL, it can also be a string, number, date, or other kind of <em>literal</em>. If we visualize the example above, we get a small graph:</p>

					<p align="center"><img src="img/batman.png" /></p>

					<p>If we scale this tiny example up by a couple of orders of magnitude, we get the <em>global graph</em> that constitutes the Web of Data. The <a href="http://richard.cyganiak.de/2007/10/lod/">Linked Data Cloud diagram</a> gives an overview of the biggest sources for Linked Data and how they are interlinked.

				<h3>Shared Vocabularies</h3>
					
					<p>The previous example already demonstrates the reuse of shared vocabularies, as it uses the DBpedia, GeoNames, and W3C WGS84 vocabularies. Reusing existing vocabularies increases the oddds that a linked dataset is being reusing, as existing vocabularies (especially the ubiquitous ones such as <a href="http://xmlns.com/foaf/spec/">FOAF</a>, <a href="http://purl.org/dc/terms/">DC</a>, or <a href="http://www.w3.org/2004/02/skos/">SKOS</a>) are often already known to potential data consumbers. A good place to look for existing vocabularies is the <a href="http://lov.okfn.org/dataset/lov/">Linked Open Vocabularies</a> website.</p>

					<p><strong>HXL provides such a shared vocabulary for the humanitarian domain.</strong> So far, such a vocabulary does not exist, apart from the <a href="http://observedchange.com/moac/ns/">Management of a Crisis</a> (MOAC) vocabulary (see <a href="http://ceur-ws.org/Vol-798/paper2.pdf">this paper</a> for details). MOAC has certainly inspired HXL; however, we chose to redefine the classes and properties shared with HXL, instead of importing them, to make sure that the vocabulary is under control of UN OCHA. However, we did reuse classes and properties from broadly use vocabularies where unexpected changes are unlikely, such as <a href="http://xmlns.com/foaf/spec/">FOAF</a>, the Open Geospatial Consortium's <a href="http://www.opengis.net/ont/geosparql">GeoSPARQL ontology</a>, <a href="http://purl.org/dc/terms/">DC</a>, and <a href="http://www.w3.org/2004/02/skos/">SKOS</a>,</p>

				<h3>Why Linked Data?</h3>
					
					<p>As the name suggests, the original idea for HXL was to develop an XML schema that allows humanitarian organisation to publish XML adhering to this schema. We then went for a Linked Data approach for a number of reasons:</p>  

					<ul>
						<li><strong>Extensibility.</strong> HXL can only provide the core classes and properties for the domain. Publishing it as an RDF vocabulary allows data publishers to extend it according to their needs.</li>
						<li><strong>Reuse of external data sources.</strong> Many sources in the Linked Data cloud contain information that is also useful in a humanitarian context, such as geographic or demographic data. </li>
						<li><strong>Semantic annotations.</strong> An XML schema strongly focuses on <em>syntactic</em> interoperability. In Linked Data, RDF provides the syntax, and shared vocabularies define the <em>semantics</em> of the shared data.</li>
						<li><strong>Standardized API.</strong> Data access works through standard HTTP requests, and the data can be queried in the <a href="#sparql">SPARQL query language</a>.</li>
						<li><strong>Inference capabilities.</strong> The structure of the shared vocabularies supports <a href="http://en.wikipedia.org/wiki/Inference">inference</a> (also referred to as reasoning) on the data.</li>
						<li><strong>Success stories.</strong> The Linked Data approach has generated a number of impressive <a href="http://answers.semanticweb.com/questions/1533/what-are-the-success-stories-of-the-semantic-weblinked-data">success stories</a>, including the BBC and BestBuy.</li>
						<li><strong>Future-proofness.</strong> This is obviously always a bet, but we had the feeling (given the arguments above) that following the Linked Data approach is future proof in the medium to long term.</li>
					</ul>
					
  				<h3 id="ld-further">Further reading</h3>

  					<p>Obviously, we can only scratch on the surface of Linked Data here. For a more detailed introduction, we recommend the book <em>Linked Data: Evolving the Web into a Global Data Space</em> by <a href="http://tomheath.com/">Tom Heath</a> and <a href="http://dws.informatik.uni-mannheim.de/en/people/professors/prof-dr-christian-bizer/">Chris Bizer</a>. You can read the whole book <a href="http://linkeddatabook.com">online for free</a>. Moreover, <a href="http://linkeddata.org/">linkeddata.org</a> offers a list with <a href="http://linkeddata.org/guides-and-tutorials">guides and tutorials</a>.</p>
   			


<!--   SPARQL 101 SECTION  -->




  			<h2 id="sparql">SPARQL 101</h2>

  				<p>So far, we have a structure where you can jump from one dataset to the next, browsing the Web of Data by <em>following your nose</em>. While that is a nice thing to have, what if we want to find all resources that match a certain criterion? Enter <a href="http://www.w3.org/TR/sparql11-query/">SPARQL</a>. The SPARQL query language defines a standard (currently a W3C recommendation) that supports such queries against <a href="http://en.wikipedia.org/wiki/Triplestore">triple stores</a>, i.e., databases optimzed for RDF storage.</p>
  				
  				<h3>Basic queries</h3>
  					
  					<p>If you are familiar with SQL, you will find many similarities in SPARQL. The big difference obviously is that we are querying graphs now, not tables in a relational database. In a SPARQL query, we define a graph pattern with a number of variables, and the result is the set of values for these variables for each match. As a starting example, following query asks for ten arbitrary triples:</p>

  					<pre class="prettyprint linenums">SELECT * WHERE {
   ?a ?b ?c . 
} LIMIT 10</pre><a href="http://sparql.carsten.io/?query=SELECT%20*%20WHERE%20%7B%0A%20%20%3Fa%20%3Fb%20%3Fc%20.%0A%7D%0ALIMIT%2010&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

					<p>The <code>*</code> in the <code>SELECT</code> clause means that we want to return the values for all variables in the <code>WHERE</code> clause, which picks random triples (subject (<code>?a</code>), predicate  (<code>?b</code>), and object (<code>?c</code>) are not restricted in any way). The number of results to return is then limited to 10 &ndash; without this restriction, this clause would return <em>all</em> triples in the store.</p>

					<p>A SPARQL query is sent as an HTTP request to a <em>SPARQL endpoint</em>. <strong>The SPARQL endpoint for the HXL triple store is at <code>http://hxl.humanitarianresponse.info/sparql</code>.</strong></p>

					<p>Since there is no database schema for a triple store, one of the first things to do when interacting with a new endpoint is often to explore its contents. To do this, we can easily ask for the different kinds of things the triple store hosts:</p>

					<pre class="prettyprint linenums">SELECT DISTINCT ?type WHERE {
   ?thing a ?type . 
}</pre><a href="http://sparql.carsten.io/?query=SELECT%20DISTINCT%20%3Ftype%20WHERE%20%7B%0A%20%20%20%3Fthing%20a%20%3Ftype%20.%20%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

					<p>In this case, we only ask for values for the <code>?type</code> variable (note that the variable names are completely arbitrary; we usually try to pick something meaningful that makes it easier to read the queries, though). The <code>DISTINCT</code> keyword makes sure that we don't get any duplicates. A look at the <code>WHERE</code> clause shows that the <code>?type</code> variable is used for the object of the triple. The predicate is a simple <code>a</code>, which is a shortcut for the <code>rdf:type</code> property that makes RDF resources instances of a class. Hence, this query gives us all classes that the triple store contains instances of.</p>

					<p>Likewise, we can ask for all the predicates used in the triple store:</p>

					<pre class="prettyprint linenums">SELECT DISTINCT ?predicate WHERE {
   ?subject ?predicate ?object . 
}</pre><a href="http://sparql.carsten.io/?query=SELECT%20DISTINCT%20%3Fpredicate%20WHERE%20%7B%0A%20%20%20%3Fsubject%20%3Fpredicate%20%3Fobject%20.%20%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

					These very simple examples illustrate the basics of SPARQL; we will show some more complex examples <a href="examples">below</a>.

  				<h3>Tools</h3>

  					<p>SPARQL is based on HTTP, so any tool that can fire an HTTP request can query a SPARQL endpoint (<a href="http://hxl.humanitarianresponse.info/sparql?query=prefix%20foaf%3A%20%3Chttp%3A//xmlns.com/foaf/0.1/%3E%20%0A%0ASELECT%20*%20WHERE%20%7B%0A%20%20%3Fagent%20a%20foaf%3APerson%20.%0A%7D">even your browser</a> &ndash; clicking this link should download an XML-encoded SPARQL results file to your computer). However, this is obviously not the most convenient way. Trying out queries is easier in an editor with proper syntax highlighting such as the one at <a href="http://sparql.carsten.io/">sparql.carsten.io</a>. Once you want to process the results programmatically, using libraries such as <a href="http://graphite.ecs.soton.ac.uk/sparqllib/">sparqllib</a> (PHP) or <a href="http://www.openrdf.org">Jena</a> (Java) come in handy. As with all things HTTP, <a href="http://curl.haxx.se">cURL</a> is extremely useful for testing and debugging. </p>

  				<h3 id="sparql-further">Further reading</h3>
  					<p>For further reading, we recommend the <a href="http://www.cambridgesemantics.com/de/semantic-university/sparql-by-example">SPARQL by Example</a> introduction over at Cambridge Semantics, and the W3C's <a href="http://www.w3.org/TR/sparql11-query/">SPARQL 1.1 working draft</a>, which has all the details, along with some handy examples.</p>  				
  			


<!--   HXL BY EXAMPLE SECTION  -->



  			<h2 id="examples">HXL by Example</h2>
  				<p>This section demonstrates how to query HXL by a number of common examples. We won't be able to cover ever possible query that you can make against our store, but the examples should get you started and allow you to extent them to build your own queries. Reading the <a href="http://hxl.humanitarianresponse.info/ns/">vocabulary documentation</a> will help you phrase your queries.</p>

  				<h3>Query by type</h3>
  				<div class="example">
  					<p>One of the most basic queries is asking for all resources of a certain type, e.g., all <a href="http://hxl.humanitarianresponse.info/ns/#APL">affected people locations</a> and their names, ordered by name: </p>
				</div>
				<pre class="prettyprint linenums">prefix hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT * WHERE {
   ?apl a hxl:APL ;
        hxl:featureRefName ?name .
} ORDER BY ?name</pre><a href="http://sparql.carsten.io/?query=prefix%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20*%20WHERE%20%7B%0A%20%20%3Fapl%20a%20hxl%3AAPL%20%3B%0A%20%20%20%20%20%20%20%20%20hxl%3AfeatureRefName%20%3Fname%20.%0A%7D%20ORDER%20BY%20%3Fname&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

				<h3>Query by resource</h3>
  				<div class="example">
  					<p>This query gets all facts about a specific resource (Burkina Faso in this example) : </p>
				</div>
				<pre class="prettyprint linenums">prefix hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;
 
 SELECT * WHERE {
   &lt;http://hxl.humanitarianresponse.info/data/locations/admin/bfa/BFA&gt; ?pred ?obj .
}</pre><a href="http://sparql.carsten.io/?query=prefix%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%20%0ASELECT%20*%20WHERE%20%7B%0A%0A%20%20%3Chttp%3A//hxl.humanitarianresponse.info/data/locations/admin/bfa/BFA%3E%20%3Fpred%20%3Fobj%20.%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

				<h3>Query specific property</h3>
  				<div class="example">
  					<p>Similar to the queries by type, specific properties of a resource are straight-forward to get. In this case, we query for the title of a specific <a href="http://hxl.humanitarianresponse.info/ns/#AgeGroupSet">age group set</a>. </p>
				</div>
				<pre class="prettyprint linenums">PREFIX hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT DISTINCT ?title WHERE {
   &lt;http://hxl.humanitarianresponse.info/data/agegroups/unhcr/ages_0-4&gt; hxl:title ?title .
}</pre><a href="http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20DISTINCT%20%3Ftitle%20WHERE%20%7B%0A%20%20%3Chttp%3A//hxl.humanitarianresponse.info/data/agegroups/unhcr/ages_0-4%3E%20hxl%3Atitle%20%3Ftitle%20.%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

				<h3>Query by datacontainer</h3>
  				<div class="example">
  					<p>The HXL data is organized in datacontainers, which correspond to <a href="http://blog.ldodds.com/2009/11/05/managing-rdf-using-named-graphs/">named graphs</a> in our triple store. This query gets all triples in the given datacontainer. Note that if no datacontainer is explicitly given in the query (using the <code>GRAPH</code> syntax), the query will be ran across <em>all</em> datacontainers (the so-called <em>union graph</em>). </p>
				</div>
				<pre class="prettyprint linenums">SELECT * WHERE {
   GRAPH &lt;http://hxl.humanitarianresponse.info/data/datacontainers/unocha/1344942253.196156&gt; {
       ?subject ?predicate ?object .
   }
}</pre><a href="http://sparql.carsten.io/?query=SELECT%20DISTINCT%20*%20WHERE%20%7B%0A%20%20GRAPH%20%3Chttp%3A//hxl.humanitarianresponse.info/data/datacontainers/unocha/1344942253.196156%3E%20%7B%0A%20%20%20%20%3Fsubject%20%3Fpredicate%20%3Fobject%20.%0A%20%20%7D%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

<div class="example">
  					<p>This query gets all datacontainers that are about the Mali emergency. </p>
				</div>
				<pre class="prettyprint linenums">PREFIX hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT DISTINCT * WHERE {
   ?container hxl:aboutEmergency <http://hxl.humanitarianresponse.info/data/emergencies/mali2012test> .
}</pre><a href="http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20DISTINCT%20*%20WHERE%20%7B%0A%20%20%20%3Fcontainer%20hxl%3AaboutEmergency%20%3Chttp%3A//hxl.humanitarianresponse.info/data/emergencies/mali2012test%3E%20.%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

				<h3>Property path queries</h3>
  				<div class="example">
  					<p>A new feature in SPARQL 1.1 makes complex queries a snap. <a href="http://www.w3.org/TR/sparql11-property-paths/">Property paths</a> allow us to query along the graph without prior knowledge of how deep we need to go with this query. For example, this query gets all places within Burkina Faso (note that in our data, every place is only linked to the containing administrative unit via the <a href="http://hxl.humanitarianresponse.info/ns/#atLocation">at location</a> property):</p>
				</div>
				<pre class="prettyprint linenums">PREFIX hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT * WHERE {
  ?feature hxl:atLocation+ &lt;http://hxl.humanitarianresponse.info/data/locations/admin/bfa/BFA&gt; .
}</pre><a href="http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20*%20WHERE%20%7B%0A%20%20%3Ffeature%20hxl%3AatLocation%2B%20%3Chttp%3A//hxl.humanitarianresponse.info/data/locations/admin/bfa/BFA%3E%20.%0A%7D%0A&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

				<div class="example">
  					<p>This query uses a property paths to fetch all things that are typed as a HXL population or <em>any of the subclasses of population</em>:</p>
				</div>
				<pre class="prettyprint linenums">prefix rdf: &lt;http://www.w3.org/1999/02/22-rdf-syntax-ns#&gt; 
prefix rdfs: &lt;http://www.w3.org/2000/01/rdf-schema#&gt; 
prefix hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT * WHERE {
  ?population rdf:type/rdfs:subClassOf* hxl:Population .
}</pre><a href="http://sparql.carsten.io/?query=prefix%20rdf%3A%20%3Chttp%3A//www.w3.org/1999/02/22-rdf-syntax-ns%23%3E%20%0Aprefix%20rdfs%3A%20%3Chttp%3A//www.w3.org/2000/01/rdf-schema%23%3E%20%0Aprefix%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20*%20WHERE%20%7B%0A%20%20%3Fpopulation%20rdf%3Atype/rdfs%3AsubClassOf*%20hxl%3APopulation%20.%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

<h3>Some math</h3>

<div class="example">
  					<p>A more complex example which queries the latest overall population numbers per location in the Mali crisis. The <code>MAX</code> syntax gets us only the latest dates, and the <code>SUM</code> adds up the person counts for the different types of population at the given place.</p>
				</div>
				<pre class="prettyprint linenums">prefix ogc: &lt;http://www.opengis.net/ont/geosparql#&gt; 
prefix hxl: &lt;http://hxl.humanitarianresponse.info/ns/#&gt;

SELECT (MAX(?valid) as ?latest) ?location ?locationName ?wkt (SUM(?count) AS ?totalRefugees) WHERE {
  
  GRAPH ?g {
    ?g hxl:aboutEmergency &lt;http://hxl.humanitarianresponse.info/data/emergencies/mali2012test&gt; ; 
       hxl:validOn ?valid .
    ?pop a hxl:RefugeesAsylumSeekers ; 
           hxl:personCount ?count ;
           hxl:atLocation  ?location .
  }
  ?location hxl:featureName ?locationName;
            ogc:hasGeometry ?geom .
  ?geom ogc:hasSerialization ?wkt .
  
} GROUP BY ?location ?locationName ?wkt 
ORDER BY ?locationName</pre><a href="http://sparql.carsten.io/?query=prefix%20ogc%3A%20%3Chttp%3A//www.opengis.net/ont/geosparql%23%3E%20%0Aprefix%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%0ASELECT%20%28MAX%28%3Fvalid%29%20as%20%3Flatest%29%20%3Flocation%20%3FlocationName%20%3Fwkt%20%28SUM%28%3Fcount%29%20AS%20%3FtotalRefugees%29%20WHERE%20%7B%0A%20%20%0A%20%20GRAPH%20%3Fg%20%7B%0A%20%20%20%20%3Fg%20hxl%3AaboutEmergency%20%3Chttp%3A//hxl.humanitarianresponse.info/data/emergencies/mali2012test%3E%20%3B%20%0A%20%20%20%20%20%20%20hxl%3AvalidOn%20%3Fvalid%20.%0A%20%20%20%20%3Fpop%20a%20hxl%3ARefugeesAsylumSeekers%20%3B%20%0A%20%20%20%20%20%20%20%20%20%20%20hxl%3ApersonCount%20%3Fcount%20%3B%0A%20%20%20%20%20%20%20%20%20%20%20hxl%3AatLocation%20%20%3Flocation%20.%0A%20%20%7D%0A%20%20%3Flocation%20hxl%3AfeatureName%20%3FlocationName%3B%0A%20%20%20%20%20%20%20%20%20%20%20%20ogc%3AhasGeometry%20%3Fgeom%20.%0A%20%20%3Fgeom%20ogc%3AhasSerialization%20%3Fwkt%20.%0A%20%20%0A%7D%20GROUP%20BY%20%3Flocation%20%3FlocationName%20%3Fwkt%20ORDER%20BY%20%3FlocationName&endpoint=http%3A//hxl.humanitarianresponse.info/sparql" class="btn pull-right execute" target="_blank">Execute <i class="icon-play"></i></a>

  			<h2 id="geo">Geodata in HXL</h2>
  				<p>yadda...</p>
  			</div>
	  	</div>
	</div>


<?php getFoot(array('jquery-ui-1.8.21.custom.min.js'), null ); ?>