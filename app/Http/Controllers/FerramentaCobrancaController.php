<?php

namespace App\Http\Controllers;

use App\Models\{FerramentaCobranca, FerramentaMensagem, CadastroVenda};
use App\Helpers\Tratamento;
use Illuminate\Http\Request;

class FerramentaCobrancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "Inicio do método de cobrança ";
    }


    public function cobranca_automatica()
    {
        $hoje = date("Y-m-d", strtotime(NOW()));
        $vence_hoje = CadastroVenda::BuscarVencimento($hoje);
        $saudacao = Tratamento::SaudacaoHorario();

        if ($vence_hoje) {

            $i = 0;
            foreach ($vence_hoje as $vencimento) {

                if (!$vencimento->celular == "") {

                    /* Variáveis Gerais */
                    $cliente_celular = "554198036863";


                    echo "Data Venda Banco de dados: " . $vencimento->data_venda . "<br><br>";



                    //$cliente_celular = Tratamento::FormatarTelefone($vencimento->celular);
                    $vencimento->data_venda = date("d/m/Y", strtotime($vencimento->data_venda));

                    echo "Data Venda: " . $vencimento->data_venda;
                    die();

                    /* Parte A - Cobrança */
                    $cobranca = new FerramentaMensagem();
                    $cobranca->titulo = "Cobrança Automática - Saudação";
                    $cobranca->mensagem = "Prezado cliente, {$saudacao}. \n\nInformamos que de acordo com sua compra *realizada em {$vencimento->data_venda}*, seu plano de recarga vencerá nas próximas 24hs. Para recarregar, dúvidas ou suporte técnico, estamos a disposição. *Escolha seu plano na tabela abaixo:*\n\n";

                    if (ApiController::enviar_mensagem($cliente_celular, $cobranca->mensagem)) {

                        $cobranca->id_cliente = $vencimento->id_cliente;
                        $cobranca->tipo = "cobranca";
                        $cobranca->whatsapp = $cliente_celular;
                        $cobranca->status = 'Enviado';
                        $cobranca->save();
                    }

                    /* Parte B - Imagem */
                    $cobranca_imagem = new FerramentaMensagem();
                    $cobranca_imagem->titulo = "Cobrança Automática - Tabela de Valores";
                    $cobranca_imagem->mensagem = "";
                    $cobranca_imagem->imagem = base64_encode(file_get_contents('../public/assets/images/tables/07408572902.jpg'));

                    if (ApiController::enviar_mensagem_imagem($cliente_celular, $cobranca_imagem->mensagem, $cobranca_imagem->imagem)) {
                        $cobranca_imagem->id_cliente = $vencimento->id_cliente;
                        $cobranca_imagem->tipo = "cobranca";
                        $cobranca_imagem->whatsapp = $cliente_celular;
                        $cobranca_imagem->status = 'Enviado';
                        $cobranca_imagem->save();
                    }

                    /* Parte C - Pix */
                    $cobranca_pix = new FerramentaMensagem();
                    $cobranca_pix->titulo = "Cobrança Automática - Pix";
                    $cobranca_pix->mensagem = "⚠️Para efetuar o pagamento via PIX basta enviar o valor do plano para \n 📱💲*Celular - (48) 99653-3629 - Dhéssica C R Baill* \n\n 💳 Caso queira pagar por *CARTÃO DE CRÉDITO*, basta solicitar o link para que possamos lhe enviar para efetuar o pagamento. \n \n ‼️ Ao efetuar o pagamento, por gentileza *ENVIAR O COMPROVANTE.*";

                    if (ApiController::enviar_mensagem($cliente_celular, $cobranca_pix->mensagem)) {

                        $cobranca_pix->id_cliente = $vencimento->id_cliente;
                        $cobranca_pix->tipo = "cobranca";
                        $cobranca_pix->whatsapp = $cliente_celular;
                        $cobranca_pix->status = 'Enviado';
                        $cobranca_pix->save();
                    }
                }

                $retorno['cliente'][] = $vencimento->nome_cliente;


                if ($i == 0) break;
            }
        }

        echo "<pre>";
        print_r($retorno);
        echo "</pre>";




    }
}
