<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertJenisRewashRequest;
use App\Models\Data\JenisRewash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisRewashController extends Controller
{
    public function insert(InsertJenisRewashRequest $request)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        JenisRewash::create($merged);

        //return redirect()->intended(route(''));
    }

    public function show($id)
    {
        $jenis_rewash = JenisRewash::find($id);
        return [
            'status' => 200,
            $jenis_rewash,
        ];
    }

    public function update(InsertJenisRewashRequest $request, $id)
    {
        $merged = $request->merge(['modified_by' => Auth::id()])->toArray();
        JenisRewash::find($id)->update($merged);

        //return redirect()->intended(route(''));
    }

    public function delete($id)
    {
        JenisRewash::destroy($id);

        //return redirect()->intended(route(''));
    }
}
