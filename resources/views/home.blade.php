@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    
   
@endsection

@section('content')
@php //$params['language'] = session('language'); @endphp
    <div class="container-fluid">
        <div class="row col-lg-12">
        
        <form class="search-form" role="search" action="{{ route('roots',$params) }}" method="get">
                <div class="input-group search">
                    <input type="text" value="{{array_key_exists('data',$params) ? $params['data'] : ''}}" name="data"
                           id="data" placeholder="Recherche Initial" class="form-control input-lg" ng-model="name">
                    <button type='submit' class="input-group-addon w3-blue">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>
                    </button>
                    <!-- Button trigger modal -->

                </div>
                <a class="recherche" data-toggle="modal" href="#exampleModal">
                    Recherche Avancée
                </a>
            </form>
            <h1>hello :{{session('language')}}</h1>

        </div>


        @php
            $parameters = [];
            $parameters2 = [];
            $parameters3 = [];
            foreach($params as $key => $parm) {
                $parameters[$key] = $parm;
                $parameters2[$key]=$parm;
                $parameters3[$key]=$parm;
            }
            //dd($parameters);
            $choixdate = '';
            $signs = '?';
            $signs2 = '?';
            $signs3 = '?';
            if(isset($parameters['fromdate']))
            {
                $choixdate = $parameters['fromdate'];
                unset($parameters['fromdate']);
            }
            if(isset($parameters2['language']))
                unset($parameters2['language']);

            if(isset($parameters3['theme']))
            {
                unset($parameters3['theme']);
            }

            if(count($parameters) > 0) {
                $signs = "&";
            }
            

            if(count($parameters2) > 0) {
                $signs2 = "&";
            }


            if(count($parameters3) > 0) {
                $signs3 = "&";
            }

        @endphp
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

        
       
        


        <!-- A voir l'optimisation du Code-->
        @if(!empty($params['start']) and count($params) >= 1)
                @php 
                    $params['start'] = 1; 
                @endphp
        @endif
        @if(!empty($parameters['start']) and count($parameters) >= 1)
                @php 
                    $parameters['start'] = 1; 
                @endphp
        @endif
        @if(!empty($parameters2['start']) and count($parameters2) >= 1)
                @php 
                    $parameters2['start'] = 1; 
                @endphp
        @endif
        @if(!empty($parameters3['start']) and count($parameters3) >= 1)
                @php 
                    $parameters3['start'] = 1; 
                @endphp
        @endif
        <!--
        <div class="row w3-padding-4 w3-margin-bottom w3-blue">
            <h3>{{ __('All Articles : ') }}</h3>
           
        </div>
-->
<!--
    <p>Active Filters : <i class="badge"  >English</i><i class="badge"  >Date <a href="#">x</a></i></p>
-->     <div class="article-widget">
        <div class="widget">
        <em class="number-articles">{{ __('Number of articles : ') }}<i>{{ $resultset->getNumFound() }} </i></em>
            @if(!empty($params['data']) OR !empty($params['noneofthis']) OR !empty($params['allthiswords'])
            OR !empty($params['orwords']))
            
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
        <br>
        <div class="themes">
        <form method="post" action="{{ route('articles.test')}}">
            {{ csrf_field() }}
        <input type="hidden" name="pdf" value="{{serialize($pdfs)}}">
        <input type="hidden" name="titles" value="{{serialize($titles)}}">
        <input type="hidden" name="language" value="{{serialize($languages)}}">

            <button type="submit"  class="w3-btn w3-green download" >{{ __('Exporter la page courante') }}</button>
            
        </form>
    <br><h4>Themes</h4><br>
    @foreach($numbers as $subject => $count)
    @if ($count > 0)
                <a href="{{ route('roots', $parameters3) }}{{$signs3}}theme={{ $subject }}">{{ $subject }}<i>({{$count}})</i></a><br>
                @endif 
    @endforeach

    </div>
        <div class="language">       
            <br><h4>Langue des Articles: </h4><br>
            @foreach ($facet1 as $value => $count)
                
                @if(isset($params['language']) AND $params['language'] == $value)
                     <p class="actives">
                    {{ $value}}
                     <a href="javascript:;" onclick="cancellink('language');"  class="closes">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                     </a>
                     
                    </p>
                @else 
                    <a href="{{ route('roots', $parameters2) }}{{$signs2}}language={{$value}}">{{ $value}}<i>{{$count}}</i></a><br>
                @endif
            @endforeach
        </div>
        <div class="source">  
            <h4>{{ __('Filter by Source :') }}</h4><br>
            @foreach ($facet3 as $value => $count)
               
                @if(isset($params['source']) AND $params['source'] == $value)
                <p class="actives">
                    {{ $value}}
                     <a href="javascript:;" onclick="cancellink('source');"  class="closes">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                     </a>
                     
                    </p>
                    
                @else
                    <a href="{{ route('roots', $params)}}{{$sign}}source={{$value}}">{{ $value}}</a><i>{{$count}}</i><br>
                @endif
            @endforeach
        </div>
        

        <div class="days">
            <h4>5 Derniers Jours</h4>

            @php $today = date("Y-m-d"); @endphp
            @for($i = 0 ; $i < 5; $i++) 
                @if($i == 0)
                    <a href="{{ route('roots', $parameters) }}{{$signs}}fromdate={{$today}}"> Aujourd'hui</a><br>
                @elseif ($i == 1)
                    <a href="{{ route('roots', $parameters) }}{{$signs}}fromdate={{date('Y-m-d', strtotime($today. '  -'.$i.' day' ))}}"> Hier</a><br>
                @else
                    <a href="{{ route('roots', $parameters) }}{{$signs}}fromdate={{date('Y-m-d', strtotime($today. '  -'.$i.' day' ))}}"> {{date("d-m-Y", strtotime($today. "  -".$i." day" ))}}</a><br>
                     
                @endif
                
            @endfor

        </div>
        <br>
        <div class="calendrier">
        <h4>Calendrier</h4><br>
            <form class="form-inline" method="get" action="{{ route('roots', $parameters)}}">
               <input type="text" name="fromdate" class="form-control" id="dateinput" placeholder="Calendrier" value="{{$choixdate}}" >
                <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw" aria-hidden="true"></i></button> 

            </form>
            <br>
    </div>

    
        
        </div>
        
        
<div class="articles">

<div>
            <b>Filtre Active : </b>
            
            @foreach($params as $param => $value)
                @if(!empty($value) AND $param != 'sort' )
                    <span class="filters">
                    
                        @if($param == 'author') 
                            @php $value = urldecode($value); @endphp
                        @endif
                            <span class="param">{{$param}}:</span>  {{$value }}  <a href="javascript:;" onclick="cancellink('{{$param}}');"  class="closes">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                             </a>
                        </span>
                @endif
            @endforeach
            
        </div>
<!--
<form class="search-form form-date" role="search" action="{{ route('roots') }}" method="get">
    <div class="input-daterange input-group ranges" id="datepicker">
        <input type="text" name="fromdate" class="input-sm form-control" value="{{array_key_exists('fromdate',$params) ? $params['fromdate'] : ''}}"  placeholder="Date du Debut" />
        <span class="input-group-addon">to</span>
        <input type="text" name="todate" class="input-sm form-control" placeholder="Date du Fin" value="{{array_key_exists('todate',$params) ? $params['todate'] : ''}}"/>
    </div>
     
     <button class="btn btn-primary input-date"><i class="fa fa-search fa-fw" aria-hidden="true"></i></button>
</form>
-->
<br>

        @php 
            $highlighting = $resultset->getHighlighting(); 
            
            
        @endphp
    
        @foreach ($resultset as $document)
            @php
                $highlightedDoc = $highlighting->getResult($document->id);
                $pdf = $document->document;
               $pdf1 = str_replace('C:\wamp64\www', '', $pdf);
               
                $datesolr = substr($document->SourceDate,0,10);
               $timess = strtotime($datesolr);

               $date = date("d-m-Y", $timess);

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
              
            $class='';
            @endphp

            @if($document->ArticleLanguage ==  "Arabic" AND $date != "14-06-2017" AND $date != "15-06-2017") 
                @php 
                    $class = 'arabic';
                @endphp
            @endif
                <div class="row w3-margin-bottom">
                          
                    <div class="media {{$class}}">
                      <div class="media-left">
                        <img src="{{ asset('img/paper.png') }}" class="media-object" style="width:90px">
                      </div>
                      <div class="media-body">
                     
                        <h4 class="media-heading w3-xlarge">
                        <a href="{{ route('articles.show', ['id' => $document->id]) }}">
                            {!! (count($highlightedDoc->getField($field))) ? implode(' ... ', $highlightedDoc->getField($field)) : $title !!}
                            
                        </a>

                        </h4>
                        @if($class == 'arabic' )
                            <i>{{ $date }} </i> نشر في 
                        @else
                            <i>{{ __('Published on ') }}{{ $date }}</i>
                        @endif
                        <p>
                       
                            {!! (count($highlightedDoc->getField('Fulltext'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext')) : substr($document->Fulltext,0,250) !!}
                            {!! (count($highlightedDoc->getField('Fulltext_en'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_en')) : substr($document->Fulltext_en,0,250) !!}
                            {!! (count($highlightedDoc->getField('Fulltext_fr'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_fr')) : substr($document->Fulltext_fr,0,250) !!}
                            {!! (count($highlightedDoc->getField('Fulltext_ar'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_ar')) : substr($document->Fulltext_ar,0,250) !!} ... <a href="{{ route('articles.show', ['id' => $document->id]) }}" >Voir la suite</a>
                        </p>
                         @php $url = rawurlencode($document->Author); @endphp
                         {{$url}}
                        @if($class == 'arabic' )
                            <i><a href="{{ route('roots', $params)}}{{$sign}}source={{$document->SourceName}}">{{ $document->SourceName }}</a></i> : المصدر<br>
                            
                             <i><a href="{{ route('roots', $params)}}{{$sign}}author={{$document->Author }}">{{ $document->Author }}</a></i> : الكاتب  
                            @if(!empty($params['data']) OR !empty($params['noneofthis']) OR !empty($params['allthiswords']) OR !empty($params['orwords']))
                                <br><i> {{ $document->score }} : التنقيط</i>
                            @endif
                        @else
                            <i>{{ __('Source : ') }}<a href="{{ route('roots', $params)}}{{$sign}}source={{$document->SourceName}}">{{ $document->SourceName }}</a></i><br>
                            
                            <i>{{ __('Author : ') }}<a href="{{ route('roots', $params)}}{{$sign}}author={{$url}}">{{ $document->Author }}</a></i>
                            @if(!empty($params['data']) OR !empty($params['noneofthis']) OR !empty($params['allthiswords']) OR !empty($params['orwords']))
                                <br><i>Score {{ $document->score }}</i>
                            @endif
                        @endif
                        <br><a href="{{ $pdf1 }}" target="_blank" class="w3-btn w3-green">{{ __('View PDF') }}</a>
                      
                      </div>
                    </div>

                </div>
                @php 
                    
                    
                    
                @endphp
        @endforeach
        


        <!--
          <a href="{{ route('articles.test', ['pdf' => $pdfs, 'titles' => $titles, 'language'=> $languages]) }}" target="_blank" 
               class="w3-btn pull-left w3-green download">{{ __('Download PDF') }}</a>
        -->
        @php 
        
            $num = $resultset->getNumFound() / 10;
            $num++;
            $endpag = (int) $num;
        @endphp
      

    @php
        $starts = 1;
        if ($num < 10)
            $end = $endpag;
        else
            $end = 10;
        
      
    if(!empty($request->start)) {
        if($request->start - 5 >= 1) {
            $starts = $request->start - 5;
        }

        if ($request->start + 4 >= 10 ) { 
            $end = $request->start + 4;
        } 
        if ($request->start + 4 > $endpag)
            $end = $request->start + ($endpag - $request->start);

        if ($request->start >= (int) $num) {
            $end = $num;
        }

    }
    @endphp
    
  <nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @for ($i = $starts; $i <= $end; $i++)
            @php $parameters['start'] = $i; @endphp

            @if($request->start == $i)
                <li class="page-item active">
                    <a class="page-link" href="#">{{$i}} <span class="page-link sr-only">(current)</span></a>
                </li>
            @else 
                <li><a href="{{ route('roots', $parameters) }}">{{$i}}</a></li>
            @endif

    @endfor
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>

</div>
</div>
<!--
<div class="widget1">

    <div class="themes">
        <h4>Themes</h4>
        <a href="#" class="big">Sport</a>
        <a href="#" class="small">Education</a>
        <a href="#" class="medium">Fashion</a>
        <a href="#" class="micro">Politique</a>
        <a href="#" class="big">Sport</a>
        <a href="#" class="small">Education</a>
        <a href="#" class="medium">Fashion</a>
        <a href="#" class="micro">Politique</a>
    </div>

    <div class="calendrier">
    <h4>Calendrier</h4><br>
        <form class="form-inline" method="get">
           <input type="text" name="fromdate" class="form-control" id="dateinput" placeholder="Calendrier" value="{{$choixdate}}" >
            <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw" aria-hidden="true"></i></button> 

             
        </form>
    </div>

    
    
</div>
-->
      
    </div>

<script>


    function cancellink(value) {
        window.location = removeURLParameter(window.location.href, value);
    }
    function getComboA(selectObject) {
        var value = selectObject.value;
        
          
        

        window.location =  '?data='+getParameterByName('data')+'&allthiswords='+getParameterByName('allthiswords')+'&noneofthis='+getParameterByName('noneofthis')+'&orwords='+getParameterByName('orwords')+'&language='+getParameterByName('language')+'&sort='+value;
    }
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return '';
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
}

   function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}
</script>

@endsection
