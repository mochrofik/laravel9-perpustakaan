<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Loan extends Model
{
    use HasFactory;


    protected $primaryKey = 'id_loan';

    public function haveBook(){

        return $this->hasOne('App\Models\Book', 'id_book', 'id_book' );
    }
    
    public function memberLoan(){
        return $this->hasOne('App\Models\User', 'id', 'id_user' );

    }


}
