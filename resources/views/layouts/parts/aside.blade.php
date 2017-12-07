<div class="wrapper">

<nav id="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
      <h3>Collapsible Sidebar</h3>
    </div>

<!-- Sidebar Links -->
    <ul class="list-unstyled components">
      <li class="active"><a href="#">@lang('sidebar.ico_review')</a></li>
      <li><a href="#">@lang('sidebar.calc')</a></li>
      <li><a href="#">@lang('sidebar.bonuses')</a></li>
      <li><a href="#">@lang('sidebar.buy_tokens')</a></li>
      <br>
      <li><a href="#">@lang('sidebar.my_profile')</a></li>
      <li><a href="#">@lang('sidebar.my_wallet')</a></li>
      <li><a href="#">@lang('sidebar.my_transactions')</a></li>
      <li><a href="#">@lang('sidebar.referral')</a></li>
      <li><a href="#">@lang('sidebar.change_pwd')</a></li>
      <li><a href="#">@lang('sidebar.change_email')</a></li>
      <br>
      <li><a href="#">@lang('sidebar.white_book')</a></li>
      <li><a href="#">@lang('sidebar.support')</a></li>
      <li><a href="#">@lang('sidebar.FAQ')</a></li>
      <li><a href="#">@lang('sidebar.community')</a></li>
      <br>
      <li><a href="#">@lang('sidebar.extended_support')</a></li>
      <br>
      <li><a href="#">@lang('sidebar.logout')</a></li>
    </ul>
</nav>

</div>

@push('scripts')
  <script>
	  $(document).ready(function () {

		  $('.sidebar-toggle').on('click', function () {
			  $('aside').toggleClass('active');
			  $('.sidebar-toggle').toggleClass('active');
			  if($('.sidebar-toggle').hasClass('active')){
				  $('.btn-glyph').removeClass('glyphicon-arrow-right');
				  $('.btn-glyph').addClass('glyphicon-arrow-left');
			  } else {
				  $('.btn-glyph').removeClass('glyphicon-arrow-left');
				  $('.btn-glyph').addClass('glyphicon-arrow-right');
        }
		  });


	  });
  </script>
@endpush