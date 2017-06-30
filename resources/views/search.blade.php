@extends ('layouts.template')

@section ('content')

	@php $highlighting = $resultset->getHighlighting(); @endphp

    <div class="mdl-card mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
      <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Recherche: {{ $search }}</h2>
      </div>

      @foreach ($resultset as $document)
        @php
            $highlightedDoc = $highlighting->getResult($document->id);
            $datesolr = substr($document->SourceDate,0,10);
            $timess = strtotime($datesolr);
            $date = date("d-m-Y", $timess);
            $pdf = "./Articles/".$document->document;

            $dir = ""; $lang = "";

            if ($document->ArticleLanguage == "Arabic") {
              $dir = 'rtl'; $lang = 'ar';
            }
        @endphp

		<div class="media mdl-card__supporting-text" dir="{{$dir}}" lang="{{$lang}}">
			<hr>
            <h5>
                <a href="{{ route('articles.show', ['id' => $document->id]) }}" class="mdl-color-text--primary-dark">
                	{!! (count($highlightedDoc->getField('Title_ar'))) ? implode(' ... ', $highlightedDoc->getField('Title_ar')) : $document->Title_ar !!}
                    
                  {!! (count($highlightedDoc->getField('Title_fr'))) ? implode(' ... ', $highlightedDoc->getField('Title_fr')) : $document->Title_fr !!}

                  {!! (count($highlightedDoc->getField('Title_en'))) ? implode(' ... ', $highlightedDoc->getField('Title_en')) : $document->Title_en !!}
                </a><br>
                <small class="mdl-color-text--black"><i>{{ $date }}</i></small>
            </h5>
           {!! (count($highlightedDoc->getField('Fulltext'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext')) : substr($document->Fulltext,0,250) !!}
          
          {!! (count($highlightedDoc->getField('Fulltext_en'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_en')) : substr($document->Fulltext_en,0,250) !!}
          
          {!! (count($highlightedDoc->getField('Fulltext_fr'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_fr')) : substr($document->Fulltext_fr,0,250) !!}
          
          {!! (count($highlightedDoc->getField('Fulltext_ar'))) ? implode(' ... ', $highlightedDoc->getField('Fulltext_ar')) : substr($document->Fulltext_ar,0,250) !!} ...<br><br>
            <a href="{{ route('home.sort', ['data' => 'source='.$document->Source]) }}" class="mdl-color-text--accent">
              <small>{{ $document->Source }}</small>
            </a> / par: 
            <a href="{{ route('home.sort', ['data' => 'author='.$document->Author]) }}" class="mdl-color-text--accent">
              <small>{{ $document->Author }}</small>
            </a>
            <a href="{{ $pdf }}" target="_blank" id="{{$document->id}}" class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons">remove_red_eye</i>
                <div class="mdl-tooltip" data-mdl-for="{{$document->id}}">Voir le pdf</div>
            </a>
        </div>

      @endforeach
      
      <div class="mdl-card__menu">
        <button id="more" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
          <i class="material-icons">more_vert</i>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
            for="more">
          <a href="{{ route('home.sort', ['data' => 'pertinents']) }}" style="text-decoration: none;">
            <li class="mdl-menu__item" >Plus pertinents</li>
          </a>
          <a href="{{ route('home.sort', ['data' => 'récents']) }}" style="text-decoration: none;">
            <li class="mdl-menu__item">Plus récents</li>
          </a>
          <a href="{{ route('home.sort', ['data' => 'anciens']) }}" style="text-decoration: none;">
            <li class="mdl-menu__item">Plus anciens</li>
          </a>
        </ul>
      </div>
    </div>

@endsection