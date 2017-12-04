<style>
  .wrapper {
    background-color: rgb(16, 21, 28);
    font-family: Arial sans-serif;
    display: block;
    flex-direction: column !important;
    margin: 0 auto;
    width: 100%;
    min-height: 550px;
  }

  .img-container {
    text-align: center;
    margin: 0 auto;
    background-size: cover;
    width: 55%;
    height: 14%;
    overflow: hidden;
  }

  .img-container img {
    padding: 15px;
    height: 60%;
    width: 60%;
    max-width: 100%;
  }

  .rect {
    margin: 0 auto;
    width: 60%;
    background-color: rgb(22, 28, 38);
    border: 1px solid rgb(84, 84, 84);
  }

  .rect div {
    line-height: 24px;
    padding: 40px 40px;
    color: #ecf0f1;
    font-size: 18px;
  }

  .rect span{
    color: #f39c12;
  }

  .bottom {
    margin: 0 auto;
    width: 60%;
    padding-left: 5%;
    padding-top: 2%;
    font-size: 15px;
    color: #999999;
  }
</style>
<div class="wrapper">
  <div class="img-container">
    <img src="https://cdn1.savepice.ru/uploads/2017/11/14/194bf674fa5353a92349d559f03c2058-full.png"
         alt="194bf674fa5353a92349d559f03c2058-full.png" border="0"/>
  </div>
  <div class="rect">
    <div>Good day <br><br>
      {!! __('home/mails.change_pwd') !!}

    </div>
  </div>

<div class="bottom">
  <p>{!! __('home/mails.do_not_reply') !!}<br>
    {!! __('home/mails.with_us') !!}</p>
  <p><a href="#">support@zabercoin.co.za</a></p>
</div>
</div>