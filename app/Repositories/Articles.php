<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Theme;
use Illuminate\Http\Request;
use App\Miseforme;
/**
* 
*/
class Articles
{
	protected $client;
	
	function __construct($client, $params, $page,$request)
	{
		$this->client = $client;
		$this->params = $params;
		$this->page = $page;
		$this->request = $request;
	}

	public function baseFilter() {
		// get the connected User
		$querySearched = "";

		if (Auth::user()->groupe->id === 1)
    			$querySearched = '*:* ';
  
    	else {
    		$user = Auth::user();
    		$themes = $user->groupe->themes;
			$querySearched = (new GetKeywords($user))->getKeywordsByThemes($themes);
    	}

		
//dd($querySearched);
		
		// get a select query instance
		$query = $this->client->createSelect();
		$this->client->getPlugin('postbigrequest');

		$helper = $query->getHelper();
		//$querySearched = (new GetKeywords(Auth::user()))->get();
		//dd($querySearched);
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

		$facetSet = $query->getFacetSet();
		$facetSet->createFacetField('language')->setField('ArticleLanguage');
		$facetSet->createFacetField('author')->setField('Author');
		$facetSet->createFacetField('source')->setField('SourceName');
		$facetSet->createFacetField('date')->setField('SourceDate');
		$facetSet->setMinCount(1);
		return $query;

	}
	public function init($query)
	{
		$nombreacticle = Miseforme::where('user_id', Auth::id())->first()->article_par_page;
		$this->page = ($this->page - 1)*$nombreacticle;
		//dd($this->page);
		$helper = $query->getHelper();
		$Textfields = ['Title_en', 'Title_fr', 'Title_ar' ,'Fulltext_en','Fulltext_fr', 'Fulltext_ar'];

		// get the dismax component and set a boost query
		
		//Fulltext_en:(("fondation" "mohammed") AND ("mise" AND ) (NOT"" NOT""))

		//Fulltext_fr:(("fondation" "mohammed") AND ("mise" AND "Ouverture") NOT "beauté")
		if (isset($this->params['theme']))
		{
			$thequery = "";
			$keywor = new GetKeywords(Auth::user());
			$theme = Theme::where('name', $this->params['theme'])->first();
			
			$keywos = $keywor->getKeywordsByTheme($theme);
			foreach ($Textfields as $value) {
                $thequery .= $value.':('.$keywos.') ';
            }
            $query->createFilterQuery('filterthemess')->setQuery($thequery);

		}
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
		
		$query->setStart($this->page)->setRows($nombreacticle);


		// get the facetset component
		$facetSet = $query->getFacetSet();
		

		// Get highlighting component, and apply settings
		$hl = $query->getHighlighting();
		$hl->setSnippets(5);
		$hl->setFields(array('Title_en', 'Title_fr','Title_ar','Fulltext_en','Fulltext_fr','Fulltext_ar','Fulltext', 'Title'));

		$hl->setSimplePrefix('<strong>');
		$hl->setSimplePostfix('</strong>');
		
		
		
		if (isset($this->params['source'])) {
			$query->createFilterQuery('source')->setQuery('SourceName:'.$helper->escapePhrase($this->params['source']));
		}
		//dd($this->params['author']);
		if (isset($this->params['author'])) {
			$query->createFilterQuery('author')->setQuery('Author:'.$helper->escapePhrase($this->params['author']));
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

		if (empty($this->params['data']) AND empty($this->params['noneofthis']) AND empty($this->params['allthiswords']) AND empty($this->params['orwords']))
				$query->addSort('SourceDate', $query::SORT_DESC);
		
		if (isset($this->params['fromdate'])) { 
			//and isset($this->params['todate'])) {
			$fromdate = $this->params['fromdate'].'T00:00:00Z';			
			$query->createFilterQuery('fromdate')->setQuery('SourceDate:"'.$fromdate.'"');
			//$todate = $this->params['todate'].'T00:00:00Z';
			//$query->createFilterQuery('fromdate')->setQuery('SourceDate:['.$fromdate.' TO '.$todate.']');
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
			$exec = '';
			$array = explode(",",$this->params['noneofthis']);

			
			foreach($array as $value){
			
		  		$thequery2 .= '"'.$value.'" ';
			}



			//dd($thequery);
			$thequery3 = '('.$thequery2.')';
			
			foreach ($Textfields as $field) {
		  		$exec .= " -".$field.":".$thequery3;
			}
			$excludequery = $exec;

			//dd($excludequery);

			$query->createFilterQuery('noneofthisq')->setQuery($excludequery);
		}

		if(!empty($this->params['allthiswords']) OR !empty($this->params['orwords'])) {
			
			foreach ($Textfields as $field) {
		  		$allquery .= $field.":(".$andquery."".$orquery.") ";
			}
			//dd($allquery);
			$query->setQuery($allquery);

		}
		//dd($allquery);
		return $query;

	}


	/**
	 * @param Illuminate\Http\Request $request
	 * @return array $resultset
	*/
	public function index()
	{

		$query = Articles::baseFilter();
		$query = Articles::init($query);
		$helper = $query->getHelper();
		if($this->request->segment(1) != 'tous' ) {
			if ($this->request->segment(1) == 'fr' ) {
				$langage = 'French';
			}
			elseif ($this->request->segment(1) == 'en') {
				$langage='ENGLISH';
			}
			else {
				$langage = 'Arabic';
			}

				//session(['language' => $this->params['language']]);
				$query->createFilterQuery('language')->setQuery('ArticleLanguage:'.$helper->escapePhrase($langage));
		}
		// this executes the query and returns the result
		return $resultset = $this->client->select($query);
	}


	public function show()
	{
		$query = Articles::baseFilter();
		$query = Articles::init($query);
		//$query = Articles::init();

		return $query;	
	}

}