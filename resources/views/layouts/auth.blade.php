<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Example') }}</title>

  <!-- Styles -->
  {{--@stack('links')--}}
</head>
<body>
<div id="app">
  @include('layouts.parts.header')

  sdfddddddddddddddddd

  @include('layouts.parts.footer')
</div>

@stack('scripts')

</body>
</html>