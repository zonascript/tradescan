<div class="wrapper row justify-content-center align-items-center">
  <div class="col-1 logo-box">
    <img src="http://cryptob2b.io/logo/white_h.png" alt="your-logo" class="header-logo">
  </div>
  <div class="col menu-box">
    <ul class="row menu-list">
      <li><a href="#"></a>@lang('header.item1')</li>
      <li><a href="#"></a>@lang('header.item2')</li>
      <li><a href="#"></a>@lang('header.item3')</li>
      <li><a href="#"></a>@lang('header.item4')</li>
      <li><a href="#"></a>@lang('header.item5')</li>
      <li><a href="#"></a>@lang('header.item6')</li>
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
</div>
