@extends('layouts.app')




@section('content')
  <div class="home-body">
      <span class="home-status-message"></span>
    <section class="upper-part">
      <h3>@lang('home/home.my_profile')</h3>

    <p class="your-entered-as"> @lang('home/home.logged_in_as') <span>{{ obfuscate_email(Auth::user()->email) }}</span></p>
    <div class="option-container">
      <a href="{{ route('change_email') }}"> @lang('home/home.change_email')</a>
      <a href="{{ route('change_password') }}"> @lang('home/home.change_password')</a>
      <a href="{{ route('logout') }}"><i class="fa fa-times" aria-hidden="true">&nbsp;</i> @lang('home/home.log_out')</a>
    </div>
    <a class="suggest-invest-container-link" href="{{ route('mycrypto') }}">
    <div class="suggest-investment-container">
      <p class="gonna-invest">
        @lang('home/home.want_purchase')<span class="temp-gray-span">{{ $data['walletFields']["name_of_wallet_invest_from"] or  __('home/home.currency_is_not_set') }}</span> @lang('home/home.wallet_address')<br> <span class="temp-gray-span">{{ $data['walletFields']["wallet_invest_from"] or __('home/home.not_set') }}</span>

          </p>
          <p class="wonna-get-tokens">
            @lang('home/home.want_to_get_ERC20') <span class="temp-gray-span">{{ $data['walletFields']["wallet_get_tokens"] or __('home/home.not_set')}}</span>
          </p>
        </div>
      </a>
      <a class="reusable-btn change-btn" href="{{ route('mycrypto') }}">@lang('home/home.change_btn')</a>
    </section>
    <section class="bottom-part">
      <ul class="nav nav-tabs freed-tabs">
        <li class="active"><a data-toggle="tab" href="#tokenSell">@lang('home/home.token_sale')</a></li>
        <li ><a data-toggle="tab" href="#myTokens">@lang('home/home.my_transactions')</a></li>
      </ul>
      <div class="tab-content">
        <div id="tokenSell" class="tab-pane fade in active">

          @includeWhen($data['widget_data'] ,'home.token_sell.widget')

          @includeWhen($data["period"] == "pre_ico" ,'home.token_sell.pre_ico')
          @includeWhen($data["period"] == "ico",'home.token_sell.ico')
          @includeWhen($data["period"] == "out",'home.token_sell.out_of_ico')
        </div>
        <div id="myTokens" class="tab-pane fade">
          @include('home.my_transactions.transactions')

        </div>
      </div>
    </section>
    @if(Auth::user()->affiliate_id)
      {{--      <p>{{url('/register').'?ref='.Auth::user()->affiliate_id}}</p>--}}
    @endif
  </div>

  <script>
	  localStorage.setItem('data-id', '{{ $data['walletFields']["name_of_wallet_invest_from"] }}' || 'ETH');
	  localStorage.setItem('current-currency', '{{ $data['walletFields']["name_of_wallet_invest_from"] }}' || 'ETH');
	  if(document.referrer.indexOf('/agreement2') !== -1){
		  history.pushState(null, null, document.URL);
		  window.addEventListener('popstate', function () {
			  history.pushState(null, null, document.URL);
		  });
	  }

  </script>
@endsection
@section('script')
  <script>




	  var data = {!! $data['widget_data'] !!};
	  [].forEach.call(data.currencies, function(v,i,a) {
		  wid_obj['currency'+ i +'_val'].html(v.value.toFixed(2));
		  wid_obj['currency'+ i +'_name'].html(v.name);
		  wid_obj['currency'+ i +'_img'].attr('src', v.img);
	  });


	  wid_obj.day.attr('data-content','{{__('home/widget.count_day')}}');
	  wid_obj.hour.attr('data-content','{{__('home/widget.count_hour')}}');
	  wid_obj.min.attr('data-content','{{__('home/widget.count_min')}}');
	  wid_obj.sec.attr('data-content','{{__('home/widget.count_sec')}}');

	  wid_obj.currency0_val.html(Math.floor(wid_obj.currency0_val.text()));
	  wid_obj.pi_range.width(data['pre-ICO_width']);
	  wid_obj.i_range.width(data['ICO_width']);
	  wid_obj.pi_range_indicator.css({'left': parseInt( data['pre-ICO_width'] ) +'%'});
	  wid_obj.i_range_indicator.css({'right': parseInt( data['ICO_width'] ) /2 - 2 +'%'});
	  wid_obj.crypto_percentage = wid_obj.logb((parseInt(data['crypto_progress_percents'])+8.1)/8,20)*110 + '%';

	  wid_obj.crypto_inner.width(wid_obj.crypto_percentage);
	  wid_obj.crypto_arrow_before.css({'left':'calc('+ wid_obj.crypto_percentage +' - 3px)'});
	  wid_obj.crypto_arrow_after.css({'left':'calc('+ wid_obj.crypto_percentage +' - 3px)'});

	  wid_obj.crypto_indicator.html(data['crypto_progress_percents']);
	  wid_obj.crypto_indicator.css({'left': 'calc('+ wid_obj.crypto_percentage +' + 1%)'});

	  if(parseInt(data['crypto_progress_percents'],10) > 93){
		  wid_obj.crypto_indicator.css({
			  'left' : 'calc('+ data['crypto_progress_percents'] +' -  8%)',
			  'color':'#dbdbdc'
		  });
	  }

	  if(parseInt(wid_obj.crypto_inner.widthPerc(),10) > parseInt("100%",10)) {
		  wid_obj.crypto_inner.width("100%");
		  wid_obj.crypto_arrow_before.css({'left':'calc('+ wid_obj.crypto_percentage +' - 3px)'});
		  wid_obj.crypto_arrow_after.css({'left':'calc('+ wid_obj.crypto_percentage +' - 3px)'});
		  wid_obj.crypto_indicator.css({
			  'left' : 'calc(100% -  8%)'
		  });
	  }

	  wid_obj.first_sum.html(data['invested'].toLocaleString());
	  wid_obj.second_sum.html(data['invest_cap'].toLocaleString());

	  var pre_ico_start = parseInt('{{ env('PRE_ICO_START') }}',10)*1000,
		  pre_ico_end = parseInt('{{ env('PRE_ICO_END') }}',10)*1000,
		  pre_ico_length = pre_ico_end - pre_ico_start,
		  ico_start = parseInt('{{ env('ICO_START') }}',10)*1000,
		  ico_end  = parseInt('{{ env('ICO_END') }}',10)*1000,
		  ico_length = ico_end - ico_start,
		  current_round,
		  diff,
		  time = '{{$data['time']}}' ? parseInt('{{$data['time']}}')*1000 : Date.now(),
	    nextRoundStart = time > pre_ico_start ? ico_start : pre_ico_start;

	  if(time < pre_ico_start){ //before pre-ICO
		  roundSlider('before');
		  wid_obj.first_article.hide();
		  wid_obj.second_article.show();
		  wid_obj.counter_title.html('{{__('home/widget.the_end_ICO')}}');
		  diff = pre_ico_start - time;
		  current_round = 'Pre-ICO';
		  wid_obj.counter_title.html(current_round +' {{__('home/widget.starts_in')}}');

	  } else if (pre_ico_start < time && time < pre_ico_end){ //pre-ICO
		  roundSlider('p-i');
		  wid_obj.first_article.css('display','flex');
		  wid_obj.second_article.show();
		  current_round = 'Pre-ICO';
		  diff = pre_ico_end - time;
		  wid_obj.currentDay.html(daysInUTC(pre_ico_length) - daysInUTC(diff));
		  wid_obj.allDay.html(Math.floor( pre_ico_length / (1000*60*60*24) ));
		  wid_obj.is_live.html('{{__('home/widget.isLive')}}');
		  wid_obj.counter_title.html('{{__('home/widget.the_end')}}'+ current_round +'{{__('home/widget.the_end_in')}}');

	  } else if (pre_ico_end < time && time < ico_start){ //between pre-ICO and ICO
		  roundSlider('between');
		  wid_obj.first_article.hide();
		  wid_obj.second_article.show();
		  current_round = 'out-of-ICO';
		  diff = nextRoundStart - time;
		  wid_obj.is_live.html('{{__('home/widget.isClosed')}}');
		  wid_obj.interval.html('{{__('home/widget.open_soon')}}');
		  wid_obj.counter_title.html('{{__('home/widget.the_begin_ICO')}}');

	  } else if (ico_start < time && time < ico_end){ // ICO
		  roundSlider('i');
		  wid_obj.first_article.css('display','flex');
		  wid_obj.second_article.show();
		  current_round = 'ICO';
		  diff = ico_end - time;
		  wid_obj.currentDay.html(daysInUTC(ico_length) - daysInUTC(diff));
		  wid_obj.allDay.html(Math.floor(ico_length / (1000*60*60*24) ));
		  wid_obj.is_live.html('{{__('home/widget.isLive')}}');
		  wid_obj.counter_title.html('{{__('home/widget.the_end')}}'+ current_round +'{{__('home/widget.the_end_in')}}');

	  } else if(time > ico_end){ //finish
		  roundSlider('finish');
		  wid_obj.first_article.css('display','flex');
		  wid_obj.second_article.hide();
		  current_round = 'out-of-ICO';
		  diff = nextRoundStart - time;
		  wid_obj.is_live.html('{{__('home/widget.isFinished')}}');
		  wid_obj.interval.html('{{__('home/widget.tnx')}}');
	  }

	  wid_obj.pi_start.html(wid_obj.getSmallDate(pre_ico_start));
	  wid_obj.pi_end.html(wid_obj.getSmallDate(pre_ico_end));
	  wid_obj.pi_interval.html(daysInUTC(pre_ico_end - pre_ico_start) + '{{ __('home/widget.days') }}');
	  wid_obj.i_start.html(wid_obj.getSmallDate(ico_start));
	  wid_obj.i_end.html(wid_obj.getSmallDate(ico_end));
	  wid_obj.i_interval.html(daysInUTC(ico_end - ico_start) + '{{ __('home/widget.days') }}');

	  obj.ico_starts.html(obj.getFullDate(ico_start));
	  obj.ico_ends.html(obj.getFullDate(ico_end));
	  obj.pre_ico_starts.html(obj.getFullDate(pre_ico_start));
	  obj.pre_ico_ends.html(obj.getFullDate(pre_ico_end));
	  obj.starts.html(obj.getFullDate(nextRoundStart));
	  obj.round.html(current_round);
	  updateWidgetTime(diff);
	  setInterval( updateWidgetTime, 1000 );

	  function roundSlider(round){
		  switch(round){
			  case 'before':
			  	if(daysInUTC(pre_ico_start - time) > 8){
					  wid_obj.i_inner.width('0%');
					  wid_obj.round_arrow_before.css({'left':'calc(0% - 3px)'});
					  wid_obj.round_arrow_after.css({'left':'calc(0% - 3px)'});
          } else {
					  wid_obj.i_inner.width(new Date(time).getUTCDate()*15 / new Date(pre_ico_start).getUTCDate()+'%');
					  wid_obj.round_arrow_before.css({'left':'calc('+ new Date(time).getUTCDate()*15 / new Date(pre_ico_start).getUTCDate()+'% - 3px)'});
					  wid_obj.round_arrow_after.css({'left':'calc('+ new Date(time).getUTCDate()*15 / new Date(pre_ico_start).getUTCDate()+'% - 3px)'});
          }
				  break;
			  case 'p-i':
				  interval = daysInUTC(pre_ico_end - pre_ico_start);
				  now_left = daysInUTC(pre_ico_end - time);
				  percent_val = 20 / interval;
				  between_val = 15 + (interval - now_left)*percent_val;
				  wid_obj.i_inner.width(between_val + '%');
				  wid_obj.round_arrow_before.css({'left':'calc('+ between_val +'% - 3px)'});
				  wid_obj.round_arrow_after.css({'left':'calc('+ between_val +'% - 3px)'});
				  break;

			  case 'between':
				  var interval = daysInUTC(ico_start - pre_ico_end);
				  var now_left = daysInUTC(ico_start - time);
          var percent_val = 15 / interval;
				  var between_val = 35 + (interval - now_left)*percent_val;
				  wid_obj.i_inner.width(between_val + '%');
				  wid_obj.round_arrow_before.css({'left':'calc('+ between_val +'% - 3px)'});
				  wid_obj.round_arrow_after.css({'left':'calc('+ between_val +'% - 3px)'});
				  break;

			  case 'i':
          interval = daysInUTC(ico_end - ico_start);
          now_left = daysInUTC(ico_end - time);
          percent_val = 50 / interval;
          between_val = 50 + (interval - now_left)*percent_val;

				  wid_obj.i_inner.width(between_val + '%');
				  wid_obj.round_arrow_before.css({'left':'calc('+ between_val +'% - 3px)'});
				  wid_obj.round_arrow_after.css({'left':'calc('+ between_val +'% - 3px)'});
				  break;

			  case 'finish':
				  wid_obj.i_inner.width('100%');
				  wid_obj.round_arrow_before.css({'left':'calc(100% - 3px)'});
				  wid_obj.round_arrow_after.css({'left':'calc(100% - 3px)'});
				  break;
			  default:
				  break;
		  }
	  }


  </script>
@endsection