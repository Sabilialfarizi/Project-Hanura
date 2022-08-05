<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    public $table = 'barang';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'kode',
        'nama',
        'kategori_id',
        'unit_id',
        'foto',
        'stok_akhir',
        'is_active',
        'is_paket',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ];

    public static function getItem($value)
    {
        return Item::where('id', $value)->select('nama')->first();
    }

    public function getKategori()
    {
        return $this->belongsTo(\App\ItemCategory::class,'kategori_id');
    }

    public function getUnit()
    {
        return $this->belongsTo(\App\ItemUnit::class,'unit_id');
    }

    public static function getStockHabis()
    {
        return \DB::table('view_barang_stock_habis')->get();
    }
}
