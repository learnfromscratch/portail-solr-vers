<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Solarium;
use App\Repositories\Articles;
use App\ConcatPdf;
use Illuminate\Support\Facades\Auth;
use App\Services\Notification;
use App\User;
use App\Newsletter;
use  Illuminate\Support\Facades\Redis;
use App\Events\Alert;
use Illuminate\Support\Facades\DB;
use App\Theme;
use App\Repositories\GetKeywords;


class HomeController extends Controller
{
    protected $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\Solarium\Client $client)
    {
        $this->middleware('auth');
         $this->middleware('language');
        //$this->middleware('abonnement');
        $this->client = $client;
        
    }

   /* public function test()
    {
        $keywordGroup = KeywordGroup::first();
        Auth::user()->notify(new Newsletter ($keywordGroup));
    }*/

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->start);
      /*
      $id = User::findOrNew(10)->name;
      dd($id);
      */
      //dd($request->segment(1));

        
        $keys = [];
        $counts = [];
        $Textfields = ['Title','Title_en', 'Title_fr', 'Title_ar' ,'Fulltext','Fulltext_en','Fulltext_fr', 'Fulltext_ar'];
        $params = $request->all();
        
        //$params['language'] = session('language');
        if (empty($params))
            $sign = "?";
        else
            $sign="&";

        
       if(empty($request->page))
            $page = 1;
        else
            $page = $request->page;

        $folderPdfs = "Articles";
        $query = (new Articles($this->client,$params,$page,$request))->baseFilter();
        $resultset = $this->client->select($query);

         //$result = (new Articles($this->client,$params,$page,$request))->all();
        $facet1 = $resultset->getFacetSet()->getFacet('language');
        //$facet2 = $resultset->getFacetSet()->getFacet('author');
        
        $facet4 = $resultset->getFacetSet()->getFacet('date');

        //$query1 = $resultset = (new Articles($this->client,$params,$page,$request))->init();
        $resultset = (new Articles($this->client,$params,$page,$request))->index();

        //$query = (new Articles($this->client,$params,$page,$request))->init($query);
       $facet3 = $resultset->getFacetSet()->getFacet('source');
       //$query = (new Articles($this->client,$params,$page,$request))->init();
       $helper = $query->getHelper();
        $keywordfacet = [];
       
       $user = Auth::user();

       
       //$filtredUsers = User::all()->whereIn('id',)->all();

       /*
       $filtredUsers = User::all()->filter(function($value,$key){
          return in_array($value->id,[10,5,11]);
       });*/
       
         
       

        if ($user->groupe->id === 1) {
            $themes = Theme::all();
        } 
        elseif ($user->role->name === 'Admin') {
            $themes = $user->groupe->themes;
        }
        
        else {
            $themes = $user->groupe->themes;
        }
        
        //$query1 = $this->client->createSelect();
        /*
        $query->setFields([
            'Title_en','Title_fr', 'Title_ar',
            'Fulltext_en','Fulltext_fr','Fulltext_ar']);
        */

        
        $Textfields = ['Title_en', 'Title_fr', 'Title_ar','Fulltext_en','Fulltext_fr', 'Fulltext_ar'];

        $keywor = new GetKeywords($user);

        $keyss = [];
        $count = [];
        foreach($themes as $theme) {
            $thequery = "";
            
            $keywos = $keywor->getKeywordsByTheme($theme);
            
            foreach ($Textfields as $value) {
                $thequery .= $value.':('.$keywos.') ';
            }

            
            $query->setQuery($thequery);
            $resultset2 = $this->client->select($query);
            $counts = $resultset2->getNumFound();


            array_push($keyss, $theme->name);
            array_push($count, $counts);

        }

         $numbers = array_combine($keyss, $count);

         $pdfs = [];
         $titles = [];
         $languages = [];
         foreach ($resultset as $document) {
            if(!empty($document->Title_en)) {
                    $field = 'Title_en';
                    $title = $document->Title_en;
              }
              if(!empty($document->Title_fr)){
                    $field = 'Title_fr';
                    $title = $document->Title_fr;
              }
            if(!empty($document->Title_ar)){
                    $field = 'Title_ar';
                    $title = $document->Title_ar;
            }
             array_push($pdfs, $document->document);
             array_push($titles, $title);
             array_push($languages, $document->ArticleLanguage);
         }
         
         //$this->user_id = 
        return view('home', compact('request','resultset','themes', 'folderPdfs', 'facet1', 'facet2', 'facet3','facet4','params','sign','numbers','user_id','pdfs','titles', 'languages'));
    }


    public function show(Request $request)
    {
        $folderPdfs = "Articles";
        $keys = [];
        $counts = [];
        $params = $request->all();
        //$params['language'] = session('language');
        //dd($params);
        if (empty($params))
            $sign = "?";
        else
            $sign="&";


        
        
        // this executes the query and returns the result
         
        $query = (new Articles($this->client,$params,1,$request))->show();  
        $helper = $query->getHelper();

        //$thequery = 'id:"'.$request->id.'"';
        
        $query->createFilterQuery('filterid')->setQuery("id:".$helper->escapePhrase($request->id));
        //$query->setQuery($thequery);
         $user = Auth::user();
        if ($user->groupe->id === 1) {
            $themes = Theme::all();
        } 
        elseif ($user->role->name === 'Admin') {
            $themes = $user->groupe->themes;
        }
        
        else {
            $themes = $user->groupe->themes;
        }
        $resultset = $this->client->select($query);
        
        $facet1 = $resultset->getFacetSet()->getFacet('language');
        $facet2 = $resultset->getFacetSet()->getFacet('author');
        $facet3 = $resultset->getFacetSet()->getFacet('source');
        $facet4 = $resultset->getFacetSet()->getFacet('date');
 
                
        

 $Textfields = ['Title_en', 'Title_fr', 'Title_ar','Fulltext_en','Fulltext_fr', 'Fulltext_ar'];

        $keywor = new GetKeywords($user);

        $keys = [];
        $counts = [];
        foreach($themes as $theme) {
            $thequery = "";
            
            $keywos = $keywor->getKeywordsByTheme($theme);
            
            foreach ($Textfields as $value) {
                $thequery .= $value.':('.$keywos.') ';
            }

            $query->setFields([
            'Title_en','Title_fr', 'Title_ar',
            'Fulltext_en','Fulltext_fr','Fulltext_ar']);
        
            $query->setQuery($thequery);
            //$resultset2 = $this->client->select($query);
            //$counts = $resultset2->getNumFound();

            $countkey = 0;
            //$query = $this->client->createSelect();
        
            

        // get the dismax component and set a boost query
        //$edismax = $query->getEDisMax();
        //$helper = $query->getHelper();

            
        // Get highlighting component, and apply settings
       $hl = $query->getHighlighting();
        
        $hl->setFields(array('Title_en', 'Title_fr','Title_ar','Fulltext_en','Fulltext_fr','Fulltext_ar'));
         $hl->setSnippets(100000); 
         //$hl->setHighlightMultiTerm(true); 
         $hl->setFragSize(2);
         //$hl->setMergeContiguous(true); 
        $hl->setSimplePrefix('<strong>');
        $hl->setSimplePostfix('</strong>');
          
        //$query->setQuery();
            $resultset1 = $this->client->select($query);
            $highlighting = $resultset1->getHighlighting();
            //$resultset1->getDocuments()[0]->getFields()['id']
            $highlightedDoc = $highlighting->getResult($request->id);
            $countkey = 0;
            
            if($highlightedDoc) {
              //dd($highlightedDoc);
            $countkey = count($highlightedDoc->getField('Title')) + count($highlightedDoc->getField('Title_en')) + count($highlightedDoc->getField('Title_fr')) + count($highlightedDoc->getField('Title_ar')) + count($highlightedDoc->getField('Fulltext')) + count($highlightedDoc->getField('Fulltext_en')) + count($highlightedDoc->getField('Fulltext_fr')) + count($highlightedDoc->getField('Fulltext_ar'));
            }

            array_push($keys, $theme->name);
            array_push($counts, $countkey);

            
        }

        $numbers = array_combine($keys, $counts);
        $user_id = Auth::user()->id;
        return view('article', compact('resultset', 'folderPdfs','numbers','user_id', 'facet1', 'facet2', 'facet3','facet4','params','sign'));
    }


    public function test(Request $request)
    {
        //dd($pdfs);
        $pdfsconcat = [];

        $start = 0;
        $f = 0;
        $k = 0;
        $pdf = new ConcatPdf;
        
        //$pdf->SetCompression(true);
        //dd($request->language);
        $pdf->addPage();
        $pdfs = unserialize($request->pdf);
        $languages = unserialize($request->language);
        $titles = unserialize($request->titles); 

        //$pdf->Image('https://opensource.org/files/twitterlogo.png',60,30,90,0,'PNG');
        $pdf->Image('img/oxdata.jpg',60,30,90,0);
        $pdf->SetTextColor(48,151,209);
         $pdf->Ln(100);
         $pdf->SetFont('times','I',30);
        $pdf->Cell(190, 20, 'Revue de presse', 1, 1, 'C');
        $pdf->SetFontSize(12);
        $pdf->Ln(120);
        $pdf->Cell(190, 20, 'Redigé le :'.date("d-m-Y"), 0, 1, 'C');
        //$pdf->addPage();
         $pdf->SetFont('times');
        $pdf->addPage();
        $countlanguage = count(array_unique($languages));
        $counttitles = $countlanguage + count($pdfs);
       $j = 0;
        if(count($pdfs) == 21 and count(array_unique($languages)) == 3){
            $j = 1;
            }

        $number = (int) ceil($counttitles / 24) + $j;
        //dd($number);
        foreach(array_unique($languages) as $language) {
            $arraylanguage = [];
        $keys = array_keys($languages, $language);
        //dd($$languages);
        foreach($keys as $key)
            array_push($arraylanguage, $pdfs[$key]);
       // dd($arraylanguage);
        //$pdf->setFiles($arraylanguage);
        //$pdf->SetAutoPageBreak(true,2);
        //$pdf->SetDisplayMode(200);
        // get the article language

        //$pdf->SetFont('Times','',12);
        //$link = $pdf->AddLink();
         //$pdf->Ln(20);
         $pdf->SetTextColor(48,151,209);
         $pdf->Cell(5, 5, '', 0, 1, 'L', false);
        $pdf->Cell(190, 10, 'Table Of Contents : '.$language, 1, 1, 'C');
        
        //$pdf->Line(10,0,10,0);
        $pdf->SetTextColor(0,0,0);
        $pdf->concat2($arraylanguage);
        //dd($arraylanguage);
        //$pdf->useTemplate($tplIdx);
        $pdf->SetTitle('Revue de Presse');
        //$pdf->SetKeywords('Fed, simo harbouj');
        //$page = 1;
        
        //dd($number);
        $start = $number + 1 + 1;
        //$startpage=0;
        //$k = 0
        for ($pageNo = 1; $pageNo <= count($arraylanguage); $pageNo++) { // nombre de documents
            $k++;

            $pageCount = $pdf->setSourceFile($arraylanguage[$pageNo - 1]);
            //$pageCount = $pdf->setSourceFile($value);

            if ($k == 1) {
                $pdf->links[$k]['p'] = $start;
                $startpage = $pageCount + $start;
            } else {
                $pdf->links[$k]['p'] = $startpage ;
                $startpage = $startpage + $pageCount ;
            }

            if (isset($pdf->links[$k])) {
                //$convertedString = iconv('ISO-8859-1', 'UTF-8//IGNORE',);
                // $strp_txt = iconv('UTF-8', 'windows-1252', $titles[$pageNo-1]);
            if($language == "Arabic") {
                $pdf->SetFont('dejavusans', '', 12);
                $pdf->Cell(5, 5, '', 0, 1, 'L', false);
                $pdf->Cell(5, 5, $pdf->links[$k]['p'], 0, 0, 'L', false, $k);
                $pdf->Cell(180, 5, $titles[$keys[$pageNo - 1]], 0, 1, 'R', false, $k);
                
            } else {
                $pdf->Cell(5, 5, '', 0, 1, 'L', false);
                $pdf->Cell(180, 5, $titles[$keys[$pageNo - 1]], 0, 0, 'L', false, $k);
                $pdf->Cell(5, 5, $pdf->links[$k]['p'], 0, 1, 'R', false, $k);
                
            }
            }
        }
        foreach($arraylanguage as $lang)
            array_push($pdfsconcat, $lang);
      }
        //dd($pdfsconcat);
         $pdf->concat($pdfsconcat);
        $pdf->Output('Revue de Presse.pdf', 'D');
    }

    public static function notifyUser($idArticle, $articleTitle, $pdfPath, $client,$articlelanguage) {
      /****************************************************************************************/ 
        // we need to send notification to all concerned client not only the authentified one;
      /***************************************************************************************/
      $users = User::all();
      $Textfields = ['Title','Title_en', 'Title_fr', 'Title_ar' ,'Fulltext','Fulltext_en','Fulltext_fr', 'Fulltext_ar'];
      $query = $client->createSelect();
      $j=0;
      foreach($users as $user) {
        $j++;
        $querySearched="";
    if($user->keywords()->get()->isNotEmpty()) {
    foreach($user->keywords()->get() as $keyword) 
    {
      $querySearched .= '"'.$keyword->name.'" ';
    }
    $keywordsquery = "";

    foreach ($Textfields as $value) {
      $keywordsquery .= $value.":(".$querySearched.") ";
    }
  
    // get a select query instance
   
      $helper = $query->getHelper();
    $query->createFilterQuery('filterkeywords'.$j)->setQuery($keywordsquery);
    $query->createFilterQuery('idfilter'.$j)->setQuery('id:'.$helper->escapePhrase($idArticle));
    $resultset = $client->select($query);
    $resultset->getNumFound();
    if ($resultset->getNumFound() > 0)
    {
      //Redis::publish('all-channel', json_encode($user));
      //echo $user;

      //insert into table News
      DB::table('news')->insert([
        'doc_title' => $articleTitle,
        'doc_path' => $pdfPath,
        'doc_user_id'=> $user->id,
        'article_language' => $articlelanguage
        ]);
      //event(new Alert($user));
    }
  }
    }
}
}
