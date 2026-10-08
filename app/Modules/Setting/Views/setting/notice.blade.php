@inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
<div style="padding:20px;">
    {{-- <h1 style="font-size:16px;margin-bottom:15px;color: #333;text-align: center">{!! $notice->title !!}</h1> --}}
    <p>{!! $showThumbImagePresenter->downRemoteImage($notice->content) !!}</p></div>
