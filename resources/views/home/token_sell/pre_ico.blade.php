<div class="ico-blade-container">

    @if(!$data['walletFields']['name_of_wallet_invest_from'])
      <p>@lang('home/ico.enter_wallet_to_participate')</p>
    @else
      <p class="appreciate">@lang('home/ico.we_appreciate')</p>
      <p>@lang('home/ico.congrats')</p>

      <ul>
        <li>@lang('home/ico.for_payment_in') {{ $data['walletFields']['name_of_wallet_invest_from'] }} @lang('home/ico.please_use')<br>{{ env('HOME_WALLET_'.$data['walletFields']['name_of_wallet_invest_from']) }}</li>
        <li>@lang('home/ico.sale_id_open')</li>
        <li>@lang('home/ico.current_round') pre-ICO</li>
        @if($data['walletFields']['name_of_wallet_invest_from'] == 'ETH')
          <li>@lang('home/ico.set_gas') 150 000</li>
        @endif
        <li>@lang('home/ico.minimum_payment') {{ env('MIN_PAY_'.$data['walletFields']['name_of_wallet_invest_from']) }} {{ $data['walletFields']['name_of_wallet_invest_from'] }}</li>
        <li>@lang('home/ico.runs_from') <span class="pre-ico-starts"> </span> UTC @lang('home/ico.to') <span class="pre-ico-ends"> </span></li>
        <li>@lang('home/ico.please_do_not') {{ env('MIN_PAY_'. $data['walletFields']['name_of_wallet_invest_from'] ) }} {{ $data['walletFields']['name_of_wallet_invest_from'] }}.</li>
        <li>@lang('home/ico.please_ensure')</li>
      </ul>

      <p class="text-center the-one-wallet"> @lang('home/ico.single_wallet') {{ $data['walletFields']['name_of_wallet_invest_from'] }}: </p>
      <div class="pay-to-us-wallet">
        <img
            src="{{ asset('img/'. $data['walletFields']['name_of_wallet_invest_from'] .'-qr-code.png') }}"
            alt=""
            class="QR-code">
        <p class="wallet-name">{{ env('HOME_WALLET_'.$data['walletFields']['name_of_wallet_invest_from']) }}</p>
      </div>
    @endif
</div>
<br><br><br>
