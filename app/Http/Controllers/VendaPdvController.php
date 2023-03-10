<?php

namespace App\Http\Controllers;

use App\Models\CadastroEmpresa;
use App\Models\CadastroCliente;
use App\Models\CadastroVenda;
use App\Models\Relatorio;

use App\Traits\FuncoesAdaptadas;


use Illuminate\Http\Request;

class VendaPdvController extends Controller
{

    use FuncoesAdaptadas;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $relatorio['7_dias'] = Relatorio::RelatorioVendaPeriodo(7);
        $relatorio['14_dias'] = Relatorio::RelatorioVendaPeriodo(14);
        $relatorio['30_dias'] = Relatorio::RelatorioVendaPeriodo(30);
        $relatorio['60_dias'] = Relatorio::RelatorioVendaPeriodo(60);
        $relatorio['90_dias'] = Relatorio::RelatorioVendaPeriodo(90);

    
        $vendas = CadastroVenda::ListaVendasUltimas(10);
        return view('pages.vendas.index', compact('vendas', 'relatorio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $empresas = CadastroEmpresa::all();
        $clientes = CadastroCliente::all();
        return view('pages.vendas.registrar', compact('empresas', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
