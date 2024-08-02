<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use Illuminate\Http\Request;

class ScoreUpdateController extends Controller
{
    //
    public function pushScoreValue(Request $request){
        $score = $request->input('score');
        event(new MyEvent($score));
        return $score;
    }
}
