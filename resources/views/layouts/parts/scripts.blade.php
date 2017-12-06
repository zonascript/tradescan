@include('_js.js_dates')
<script src="{{ asset('js/jquery.min.3.2.1.js') }}"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/script.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/app.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/custom-validation.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/mycrypto.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/date_count_down.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/widget.js?v='.env('VERSION')) }}"></script>
<script src="{{ asset('js/vanilla-masker.js?v='.env('VERSION')) }}"></script>
@include('_js.js_custom_validation')

