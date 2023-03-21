<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use DB;
use Auth;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $factures = Invoice::where('compagnie', Auth::user()->compagnie_id)->get();
        $enrollements = DB::table('module_enrollements')->where('id_compagnie', Auth::user()->compagnie_id)->where('type_offre', 0)->where('actif', 1)->get();
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $soldes = DB::table('soldes')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        $enregistrements = DB::table('bagage')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        return view('invoices-lists', compact('factures', 'gares', 'enrollements', 'soldes', 'enregistrements'));
    }
}
