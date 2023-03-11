<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterRuteDetailOutlet;
use Illuminate\Http\Request;

class getRuteId extends Controller
{
    public function updateAlamat(Request $request)
    {
        $mrdo = MasterRuteDetailOutlet::find($request->id);
        $mrdo->alamat = $request->alamat;
        $mrdo->save();

        return response()->json([
            'alamat' => $mrdo->alamat
        ]);
    }
}
