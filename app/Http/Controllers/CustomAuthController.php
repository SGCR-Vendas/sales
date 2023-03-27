<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\CadastroEmpresa;
use App\Traits\FuncoesAdaptadas;
use RealRashid\SweetAlert\Facades\Alert;



class CustomAuthController extends Controller
{

    use FuncoesAdaptadas;

    public function index()
    {
        if(Auth::check()){
            return redirect()->intended('dashboard');
        }
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $id_empresa = (Auth::user()->id_empresa) ?? 0;
            if($id_empresa == 0){
                $empresa = [
                    'id' => 0,
                    'nome' => 'Todas as Empresas (Master)'
                ];
            } else {
                $empresa = CadastroEmpresa::find($id_empresa);
            }

            $request->session()->put('empresa',
                $empresa
            );

            Alert::success('Seja bem vindo ;)', 'Você acabou de fazer o login no sistema!');
            return redirect()->intended('dashboard');

        }

        Alert::error('Urps!', 'Infelizmente os dados digitados não correspondem!');
        return redirect('login');
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('pages.dashboard.index');
        }

        Alert::error('Urps!', 'Você não está logado!');
        return redirect('login');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        Alert::success('Até a Próxima!', 'Logout efetuado com sucesso!');
        return redirect('login');
    }
}
