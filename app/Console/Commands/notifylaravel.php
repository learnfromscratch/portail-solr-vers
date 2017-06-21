<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use JasonLewis\ResourceWatcher\Tracker;
use JasonLewis\ResourceWatcher\Watcher;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use App\Mail\ErrorMails;
use Mail;
class notifylaravel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:laravelnotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $files = new Filesystem;
        $tracker = new Tracker;

        $watcher = new Watcher($tracker, $files);
        $listener = $watcher->watch(public_path().'/Articles');

        $listener->create(function($resource, $path) {
            $doc1 = [];
            $buffer = $this->client->getPlugin('bufferedadd');
            $buffer->setBufferSize(50);
            $this->client->getPlugin('postbigrequest'); 
            if (strtolower(substr($path, strrpos($path, '.') + 1)) == 'xml') 
            {  
                //sleep(1);         
                $xml=simplexml_load_file($path) or die("Error: Cannot create object");

                $i = 0;
                foreach($xml->Record->Field as $keys => $value) {
                    $key = (string) $xml->Record->Field[$i]['name'];
                    $value = (string) $xml->Record->Field[$i];
                    if ($key == 'RevDate' || $key == 'SourceDate') {
                        $time = strtotime($value);
                        $value = date('Y-m-d',$time);
                        //$value =  $newformat;
                        // get the year 2017 -- year : integer
                            // get the month janvier -- mois : string
                                // get the week week 1 -- week : string
                                    // get the day 01-01-2017 -- we already have that

                    }
                    $doc1[$key] = $value;
                    $i++;
                    
                }
                $pdfname = (string) $xml->Record->Document['name'];
                    //$pdfpath = dirname($path)."/".$pdfname;
                    //echo $pdfname. '- ';
                if ($doc1['Source'] != '') {
                    $id_doc = preg_replace(['/_/', '/\s+/'], '', basename($pdfname, '.pdf'));
                    $doc1['id'] = $id_doc;
                    //echo $id_doc .' - ';
                    $pdfname = (string) $xml->Record->Document['name'];
                
                    $pdfpath = dirname($path)."/".$pdfname;
                    $doc1["document"] = $pdfpath;
                    if ($doc1['ArticleLanguage'] == 'ENGLISH') {
                        
                        // count letter of title
                        $count = strlen($doc1['Title']);


                        // delete the count from the fulltext
                        $fulltext = substr($doc1['Fulltext'], $count);

                        $doc1['Fulltext_en'] = $fulltext;
                        $doc1['Title_en'] = $doc1['Title'];
                    }
                    if ($doc1['ArticleLanguage'] == 'FRENCH') {
                        $doc1['Fulltext_fr'] = $doc1['Fulltext'];
                        $doc1['Title_fr'] = $doc1['Title'];
                    }
                    if ($doc1['ArticleLanguage'] == 'Arabic,English') {
                        $doc1['ArticleLanguage'] = 'Arabic';
                        $doc1['Fulltext_ar'] = $doc1['Fulltext'];
                        $doc1['Title_ar'] = $doc1['Title'];
                    }
                    $title = $doc1['Title'];
                    $language = $doc1['ArticleLanguage']; 
                    unset($doc1['Fulltext']);
                    unset($doc1['Title']);
                    $buffer->createDocument($doc1);
                    //array_push($notif, $doc1['id']);
                    $buffer->commit();
                    HomeController::notifyUser($id_doc,$title,$pdfpath,$this->client,$language);
                    echo 'File created: '.$path.PHP_EOL;
                }else {
                     \Mail::to('admin@oxdata.ma')->send(new ErrorMails($path));

                }
            }


        });

        $watcher->start();

    }
}
