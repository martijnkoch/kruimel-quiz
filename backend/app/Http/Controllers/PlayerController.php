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
}
