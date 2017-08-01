<?php
 namespace App;

use App\ConcatPdf;
use App\Mail\pdfmail;

 class createpdf
{

 	public function __construct($languages, $pdfs, $titles,$user,$newslettre)
    {
        $this->languages = $languages;
        $this->pdfs = $pdfs;
        $this->titles = $titles;
        $this->user = $user;
        $this->email = $newslettre->email;
    }

    public function createpdfs() {

        //dd($pdfs);
        $pdfsconcat = [];

        $start = 0;
        $f = 0;
        $k = 0;
        $pdf = new ConcatPdf;
        
        //$pdf->SetCompression(true);
        //dd($request->language);
        $pdf->addPage();
         

        //$pdf->Image('https://opensource.org/files/twitterlogo.png',60,30,90,0,'PNG');
        $pdf->Image(public_path().'/img/oxdata.jpg',60,30,90,0);
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
        $countlanguage = count(array_unique($this->languages));
        $counttitles = $countlanguage + count($this->pdfs);
       $j = 0;
        if(count($this->pdfs) == 21 and count(array_unique($this->languages)) == 3){
            $j = 1;
            }

        $number = (int) ceil($counttitles / 24) + $j;
        //dd($number);
        foreach(array_unique($this->languages) as $language) {
            $arraylanguage = [];
        $keys = array_keys($this->languages, $language);
        //dd($$$this->languages);
        foreach($keys as $key)
            array_push($arraylanguage, $this->pdfs[$key]);
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
                $pdf->Cell(180, 5, $this->titles[$keys[$pageNo - 1]], 0, 1, 'R', false, $k);
                
            } else {
                $pdf->Cell(5, 5, '', 0, 1, 'L', false);
                $pdf->Cell(180, 5, $this->titles[$keys[$pageNo - 1]], 0, 0, 'L', false, $k);
                $pdf->Cell(5, 5, $pdf->links[$k]['p'], 0, 1, 'R', false, $k);
                
            }
            }
        }
        foreach($arraylanguage as $lang)
            array_push($pdfsconcat, $lang);
      }
        //dd($pdfsconcat);
         $pdf->concat($pdfsconcat);
         $date = date('d-m-Y');
         $pdf->Output(public_path().'\mailedPdfs\Revue de Presse_'.$date.'_'.$this->user->name.'_.pdf', 'F');
         
         \Mail::to($this->email)->send(new pdfmail('http://localhost\portail\public\mailedPdfs\Revue de Presse_'.$date.'_'.$this->user->name.'_.pdf', $this->user->name));
    }

}