$('body').css('height', $(document).height());

$(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
    $('body').css('height', $('html').height());
    $('body').css('height', $(document).height());
});

if (localStorage.getItem('wallet_msg')) {
    var status_msg = $('.home-status-message');
    status_msg.css('display', 'block');
    status_msg.text(localStorage.getItem('wallet_msg'));
}

//'password has been successfully changed' - message
$('.home-status-message').delay(3000).hide('slow', function () {
    $('.home-status-message').remove();
    localStorage.removeItem('wallet_msg');

});

var second = 58;

function timer() {
    var time = document.getElementById('timer');
    var button = document.getElementById('button');
    if (time) {
        time.innerHTML = second;
        second--;
        if (time.innerHTML == 0) {

            time.style.display = 'none';
            button.classList.remove("repass-btn-dis");
            button.classList.add("repass-btn");
            button.disabled = false;

        } else {

            setTimeout(timer, 1000);
        }
    }
}

// agreement2 page
$(document).ready(function () {

    setTimeout(timer, 1000);
    var flag = true;
    $('#dropdown').click(function () {

        if ($(document).width() < 768) {

            if (flag === true) {
                $('.dropdown-ul').show();
                $(this).animate({marginBottom: '0'}, 150);
            } else {
                $(this).animate({marginBottom: '0'}, 150);
                $('.dropdown-ul').hide();
            }
            flag = !flag;

        } else {

            if (flag === true) {
                $('.dropdown-ul').hide();
            } else {
                $('.dropdown-ul').show();
            }
            flag = !flag;
        }

    });

    $('.close-collapse').click(function () {
        $('.navbar-collapse').attr("aria-expanded", "false");
        $('.navbar-collapse').removeClass("in");
    });


    $('.switch-box-container div').click(function () {
        $('.switch-box-container div').removeClass('active-investment');
        $(this).addClass('active-investment');
        $('#presumptive_investment').val($(this).text());
    });

    // Email validator
    $('input[name^=email]').on('input', function (e) {
        $(this).val($(this).val().toLowerCase().replace(/[^a-z0-9@.+\-_]/g, '').substr(0, 255));
    });
    // Password validator
    $('input[type=password]').on('input', function (e) {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9`\-=_+~!@#$%^&*()|\\,.;:\'\"<>\/?[\]{}]/g, '').substr(0, 255));
    });

    // ETH validator
    function eth_parse(wallet) {
        return (wallet.match(/(0(x([a-fA-F0-9]{0,40})?)?){1}/g, '$0') || [""]).shift();
    }

    function btc_parse(wallet) {
        return (wallet.match(/([13]{1}([1-9A-HJ-NP-Za-km-z]{0,33})?){1}/g, '$0') || [""]).shift();
    }

    $('input[name=wallet_get_tokens]').on('input', function (e) {
        $(this).val(eth_parse($(this).val()));
    });

    //BTC validator
    $('input[name=wallet_invest_from]').on('input', function (e) {
        var cur_wallet_type = 'ETH';
        var active_tab = $('.crypto-currency-container .active-investment');
        if (active_tab) cur_wallet_type = active_tab.data('id');
        switch (cur_wallet_type) {
            case 'BTC':
                $(this).val(btc_parse($(this).val()));
                break;
            case 'ETC':
            default:
                $(this).val(eth_parse($(this).val()));
        }
    });

});




