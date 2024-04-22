<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        return view('produk.index');
    }

    public function list(Request $request)
    {

        $query = DB::table('produk')
            ->select('id', 'nama_produk', 'harga_barang', 'harga_jual', 'stok', 'created_at') // Sertakan 'created_at' dalam select
            ->orderBy('created_at', 'desc')
            ->skip($request->start)
            ->take($request->length);

        dd($query);

        if ($request->keyword) {
            $search = $request->keyword;
            $query->where(function ($query) use ($search) {
                $query->where('nama_produk', 'ilike', "%$search%");
            });
        }

        if ($request->produk) {
            $query->where('kategori_produk', $request->produk);
        }

        $result     = $query->get();
        $resCount   = $query->count();
        $no         = $request->start;

        foreach ($result as $row) {
            $row->id        = $row->mp_p_id;
            $row->rownum    = ++$no;
        }

        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $result
        ];
        return response()->json($response);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name_pemda' => 'required|string',
        ]);
        $namakota = $request->input('name_kota');
        $namakotaUpper = strtoupper($namakota);

        $mp_mkk_nama = DB::table('mp_master_kota_kabupaten')
            ->where('mp_mkk_nama', 'ilike', "%$namakotaUpper%")
            ->value('mp_mkk_kode');


        $newData = [
            'mp_p_id'        => $request->input('kode_pemda'),
            'mp_p_nama'  => $request->input('name_pemda'),
            'mp_p_mkk_id'        => $mp_mkk_nama,
            'mp_p_fee'  => $request->input('biaya_admin'),
            'mp_p_min_fee'        => $request->input('transaksi'),
            'mp_p_pembayaran_cutoff'  => $request->input('cut_off'),
            'mp_p_pembayaran_date'        => $request->input('date'),
            'mp_p_status'  => $request->input('isactive'),
            'mp_p_created_by'        => Session('user')->nama,
            'mp_p_created_date'  => Carbon::now('Asia/Jakarta'),
        ];
        $record = DB::table('mp_pbb_pemda')->insert($newData);

        // Berikan respons berdasarkan keberhasilan operasi
        if ($record) {
            $message    = "Berhasil menambahkan data!";
            $rc         = "0000";
        } else {
            $message    = "Gagal menambahkan data!";
            $rc         = "0066";
        }

        $result = [
            "rc"        => $rc,
            "message"   => $message
        ];

        return response()->json($result);
    }
}
