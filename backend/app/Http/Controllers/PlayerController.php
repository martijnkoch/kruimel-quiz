<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function storePlayer(Request $request)
    {

        if (Player::where('name', request('name'))->first()) {
            $response = [
                'success' => false,
                'message' => 'name already exsists',
                'data' => [
                    "name" => request('name'),
                ],
            ];
        } else {
            $player = new Player;

            $player->name = request('name');
            $player->save();

            $response = [
                'success' => true,
                'data' => [
                    "name" => request('name'),
                ],
            ];
        }

        return response($response);
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

        return response($response);
    }

    public function showLeaderboard()
    {
        $result = Player::whereNotNull('score')
            ->orWhere('score', '<>', '')
            ->limit(10)
            ->get();

        $response = [
            'success' => true,
            'user' => [
                $result,
            ],
        ];

        return response($result);
    }
}
