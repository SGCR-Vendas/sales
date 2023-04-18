<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CadastroEmpresa;
use RealRashid\SweetAlert\Facades\Alert;


class ApiController extends Controller
{
    //

    protected $table_mensagem = "clientes_mensagem";

    public function selecionar_empresa(Request $Request)
    {
        if(Auth::user()->user_level==1){
            $empresa = CadastroEmpresa::find($Request->id_empresa);
            $Request->session()->put(
                'empresa',
                $empresa
            );
            echo "alterado";
        } else {
            echo "erro";
        }
    }

    // Enviar MSG para whatsApp
    public static function enviar_mensagem($phone_number, $message_body)
    {
        //  return true;

        $api_key = "d929f392-3d7b-4f06-b944-ba26007bd9b8";
        $phone_number_sender = "5548996533629";
        $contact_phone_number = $phone_number;
        $message_custom_id = "mysoftwareid";
        $message_type = "text";
        $message_body = ($message_body) ?? 'Seja bem vindo (a) <b>Blue TV!</b> \n Efetue sua compra conosco! \n Conheça nosso site: www.hdtv.blue';

        $curl = curl_init();       

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.whatsgw.com.br/api/WhatsGw/Send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apikey={$api_key}&phone_number={$phone_number_sender}&contact_phone_number={$contact_phone_number}&message_custom_id={$message_custom_id}&message_type={$message_type}&message_body={$message_body}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function enviar_mensagem_imagem($phone_number, $message_body, $image)
    {
        // return true;

        $curl = curl_init();

        $api_key = "d929f392-3d7b-4f06-b944-ba26007bd9b8";
        $phone_number_sender = "554896533629";
        $contact_phone_number = $phone_number;
        $message_custom_id = "mysoftwareid";

        $message_type = "image";
        $message_body_mimetype = "image/jpeg";
        $message_body_filename = "tabela_de_valores.jpg";
        $message_caption = "";
        $message_body = $image;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.whatsgw.com.br/api/WhatsGw/Send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "apikey={$api_key}&phone_number={$phone_number_sender}&contact_phone_number={$contact_phone_number}&message_custom_id={$message_custom_id}&message_type={$message_type}&message_body_mimetype={$message_body_mimetype}&message_body_filename={$message_body_filename}&message_caption={$message_caption}&message_body=" . $message_body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
