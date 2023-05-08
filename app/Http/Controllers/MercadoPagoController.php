<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use MercadoPago;



class MercadoPagoController extends Controller
{
    //

    function show()
    {
        return view('site.views.pagamento');
    }



    public function payment()
    {

        \MercadoPago\SDK::setAccessToken(config('services.mercadopago.token')); // Either Production or SandBox AccessToken


        // MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");

        $payment = new MercadoPago\Payment();

        $payment->transaction_amount = 100;
        $payment->token = "CARD_TOKEN";
        $payment->description = "Title of what you are paying for";
        $payment->installments = 1;

        $payer = new MercadoPago\Payer();
        $payer->email = "your.payer@email.com";

        $payment->payer = $payer;
        $payment->save();



        echo "Payment ID: " . $payment->id . "\n";
        echo "Payment Status: " . $payment->status . "\n";


        dd(config('services.mercadopago.token'));

        // $payment = new MercadoPago\Payment();

        // $payment->transaction_amount = "10";
        // $payment->description = "Plano 24 horas";
        // $payment->payment_method_id = "pix";
        // $payment->payer = array(
        //     "email" => "test_user_75171799@testuser.com",
        //     "first_name" => "Test",
        //     "last_name" => "Test",
        //     "identification" => array(
        //         "type" => "CPF",
        //         "number" => "11111111111"
        //     )
        // );

        // if ($payment->save()) {
        //     $dados = [
        //         'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
        //         'qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
        //         'payment_id' => $payment->id,
        //         'valor' => '10',
        //         'produto' => 'Plano 24 horas',


        //     ];
        //     return response()->json([$dados]);
        // }
    }

    public function status(Request $request)
    {
        \MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));
        $payment = new MercadoPago\Payment();

        $id = $request->input('id');

        return response()->json([$payment->get($id)->status]);
    }

    public function receberdados(Request $request)
    {
        return $request;
    }

    public function preference()
    {
        \MercadoPago\SDK::setAccessToken(config('services.mercadopago.token')); // Either Production or SandBox AccessToken

        // Cria a preferência
        $preference = new MercadoPago\Preference();

        // Cria um item
        $item = new MercadoPago\Item();
        $item->title = '24 horas de internet';
        $item->description = 'Acesso por 24 horas de internet';
        $item->quantity = 1;
        $item->currency_id = 'BRL';
        $item->unit_price = 20.00;
        $item->auto_return = "http://localhost:3000/sucessnetwork";

        // Criando os itens na preferência
        $preference->items = array($item);

        // Criando e selecionando o metodo de pagamento
        $preference->payment_methods = array(
            "default_payment_method_id" => "pix",
            "excluded_payment_types" => array(
                array("id" => "ticket")
            ),
            "installments" => 12
        );


        if (
            $preference->save()
        ) {
            $dados = [
                'preference_id' => $preference->id,
                'exibir' => $preference->payment_methods,
                'exibir2' => $preference->items,
            ];
            return response()->json([$dados]);
        }
    }
}
