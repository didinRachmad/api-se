<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;

class ExecRekap extends Controller
{
    public function index()
    {
        $data = Karyawan::select('karyawan.nama', 'karyawan.id_salesman_mss', 'karyawan.iddepo', 'master_depo.nama_depo', 'distributor.nama_distributor')
            ->whereNotNull('karyawan.id_salesman_mss')
            ->whereNull('karyawan.resign_date')
            ->where('karyawan.id_salesman_mss', '<>', '')
            ->where('karyawan.kategori', '=', 'SE')
            ->join('master_depo', 'karyawan.iddepo', '=', 'master_depo.iddepo')
            ->join('distributor', 'karyawan.distributor', '=', 'distributor.id')
            ->orderBy('master_depo.nama_depo')
            ->orderBy('karyawan.nama')
            ->get();

        return view('ExecRekap', compact('data'));
    }
}
