<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

use RealRashid\SweetAlert\Facades\Alert;

/* Site */
use App\Http\Controllers\SiteController;

/* Configurações */
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\ConfiguracaoMinhaContaController;
use App\Http\Controllers\ConfiguracaoUsuarioTipoController;
use App\Http\Controllers\ConfiguracaoUsuarioController;
use App\Http\Controllers\ConfiguracaoModuloController;
use App\Http\Controllers\ConfiguracaoSistemaController;

/* Cadastros */
use App\Http\Controllers\CadastroClienteController;
use App\Http\Controllers\CadastroEmpresaController;
use App\Http\Controllers\CadastroProdutoController;
use App\Http\Controllers\CadastroProdutoAssociarController;

/* Anexos */
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AppImportarController;

/* PDV */
use App\Http\Controllers\VendaPdvController;

/* Ferramenta - Cobranças */
use App\Http\Controllers\FerramentaCobrancaController;
use App\Http\Controllers\FerramentaMensagemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function () {
    Alert::error('Que pena!', 'Este módulo está indisponível para você ou não foi encontrado.');
    return redirect(route('dashboard'));
});


// Route::get('/',                                         [SiteController::class, 'index'])->name('site');
// Route::get('/',                                         [SiteController::class, 'index'])->name('admin');
Route::get('admin',                                               [CustomAuthController::class, 'index'])->name('admin');
Route::get('admin/login',                                         [CustomAuthController::class, 'index'])->name('login');
Route::post('admin/custom-login',                                 [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('admin/signout',                                       [CustomAuthController::class, 'signOut'])->name('signout');

/* Grupo de Rotas Autenticadas */
Route::group(['middleware' => 'auth'], function () {

    /* Configurações - Dashboard */
    Route::get('admin/dashboard',                                 [CustomAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/configuracao',                              [ConfiguracaoController::class, 'index']);

    /* Configurações */
    /* Tipos de Usuário */
    Route::get('admin/configuracao/usuario_tipo',                 [ConfiguracaoUsuarioTipoController::class, 'index'])->name('usuario_tipo');
    Route::get('admin/configuracao/usuario_tipo/editar/{id?}',    [ConfiguracaoUsuarioTipoController::class, 'edit'])->name('usuario_tipo.editar');
    Route::get('admin/configuracao/usuario_tipo/adicionar',       [ConfiguracaoUsuarioTipoController::class, 'create'])->name('usuario_tipo.adicionar');
    Route::post('admin/configuracao/usuario_tipo/store',          [ConfiguracaoUsuarioTipoController::class, 'store'])->name('usuario_tipo.store');
    Route::post('admin/configuracao/usuario_tipo/update/{id}',    [ConfiguracaoUsuarioTipoController::class, 'update'])->name('usuario_tipo.update');
    /* Usuários */
    Route::get('admin/configuracao/usuario',                      [ConfiguracaoUsuarioController::class, 'index'])->name('usuario');
    Route::get('admin/configuracao/usuario/editar/{id?}',         [ConfiguracaoUsuarioController::class, 'edit'])->name('usuario.editar');
    Route::get('admin/configuracao/usuario/adicionar',            [ConfiguracaoUsuarioController::class, 'create'])->name('usuario.adicionar');
    Route::post('admin/configuracao/usuario/store',               [ConfiguracaoUsuarioController::class, 'store'])->name('usuario.store');
    Route::post('admin/configuracao/usuario/update/{id}',         [ConfiguracaoUsuarioController::class, 'update'])->name('usuario.update');
    /* Configurações - Sistema */
    Route::get('admin/configuracao/sistema',                      [ConfiguracaoSistemaController::class, 'index'])->name('sistema');
    Route::post('admin/configuracao/sistema/store',               [ConfiguracaoSistemaController::class, 'store'])->name('sistema.store');
    /* Módulos */
    Route::get('admin/configuracao/modulo',                       [ConfiguracaoModuloController::class, 'index'])->name('modulo');
    Route::get('admin/configuracao/modulo/editar/{id?}',          [ConfiguracaoModuloController::class, 'edit'])->name('modulo.editar');
    Route::get('admin/configuracao/modulo/adicionar',             [ConfiguracaoModuloController::class, 'create'])->name('modulo.adicionar');
    Route::post('admin/configuracao/modulo/store',                [ConfiguracaoModuloController::class, 'store'])->name('modulo.store');
    Route::post('admin/configuracao/modulo/update/{id}',          [ConfiguracaoModuloController::class, 'update'])->name('modulo.update');
    /* Minha Conta */
    Route::get('admin/configuracao/minhaconta',                   [ConfiguracaoMinhaContaController::class, 'index'])->name('minhaconta');
    Route::post('admin/configuracao/minhaconta/store',            [ConfiguracaoMinhaContaController::class, 'store'])->name('minhaconta.store');

    /* Sites */
    //configurar
    Route::get('admin/sites/configurar',                          [FerramentaCobrancaController::class, 'index'])->name('sites.configurar');
    //conteudos
    Route::get('admin/sites/conteudos',                          [FerramentaCobrancaController::class, 'index'])->name('sites.conteudos');

    /* Ferramentas*/
    //Mensagens para WhatsApp
    Route::get('admin/ferramenta/mensagem',                       [FerramentaMensagemController::class, 'index'])->name('ferramenta.mensagem');
    Route::get('admin/ferramenta/mensagem/adicionar',             [FerramentaMensagemController::class, 'create'])->name('ferramenta.mensagem.adicionar');
    Route::get('admin/ferramenta/mensagem/editar/{id?}',          [FerramentaMensagemController::class, 'edit'])->name('ferramenta.mensagem.editar');
    Route::post('admin/ferramenta/mensagem/store',                [FerramentaMensagemController::class, 'store'])->name('ferramenta.mensagem.store');
    Route::post('admin/ferramenta/mensagem/update/{id}',          [FerramentaMensagemController::class, 'update'])->name('ferramenta.mensagemda.update');
    // Cobranças via WhatsApp
    Route::get('admin/ferramenta/cobranca',
        [FerramentaCobrancaController::class, 'index']
    )->name('ferramenta.cobranca');

    /* Cadastros */
    /* Cadastros - Empresa */
    Route::get('admin/empresa',                                   [CadastroEmpresaController::class, 'index'])->name('empresa');
    Route::get('admin/cadastro/empresa',                          [CadastroEmpresaController::class, 'index'])->name('cadastro.empresa');
    Route::get('admin/cadastro/empresa/editar/{id?}',             [CadastroEmpresaController::class, 'edit'])->name('cadastro.empresa.editar');
    Route::get('admin/cadastro/empresa/adicionar',                [CadastroEmpresaController::class, 'create'])->name('cadastro.empresa.adicionar');
    Route::post('admin/cadastro/empresa/store',                   [CadastroEmpresaController::class, 'store'])->name('cadastro.empresa.store');
    Route::post('admin/cadastro/empresa/update/{id}',             [CadastroEmpresaController::class, 'update'])->name('cadastro.empresa.update');
    /* Cadastros - Empresa - Configurações do Site */
    Route::get('admin/cadastro/empresa/site/{id?}',               [CadastroEmpresaController::class, 'site'])->name('cadastro.empresa.site');
    /* Cadastros - Cliente */
    Route::get('admin/cadastro/cliente',                          [CadastroClienteController::class, 'index'])->name('cadastro.cliente');
    Route::get('admin/cadastro/cliente/editar/{id?}',             [CadastroClienteController::class, 'edit'])->name('cadastro.cliente.editar');
    Route::get('admin/cadastro/cliente/adicionar',                [CadastroClienteController::class, 'create'])->name('cadastro.cliente.adicionar');
    Route::post('admin/cadastro/cliente/store',                   [CadastroClienteController::class, 'store'])->name('cadastro.cliente.store');
    Route::post('admin/cadastro/cliente/update/{id}',             [CadastroClienteController::class, 'update'])->name('cadastro.cliente.update');
    /* Cadastros - Produto */
    Route::get('admin/produto',                                   [CadastroProdutoController::class, 'index'])->name('produto');
    Route::get('admin/cadastro/produto',                          [CadastroProdutoController::class, 'index'])->name('cadastro.produto');
    Route::get('admin/cadastro/produto/editar/{id?}',             [CadastroProdutoController::class, 'edit'])->name('cadastro.produto.editar');
    Route::get('admin/cadastro/produto/adicionar',                [CadastroProdutoController::class, 'create'])->name('cadastro.produto.adicionar');
    Route::post('admin/cadastro/produto/store',                   [CadastroProdutoController::class, 'store'])->name('cadastro.produto.store');
    Route::post('admin/cadastro/produto/update/{id}',             [CadastroProdutoController::class, 'update'])->name('cadastro.produto.update');
    /* Cadastros - Associar Empresa/Lider ao Produto */
    Route::get('admin/cadastro/produto/associar',                 [CadastroProdutoAssociarController::class, 'index'])->name('cadastro.produto.associar');
    Route::get('admin/cadastro/produto/associar/editar/{id?}',    [CadastroProdutoAssociarController::class, 'edit'])->name('cadastro.produto.associar.editar');
    Route::get('admin/cadastro/produto/associar/adicionar',       [CadastroProdutoAssociarController::class, 'create'])->name('cadastro.produto.associar.adicionar');
    Route::post('admin/cadastro/produto/associar/store',          [CadastroProdutoAssociarController::class, 'store'])->name('cadastro.produto.associar.store');
    Route::post('admin/cadastro/produto/associar/update/{id}',    [CadastroProdutoAssociarController::class, 'update'])->name('cadastro.produto.update');

    /* Estoque */
    //Gerenciar
    Route::get('admin/estoque/gerenciar',                          [FerramentaCobrancaController::class, 'index'])->name('sites.gerenciar');

    /* Vendas */
    /* Ponto de Venda */
    Route::get('admin/venda/pdv',                                 [VendaPdvController::class, 'index'])->name('venda.pontodevenda');
    Route::get('admin/venda/adicionar',                           [VendaPdvController::class, 'create'])->name('venda.adicionar');
    Route::get('admin/venda/editar/{id?}',                        [VendaPdvController::class, 'edit'])->name('venda.editar');
    Route::post('admin/venda/store',                              [VendaPdvController::class, 'store'])->name('venda.store');
    Route::post('admin/cadastro/produto/update/{id}',             [VendaPdvController::class, 'update'])->name('venda.update');

    /* Relatório */
    // Logs de Acesso
    Route::get('admin/relatorio/logs_de_acesso',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.logs_de_acesso');
    // Empresas
    Route::get('admin/relatorio/empresas',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.empresas');
    // Produtos
    Route::get('admin/relatorio/produtos',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.produtos');
    // Clientes
    Route::get('admin/relatorio/clientes',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.clientes');
    // Estoque
    Route::get('admin/relatorio/estoque',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.estoque');
    // Vendas
    Route::get('admin/relatorio/vendas',                          [FerramentaCobrancaController::class, 'index'])->name('relatorio.vendas');

    /*
        @function pesquisar_produto_por_empresa
        @int id_empresa
        @retornar produtos que não foram vinculados ainda
        @caso null ou false, nenhum produto encontrado
    */
    Route::post('admin/cadastro/produto/associar/pesquisar_produto_por_empresa', [CadastroProdutoAssociarController::class, 'pesquisar_produto_por_empresa'])->name('produto.associar.pesquisar_produto_por_empresa');
    Route::post('admin/cadastro/produto/associar/pesquisar_empresa_por_produto', [CadastroProdutoAssociarController::class, 'pesquisar_empresa_por_produto'])->name('produto.associar.pesquisar_empresa_por_produto');

    /* Manipulação de Anexos */
    Route::post('admin/anexo/salvar_anexo',                       [AnexoController::class, 'store'])->name('anexo.salvar');

    /* APP - Retorno dos dados do sistema antigo */
    Route::get('admin/api/importar_cliente',                      [AppImportarController::class, 'importar_clientes'])->name('importar.cliente');
    Route::get('admin/api/importar_plano',                        [AppImportarController::class, 'importar_planos'])->name('importar.plano');
    Route::get('admin/api/importar_venda',                        [AppImportarController::class, 'importar_vendas'])->name('importar.venda');

    /* API de Controles */
    Route::post('admin/api/selecionar_empresa',                   [ApiController::class, 'selecionar_empresa'])->name('api.selecionar_empresa');

});

/* Rotas do Site */
Route::get('como-funciona',                                       [SiteController::class, 'comofunciona'])->name('site.comofunciona');


Route::get('admin/ferramenta/cobranca/automatica',            [FerramentaCobrancaController::class, 'cobranca_automatica'])->name('ferramenta.cobranca.automatica');
