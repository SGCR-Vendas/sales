<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class CadastroVenda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    public $timestamps = true;

    // Por padrão o laravel requer para as o campo de chave primaria o nome
    // ID, porem quando se quer utilizar um nome diferente se faz necessário
    // aplicar a regra a baixo.
    protected $primaryKey = 'id';

    // Com esta proteção permite que somente os campos identificados no array
    // serão manipulados.
    protected $fillable =   [
        'id',
        'id_cliente',
        'id_produto',
        'data_vencimento',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function ListaVendasUltimas($periodo)
    {

        if (!$periodo) return [];

        $consulta = CadastroVenda::select(
            'vendas.*',
            DB::raw('DATE_FORMAT(vendas.created_at, "%d/%m/%Y %H:%i") as data_venda'),
            'c.nome as nome_cliente',
            'p.titulo as titulo_produto',
            'pc.valor_compra',
            'pc.valor_venda'
        )
            ->join("clientes AS c", "c.id", "=", "vendas.id_cliente")
            ->join("produtos AS p", "p.id", "=", "vendas.id_produto")
            ->join("produtos_configuracoes AS pc", "pc.id", "=", "vendas.id_produto")
            ->latest()
            ->skip(0)
            ->take(10)
            ->get()
            ->toArray();


        return $consulta;
    }

    public static function BuscarVencimento($data)
    {
        if (!$data) return [];

        $listaVencimento = CadastroVenda::select(
            'vendas.*',
            DB::raw('DATE_FORMAT(vendas.created_at, "%d/%m/%Y %H:%i") as data_venda'),
            'c.nome as nome_cliente',
            'c.celular',
            'c.id as id_cliente',
            'p.titulo as titulo_produto',
            'pc.valor_compra',
            'pc.valor_venda',
            'e.nome',
            'e.cpf'
        )
            ->join("clientes AS c", "c.id", "=", "vendas.id_cliente")
            ->join("produtos AS p", "p.id", "=", "vendas.id_produto")
            ->join("produtos_configuracoes AS pc", "pc.id", "=", "vendas.id_produto")
            ->join("empresas AS e", "e.id", "=", "c.id_empresa")
            ->where('vendas.data_vencimento', 'LIKE', '%' . $data . '%')
            ->where('c.id_empresa', 1)
            ->get();

        return $listaVencimento;
    }


}
