<form method="post" id="{{ $formId }}" action="/inquiryStore" >
    @csrf
    <x-honeypot />
        @section('content')
            <ul>

            <li>
                <input type="text" name="msg_email"  required="required" class="meInput" placeholder="Email">
            </li>
            <li>
                <input type="text" name="msg_title" required="required" class="meInput" placeholder="Subject">
            </li>
            <li>
                <textarea id="meText" placeholder="Content" required="required" name="msg_content" style="color:#808080;" class="meText"></textarea>
            </li>
            <div class="clearfix"></div>
            </ul>
        @show
        @if(app('settings')['setting']['chat_token'] === 'google captcha')
            {!! NoCaptcha::renderJs() !!}
                <div data-theme="dark" class="g-recaptcha" data-callback="onSubmitemail_form" data-sitekey="{!! app('settings')['setting']['nocaptcha_sitkey'] !!}"></div>
                <span class="{{ $spanClass }}"><input type="submit" value="" class="{{ $inputClass }}">{{ $inputValue }}</span>
        @else
                <span class="{{ $spanClass }}"><input type="submit" value="" class="{{ $inputClass }}">{{ $inputValue }}</span>
        @endif
</form>
