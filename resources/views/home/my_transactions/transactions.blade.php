@foreach ($data['transactions'] as $key => $transaction)
        <div class="transaction-container">
        <section class="float-left-box">
            <div class="box">
                <div class="top-box">
                    <span class="id-span">ID => {{ $transaction['tx'] }}</span>
                </div>
                <div class="bottom-box">
                    <span class="from">{{ $transaction['from'] }}</span> => <span class="to">{{ $transaction['to'] }}</span>
                </div>
            </div>
        </section>
        <section class="float-right-box">
             <div class="box">
               <a target="_blank" href="{{ $transaction['url'] or 'https://blockchain.info/' }}">@lang('home/transactions.info')</a>
             </div>
             <div class="box date-box">{{ $transaction['time'] }}</div>
             <div class="box">
               <span class="value">{{ $transaction['value'] }}</span>
               <span class="currency">{{ $transaction['currency'] == 'Token' ?  env('TOKEN_NAME')  : $transaction['currency'] }}</span>
             </div>
       </section>
      </div>
@endforeach

<script>

	var transactions = '{{ $data['transactions'] }}';
	var wallet = '{{ $data['walletFields']["full_name_of_wallet_invest_from"] }}' || 'Ethereum';
	var mt = document.getElementById("myTokens");
	var noWallets = '{{ __('home/transactions.no_wallets_yet') }}';
	var noTransactions = '{{ __('home/transactions.no_transactions_yet') }}';
	var newSpan = document.createElement('span');
	mt.appendChild(newSpan);

  if(transactions.length === 2 && wallet.length === 0){
	  newSpan.appendChild(document.createTextNode(noWallets));
  } else if (transactions.length <= 2) {
	  newSpan.appendChild(document.createTextNode(noTransactions));
  }


</script>


