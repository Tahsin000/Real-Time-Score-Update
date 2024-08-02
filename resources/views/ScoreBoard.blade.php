@extends('app')
@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="p-4 col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 id="score">...</h2>
                    <h5>Live Score</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
        Pusher = new Pusher('9be01453309c8b0f921a', {
            cluster: 'mt1',
        });

        var channel = Pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            $('#score').html('');
            $('#score').html(data['scoreValue']);
        });
         
    </script>
@endsection