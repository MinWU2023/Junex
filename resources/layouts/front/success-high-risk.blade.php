<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inquiry</title>
    {!! app('settings')['setting']->gsg_code !!}
    {!! app('settings')['setting']->head_code !!}
</head>
<body>
{!! app('settings')['setting']->body_code !!}
<style>
    body{background: url(../images/wave.png)no-repeat bottom center;height: 100vh;margin: 0;padding: 0;background-size: contain;background-color:#fbfff6;}
    .n_main{text-align: center;padding-top: 4%;}
    .n_main .img img{max-width:100px;}
    .i_btn a{text-decoration: none;color: #fff;padding: 15px 30px;background:#6bab2b;margin-top: 20px;display: inline-block;border-radius: 4px;overflow: hidden;font-weight: bold;}
    .i_btn a:hover{background: #6bab2b;color: #fff;}
    .i_btn a{position: relative;}
    .i_btn a::before {content: ' '; position: absolute; background:rgba(255,255,255,0.3); width:0; height: 100%; top: 0; left:0; opacity: 0.3; -webkit-transition: all 0.5s ease-out; transition: all 0.5s ease-out; }

    .n_main h1{font-size: 36px;}
    .n_main p{font-size: 18px;}
    .n_main .container{max-width:700px;box-shadow: 0 0 25px rgba(41, 72, 10, 0.18);border-radius:16px;margin: auto;padding:4% 5%;background: #fff;}
    .email{border-radius: 30px;;color: #fff;display:flex;display: -webkit-flex;gap:10px;padding:5px 20px;align-items:center;font-size:24px;font-weight: bold;justify-content: center;background:linear-gradient(to right, #6bab2b 0%,#8cd146 100%);}
    .email img{width: 40px;}
    @media(min-width:1200px){
        .i_btn a:hover:before{ width: 100%;}
    }
    @media(max-height:680px){
        .n_main{text-align: center;padding-top:2%;}
    }
    @media(max-width:768px){
        body{background-size: auto;}
        .n_main .container{box-shadow: none;}
        .n_main h1{font-size: 30px;}
        .n_main p{font-size: 16px;}
        .n_main .img img{max-width:80px;}
    }

</style>

<div class="n_main">
    <div class="container">
        <div class="img"><img src="{{ asset('/images/successful.svg') }}" /></div>
        <h1>Thank You for Your inquiry!</h1>
        <p>{{ __('Please focus on your email') }}<span style="color:#6bab2b"> {{ $email }}</span><br/>{{ __('We will contact you as soon as possible') }}</p>
        <div class="i_btn">
            <a href="javascript:history.back(-1)">RETURN TO PREVIOUS PAGE</a>
        </div>
    </div>
</div>


</body>
</html>
