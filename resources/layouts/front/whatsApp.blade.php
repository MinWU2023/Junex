{{--<script type="text/javascript" src="{{ mix('/js/admin/admin.newjquery.min.js') }}"></script>--}}

@if(ismobile())
<style>
    #whatsapp_more {
        z-index: 99999999;
        position: fixed;
        left:15px;
        bottom: 90rem;
        font-size: 13px;
    }

    @media screen and (max-width: 769px) {
        #whatsapp_more {
            right: 5px;
            bottom: 90px;
            left: 5px;
        }

        #onlineService_2 {
            width: 100%;
            max-height: 400px;
            overflow-y: auto !important;
        }

        #whatsapp_tabs #floatShow_2 p {
            width: 120px;
            padding: 8px 8px;
        }

    }
    #onlineService_2 .li a .icon svg{width:20px!important;height:20px!important;}
    #onlineService_2 .title svg{width: 70px!important;height: 70px!important;}
    #onlineService_2 .title{padding: 10px 20px!important;}
    #onlineService_2 .li a{margin-bottom: 10px!important;}
    #onlineService_2 .li a{background-size: 20px 20px!important;}
</style>
@else
<style>
    #whatsapp_more {
        z-index: 99999999;
        position: fixed;
         left:15px;
        bottom: {{app('settings')['setting']->whatsapp_bottom}}rem;
        font-size: 13px;
    }



    @media screen and (max-width: 769px) {
        #whatsapp_more {
            right: 5px;
            bottom: 68px;
            left: 5px;
        }

        #onlineService_2 {
            width: 100%;
            max-height: 400px;
            overflow-y: auto !important;
        }

        #whatsapp_tabs #floatShow_2 p {
            width: 120px;
            padding: 8px 8px;
        }

    }
</style>
@endif
<style>
    #floatShow_2 {
        display: block;
    }

    #floatHide_2 {
        display: none;
    }

    #whatsapp_tabs {
        position: relative;
        z-index: 9;
        width: 50px;
        height: 50px;
        position: absolute;
        left: 0;
        bottom: 0;
        background: #55CD6C;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #whatsapp_tabs #floatShow_2 {
        line-height: 50px;
        position: relative;
        color: #fff;
        font-size: 13px;
        text-transform: capitalize;
        transition: all .4s ease;
        width: 100%;
        height: 100%;
        display: block;

    }

    #whatsapp_tabs #floatShow_2 svg {
        width: 30px;
        height: 30px;
        fill: #fff;
        margin-top: 10px;
        margin-left: 10px;
        transition: all .4s ease;
    }

    #whatsapp_tabs #floatShow_2 p {
        background-color: #f5f7f9;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        color: #43474e;
        font-size: 14px;
        letter-spacing: -.03em;
        line-height: 1.5;
        margin-right: 7px;
        padding: 8px 12px;
        position: absolute;
        left: 120%;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        transition: all 0 ease;
        -webkit-transition: all .4s ease;
        -moz-transition: all .4s ease;
        width: 156px;
        font-weight: 600;
        margin: 5;
    }

    #whatsapp_tabs #floatShow_2:hover {
        margin-right: 0;
    }

    #whatsapp_tabs #floatHide_2 {
        height: 100%;
        color: #fff;
        width: 100%;
        border-radius: 50%;
        text-align: center;
        position: absolute;
        transition: all .4s ease;
        display: block;
        opacity: 0;
    }

    /* #whatsapp_tab #floatHide2:after{border-radius: 0;color:#999;font-size:20px; content: "\f00d";color: #fff; line-height: 50px;} */
    #whatsapp_tabs #floatHide_2:after {
        content: '';
        width: 20px;
        height: 3px;
        background: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) rotate(45deg);
    }

    #whatsapp_tabs #floatHide_2:before {
        content: '';
        width: 20px;
        height: 3px;
        background: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) rotate(-45deg);
    }

    #whatsapp_tabs #floatShow_2:hover,
    #whatsapp_tabs #floatHide_2:hover {
        text-decoration: none;
    }

    #onlineService_2 {
        display: inline;
        width: 350px;
        display: none;
        font-size: 14px;
        border-top: none;
        margin-bottom: 70px;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgba(0, 0, 0, 0.15) 0px 5px 30px 0px, rgba(0, 0, 0, 0.05) 0px 3px 3px 0px;
        border-radius: 5px;
        background: #f9fafa;
    }

    #onlineService_2 .li em {
        font-style: normal;
    }

    a {
        text-decoration: none;
        color: #000;
    }

    #onlineService_2 .li a {
        display: flex;
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NzguMTY1IDQ3OC4xNjUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ3OC4xNjUgNDc4LjE2NSIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMiIgaGVpZ2h0PSI1MTIiPjxwYXRoIGQ9Ik00NzguMTY1IDIzMi45NDZjMCAxMjguNTY3LTEwNS4wNTcgMjMyLjk2Ni0yMzQuNjc5IDIzMi45NjYtNDEuMTAyIDAtNzkuODE0LTEwLjU5OS0xMTMuNDQ1LTI4Ljk2OUwwIDQ3OC4xNjVsNDIuNDM3LTEyNS4wNGMtMjEuNDM4LTM1LjA2NS0zMy43Ny03Ni4yMDctMzMuNzctMTIwLjE1OUM4LjY2NyAxMDQuMzQgMTEzLjc2MyAwIDI0My40ODUgMGMxMjkuNjIzIDAgMjM0LjY4IDEwNC4zNCAyMzQuNjggMjMyLjk0NnpNMjQzLjQ4NSAzNy4wOThjLTEwOC44MDIgMC0xOTcuNDIyIDg3LjgwMy0xOTcuNDIyIDE5NS44NjggMCA0Mi45MTUgMTMuOTg2IDgyLjYwMyAzNy41NzYgMTE0Ljg3OWwtMjQuNTg2IDcyLjU0MiA3NS44NDktMjMuOTY4YzMxLjEyMSAyMC40ODEgNjguNDU3IDMyLjI5NiAxMDguNTgzIDMyLjI5NiAxMDguNzIzIDAgMTk3LjMyMy04Ny44NDMgMTk3LjMyMy0xOTUuOTA4IDAtMTA3Ljg4Ni04OC42LTE5NS43MDktMTk3LjMyMy0xOTUuNzA5ek0zNjEuOTMxIDI4Ni42MmMtMS4zOTUtMi4zMzEtNS4yMi0zLjc0Ni0xMC44OTgtNi44MTQtNS45MTctMi44NDktMzQuMDg5LTE2LjQ5Ny0zOS41MDgtMTguMzctNS4xNi0xLjkxMy04Ljk4Ni0yLjg0OS0xMi44MTEgMi44MjktNC4wMDUgNS42MzgtMTQuOTAzIDE4LjYyOS0xOC4yMyAyMi4zNTQtMy41NDYgMy43ODUtNi44NTQgNC4yNjQtMTIuNTUyIDEuNDM1LTUuNjE4LTIuODA5LTI0LjI2Ny04Ljg2Ni00Ni4yMDMtMjguMzkxLTE3LjA1NS0xNS4wNDItMjguNjctMzMuNzExLTMxLjk5Ny0zOS41MDgtMy40MjctNS43NTgtLjM5OC04LjgyNiAyLjQ3MS0xMS42MzUgMi42OS0yLjU5IDUuNzc4LTYuNzM0IDguNjI3LTEwLjA0MSAyLjk2OS0zLjI4NyAzLjkwNS01LjYzOCA1Ljc5OC05LjQyNCAxLjkxMy0zLjkwNS45MzYtNy4xOTItLjQ3OC0xMC4xNDEtMS40MTUtMi44NDktMTMuMDEtMzAuODgxLTE3Ljc1Mi00Mi4zMzctNC44NDEtMTEuNDE2LTkuNTQzLTkuNTIzLTEyLjg3MS05LjUyMy0zLjQ2NyAwLTcuMjEyLS40NzgtMTEuMTE3LS40NzgtMy43ODUgMC0xMC4wNDEgMS4zOTUtMTUuMzgxIDcuMTkyLTUuMiA1LjY1OC0yMC4xMjMgMTkuNDY1LTIwLjEyMyA0Ny41OTcgMCAyOC4wNTIgMjAuNjAxIDU1LjMwOCAyMy41NSA1OS4wNTMgMi44NjkgMy43ODUgMzkuNzQ3IDYzLjE5NyA5OC4zMDMgODYuMDcgNTguNDc2IDIyLjg3MiA1OC40NzYgMTUuMzIxIDY5LjExNSAxNC4zNjUgMTAuMzgtLjk1NiAzNC4wNjktMTMuODY3IDM4LjgxMS0yNy4wOTYgNC42Ni0xMy40NSA0LjY2LTI0Ljc2NiAzLjI0Ni0yNy4xMzd6IiBmaWxsPSIjMkRCNzQyIi8+PC9zdmc+) 95% center no-repeat;
        background-size: 26px 26px;
        align-items: center;
        border-radius: 5px;
        border-left: 2px solid #55CD6C;
        transform: translateY(20px);
        -webkit-transform: translateY(20px);
        -moz-transform: translateY(20px);
        will-change: opacity, transform;
        opacity: 0;
    }

    #onlineService_2.whatsappShow .li a {
        transition-delay: 2.1s;
        transition: all .4s ease;
        transform: translate(0);
        opacity: 1;
    }

    #onlineService_2.whatsappShow .li a:first-child {
        transition-delay: .3s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(2) {
        transition-delay: .5s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(3) {
        transition-delay: .7s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(4) {
        transition-delay: .9s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(5) {
        transition-delay: 1.1s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(6) {
        transition-delay: 1.3s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(7) {
        transition-delay: 1.5s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(8) {
        transition-delay: 1.7s;
    }

    #onlineService_2.whatsappShow .li a:nth-child(9) {
        transition-delay: 1.9s;
    }

    #onlineService_2 .title {
        background: #55CD6C;
        display: flex;
        fill: #fff;
        padding: 20px;
        align-items: center;
    }

    #onlineService_2 .title svg {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }

    #onlineService_2 .title .h4 {
        color: #fff;
        font-size: 20px;
    }

    #onlineService_2 .title p {
        color: #fff;
        line-height: 20px;
    }

    #onlineService_2 .li {
        padding: 5%;
    }

    #onlineService_2 .li a {
        background-color: #eee;
        margin-bottom: 15px;
        padding: 8px;
        line-height: 20px;
    }

    #onlineService_2 .li a p {
        font-family: 'poppins semibold';
    }

    #onlineService_2 .li a .icon svg {
        width: 50px;
        height: 50px;
        fill: #55CD6C;
        margin-right: 10px;
    }

    #onlineService_2 .li a:hover {
        background-color: #ddd;
    }
</style>

<svg version="1.1" class="hidden">
    <symbol id="icon-whatsapp1" viewBox="0 0 1024 1024">
        <path
            d="M85.504 938.666667l57.685333-211.968A424.704 424.704 0 0 1 85.333333 512C85.333333 276.352 276.352 85.333333 512 85.333333s426.666667 191.018667 426.666667 426.666667-191.018667 426.666667-426.666667 426.666667a424.704 424.704 0 0 1-214.613333-57.813334L85.504 938.666667zM358.016 311.808a41.002667 41.002667 0 0 0-15.829333 4.266667 55.168 55.168 0 0 0-12.544 9.728c-5.12 4.821333-8.021333 9.002667-11.136 13.056A116.437333 116.437333 0 0 0 294.4 410.453333c0.085333 20.906667 5.546667 41.258667 14.08 60.288 17.450667 38.485333 46.165333 79.232 84.096 116.992 9.130667 9.088 18.048 18.218667 27.648 26.709334a403.114667 403.114667 0 0 0 163.84 87.296l24.277333 3.712c7.893333 0.426667 15.786667-0.170667 23.722667-0.554667a84.906667 84.906667 0 0 0 35.541333-9.856 206.08 206.08 0 0 0 16.341334-9.386667s1.834667-1.194667 5.333333-3.84c5.76-4.266667 9.301333-7.296 14.08-12.288 3.541333-3.669333 6.613333-7.978667 8.96-12.885333 3.328-6.954667 6.656-20.224 8.021333-31.274667 1.024-8.448 0.725333-13.056 0.597334-15.914666-0.170667-4.565333-3.968-9.301333-8.106667-11.306667l-24.832-11.136s-37.12-16.170667-59.776-26.496a21.248 21.248 0 0 0-7.552-1.749333 20.565333 20.565333 0 0 0-16.128 5.418666v-0.085333c-0.213333 0-3.072 2.432-33.92 39.808a14.933333 14.933333 0 0 1-15.701333 5.546667 60.416 60.416 0 0 1-8.149334-2.816c-5.290667-2.218667-7.125333-3.072-10.752-4.650667l-0.213333-0.085333a256.426667 256.426667 0 0 1-66.986667-42.666667c-5.376-4.693333-10.368-9.813333-15.488-14.762667a268.629333 268.629333 0 0 1-43.52-54.101333l-2.517333-4.053333a39.381333 39.381333 0 0 1-4.352-8.746667c-1.621333-6.272 2.602667-11.306667 2.602667-11.306667s10.368-11.349333 15.189333-17.493333a186.88 186.88 0 0 0 11.221333-15.914667c5.034667-8.106667 6.613333-16.426667 3.968-22.869333-11.946667-29.184-24.32-58.24-37.034666-87.082667-2.517333-5.717333-9.984-9.813333-16.768-10.624-2.304-0.256-4.608-0.512-6.912-0.682666a144.426667 144.426667 0 0 0-17.194667 0.170666z"
            p-id="3992"></path>
    </symbol>
    <symbol id="icon-whatsapp2" viewBox="0 0 1024 1024">
        <path
            d="M636.013714 556.544q7.460571 0 55.734857 25.161143t51.126857 30.281143q1.170286 2.852571 1.170286 8.557714 0 18.870857-9.728 43.446857-9.142857 22.308571-40.594286 37.449143t-58.294857 15.140571q-32.548571 0-108.544-35.401143-56.027429-25.746286-97.133714-67.437714t-84.553143-105.691429q-41.179429-61.147429-40.594286-110.884571l0-4.534857q1.682286-52.004571 42.276571-90.258286 13.677714-12.580571 29.696-12.580571 3.437714 0 10.313143 0.877714t10.825143 0.877714q10.825143 0 15.140571 3.730286t8.850286 15.725714q4.534857 11.410286 18.870857 50.322286t14.262857 42.861714q0 11.995429-19.748571 32.841143t-19.748571 26.550857q0 4.022857 2.852571 8.557714 19.456 41.691429 58.294857 78.262857 32.036571 30.281143 86.308571 57.709714 6.875429 4.022857 12.580571 4.022857 8.557714 0 30.866286-27.721143t29.696-27.721143zM520.009143 859.428571q72.557714 0 139.117714-28.598857t114.541714-76.580571 76.580571-114.541714 28.598857-139.117714-28.598857-139.117714-76.580571-114.541714-114.541714-76.580571-139.117714-28.598857-139.117714 28.598857-114.541714 76.580571-76.580571 114.541714-28.598857 139.117714q0 116.004571 68.534857 210.285714l-45.129143 133.12 138.313143-44.032q90.258286 59.465143 197.12 59.465143zM520.009143 69.705143q87.405714 0 167.131429 34.304t137.435429 92.013714 92.013714 137.435429 34.304 167.131429-34.304 167.131429-92.013714 137.435429-137.435429 92.013714-167.131429 34.304q-111.396571 0-208.603429-53.686857l-238.299429 76.580571 77.677714-231.424q-61.732571-101.741714-61.732571-222.281143 0-87.405714 34.304-167.131429t92.013714-137.435429 137.435429-92.013714 167.131429-34.304z"
            p-id="4135"></path>
    </symbol>
</svg>

<div id="whatsapp_more">
    <div id="whatsapp_tabs">
        <a id="floatShow_2" rel="nofollow" href="javascript:void(0);">
            <svg class="icon">
                <use xlink:href="#icon-whatsapp1"></use>
            </svg>
        </a>
        <a id="floatHide_2" rel="nofollow" href="javascript:void(0);"></a>
    </div>
    <div id="onlineService_2">
        <div class="title">
            <svg>
                <use xlink:href="#icon-whatsapp1"></use>
            </svg>
            <div>
                <div class="h4">Start a Conversation</div>
                <p>Hi! Click one of our members below to chat on </p>
            </div>
        </div>
        <div class="li">
            @for($i=0;$i<6;$i++)
                @if(isset(app('settings')['setting']->whatsapp_float_data['key'][$i]) && isset(app('settings')['setting']->whatsapp_float_data['value'][$i]))
                <a rel="nofollow" target="_blank" href="{{ whatsapp_link(trim(app('settings')['setting']->whatsapp_float_data['value'][$i])) }}">
                    <span class="icon"><svg>
                            <use xlink:href="#icon-whatsapp1"></use>
                        </svg></span>
                    <span class="text"><em>{{ trim(app('settings')['setting']->whatsapp_float_data['key'][$i]) }}</em></span>
                </a>
                @endif
                @endfor
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#floatShow_2").bind("click", function() {
            $("#onlineService_2").animate({
                height: "show",
                opacity: "show"
            }, "normal", function() {
                $("#onlineService_2").show().addClass('whatsappShow');
            });
            $("#floatShow_2").attr("style", "opacity: 0;");
            $("#floatShow_2 .icon").attr("style", "opacity: 0;transform: scale(0) rotate(1turn);");
            $("#floatHide_2").attr("style", "opacity: 1;transform: scale(1) rotate(0deg);");
            return false;
        });

        $("#floatHide_2").bind("click", function() {
            $("#onlineService_2").animate({
                height: "hide",
                opacity: "hide"
            }, "normal", function() {
                $("#onlineService_2").hide().removeClass('whatsappShow');
            });
            $("#floatShow_2").attr("style", "opacity: 1;");
            $("#floatShow_2 .icon").attr("style", "opacity: 1;transform: scale(1) rotate(0deg);");
            $("#floatHide_2").attr("style", "opacity: 0;transform: scale(0) rotate(-1turn);");
            return false;
        });

    });
</script>
