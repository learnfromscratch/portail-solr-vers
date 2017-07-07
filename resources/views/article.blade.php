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
        <div class="row col-lg-12">
            <form class="search-form" role="search" action="{{ route('roots') }}" method="get">
                <div class="input-group search">
                    <input type="text" name="data" id="data" placeholder="Recherche" class="form-control input-lg" ng-model="name">
                    <a  class="input-group-addon w3-blue"><i class="fa fa-search fa-fw" aria-hidden="true"></i></a>
                </div>
            </form>
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
            <div class="widget">
        <em class="number-articles">{{ __('Number of articles : ') }}<i>{{ $resultset->getNumFound() }} </i></em>
            @if(!empty($params['data']))
            
            <br><br>
            <select id="comboA" onchange="getComboA(this)" class="form-control">
                @if(!empty($params['sort']) and $params['sort'] == 'pertinence')
                    <option value='pertinence' selected="selected">Relevance</option>
                @elseif(empty($params['sort']) or $params['sort'] != 'pertinence')
                    <option value='pertinence'>Relevance</option>
                @endif

                @if(!empty($params['sort']) and $params['sort'] == 'date')
                    <option value='date' selected="selected">Newest</option>
                @elseif(empty($params['sort']) or $params['sort'] != 'date')
                    <option value='date'>Newest</option>
                @endif
                
            </select>
        @endif
        <div class="themes">
    <h4>Themes</h4><br>
    @foreach($numbers as $subject => $count)
    @if ($count > 0)
                <a href="{{ route('roots', $parameters) }}{{$signs}}theme={{ $subject }}">{{ $subject }}<i>({{$count}})</i></a><br>
                @endif 
    @endforeach

    </div><!-- This is custom facade, so I have to code everything-->
        <div class="keywords">
            @php

                 $user = Auth::user();
            @endphp
        </div>
        <div class="language">       
            <h4>{{ __('Filter by Language :') }}</h4><br>
            @foreach ($facet1 as $value => $count)
                @if (empty($params['language']))
                <a href="{{ route('roots', $params) }}{{$sign}}language={{$value}}">{{ $value}}<i>{{$count}}</i></a><br>
                @elseif ($params['language'] == $value)
                     <p class="actives">
                    {{ $value}}
                     <a href="#" class="closes">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                     </a>
                     
                    </p><br>
                @endif
            @endforeach
        </div>
        <div class="source">  
            <h4>{{ __('Filter by Source :') }}</h4><br>
            @foreach ($facet3 as $value => $count)
               @if (empty($params['source']))

                    <a href="{{ route('roots', $params)}}{{$sign}}source={{$value}}">{{ $value}}</a><i>{{$count}}</i><br>
                 @elseif ($params['source'] == $value)
                    <p class="actives">{{ $value}}<i>{{$count}}</i></p><br>
                @endif
            @endforeach
        </div>
        

        <div class="days">
            <h4>5 Derniers Jours</h4>

            @php $today = date("Y-m-d"); @endphp
            @for($i = 0 ; $i < 5; $i++) 
                @if($i == 0)
                    <a href="{{ route('roots', $params) }}{{$signs}}fromdate={{$today}}"> Aujourd'hui</a><br>
                @elseif ($i == 1)
                    <a href="{{ route('roots', $params) }}{{$signs}}fromdate={{date('Y-m-d', strtotime($today. '  -'.$i.' day' ))}}"> Hier</a><br>
                @else
                    <a href="{{ route('roots', $params) }}{{$signs}}fromdate={{date('Y-m-d', strtotime($today. '  -'.$i.' day' ))}}"> {{date("d-m-Y", strtotime($today. "  -".$i." day" ))}}</a><br>
                     
                @endif
                
            @endfor

        </div>
        <br>
        <div class="calendrier">
        <h4>Calendrier</h4><br>
            <form class="form-inline" method="get" action="{{ route('roots', $params)}}">
               <input type="text" name="fromdate" class="form-control" id="dateinput" placeholder="Calendrier" value="{{$choixdate}}" >
                <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw" aria-hidden="true"></i></button> 

            </form>
            <br>
    </div>
        
        </div>
                <div class="row w3-margin-bottom">
                    <div class="media {{$class}}">
                    <!--
                      <div class="media-left">
                        <img src="https://www.heighpubs.org/articleIcons/0423042031704article-icon[1].png" class="media-object" style="width:90px">
                      </div>
                      -->
                      <div class="media-body">
                        <!--<h4 class="media-heading w3-xlarge">
                            {{ $doc }}
                            {{ $doc_en }}
                            {{ $doc_fr }}
                            {{ $doc_ar }}
                        </h4>
                        -->
                        
                        

                        <p class="text-center">
                            <!--
                            {{ $text }}
                            {{ $text_en }}
                            {{ $text_fr }}
                            {{ $text_ar }} -->
<embed src="{{$pdf1}}#page=1&zoom=150" width="800" height="500">

                            
                        </p>
                        <i>Source : {{ $document->Source }}</i><br>
                        <i>Publié le {{ $date }}</i>
                        <p>
                        Keywords : 
                            @foreach($numbers as $key => $count)
                                <i class="badge"  >{{$key}}({{$count}})</i>
                            @endforeach
                        </p>
                        <a href="{{ $pdf1 }}" target="_blank" class="w3-btn pull-right w3-green">Visualiser pdf</a>
                      </div>
                    </div>
                </div>
        @endforeach

    </div>
@endsection
