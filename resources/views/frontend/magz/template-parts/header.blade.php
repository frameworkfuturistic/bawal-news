@inject('images', 'App\Helpers\ImageHelper')

<div class="firstbar">
    <div class="container-md">
        <div class="row">
            <div class="hidden-xs col-md-3 col-sm-12">
                <div class="brand" style="margin-top: -10px;">
                    <a href="/">
                        <img class="logo_dark" src="{{ $images->webLogoLight() }}" alt="Web Logo" width="200" height="63">
                        <img class="logo_light" src="{{ $images->webLogoDark() }}" alt="Web Logo" width="200" height="63">
                    </a>
                </div>
            </div>

            <div class="col-md-9 col-sm-12">
               <img src="{{ \App\Helpers\ImageHelper::headerBanner() }}" alt="BAWAL NEWS" width="400" height="100">
               {{-- <h1 class=" text-white" style="font-size: 6em;">Bawal News</h1>
               <p class="lead text-white">Stay updated with the latest headlines.</p> --}}
            </div>


            {{-- <div class="col-md-6 col-sm-12">
                <form action="{{ route('search') }}" method="GET" class="search" autocomplete="off">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="{{ __('Laramagz::magz.type_something_here') }}">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary" aria-label="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>
</div>

<!-- Start nav -->
<x-menu-header :localeId="$localeId"/>
<!-- End nav -->
