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

        $hoje = date("Y-m-d", strtotime(NOW()));
        $vence_hoje = CadastroVenda::BuscarVencimento($hoje);

        return view('pages.ferramentas.cobranca.index', compact('vence_hoje'));
    }


    public function cobranca_automatica()
    {
        $hoje = date("Y-m-d", strtotime(NOW()));
        $vence_hoje = CadastroVenda::BuscarVencimento($hoje);
        $saudacao = Tratamento::SaudacaoHorario();
        $retorno = [];

       

        if ($vence_hoje) {

            $i = 0;
            foreach ($vence_hoje as $vencimento) {



                $busca = FerramentaMensagem::where('id_cliente', $vencimento->id_cliente)
                    ->where('id_produto', $vencimento->id_produto)
                    ->where('data_vencimento', $vencimento->data_vencimento)
                    ->first();



                if (!$busca) {

                    if (!$vencimento->celular == "") {

                        /** Variáveis de Uso */
                        $data = explode(" ", $vencimento->data_venda);
                        $cliente_celular = Tratamento::FormatarTelefone($vencimento->celular);

                        /* Parte A - Cobrança */
                        $cobranca = new FerramentaMensagem();
                        $cobranca->titulo = "Cobrança Automática - Saudação";
                        $cobranca->mensagem = "Prezado cliente, {$saudacao}. \n\nInformamos que de acordo com sua compra *realizada em {$data[0]}*, seu plano de recarga vencerá nas próximas 24hs. Para recarregar, dúvidas ou suporte técnico, estamos a disposição. *Escolha seu plano na tabela abaixo:*\n\n";

                        if (ApiController::enviar_mensagem($cliente_celular, $cobranca->mensagem)) {
                            $cobranca->id_cliente = $vencimento->id_cliente;
                            $cobranca->id_produto =  (!empty($vencimento->id_produto) ??  1);
                            $cobranca->data_vencimento = $vencimento->data_vencimento;
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

                    $retorno['cliente'][$i] = $vencimento->nome_cliente;
                    $i++;
                }
            }
        }


    }
}
