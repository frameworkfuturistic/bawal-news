<div class="col-lg-4 sidebar" id="sidebar" style="background-color: #f5f5f0;">
    @foreach($sidebar as $widgetName => $widgetData)
        @if ($widgetData['active'] == 'true')
        <x-dynamic-component :component="$themeHelper->getComponentName($widgetName)" page="home" layout="sidebar" :widgetName="$widgetName" :widgetData="$widgetData" :localeId="$localeId"/>
        @endif
    @endforeach
</div>