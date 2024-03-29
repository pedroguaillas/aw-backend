<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\StaticClasses\DBStatics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivoController extends Controller
{
    public function store(Request $request)
    {
        $info = $request->get('info');
        $ruc = substr($info, 0, 13);
        $anio = substr($info, 13, 4);
        $mes = substr($info, 17);

        $db = null;
        switch ((int)$anio) {
            case 2021:
                $db = DBStatics::DB21;
                break;
            case 2022:
                $db = DBStatics::DB22;
                break;
            case 2023:
                $db = DBStatics::DB23;
                break;
            case 2024:
                $db = DBStatics::DB24;
                break;
            default:
                $db = DBStatics::DB;
                break;
        }

        DB::connection($db)
            ->table('archivos')
            ->updateOrInsert(
                ['cliente_auditwhole_ruc' => $ruc, 'mes' => (int) $mes, 'anio' => $anio],
                [
                    $request->get('tipo') => $request->get('file'),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('+5 hours'))
                ]
            );

        return response()->json(['OK', 201]);
    }

    public function show(Request $request)
    {
        $info = $request->get('info');
        $ruc = substr($info, 0, 13);
        $anio = substr($info, 13, 4);
        $mes = substr($info, 17);

        $db = null;
        switch ((int)$anio) {
            case 2021:
                $db = DBStatics::DB21;
                break;
            case 2022:
                $db = DBStatics::DB22;
                break;
            case 2023:
                $db = DBStatics::DB23;
                break;
            case 2024:
                $db = DBStatics::DB24;
                break;
            default:
                $db = DBStatics::DB;
                break;
        }

        try {
            $file = Archivo::on($db)
                ->where([
                    'cliente_auditwhole_ruc' => $ruc,
                    'mes' => (int) $mes,
                    'anio' => $anio
                ])->get();
            if ($file)
                return $file[0];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function showtype(Request $request)
    {
        $info = $request->get('info');
        $ruc = substr($info, 0, 13);
        $anio = substr($info, 13, 4);
        $mes = substr($info, 17);
        try {
            $file = DB::table('archivos')
                ->select($request->get('tipo'))
                ->where([
                    'cliente_auditwhole_ruc' => $ruc,
                    'mes' => (int) $mes,
                    'anio' => $anio
                ])->get();
            if ($file)
                return base64_decode($file[0]->{$request->get('tipo')});
        } catch (\Exception $e) {
            return null;
        }
    }
}
