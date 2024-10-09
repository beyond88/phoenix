<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{

    protected $table = 'term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';
    public $timestamps = false;

    protected $fillable = [
        'term_id', 
        'taxonomy', 
        'description', 
        'parent', 
        'count'
    ];

    public function incrementCount($value = 1)
    {
        $this->increment('count', $value);
    }

    public function decrementCount($value = 1)
    {
        $this->decrement('count', $value);
    }

}
