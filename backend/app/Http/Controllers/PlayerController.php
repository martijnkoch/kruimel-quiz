<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function storePlayer(Request $request)
    {
        $player = new Player;

        $player->name = request('name');
        $player->save();

        $response = [
            'success' => true,
            'data' => [
                "name" => request('name'),
            ],
        ];

        return response()->json($response);
    }

    public function storeScore(Request $request)
    {
        Player::where('name', request('name'))
            ->update(['score' => request('score')]);

        $response = [
            'success' => true,
            'data' => [
                "name" => request('name'),
                "score" => request('score'),
            ],
        ];

        return response()->json($response);
    }

    public function showLeaderboard(Request $request)
    {
        $result =  Player::whereNotNull('score')
        ->orWhere('score', '<>', '')
        ->limit(10)
        ->get();

        $response = [
            'success' => true,
            'user' => [
                $result
            ],
        ];

        return response()->json($result);
    }
}
