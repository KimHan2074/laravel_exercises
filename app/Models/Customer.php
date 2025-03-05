<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['name', 'gender', 'email', 'address', 'phone_number', 'note'];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'id_customer');
    }
}
