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

        $search = "LIKE '%+'"; /* Se tiver + é id_empresa 2 */


        $cliente_novo = [];

        $clientes = DB::connection('mysql_hdtv')->select("SELECT * FROM cliente WHERE nome {$search}");

        /** Pesquisa se o cliente já está cadastrado */
        foreach ($clientes as $i => $cliente) {
            if (!CadastroCliente::find($cliente->id_cliente)) {
                $cliente_novo[$i] = $cliente;
            }
        }

        if ($cliente_novo) {
            foreach ($cliente_novo as $cliente) {
                $cliente_app_array = [
                    'id' => $cliente->id_cliente,
                    'id_empresa' => 2,
                    'nome' => $this->importar_cliente_nome($cliente->nome),
                    'celular' => $cliente->telefone,
                    'status' => 'Ativo',
                    'created_at' => $cliente->data_inclusao
                ];

                if (CadastroCliente::insert($cliente_app_array)) {
                    echo "" . $cliente->id_cliente . ": " . $this->importar_cliente_nome($cliente->nome) . " <B>REGISTRADO!</B> <br>";
                } else {
                    echo "Erro ao cadastrar cliente. ";
                }
            }
            echo "<hr> <h1>Foram importados " . count($cliente_novo) . " Clientes</h1>";
        } else {
            echo "Nenhum cliente importado.";
        }       
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



        $vendas = DB::connection('mysql_hdtv')->select("SELECT * FROM venda");
        $venda_nova = [];

        foreach ($vendas as $i => $venda) {

            $busca = CadastroVenda::where(
                'id_cliente',
                $venda->id_cliente
            )
                ->where('id_produto', $venda->id_plano)
                ->where('created_at', $venda->data_criacao)
                ->first();

            if (!$busca) {
                $venda_nova[$i] = $venda;
            }
        }

        if ($venda_nova) {
            foreach ($venda_nova as $venda) {
                if ($venda->id_cliente) {
                    $venda_array = [
                        'id_cliente' => $venda->id_cliente,
                        'id_produto' => $venda->id_plano,
                        'created_at' => $venda->data_criacao,
                        'data_vencimento' => ($venda->data_vencimento == '0000-00-00 00:00:00') ? null : $venda->data_vencimento,
                        'status' => 'Entregue'
                    ];

                    if (CadastroVenda::insert($venda_array)) {
                        echo "Venda Incluida <br>";
                    } else {
                        echo "Erro ao cadastrar plano. ";
                    }
                }
            }

            echo "<h1> Total de Vendas Registradas: " . count($venda_nova) . "</h1>";
        } else {
            echo "Nenhuma venda nova registrada.";
        }
    }
}
