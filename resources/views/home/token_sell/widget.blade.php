<main id="widget">
  <article id="squareAndCurrencies">
    <section id="square">
      <span class="square__live">Crowdsale is live!</span>
      <span class="square__interval">@lang('home/widget.sq_day')<span class="current_day"></span>@lang('home/widget.sq_of')<span class="all_day"></span></span>
    </section>
    <section id="Currencies">
      <nav class="crypto">
        <div class="crypto__box crypto__ETH">
          <img  class="img_ETH crypto__img crypto__currency0_img"
                {{--src="{{ asset('img/eth-icon.png') }}"--}}
                alt="">
          <div class="crypto__currency-container">
            <div class="crypto__currency_val crypto__currency0_val"></div>
            <div class="crypto__currency_name crypto__currency0_name"></div>
          </div>
        </div>

        <div class="crypto__box crypto__BTC">
          <img  class="img_BTC crypto__img crypto__currency1_img"
                {{--src="{{ asset('img/btc-icon.png') }}"--}}
                alt="">
          <div class="crypto__currency-container">
            <div class="crypto__currency_val crypto__currency1_val"></div>
            <div class="crypto__currency_name crypto__currency1_name"></div>
          </div>
        </div>
      </nav>
      <nav class="crypto-progress">

        <span class="crypto_arrow_before before-arrow"></span>
        <div class="crypto-progress__second progress crypto__progress outer crypto__outer">
          <div class="crypto__inner inner"></div>
        </div>
        <span class="crypto_arrow_after after-arrow"></span>

        <span class="crypto-progress__indicator"></span>
      </nav>

      <nav class="real-money">
        <span class="dollar">$</span><span class="first_sum">3 421 321</span><span class="dollar"> of $</span><span class="second_sum">72 000 000</span>
      </nav>
    </section>
  </article>

  <article id="counterAndRounds">

    <section id="counter">
      <p class="counter__title"><span class="i_pi"></span></p>
      <div class="time">
        <div class="time__item time__days"></div>
        <div class="time__item time__hour"></div>
        <div class="time__item time__min"></div>
        <div class="time__item time__sec"></div>
      </div>
    </section>

    <section id="rounds">
      <span class="round_arrow_before before-arrow"></span>
      <div class="rounds__second progress rounds__progress outer rounds__outer">
        <div class="rounds__inner inner"></div>

        <div class="rounds__range rounds__pi-range">
          <div class="rounds__dates">
            <span class="rounds__date rounds__pi-start"></span>
            <span class="rounds__date rounds__pi-end"></span>
          </div>
          <div class="range__shaded pi-range__shaded"></div>
          <div class="range__interval pi-range__interval"></div>
        </div>

        <div class="rounds__range rounds__i-range">
          <div class="rounds__dates">
            <span class="rounds__date rounds__i-start"></span>
            <span class="rounds__date rounds__i-end"></span>
          </div>
          <div class="range__shaded i-range__shaded"></div>
          <div class="range__interval i-range__interval"></div>
        </div>
      </div>
      <span class="round_arrow_after after-arrow"></span>

      <span class="range__shaded_name range__shaded_pi">Pre-ICO</span>
      <span class="range__shaded_name range__shaded_i">ICO</span>
    </section>
  </article>

</main>