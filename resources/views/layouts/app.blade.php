<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Example') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fa/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobirise/mobirise.style.css') }}">
    <link href="{{ asset('css/app.css?v='.env('VERSION')) }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:100,300,400|Roboto:100,300,400,500&amp;subset=cyrillic"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="{{ asset('css/styles.css?v='.env('VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/widget.css?v='.env('VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/styles.desktop.css?v='.env('VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/styles.mobile.css?v='.env('VERSION')) }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="app">

  <header>
    <div class="logo-language-container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="http://cryptob2b.io/logo/white_h.png" class="freed-logo-img">
      </a>
      @foreach (Config::get('languages') as $lang => $language)
        @if ($lang != App::getLocale())
          <a class="lang-switcher" href="{{ route('lang.switch', $lang) }}">
            {{ $lang == 'ru' ? 'rus' : 'eng' }}
          </a>
        @endif
      @endforeach

        </div>

        <nav class="navbar navbar-default">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a class="free-brand navbar-brand" href="{{ url('/home') }}">
                <img src="http://cryptob2b.io/logo/white_h.png" class="freed-logo-img">
            </a>

            <div class="collapse navbar-collapse" id="myNavbar">
                <div class="container">
                <a class="close-collapse" href="#" data-action="mobilemenu-close">
                    <img src="{{ asset('img/cross.png') }}"
                         alt="">
                </a>
                <ul class="nav navbar-nav">
                    <li>
                        <a title="Home" href="/">@lang('home/home.home')</a>
                    </li>
                    <li class="dropdown">
                        <a target="_blank" href="http://cryptob2b.io/en/services/">@lang('home/home.services')</a>
                    </li>
                    <li class="dropdown">
                        <a target="_blank" href="http://cryptob2b.io/ico-platform/">@lang('home/home.ico_platform')</a>
                    </li>
                    <li >
                        <a target="_blank" title="Portfolio" href="http://cryptob2b.io/en/portfolio/" >@lang('home/home.portfolio')</a>
                    </li>
                    <li>
                        <a target="_blank" title="Contacts" href="http://cryptob2b.io/en/contacts/" >@lang('home/home.contacts')</a>
                    </li>

                    {!! @file_get_contents('https://freedcoin.io/getGeneratedMenu.php?locale='. app()->getLocale() ) !!}
                    <div class="mobile-additional">
                        <li class="mob-lang-switcher">

                            @foreach (Config::get('languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <a class="lang-switcher" href="{{ route('lang.switch', $lang) }}">
                                        {{ $lang == 'ru' ? 'rus' : 'eng' }}
                                    </a>
                                @endif
                            @endforeach
                        </li>
                    </div>
                </ul>
            </div>
            </div>

        </nav>

    </header>


    @yield('content')

</div>

<script>
    var Jan = '{{ __('app.january_short') }}',
        Feb = '{{ __('app.february_short') }}',
        Mar = '{{ __('app.march_short') }}',
        Apr = '{{ __('app.april_short') }}',
        May = '{{ __('app.may_short') }}',
        June = '{{ __('app.june_short') }}',
        July = '{{ __('app.july_short') }}',
        Aug = '{{ __('app.august_short') }}',
        Sept = '{{ __('app.september_short') }}',
        Oct = '{{ __('app.october_short') }}',
        Nov = '{{ __('app.november_short') }}',
        Dec = '{{ __('app.december_short') }}';

    var January = '{{ __('app.january') }}',
        February = '{{ __('app.february') }}',
        March = '{{ __('app.march') }}',
        April = '{{ __('app.april') }}',
        May = '{{ __('app.may') }}',
        June = '{{ __('app.june') }}',
        July = '{{ __('app.july') }}',
        August = '{{ __('app.august') }}',
        September = '{{ __('app.september') }}',
        October = '{{ __('app.october') }}',
        November = '{{ __('app.november') }}',
        December = '{{ __('app.december') }}';

    var day_0 = '{{ __('app.day_0') }}',
        day_1 = '{{ __('app.day_1') }}',
        day_234 = '{{ __('app.day_234') }}',
        day_default = '{{ __('app.day_default') }}';

    var mycrypto_text1 = '{!! __('home/mycrypto.enter_ethereum_for_both') !!}';
    var mycrypto_text2_0 = '{{ __('home/mycrypto.enter_invest_wallet') }}';
    var mycrypto_text2_1 = '{{ __('home/mycrypto.exch_not_allowed') }}';
</script>

<!-- Scripts -->

<script src="{{ asset('js/jquery.min.3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/app.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/custom-validation.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/mycrypto.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/date_count_down.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/widget.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/vanilla-masker.js?v='.env('VERSION')) }}"></script>
@include('_js.js_custom_validation')

@yield('script')


</body>
</html>
