@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
@php
            $parameters = [];
            foreach($params as $key => $parm) {
                $parameters[$key] = $parm;
            }
            //dd($parameters);
            $choixdate = '';
            $signs = '?';
            if(isset($parameters['fromdate']))
            {
                $choixdate = $parameters['fromdate'];
                unset($parameters['fromdate']);
            }

            if(isset($parameters['theme']))
            {
                unset($parameters['theme']);
            }

            if(count($parameters) > 0) {
                $signs = "&";
            }
        @endphp
    <div class="container-fluid">
       <div class="rechercher row">
             <div class="col-md-6 col-md-offset-3">
        
        <form class="search-form" role="search" action="{{ route('roots',$params) }}" method="get">
                <div class="input-group search">
                    <input type="text" value="{{array_key_exists('data',$params) ? $params['data'] : ''}}" name="data"
                           id="data" placeholder="Recherche Initial" class="form-control input-lg" ng-model="name">
                    <button type='submit' class="input-group-addon w3-blue">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>
                    </button>
                    <!-- Button trigger modal -->

                </div>
                    <a class="recherche pull-right" data-toggle="modal" href="#exampleModal">
                    Recherche Avancée
                </a>

                
        </form>
            <!--<h1>hello :{{session('language')}}</h1>!-->

       
        </div>
        
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form action="{{ route('roots') }}" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recherche Avancée</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">All these words:</label>
                                <input data-role="tagsinput" type="text" class="form-control" id="recipient-name" name="allthiswords" value="{{array_key_exists('allthiswords',$params) ? $params['allthiswords'] : ''}}" placeholder='Sépare les mots par virgule (AND)'>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">This exact word or phrase:</label>
                                <input type="text" class="form-control" name="phrase_search" id="recipient-name" placeholder='Put exact words in quotes: "rat terrier"'>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">Any of these words:</label>
            <input type="text" class="form-control " data-role="tagsinput" id="recipient-name" placeholder="Sépare les mots par virgule (OR)" name="orwords" value="{{array_key_exists('orwords',$params) ? $params['orwords'] : ''}}">
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="form-control-label">None of these words:</label>
                                <input type="text" data-role="tagsinput" class="form-control redtags" name="noneofthis" placeholder="Sépare les mots par virgule (exclut)" id="recipient-name" value="{{array_key_exists('noneofthis',$params) ? $params['noneofthis'] : ''}}">

    
                            
                            </div>

 
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Recherche Avancé</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="row col-lg-12">
            <hr class="w3-blue w3-text-blue hr-search" />
        </div>

        
        <div class="row w3-margin-bottom">
        </div>
        
        
        @php 
        $highlighting = $resultset->getHighlighting(); 
          $array = $resultset->getDocuments();
          $mom = $array[0]->getFields();
        @endphp
       <!--  {{$array[0]->getFields()['id']}}-->
        @foreach ($resultset as $document)

            @php
            
                $highlightedDoc = $highlighting->getResult($document->id);
                $pdf = $document->document;
                $pdf1 = str_replace('C:\wamp64\www', '', $pdf);
                $datesolr = substr($document->SourceDate,0,10);

                $date = date("d-m-Y", strtotime($datesolr));
                $dateme = date("d-m-Y", strtotime($datesolr." +3 month" ));
                $datenow = date("d-m-Y", strtotime('now'));
                
                $date3mois = new DateTime($dateme);
                $datenows = new DateTime($datenow);

            @endphp
            <!--
            date source : <strong>{{$date}} </strong> <br>
            date source + 3 mois :<strong> {{$dateme}} </strong> <br>
            date du jour :<strong>{{$datenow}}</strong>
            -->
            @php
            if ($datenows > $date3mois) {
                $doc_ar = substr($document->Title_ar,0,300);
                $doc_fr = substr($document->Title_fr,0,300);
                $doc_en = substr($document->Title_en,0,300);
                $doc = substr($document->Title,0,300);

                $text_ar = substr($document->Fulltext_ar,0,300);
                $text_fr = substr($document->Fulltext_fr,0,300);
                $text_en = substr($document->Fulltext_en,0,300);
                $text = substr($document->Fulltext,0,300);
              }
              
              else {
                $doc_ar = $document->Title_ar;
                $doc_fr = $document->Title_fr;
                $doc_en = $document->Title_en;
                $doc = $document->Title;

                $text_ar = $document->Fulltext_ar;
                $text_fr = $document->Fulltext_fr;
                $text_en = $document->Fulltext_en;
                $text = $document->Fulltext;
            }
            $class = '';
            @endphp
               <!-- 
               {{$dateme}} <br>
               {{$date}} 
               -->
                @if($document->ArticleLanguage ==  "Arabic") 
                @php 
                    $class = 'arabic';
                @endphp
            @endif
            
                <div class="row w3-margin-bottom">
                    <div class="media {{$class}}">
                    <!--
                      <div class="media-left">
                        <img src="https://www.heighpubs.org/articleIcons/0423042031704article-icon[1].png" class="media-object" style="width:90px">
                      </div>
                      -->
                      <div class="media-body">
                       
                        
                        <div style=" text-align:left; width: 85%;">
                            <div style=" float: left;">
                                <i>Source : {{ $document->SourceName }}</i><br>
                                <i>Publié le {{ $date }}</i>
                                <p>
                                Keywords : 
                                    @foreach($numbers as $key => $count)
                                        <i class="badge"  >{{$key}}({{$count}})</i>
                                    @endforeach
                                </p>
                            </div>
                            <a href="{{ $pdf1 }}" target="_blank" class="w3-btn pull-right w3-green">Visualiser pdf</a>
                        </div>

                       
<div style="clear:both;">
                            <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Texte Structué</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Texte brute</a></li>
    
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
               @php $zoom = 125;@endphp
    <object type="application/pdf" data="{{$pdf1}}#zoom=135" style="width:1000px; height:1000px;">
        alt : <a href="{{$pdf1}}">veuillez téléchargez un navigate</a>
    </object>
    </div>

    <div role="tabpanel" class="tab-pane" id="profile"> 
    <br>
         <h4 class="media-heading w3-xlarge">
                            {{ $doc }}
                            {{ $doc_en }}
                            {{ $doc_fr }}
                            {{ $doc_ar }}
                        </h4>
        <br>                
        <p style="float:left; text-align:left;">
                          <pre>  
                            {{ $text }}
                            {{ $text_en }}
                            {{ $text_fr }}
                            {{ $text_ar }}
                            </pre> 
        </p>
    </div>
    
  </div>
     </div>                   

     
                 
                        
                      </div>
                    </div>
                </div>
        @endforeach
 
    </div>
@endsection
