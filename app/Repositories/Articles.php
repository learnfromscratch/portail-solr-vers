<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

/**
* 
*/
class Articles
{
	protected $client;
	
	function __construct($client, $params, $start)
	{
		$this->client = $client;
		$this->params = $params;
		$this->start = ($start - 1)*10;
	}


	public function init()
	{
		// get the connected User
		$user = Auth::user();

		// construct the query for searcg
    	$querySearched = "";

		

		
		// get a select query instance
		$query = $this->client->createSelect();
		$this->client->getPlugin('postbigrequest');

		$helper = $query->getHelper();
		foreach($user->keywords()->get() as $keyword)
		{
			$querySearched .= $helper->escapePhrase($keyword->name);
		}
		//dd($querySearched);
		$keywordsquery = "";
		$Textfields = ['Title_en', 'Title_fr', 'Title_ar' ,'Fulltext_en','Fulltext_fr', 'Fulltext_ar'];

		foreach ($Textfields as $value) {
		  $keywordsquery .= $value.":(".$querySearched.") ";
		}

		$query->createFilterQuery('filterkeywords')->setQuery($keywordsquery);
		
		$query->setFields([
			'id',
			'Title_en','Title_fr', 'Title_ar',
			'Fulltext_en','Fulltext_fr','Fulltext_ar',
			'document', 'Source','SourceName','ArticleLanguage', 'SourceDate','Author','score']);


		// get the dismax component and set a boost query
		
		//Fulltext_en:(("fondation" "mohammed") AND ("mise" AND ) (NOT"" NOT""))

		//Fulltext_fr:(("fondation" "mohammed") AND ("mise" AND "Ouverture") NOT "beauté")

		
		if (isset($this->params['data']))
		{
			//$query->setQuery($helper->escapePhrase($_GET['searchterm']));
    		$edismax = $query->getEDisMax();
			$thequery = "";
			
			foreach ($Textfields as $value) {
		  		$thequery .= $value . ":(".$this->params['data'].") ";
			}
			//dd($thequery);
			$query->setQuery($thequery);
			//$datesss = date("Y-m-d");
			//dd($datesss);
    		//$datesssm = $datesss."T00:00:00Z";

    		//$edismax->setQueryFields("Fulltext_ar^4 Fulltext_fr^4 Fulltext_en^4 Title_en^3 Title_fr^3 Title_ar^3");
    		//$edismax->setBoostQuery('SourceDate:"'.$datesssm.'"^5');
    		//dd($edismax);
			//dd($edismax);
			
		}

		$query->setStart($this->start)->setRows(1000);


		// get the facetset component
		$facetSet = $query->getFacetSet();
		$facetSet->createFacetField('language')->setField('ArticleLanguage');
		$facetSet->createFacetField('author')->setField('Author');
		$facetSet->createFacetField('source')->setField('SourceName');
		$facetSet->createFacetField('date')->setField('SourceDate');
		$facetSet->setMinCount(1);

		// Get highlighting component, and apply settings
		$hl = $query->getHighlighting();
		$hl->setSnippets(5);
		$hl->setFields(array('Title_en', 'Title_fr','Title_ar','Fulltext_en','Fulltext_fr','Fulltext_ar','Fulltext', 'Title'));

		$hl->setSimplePrefix('<strong>');
		$hl->setSimplePostfix('</strong>');
		if (isset($this->params['language'])) {
			$query->createFilterQuery('language')->setQuery('ArticleLanguage:"'.$helper->escapePhrase($this->params['language']).'"');
		}
		if (isset($this->params['source'])) {
			$query->createFilterQuery('source')->setQuery('SourceName:'.$helper->escapePhrase($this->params['source']));
		}
		if (isset($this->params['author'])) {
			$query->createFilterQuery('author')->setQuery('Author:'.$helper->escapePhrase(urldecode($this->params['author'])));
			//dd($query->getQuery());

			//dd('Author:'.$helper->escapeTerm($this->params['author']));
		}
		if (isset($this->params['keyword'])) {
			$key = $helper->escapePhrase($this->params['keyword']);
			$query->createFilterQuery('keyword')->setQuery('Title:'.$key.' Fulltext_en:'.$key.' Fulltext_fr:'.$key.' Fulltext_ar:'.$key.' Fulltext:'.$key.' Title_fr:'.$key.' Title_en:'.$key.' Title_ar:'.$key);
		}

		if (isset($this->params['sort']) and $this->params['sort'] == "date") {
			$query->addSort('SourceDate', $query::SORT_DESC);
		}
		if (isset($this->params['sort']) and $this->params['sort'] == "pertinence") {
			$query->addSort('score', $query::SORT_DESC);
		}

		if (empty($this->params['data']))
			$query->addSort('SourceDate', $query::SORT_DESC);
		
		if (isset($this->params['fromdate'])) { 
			//and isset($this->params['todate'])) {
			$fromdate = $this->params['fromdate'].'T00:00:00Z';			
			$query->createFilterQuery('fromdate')->setQuery('SourceDate:"'.$fromdate.'"');
			//$todate = $this->params['todate'].'T00:00:00Z';
			//$query->createFilterQuery('fromdate')->setQuery('SourceDate:['.$fromdate.' TO '.$todate.']');
		}
		if (isset($this->params['allthiswords'])) {

		}

		$thequery = '';
		$thequery2 = '';
		$excludequery = '';
		$andquery = '';
		$allquery='';
		$theorquery = '';
		$orquery='';
		$after='';

		if (isset($this->params['allthiswords'])) { 
			$array = explode(",",$this->params['allthiswords']);
			
			foreach($array as $value){
			
		  		$thequery .= '"'.$value.'" AND ';
			}
			$thequery1 = substr($thequery,0,-4);
			//dd($thequery1);
			$andquery = "(".$thequery1.") ";
			
			$after = " AND ";

			//dd($andquery);

			//$query->createFilterQuery('allthiswords')->setQuery($andquery);
		}

		if(isset($this->params['orwords'])) {
			$array = explode(",",$this->params['orwords']);

			foreach($array as $value){
			
		  		$theorquery .= '"'.$value.'" ';
			}

			$orquery = $after."(".$theorquery.") ";
			

		}

		if (isset($this->params['noneofthis'])) {
			//dd($this->params['noneofthis']);
			$array = explode(",",$this->params['noneofthis']);

			
			foreach($array as $value){
			
		  		$thequery2 .= ' NOT "'.$value.'" ';
			}

			//dd($thequery);

			$excludequery = $thequery2;

			//dd($excludequery);

			//$query->createFilterQuery('noneofthis')->setQuery($excludequery);
		}

		if(!empty($this->params['noneofthis']) OR !empty($this->params['allthiswords']) OR !empty($this->params['orwords'])) {
			
			foreach ($Textfields as $field) {
		  		$allquery .= $field.":(".$andquery."".$orquery."".$excludequery.") ";
			}
			//dd($allquery);
			$query->setQuery($allquery);

		}
		//dd($query);
		return $query;

	}


	/**
	 * @param Illuminate\Http\Request $request
	 * @return array $resultset
	*/
	public function index()
	{
		$query = Articles::init();

		// this executes the query and returns the result
		return $resultset = $this->client->select($query);
	}


	public function show($request)
	{
		$query = Articles::init();
		$helper = $query->getHelper();

		$thequery = 'id:"'.$request.'"';
		$query->setQuery($thequery);

		// this executes the query and returns the result
		return $resultset = $this->client->select($query);	
	}

}