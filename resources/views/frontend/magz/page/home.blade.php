@extends('frontend.magz.index')

@inject('themeHelper', 'App\Helpers\ThemeHelper')

@section('content')
<section class="home top">
    <div class="container-md">
      {{-- Anil Mishra --}}
      <div class="breaking-news-container">
         <div class="label">
             <span>Breaking News</span>
         </div>
         <div class="news-ticker">
             <ul>
                 <li>Headline 1: Major event happening now!</li>
                 <li>Headline 2: Something significant just happened.</li>
                 <li>Headline 3: Important updates on the current situation.</li>
                 <!-- Add more headlines as needed -->
             </ul>
         </div>
     </div>

      {{-- ================ --}}

      <div class="row">
            @if($sidebarPosition === "left" AND $sidebarActive)
                @include('frontend.magz.template-parts.sidebar')
            @endif
            <div style="background-color: #eff3f6;" class="col-lg-8 col-md-12 col-sm-12 col @if($sidebarActive === false) offset-lg-2 @endif">
                @foreach($body as $widgetName => $widgetData)
                    @if($widgetName != 'bottom_post')
                        @if (Arr::first(Str::of($widgetName)->explode('-')) == 'section')
                            @if ($widgetData['active'] == 'true')
                            <x-dynamic-component :component="$themeHelper->getComponentName($widgetName)" page="home" layout="body" :widgetName="$widgetName" :widgetData="$widgetData['widget']" :localeId="$localeId"/>
                            @endif
                        @else
                            @if ($widgetData['active'] == 'true')
                            <x-dynamic-component :component="$themeHelper->getComponentName($widgetName)" page="home" layout="body" :widgetName="$widgetName" :widgetData="$widgetData" :localeId="$localeId"/>
                            @endif
                        @endif
                    @endif
                @endforeach
            </div>
            @if($sidebarPosition === "right" AND $sidebarActive)
                @include('frontend.magz.template-parts.sidebar')
            @endif
        </div>
    </div>
</section>

@if($bottomPostActive)
    <x-bottom-post :widgetData="$bottomPost" :localeId="$localeId"/>
@endif

@endsection

@push('scripts')
    <script>
        let $target_end=$(".best-of-the-week");
    </script>
@endpush
