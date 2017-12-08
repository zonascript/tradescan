<div class="wrapper row justify-content-center align-items-center">
  <div class="col-1 logo-box">
    <img src="http://cryptob2b.io/logo/white_h.png" alt="your-logo" class="header-logo">
  </div>
  <div class="col menu-box">
    <ul class="row menu-list">
      <li><a href="#">@lang('header.item1')</a></li>
      <li><a href="#">@lang('header.item2')</a></li>
      <li><a href="#">@lang('header.item3')</a></li>
      <li><a href="#">@lang('header.item4')</a></li>
      <li><a href="#">@lang('header.item5')</a></li>
      <li><a href="#">@lang('header.item6')</a></li>
    </ul>
  </div>
  <div class="col-1 lang-box">
    @foreach (Config::get('languages') as $lang => $language)
      @if ($lang != App::getLocale())
        <a class="lang-switcher" href="{{ route('lang.switch', $lang) }}">
          {{ $lang == 'ru' ? 'rus' : 'eng' }}
        </a>
      @endif
    @endforeach
  </div>
  <div class="col burger-box">
    <a href="#" class="btn btn-md">
      <span class="glyphicon glyphicon-menu-hamburger"></span>
    </a>
  </div>
</div>
<div class="mob-menu">
  <ul class="mob-menu-list ">
    <li><a href="#">@lang('header.item1')</a></li>
    <li><a href="#">@lang('header.item2')</a></li>
    <li><a href="#">@lang('header.item3')</a></li>
    <li><a href="#">@lang('header.item4')</a></li>
    <li><a href="#">@lang('header.item5')</a></li>
    <li><a href="#">@lang('header.item6')</a></li>
    <br>
    <li class="mob-lang">@foreach (Config::get('languages') as $lang => $language)
        @if ($lang != App::getLocale())
          <a class="lang-switcher" href="{{ route('lang.switch', $lang) }}">
            {{ $lang == 'ru' ? 'rus' : 'eng' }}
          </a>
        @endif
      @endforeach
    </li>
  </ul>
</div>
@push('scripts')
  <script>
		$(document).ready(function () {

			$('.burger-box a').on('click', function () {
				$('.mob-menu').toggleClass('active');
			});

		});
  </script>
@endpush