<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Traits\FuncoesAdaptadas;
use App\Models\CadastroCliente;
use App\Models\CadastroProduto;
use App\Models\CadastroVenda;

use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class AppImportarController extends Controller
{
    //


    use FuncoesAdaptadas;


    public function importar_clientes(){
        // echo "Todos os clientes já foram importados com sucesso. \n Função desativada!";
        // return false;

        $Clientes = DB::connection('mysql_hdtv')->select("SELECT * FROM cliente WHERE nome LIKE '%+'");
        foreach($Clientes as $cliente){
            $cliente_app_array = [
                'id' => $cliente->id_cliente,
                'id_empresa' => 2,
                'nome' => $this->importar_cliente_nome($cliente->nome),
                'celular' => $cliente->telefone,
                'status' => 'Ativo',
                'created_at' => $cliente->data_inclusao
            ];

            if (CadastroCliente::insert($cliente_app_array)) {
                echo "".$cliente->id_cliente.": " . $this->importar_cliente_nome($cliente->nome)." <B>REGISTRADO!</B> <br>";
            } else {
                echo "Erro ao cadastrar cliente. ";
            }

        }

        echo "<hr> <h1>Foram importados ".count($Clientes)." Clientes</h1>";
    }

    public function importar_planos(){

        echo "Todos os planos já foram importados com sucesso. \n Função desativada!";
        return false;


        $Planos = DB::connection('mysql_hdtv')->select("SELECT * FROM plano");

        foreach($Planos as $plano){

            $plano_array = [
                'titulo' => $plano->titulo,
                'status' => 'Ativo'
            ];


            if (CadastroProduto::insert($plano_array)) {
                echo $plano->titulo . " <B>REGISTRADO!</B> <br>";
            } else {
                echo "Erro ao cadastrar plano. ";
            }

        }
    }

    public function importar_vendas(){

        // echo "Todos as vendas já foram importados com sucesso. \n Função desativada!";
        // return false;



        $Vendas = DB::connection('mysql_hdtv')->select("SELECT * FROM venda");

        echo "<h1> Total de Vendas Registradas: ".count($Vendas)."</h1>";


        foreach($Vendas as $venda){


            $venda_array = [
                'id_cliente' => $venda->id_cliente,
                'id_produto' => $venda->id_plano,
                'created_at' => $venda->data_criacao,
                'data_vencimento' => ($venda->data_vencimento== '0000-00-00 00:00:00') ? null : $venda->data_vencimento,
                'status' => 'Entregue'
            ];


            if (CadastroVenda::insert($venda_array)) {
                echo "Venda Incluida <br>";
            } else {
                echo "Erro ao cadastrar plano. ";
            }

        }


        $this->dd($venda_array);

    }



}
