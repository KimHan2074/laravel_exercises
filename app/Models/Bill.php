<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';
    protected $fillable = ['id_customer', 'date_order', 'total', 'payment', 'note'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class, 'id_bill');
    }
}

