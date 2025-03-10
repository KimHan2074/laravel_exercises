<?php
namespace App\Models;

use App\Models\TypeProduct;
use App\Models\BillDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['name', 'id_type', 'description', 'unit_price', 'promotion_price', 'image', 'unit'];

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class, 'id_type');
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class, 'id_product');
    }
}
