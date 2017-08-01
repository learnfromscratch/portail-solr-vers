<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\ConcatPdf;
use App\Mail\pdfmail;
use App\User;
use Mail;
use App\Theme;
use App\Newsletter;
use App\createpdf;
use App\Repositories\GetKeywords;


class DailyNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily Newsletter to clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(\Solarium\Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // récupérer la date du jour
        $date = date('Y-m-d', strtotime('-5 days'));
       
        $date = '2017-08-10';
        // voir s'il y'a de nouveau mails à envoyer
        $news = Newsletter::where([['date_envoie_newslettre','=', $date],['envoi_newslettre',true]])->get();
        //dd($news->isNotEmpty());
        //dd($news);
        // s'il y'a des mails à envoyer
        if($news->isNotEmpty()) {
            $query = $this->client->createSelect();
            $this->client->getPlugin('postbigrequest');
            $Textfields = ['Title_en', 'Title_fr', 'Title_ar','Fulltext_en','Fulltext_fr', 'Fulltext_ar'];


          foreach ($news as $value) {
            
            if($value->periode_newslettre == 'chaque jour') {
                $fromdate = $date.'T00:00:00Z';
                $dateplus = date('Y-m-d', strtotime('+1 days'));

                $query->createFilterQuery('fromdate')->setQuery('SourceDate:"'.$fromdate.'"');

                $value->date_envoie_newslettre = $dateplus;
                $value->save();
                
            }

            elseif($value->periode_newslettre == 'chaque semaine') {
                // execute range date fromdate->date du jour - 7 to endDate : date du jour : return articles
                $fromdate = date('Y-m-d', strtotime('-6 days')).'T00:00:00Z';
                $todate = date('Y-m-d').'T00:00:00Z';
                $dateplus = date('Y-m-d', strtotime('+7 days'));

                $query->createFilterQuery('fromdate')->setQuery('SourceDate:['.$fromdate.' TO '.$todate.']');

                 $value->date_envoie_newslettre = $dateplus;
                $value->save();
            }

            elseif($value->periode_newslettre == 'chaque mois') {
                $fromdate = date('Y-m-d', strtotime('-29 days')).'T00:00:00Z';
                $todate = date('Y-m-d').'T00:00:00Z';
                $dateplus = date('Y-m-d', strtotime('+30 days'));

                $query->createFilterQuery('fromdate')->setQuery('SourceDate:['.$fromdate.' TO '.$todate.']');

                $value->date_envoie_newslettre = $dateplus;
                $value->save();
            }
            //dd($query);
            //dd($value->user_id)
            
            $user = User::find($value->user_id);
            //dd($user->name);
            if ($user->groupe->id === 1) {
                $themes = Theme::all();
            } 
            elseif ($user->role->name === 'Admin') {
                $themes = $user->groupe->themes;
            }
            
            else {
                $themes = $user->groupe->themes;
            }

            //dd($themes->isNotEmpty());

            if($themes->isNotEmpty()) {
                $pdfs = [];
                $titles = [];
                $languages = [];
                $keywor = new GetKeywords($user);
                       
                $thequery = "";
                // get keywords execute         
                $keywos = $keywor->getKeywordsByThemes($themes);
                //dd($keywos);
                foreach ($Textfields as $values) {
                    $thequery .= $values.':('.$keywos.') ';
                }

                $query->setQuery($thequery);
                $resultset = $this->client->select($query);

                //dd($resultset->getNumFound());
                
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
                // send email
                $downpdf = new createpdf($languages,$pdfs,$titles,$user,$value);
                $downpdf->createpdfs();  
            }
            

            

            // if $value->periode = 'chaque jour'  => update $value->periode = $date + 1
            // 'chaque semaine' => $date + 7
            // 'chaque mois' => $date + 30



          }
       }

    }
}
