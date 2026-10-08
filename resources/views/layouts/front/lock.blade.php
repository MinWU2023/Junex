<div class="top_title container">
    <div class="main clr">
        <p>Banned in mainland China IP, please enter the password!</p>
    </div>

    <div class="main_m clr">
        <div class="fp__special_box_item_icon">
            <p><img src="{{ asset(app('settings')['setting']->logo) }}"></p>
        </div>
        @if ($errors->any())
            <p style="color: red;text-align: center">Password mistake</p>
        @endif
        <div class="main_form">
            <form method="post" action="/lockSubmit">
                @csrf
                <input type="password" name="lock_password" required class="search_txt_a"
                       placeholder="please enter your password">
                <input type="submit" value="Submit" class="search_txt_b">
            </form>
        </div>
    </div>
</div>


<style>
    /*reset*/
    :focus {
        outline: 0;
    }

    body, ul, img, p, input, dl, dd, tr, th, td {
        margin: 0;
        padding: 0;
    }

    em {
        font-style: normal;
    }

    img {
        border: none;
    }

    /*li,ul,ol{list-style:none;}*/
    a {
        text-decoration: none;
        color: #4d4d4d;
    }

    input {
        padding: 0px;
        vertical-align: middle;
        line-height: normal;
        border: none;
    }

    body {
        overflow-x: hidden;
    }

    button::-moz-focus-inner, input[type="reset"]::-moz-focus-inner, input[type="button"]::-moz-focus-inner, input[type="submit"]::-moz-focus-inner, input[type="file"] > input[type="button"]::-moz-focus-inner {
        border: none;
        padding: 0;
    }

    a:focus {
        outline: none;
    }

    /*share*/
    body {
        font-size: 13px;
        color: #4d4d4d;
        background: #fff;
    }

    .bold {
        font-weight: bold;
    }

    .fontRed {
        color: red;
    }

    .clearfix:before, .clearfix:after {
        content: " ";
        display: table;
    }

    .clearfix:after {
        clear: both;
    }

    b, strong {
        font-weight: normal;
    }


    *:link, *:visited, *:hover, *:active, *:focus {
        transition: color .30s linear, background-color .30s linear, border-color .30s linear, opacity .30s linear, background-image .30s linear;
        -webkit-transition: color .30s linear, background-color .30s linear, border-color .30s linear, opacity .30s linear, background-image .30s linear;
    }

    body {
        background: /*#f5f7f9 */ url(/images/bg.png) no-repeat top center
    }


    .main {
        padding-top: 9%
    }

    .main > p {
        text-align: center;
        font-size: 40px;
        font-family: '微软雅黑';
        font-weight: bold;
        _ *
        letter-spacing: 5px;
    }

    .main_m {
        background: rgba(0, 130, 255, .06);
        padding: 64px 20px;
        width: 450px;
        margin: 0 auto;
        border-radius: 6px;
        margin-top: 3%;
        position: relative;
    }

    .fp__special_box_item_icon p {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 100px;
        margin-bottom: 13px;
        top: -13%;
        padding: 15px 30px;
        display: -webkit-flex;
    }

    .fp__special_box_item_icon img {
        max-width: 80%;
    }

    .search_txt_a {
        width: 90%;
        padding: 18px 48px;
        border-radius: 30px;
        margin: 0 auto;
        display: block;
        box-shadow: 0 5px 5px #a2d0fc;
        background: #fff url(/images/icon_a.png) no-repeat 15px center
    }

    .search_txt_b {
        width: 40%;
        padding: 12px 12px;
        border-radius: 24px;
        margin: 0 auto;
        display: block;
        background: linear-gradient(-30deg, #007cf5, #8d7dfe 88%, #8c7cff 0);
        color: #fff;
        box-shadow: 0px 10px 10px 0 rgba(128, 189, 249, 0.3);
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
    }

    .main_form input {
        margin: 30px auto 40px auto;
    }

    @media (max-width: 850px) {
        .main > p {
            font-size: 28px;
        }

        .main_m {
            width: 90%
        }

        .main {
            margin-bottom: 13%;
        }

        .fp__special_box_item_icon p {
            padding: 10px 20px;
            top: -9%;
        }
    }


</style>
