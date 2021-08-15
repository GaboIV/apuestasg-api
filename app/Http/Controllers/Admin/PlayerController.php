<?php

namespace App\Http\Controllers\Admin;

use App\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PlayerController extends ApiController
{
    public function index()
    {
        $players = Player::orderBy('created_at', 'desc')->paginate();

        return $this->successResponse($players, 200);
    }

    public function show($id)
    {
        $player = Player::whereId($id)->first();

        return $this->successResponse([
            'player' => $player
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }
}
