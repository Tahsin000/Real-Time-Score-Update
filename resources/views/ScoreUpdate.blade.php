@extends('app')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="p-4 col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>Update Score</h3>
                        <hr>
                        <input type="text" class="form-control ScoreValue">
                        <br>
                        <button class="btn updateBtn btn-success btn-block">update</button>
                        <h4 class="lastScore pt-3"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Function to update score
        function updateScore() {
            var scoreValue = $('.ScoreValue').val();
            var url = "/push-score";
            axios.post(url, {
                score: scoreValue
            }).then(function(response) {
                $('.lastScore').html(response.data);
            }).catch(function(e) {
                console.log(e);
            });
        }

        // Bind click event to the .updateBtn
        $('.updateBtn').click(function() {
            updateScore();
        });

        // Bind Enter key press event to the input field
        $('.ScoreValue').keypress(function(e) {
            if (e.which === 13) { // Enter key pressed
                e.preventDefault(); // Prevent the default action (e.g., form submission)
                updateScore();
            }
        });
    </script>
@endsection
