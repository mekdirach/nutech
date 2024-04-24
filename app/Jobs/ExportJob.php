<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DaftarTpbbExport;
use App\Models\MpDownloadManager;
use App\Exports\LaporanBlokirExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use App\Models\Views\VPbbLaporanBlokir;
use Illuminate\Support\Facades\Session;
use App\Exports\LaporanPembatalanExport;
use App\Models\Views\VPbbDaftarTabungan;
use Illuminate\Queue\InteractsWithQueue;
use App\Exports\LaporanPendaftaranExport;
use App\Exports\LaporanProduk;
use App\Models\Views\VPbbLaporanTransaksi;
use App\Models\Views\VPbbLaporanPembatalan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exports\LaporanTransaksiGagalExport;
use App\Models\Views\VPbbLaporanPendaftaran;
use App\Exports\LaporanTransaksiSuksesExport;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parameter;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->parameter = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request        = $this->parameter['request'];
        $type           = $this->parameter['type'];
        $count          = $this->parameter['count'];
        $export_type    = $request['type'];
        $date           = date('Ymd - hms');

        if ($export_type == '1') {
            if (strtolower($type) == 'produk') {
                $fileName   = 'produk-' . $date . '.xlsx';
            }
        }

        $extension = explode('.', $fileName);
        $dm = new MpDownloadManager();
        $dm->branch_code    = $request['session_kode_cabang'];
        $dm->counted_record = $count;
        $dm->document_type  = $type;
        $dm->path           = "app\\";
        $dm->filename       = $fileName;
        $dm->extension_file = '.' . $extension[1];
        $dm->save();

        if ($export_type == '1') {
            //excel
            if (strtolower($type) == 'pendaftaran') {
                $action = Excel::store(new LaporanProduk($request), $fileName);
            }
        }
    }

    public function getLaporanPendaftaran($request)
    {
        $branch = isset($request['mBranch']) ? $request['mBranch'] : null;
        $pemda = isset($request['mPemda']) ? $request['mPemda'] : null;
        $nop = isset($request['mNop']) ? $request['mNop'] : null;
        $nama = isset($request['mNama']) ? $request['mNama'] : null;
        $norek = isset($request['mNorek']) ? $request['mNorek'] : null;
        $start = isset($request['mStart']) ? $request['mStart'] : null;
        $end = isset($request['mEnd']) ? $request['mEnd'] : null;

        $records = VPbbLaporanPendaftaran::orderBy('pbb_c_reg_date', 'asc');

        if ($branch && $branch != 'ALL') {
            $records->where('pbb_c_created_office', $branch);
        }

        if ($pemda) {
            $records->where('mp_p_id', $pemda);
        }

        if ($nop) {
            $records->where('pbb_c_nop', $nop);
        }

        if ($nama) {
            $search = $nama;
            $records->where(function ($records) use ($search) {
                $records->where('pbb_c_nop_name', 'ilike', "%$search%");
            });
        }

        if ($norek) {
            $records->where('pbb_c_src_extacc', $norek);
        }

        if ($start) {
            $records->where('pbb_c_reg_date', '>=', "$start 00:00:00");
        }

        if ($end) {
            $records->where('pbb_c_reg_date', '<=', "$end 23:59:59");
        }

        return $records->get();
    }
}
