<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Monolog\ErrorHandler;

class LoanController extends Controller
{
    //

    public function index(Request $request){


   

        
       
        $books = Book::with('bookCategory');

        if(($s = $request->s)){

            $books->where(function ($query) use ($request) {
                    $query->where('title', 'ILIKE', "%{$request->s}%")
                    ->orWhere('author', 'ILIKE', "%{$request->s}%");
                
                $query->orWhereHas('bookCategory', function($q) use ($request){
                    $q->where('name_category', 'ILIKE', "%{$request->s}%");
                });
            });

        }
        
       $books = $books->paginate(5);

        return view('loan.index', compact('books' ))->with('i' ,(request()->input('page', 1) - 1) * 5);



    }

    public function loanBook(Request $request){
        DB::connection('pgsql')->beginTransaction();
        try{
        
            $book = Book::find($request->id_book);
    
            $stock = $book->stock ;

            if($stock < 1){
                return redirect('/loans')->with('error', "Book not available");
            }
    
            $book->stock = $stock - 1;
            $book->save();


        $loan = new Loan();

        $user = Auth::user();
        $loan->id_book = $request->id_book;
        $loan->id_user = $user->id;
        $loan->date_loan = date('Y-m-d');

        $loan->save();


        DB::connection('pgsql')->commit();
        return redirect('/loans')->with('success', 'book successfully borrowed! ');

        }catch (\Exception $e) {
            DB::connection('pgsql')->rollBack();
            throw new Exception($e);
        }


    }

    public function myLoans(Request $request){


        $user = Auth::user();

        $loans = Loan::where('date_return', null)-> where('id_user', $user->id)->with('haveBook')->with('haveBook.bookCategory')->get();

        

        return view('my_loans.index', compact('loans'))->with('i');


    }

    public function memberLoans(Request $request){

        $loans = Loan::with('haveBook')->with('haveBook.bookCategory')->with('memberLoan');

        if(($s = $request->search)){

            $loans->where(function ($query) use ($request) {
                $query->whereHas('haveBook', function($q) use ($request){
                    $q->where('title', 'ILIKE', "%{$request->search}%");
                });
                $query->orWhereHas('haveBook.bookCategory', function($q) use ($request){
                    $q->where('name_category', 'ILIKE', "%{$request->search}%");
                });
                $query->orWhereHas('memberLoan', function($q) use ($request){
                    $q->where('name', 'ILIKE', "%{$request->search}%");
                });
            });

        }


        $loans = $loans->paginate('5');

        return view('member_loan.index', compact('loans'))->with('i');
    }

    public function loanReturn(Request $request, $id){

        DB::connection('pgsql')->beginTransaction();
        try{

            $dt     = Carbon::now();

        $loan = Loan::find($id);

        $book = Book::find($loan->id_book);

        $stock = $book->stock;
        $book->stock = $stock +1;

        
       $date = $dt->diffInDays($loan->date_loan);



        
        if($date > 7 && $date < 14){

            $loan->penalty = 10000;
            
        }else if($date > 14){
            $loan->penalty = 50000;
        }


        $loan->date_return = date('Y-m-d');
        
        
        
        $book->save();

        $loan->save();

        
        DB::connection('pgsql')->commit();
        return redirect('/my-loans')->with('success', 'book successfully return! ');

        }catch (\Exception $e) {
            DB::connection('pgsql')->rollBack();
            throw new Exception($e);
        }
    }
}
