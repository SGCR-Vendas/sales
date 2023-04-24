@extends('dashboard')
@section('title', 'Cobrança Automática')
@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-access-point-network menu-icon"></i>
        </span> Cobrança Automática
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span>Enviar Cobrança Automática <i class="mdi mdi-check icon-sm text-primary align-middle"></i></span>
            </li>
        </ul>
    </nav>
</div>

<!-- <div class="page-header">
    <h3 class="page-title">
        <a href="{{ route('ferramenta.mensagem.adicionar') }}">
            <button class="btn btn-sm btn-primary">Enviar Cobrança </button>
        </a>
    </h3>
</div> -->

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="pb-2">
                    <span class="btn btn-gradient-dark"> {{ date('d/m/Y') }} </span>
                    <span class="btn btn-gradient-danger"> Cobranças de Hoje </span>

                    <a href="{{ route('ferramenta.cobranca.automatica') }}" target="_blank">
                        <span class="btn btn-gradient-success border-dark"> Disparar Cobrança </span>
                    </a>
                    <hr>
                </div>

                <table class="table table-hover table-striped" id="lista-simples">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Cliente</th>
                            <th>Plano</th>
                            <th>Data da Compra</th>
                            <th>Vencimento</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($vence_hoje as $hoje)
                        <tr>
                            <td>{{ $hoje->nome }}</td>
                            <td>{{ $hoje->nome_cliente }}</td>
                            <td><span class="badge badge-warning badge-margin">{{ $hoje->titulo_produto }}</span></td>
                            <td>{{ $hoje->data_venda }}</td>
                            <td><span class="badge badge-dark badge-margin">{{ Tratamento::FormatarData($hoje->data_vencimento) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Empresa</th>
                            <th>Cliente</th>
                            <th>Plano</th>
                            <th>Data da Compra</th>
                            <th>Vencimento</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection