<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertOutletRequest;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletController extends Controller
{
    public function insert(InsertOutletRequest $request)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        Outlet::create($merged);

        return redirect()->intended(route('menu-outlet'));
    }

    public function show($id)
    {
        $outlet = Outlet::find($id);
        return [
            'status' => 200,
            $outlet,
        ];
    }

    public function update(InsertOutletRequest $request, $id)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        Outlet::find($id)->update($merged);

        return redirect()->intended(route('menu-outlet'));
    }

    public function delete($id)
    {
        Outlet::destroy($id);

        return redirect()->intended(route('menu-outlet'));
    }

    public function updateSaldo(Request $request, Outlet $outlet)
    {
        $outlet->update([
            'saldo' => $outlet->saldo + $request->nominal
        ]);
        $outlet->save();

        return redirect()->intended(route('menu-outlet'));
    }

    public function component() {
        return view('components.selectOutlet', [
            'outlets' => Outlet::all(),
        ]);
    }
}
