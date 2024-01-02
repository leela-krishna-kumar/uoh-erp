<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id', 'unit', 'serial_number', 'quantity', 'description', 'attach', 'status','type', 
    ];

    public const TYPE_ASSEST_ITEM = 0;
    public const TYPE_INVENTORY_ITEM = 1;


    public const TYPES = [
        "0" => ['label' =>' Assest Item','color' => 'primary'],
        "1" => ['label' =>'Inventory Item','color' => 'danger'],  
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function stocks()
    {
        return $this->hasMany(ItemStock::class, 'item_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(ItemIssue::class, 'item_id', 'id');
    }
}
