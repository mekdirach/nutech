<?php

namespace App\Http\Controllers;

use App\Exports\LaporanProduk;
use App\Jobs\ExportJob;
use App\Models\produk;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class ProdukController extends Controller
{
    public function index()
    {
        return view('produk.index');
    }

    public function showTambahPage()
    {
        return view('produk.content.tambah');
    }

    public function list(Request $request)
    {

        $query      = produk::orderBy('created_at', 'desc');
        if ($request->keyword) {
            $search = $request->keyword;
            $query->where(function ($query) use ($search) {
                $query->where('nama_produk', 'ilike', "%$search%");
            });
        }

        if ($request->produk) {
            $query->where('kategori_produk', $request->produk);
        }

        $resCount   = $query->count();
        $result    = $query->skip($request->start)->take($request->length)->get();
        $no         = $request->start;

        foreach ($result as $row) {
            $row->id        = $row->id;
            $row->rownum    = ++$no;
            $row->gambar = url($row->gambar);
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $result
        ];
        Log::info('Metode list dipanggil');
        return response()->json($response);
    }

    public function create(Request $request)
    {
        Log::info('Metode create dipanggil');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'kategori' => 'required|string',
            'harga_barang' => 'required|numeric',
            'file' => 'required|image|mimes:jpeg,png|max:100',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->file('file');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('image'), $nama_file);

        $harga_beli = $request->input('harga_barang');
        $harga_jual = $harga_beli * 1.3;
        $request->merge(['harga_jual' => $harga_jual]);

        $newData = [
            'nama_produk'        => $request->input('name'),
            'kategori_produk'  => $request->input('kategori'),
            'harga_barang'  => $request->input('harga_barang'),
            'harga_jual'        => $harga_jual,
            'stok'  => $request->input('stok'),
            'created_at'  => Carbon::now('Asia/Jakarta'),
            'gambar' => 'image/' . $nama_file,
        ];
        $record = DB::table('produk')->insert($newData);

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

    public function edit(Request $request)
    {
        Log::info('Metode edit dipanggil');


        $id = $request->input('account_id');
        $harga_beli = $request->input('harga_barang');
        $harga_jual = $harga_beli * 1.3;
        $request->merge(['harga_jual' => $harga_jual]);
        $updatedData = [
            'nama_produk' => $request->input('name'),
            'kategori_produk' => $request->input('kategori_'),
            'harga_barang' => $request->input('harga_barang'),
            'harga_jual' => $harga_jual,
            'stok' => $request->input('stok'),
        ];
        $affectedRows = DB::table('produk')
            ->where('id', $id)
            ->update($updatedData);

        if ($affectedRows) {
            $message = "Data berhasil diubah!";
            $rc = "0000";
        } else {
            $message = "Gagal mengubah data!";
            $rc = "0066";
        }

        $result = [
            "rc" => $rc,
            "message" => $message
        ];

        return response()->json($result);
    }

    public function export(Request $request)
    {
        $records = Produk::orderBy('created_at', 'asc');

        if ($request->mProduk) {
            $search = $request->mProduk;
            $records->where(function ($query) use ($search) {
                $query->where('nama_produk', 'ilike', "%$search%");
            });
        }

        if ($request->mKategori) {
            $records->where('kategori_produk', $request->mKategori);
        }

        $data = $records->get();

        if ($data->isNotEmpty()) {
            $export = new LaporanProduk($data);
            return \Maatwebsite\Excel\Facades\Excel::download($export, 'laporan_produk.xlsx');
        } else {
            return back()->with([
                'message' => 'Gagal melakukan export, data tidak ditemukan',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function show(Request $request)
    {
        $record = DB::table('produk')->where('id', $request->id)->first();
        return response()->json($record);
    }

    public function delete($id)
    {

        try {
            $record = DB::table('produk')->where('id', $id)->delete();
            if ($record) {
                $message = "Data berhasil dihapus!";
                $rc = "0000";
                $status = 200;
            } else {
                $message = "Gagal menghapus data !";
                $rc = "0066";
                $status = 500;
            }
            return response()->json(['rc' => $rc, 'message' => $message], $status);
        } catch (\Exception $e) {
            $message = "Gagal menghapus data!";
            $rc = "0066";
            return response()->json(['rc' => $rc, 'message' => $message], 500);
        }
    }
}
