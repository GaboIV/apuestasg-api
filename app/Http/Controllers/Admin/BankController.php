<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Banks\BankRequest;

class BankController extends ApiController
{
    public function index(Request $request)
    {
        if (request()->page) {
            $banks = Bank::filterByColumns($request->all())
            ->orderBy('id', 'desc')->paginate(20);
        } else {
            $banks = Bank::all();
        }

        return $this->successResponse([
            'banks' => $banks
        ], 200);
    }

    public function store(BankRequest $request)
    {
        $data = $request->validated();

        $bank = Bank::create($data);

        return $this->successResponse($bank, 200);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        Bank::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }
}
