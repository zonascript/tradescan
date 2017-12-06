<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Example') }}</title>

@include('layouts.parts.links')
    <!-- Styles -->
</head>
<body>
  <header class="container-fluid">
    @include('layouts.parts.header')
  </header>
<div class="app">

  <div class="container-fluid wrapper">
    <div class="row">
      <aside class="col-2">
        {{--@include('layouts.parts.aside')--}}
      </aside>
      <main class="col">
        @yield('content')
      </main>
    </div>
  </div>

</div>

  <footer class="footer">
    @include('layouts.parts.footer')
  </footer>

  @include('layouts.parts.scripts')

@stack('scripts')
</body>
</html>
