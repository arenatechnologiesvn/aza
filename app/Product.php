<?php

namespace App;
use App\Helper\RoleConstant;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Mediable;
use Plank\Mediable\Media as Media;
use Tymon\JWTAuth\Claims\Custom;

class Product extends BaseModel
{
    use Mediable;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_code',
        'name',
        'description',
        'unit',
        'quantitative',
        'price',
        'discount_price',
        'category_id',
        'provider_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function orders() {
        return $this->belongsToMany(Order::class,'order_product')
                ->withPivot('quantity', 'tmp_price', 'real_price');
    }

    public function customerFavorites () {
        return $this->belongsToMany(Customer::class,'favorites', 'product_id','customer_id')
            ->where('customer_id', '=', $this->getCustomerId());
    }

    public function customerCarts () {
        return $this->belongsToMany(Customer::class,'carts', 'product_id','customer_id')
            ->withPivot('quantity')
            ->where('customer_id', '=', $this->getCustomerId());
    }
    public function previews () {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->where([
            ['mediable_type', '=', 'App\Product'],
            ['tag', '=', 'preview']
        ]);
    }
    public function featured () {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->where([
            ['mediable_type', '=', 'App\Product'],
            ['tag', '=', 'featured']
        ]);
    }

    private function getCustomerId (){
        try {
            if (Auth::user()->role_id == RoleConstant::Customer){
                return Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
