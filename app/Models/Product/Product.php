<?php

namespace App\Models\Product;

use App\Models\Product\ProductCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'amount_in_stock', 'product_category_id',
        'image'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price'             => 'decimal:2',
        'amount_in_stock'   => 'integer',
    ];

    public function getImageLinkAttribute()
    {
        return !is_null($this->image) ? 'storage/' . $this->image : 'storage/img/empty.png';
    }

    /**
     * return a single ProductCategory
     *
     * @return ProductCategory
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
