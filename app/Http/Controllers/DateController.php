<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateController extends Controller
{
    public static function getDate(){

        if (!session('dataIni')) {
            session(['dataIni' => session('dataIni') ? session('dataIni') : date('Y-m-01')]);
            session(['dataFim' => session('dataFim') ? session('dataFim') : date('Y-m-t')]);
        }

    }

    public static function setDate(Request $request)
    {
        // SE TEM POST, COLOCA NA SESSION
        if ($request->input('dataIni')) {
            session(['dataIni' => $request->input('dataIni')]);
        }
        if ($request->input('dataFim')) {
            session(['dataFim' => $request->input('dataFim')]);
        }
        // SE AQUI NÃO TME SESSION NEM POST É O PRIMEIRO ACESSO
        // COLOCANDO DATA INICIAL E FINAL PADRAO

        return redirect()->back();
    }

    public static function getPeriodo(){
        return [session('dataIni'), session('dataFim')];
    }

    public static function getdataIni()
    {
       return session('dataIni');
    }

    public static function getdataFim()
    {
       return session('dataFim');
    }
}
