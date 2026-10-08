<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body" style="padding:0">
                <ul class="photo_card">
                    @foreach($photos as $photo)
                    <li><img src="{{ asset($photo->true_path) }}"/></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('/js/admin/admin.album.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
