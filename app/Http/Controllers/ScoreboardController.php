<?php

namespace App\Http\Controllers;

use App\Models\Scoreboard;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'game_data' => 'required',
        ]);

        $scoreboard = self::create($validatedData);

        return response()->json($scoreboard);
    }

    public static function create(array $validatedData): Scoreboard
    {
        $scoreboard = new Scoreboard();
        $scoreboard->name = $validatedData['name'];
        $scoreboard->game_data = $validatedData['game_data'];
        $scoreboard->save();

        return $scoreboard;
    }
}
