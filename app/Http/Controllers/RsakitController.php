<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Rsakit;
use Illuminate\Http\Request;
use Exception;

class RsakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $rsakits = Rsakit::where('nama_pasien','LIKE','%'.$search.'%')->limit($limit)->get();

        if ($rsakits) {
            // kalau data berhasil diambil
            return ApiFormatter::createAPI(200, 'success', $rsakits);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pasien' => 'required',
                'alamat' => 'required',
                'umur' => 'required',
                'no_telp' => 'required',
                'tanggal_pendaftaran' => 'required',
                'dokter' => 'required',
            ]);

            $rsakit = Rsakit::create([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'no_telp' => $request->no_telp,
                'tanggal_pendaftaran' => \Carbon\Carbon::parse($request->tanggal_pendaftaran)->format('Y-m-d'),
                'dokter' => $request->dokter,
            ]);
            $hasilTambahData = Rsakit::where('id', $rsakit->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'success', $rsakit);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'failed', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rsakit  $rsakit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $Rsakit = Rsakit::find($id);
            if ($Rsakit) {
                return ApiFormatter::createAPI(200, $Rsakit);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rsakit  $rsakit
     * @return \Illuminate\Http\Response
     */
    public function edit(Rsakit $rsakit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rsakit  $rsakit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rsakit $rsakit, $id)
    {
        try{
            $request->validate([
                'nama_pasien' => 'required',
                'alamat' => 'required',
                'umur' => 'required',
                'no_telp' => 'required',
                'tanggal_pendaftaran' => 'required',
                'dokter' => 'required',
            ]);
            $rsakit = Rsakit::find($id);
            $updatersakit = $rsakit->update([
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'no_telp' => $request->no_telp,
                'tanggal_pendaftaran' => \Carbon\Carbon::parse($request->tanggal_pendaftaran)->format(Y-m-d),
                'dokter' => $request->dokter,
            ]);
            $databaru = rsakit::where('id', $rsakit->id)->first();
            if ($databaru) {
                return ApiFormatter::createApi('200', $databaru);
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rsakit  $rsakit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rsakit $rsakit, $id)
    {
        try{
            $rsakit = Rsakit::find($id);
            $delete = $rsakit->delete();
            
            if ($delete) {
                //jika delete berhasil, data yang dimunculin texts cofirm dengan status code 200
                return ApiFormatter::createApi('200','succes delete data');
            } else {
                return ApiFormatter::createApi (400, 'failed');
            }
        }
        catch (Exception $error) {
            //jika baris code try ada yang trouble, error dimunculkan dengan desc err nya dengan status code 400
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            $rsakits = Rsakit::onlyTrashed()->get();
            if($rsakits) {
                return ApiFormatter::createAPI (200, 'success',$rsakits);
            }else {
                return ApiFormatter::createAPI (400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $rsakit = Rsakit::onlyTrashed()->where('id', $id);
            $rsakit->restore();
            $dataKembali = Rsakit::where('id', $id)->first();
            if ($dataKembali) {
                return ApiFormatter::createAPI(200,'success',$dataKembali);
            } else {
                return ApiFormatter::createAPI(400,'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try{
            $rsakit = Rsakit::onlyTrashed()->where('id', $id);
            $proses = $rsakit->forceDelete();
            if ($proses) {
                return ApiFormatter::createAPI(200, 'success', 'data berhasil kehapus');
            } else {
                return ApiFormatter::createAPI(400,'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error->getMessage());
        }
        }
}
