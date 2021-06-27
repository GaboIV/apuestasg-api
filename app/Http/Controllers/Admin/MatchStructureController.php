<?php

namespace App\Http\Controllers\Admin;

use App\BetType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Categories\CategoryRequest;
use App\MatchStructure;

class MatchStructureController extends ApiController
{
    public function index(Request $request)
    {
        if (request()->page) {
            $match_structures = MatchStructure::with('main_bet_types')->filterByColumns($request->all())
            ->with('category')->orderBy('id', 'desc')->paginate(20);
        } else {
            $match_structures = MatchStructure::with('category', 'main_bet_types')
            ->filterByColumns($request->all())->get();
        }

        return $this->successResponse([
            'match_structures' => $match_structures
        ], 200);
    }

    public function store(CategoryRequest $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        MatchStructure::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }

    public function attachMainBetType(Request $request, $id) {
        $data = $request->all();

        $match_structure = MatchStructure::whereId($id)->first();

        if (is_array(! $match_structure->main_bet_types)) {
            $main_bet_types = [];
        } else {
            $main_bet_types = $match_structure->main_bet_types;
        }

        if (in_array($data['main_bet_type'], $match_structure->main_bet_types ?? [])) {
            return $this->errorResponse("Tipo de apuesta ya está agregado", 409);
        }

        $main_bet_types[] = $data['main_bet_type'];

        $match_structure->update([
            "main_bet_types" => $main_bet_types
        ]);

        $match_structure = MatchStructure::with('category', 'main_bet_types')->whereId($id)->first();

        return $this->successResponse([
            'match_structure' => $match_structure
        ], 200);
    }

    public function dettachMainBetType(Request $request, $id) {
        $data = $request->all();

        $main_bet_type_stay = [];

        $main_bet_type = $data['main_bet_type'];

        $match_structure = MatchStructure::whereId($id)->first();

        foreach ($match_structure->main_bet_types as $key => $bet_type) {
            if ($bet_type != $main_bet_type['id']) {
                $main_bet_type_stay[] = $bet_type;
            }
        }

        $match_structure->update([
            "main_bet_types" => $main_bet_type_stay
        ]);

        $match_structure = MatchStructure::with('category', 'main_bet_types')->whereId($id)->first();

        return $this->successResponse([
            'match_structure' => $match_structure
        ], 200);
    }
}
