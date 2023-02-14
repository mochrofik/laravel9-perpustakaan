<?php

namespace App\Http\Controllers;

use App\Models\BookCategories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookCategoryController extends Controller
{
    
    public function index(Request $request){

   
        $categories = BookCategories::where([
            ['name_category', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere( 'name_category', 'iLIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
      

        return view('master_data.book_category', compact('categories' ))->with('i' ,(request()->input('page', 1) - 1) * 5);

    }

    public function show(Request $request, $id){

        $category = BookCategories::find($id);


        return response()->json([
            'status' => 200,
            'data' => $category
        ]);

        // return view('master_data.book_category_detail', [
            
        //     'category' => $category,
        //     'id_category' => $id]);
    }

    public function getCategories(Request $request){
        $categories = BookCategories::where([
            ['name_category', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere( 'name_category', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);

   
        $index = 0;
        
    }

    public function addBookCategories(Request $request){

        if($request->input('name_category') == null){

            return Session::flash('error', 'Field is required');
        }

        $categories = new BookCategories();
        $categories->name_category = $request->name_category;
        $categories->save();


        return Session::flash('success', 'Input Book Category is completed!');
  
        
    }

    public function updateBookCategories( Request $request,  $id){



        $categories = BookCategories::find($id);

        if($request->input('name_category') == null){
            return Session::flash('error', 'Data is required!');
        }

        $categories->name_category = $request->name_category;
        $categories->save();

        return Session::flash('success', 'Data Has Been Updated!');

    }
    public function destroy($id)
    {
        //delete post by ID
        BookCategories::where('id', $id)->delete();

        //return response

       return Session::flash('success', 'Data Has Been Deleted!');

      
    }

}
