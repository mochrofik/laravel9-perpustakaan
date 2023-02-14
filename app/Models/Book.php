<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;


    protected $primaryKey = 'id_book';


    public function bookCategory(){
        return $this->hasOne('App\Models\BookCategories', 'id', 'category');
    }

    public function loanBook(){

        return $this->hasOne('App\Models\Loan', 'id_book', 'id_book' );
    }
}
