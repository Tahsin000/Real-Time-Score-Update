# Real-Time Score Update System

## Project Files

### 1. `ScoreUpdate.blade.php`

This Blade template provides a user interface for updating the score. 

```blade
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
                        <button class="btn updateBtn btn-success btn-block">Update</button>
                        <h4 class="lastScore pt-3"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
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

        $('.updateBtn').click(function() {
            updateScore();
        });

        $('.ScoreValue').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                updateScore();
            }
        });
    </script>
@endsection
```

### 2. `ScoreBoard.blade.php`

This Blade template displays the live score using Pusher for real-time updates.

```blade
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
        Pusher = new Pusher('config(your-pusher-key)', {
            cluster: 'mt1',
        });

        var channel = Pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            $('#score').html(data['scoreValue']);
        });
    </script>
@endsection
```

### 3. `web.php`

Defines the routes for displaying the views and handling score updates.

```php
<?php

use App\Http\Controllers\ScoreUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('ScoreBoard');
});
Route::get('/update', function () {
    return view('ScoreUpdate');
});

Route::post('/push-score', [ScoreUpdateController::class, 'pushScoreValue']);
```

### 4. `ScoreUpdateController.php`

Handles the logic for updating the score and broadcasting the event.

```php
<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use Illuminate\Http\Request;

class ScoreUpdateController extends Controller
{
    public function pushScoreValue(Request $request){
        $score = $request->input('score');
        event(new MyEvent($score));
        return $score;
    }
}
```

### 5. `MyEvent.php`

Event class that broadcasts the score updates to the `my-channel` channel.

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $scoreValue;

    public function __construct($scoreValue)
    {
        $this->scoreValue = $scoreValue; 
    }

    public function broadcastOn(): array
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
```

### 6. Pusher Configuration

Make sure to configure your `.env` file with Pusher credentials:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=mt1
```

## Getting Started

1. **Clone the Repository**: 
    ```sh
    git clone <repository-url>
    cd <repository-folder>
    ```

2. **Install Dependencies**: 
    ```sh
    composer install
    npm install
    ```

3. **Configure Environment**:
    - Copy `.env.example` to `.env` and add your Pusher credentials.

4. **Run Migrations** (if any):
    ```sh
    php artisan migrate
    ```

5. **Start the Application**:
    ```sh
    php artisan serve
    ```

6. **Start the WebSocket Server** (if needed):
    ```sh
    npm run dev
    ```

Visit `http://localhost:8000` to access the application and test real-time score updates.
