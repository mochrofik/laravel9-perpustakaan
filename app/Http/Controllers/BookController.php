<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Models\Book;
use App\Models\BookCategories;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PDF;


class BookController extends Controller
{
    

    public function index(Request $request){

        $books = Book::with('bookCategory' );


        if (($s = $request->s)) {
            
            $books->whereHas('bookCategory', function($query) use ($request){
                $query->where('name_category', 'iLIKE', '%' . $request->s . '%');
            });
            $books->orWhere('title','iLIKE', '%' . $request->s . '%' )
            ->orWhere('author','iLIKE', '%' . $request->s . '%' );
            // ->orWhere('stock','=',  $request->s  );
        }
        

        $books = $books->orderBy('created_at', 'desc')
        
        ->paginate(5);

   
        $index = 0;

        $categories = BookCategories::all();

        return view('book.index', compact('books' ))->with('i' ,(request()->input('page', 1) - 1) * 5)->with('categories', $categories);



    }

    public function store(Request $request){

        $book = new Book();

        $book->title = $request->title;
        $book->author = $request->author;
        $book->status = 0;
        $book->category = $request->id_category;
        $book->stock = $request->stock;

        if($request->has('image')){
            
            $ekstensi = $request->file('image')->getClientOriginalExtension();
            $filename = round(microtime(true) * 1000).'-'. 'book.'.$ekstensi;
                
            $request->file('image')->move(public_path('img'), $filename);
    
            $book->img = $filename;
        }

        $book->save();

        if($book){
            return redirect('/books')->with('success', 'Add New Book Completed');
        }else{

            return redirect('/books')->with('error', 'Add New Book Not Completed');
        }
    }

    public function destroy($id){

        Book::where( 'id_book', $id)->delete();

        return redirect('/books')->with('success', 'Data Has Been Deleted!');
    }

    public function show($id){

        $book = Book::where('id_book',$id)->with('bookCategory')->first();

        return view('book.show', compact('book'));
    }

    public function update(Request $request){

    

        $book = Book::find($request->id_book);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->id_category;
        $book->stock = $request->stock;
        $book->save();

        return redirect('/books')->with('success', 'Data Has Been Updated!');
    }

    public function exportExcel(Request $request){
        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //fine border
                ],
            ],
            'font' => [
                'bold'  =>  true,
            ]
        ];

        $styleArrayBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //fine border
                ],
            ],
        ];

        $activeSheet->setCellValue('A2', 'ID');
        $activeSheet->setCellValue('B2', 'Title');
        $activeSheet->setCellValue('C2', 'Author');
        $activeSheet->setCellValue('D2', 'Category');
        $activeSheet->setCellValue('E2', 'Stock');

        $activeSheet->getColumnDimension("A")->setAutoSize(true);
        $activeSheet->getColumnDimension("B")->setAutoSize(true);
        $activeSheet->getColumnDimension("C")->setAutoSize(true);
        $activeSheet->getColumnDimension("D")->setAutoSize(true);
        $activeSheet->getColumnDimension("E")->setAutoSize(true);

        $activeSheet->getStyle('A2:E2')->applyFromArray($styleArrayBorder);
        
        $book = Book::with('bookCategory')->get();
        
        $mulai_target = 3;
        
        foreach($book as $val){
            $activeSheet->setCellValue('A'. $mulai_target, $val->id_book );
            $activeSheet->setCellValue('B'. $mulai_target, $val->title );
            $activeSheet->setCellValue('C'. $mulai_target, $val->author );
            $activeSheet->setCellValue('D'. $mulai_target, $val->bookCategory->name_category );
            $activeSheet->setCellValue('E'. $mulai_target, $val->stock );

            $activeSheet->getStyle('A'.$mulai_target. ':E'.$mulai_target)->applyFromArray($styleArrayBorder);
            $mulai_target++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $file = "file_export/books.xlsx";

        $Excel_writer->save($file);

        return response()->download($file);

        
    }


    public function templateExcel(Request $request){


        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //fine border
                ],
            ],
            'font' => [
                'bold'  =>  true,
            ]
        ];

        $styleArrayBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //fine border
                ],
            ],
        ];

        $activeSheet->setCellValue('A2', 'No');
        $activeSheet->setCellValue('B2', 'Title');
        $activeSheet->setCellValue('C2', 'Author');
        $activeSheet->setCellValue('D2', 'Category');
        $activeSheet->setCellValue('E2', 'Stock');

        $activeSheet->getColumnDimension("A")->setAutoSize(true);
        $activeSheet->getColumnDimension("B")->setAutoSize(true);
        $activeSheet->getColumnDimension("C")->setAutoSize(true);
        $activeSheet->getColumnDimension("D")->setAutoSize(true);
        $activeSheet->getColumnDimension("E")->setAutoSize(true);

        $activeSheet->setCellValue('A3', '1');
        $activeSheet->setCellValue('B3', 'Input book title');
        $activeSheet->setCellValue('C3', 'Input book author');
        $activeSheet->setCellValue('D3', 'Input ID category (you can see in Book Categories)');
        $activeSheet->setCellValue('E3', 'Input number of stock');

        $mulai_target = 3;
        // Create a new worksheet called "My Data"
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Book Categories');

        // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
        $spreadsheet->addSheet($myWorkSheet, 1);

        $activeSheetTarget = $spreadsheet->getSheetByName('Book Categories');

        $activeSheetTarget->getStyle('A')->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $activeSheetTarget->getStyle('A2:B2')->applyFromArray($styleArray);


        $activeSheetTarget->setCellValue('A2', 'ID');
        $activeSheetTarget->setCellValue('B2', 'Name Category');
        $activeSheetTarget->getColumnDimension("A")->setAutoSize(true);
        $activeSheetTarget->getColumnDimension("B")->setAutoSize(true);


        $categories = BookCategories::all();

        foreach($categories as $val){
            $activeSheetTarget->setCellValue('A'. $mulai_target, $val->id );
            $activeSheetTarget->setCellValue('B'. $mulai_target, $val->name_category );
            $mulai_target++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $file = "file_export/export-template.xlsx";
        $Excel_writer->save($file);

        return response()->download($file);
        
    }

    public function importBook(Request $request){


        if( !$request->has('file_name') ){

            return redirect('/books')->with('error', 'File Empty!');

        }


        $spreadsheet =  \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file_name'));
        $worksheet = $spreadsheet->getSheet(0);
        $highestRow = $worksheet->getHighestRow();
        $mulai = 3;


        try {
            for ($row = $mulai; $row <= $highestRow; ++$row) {
                $no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $title = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $author = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $category = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $stock = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                

                $cek = BookCategories::find( $category);

                
                if(empty($cek) ){
                    return redirect('/books')->with('error', 'ID Category is wrong! ');
                }

                $book = new Book();


                if ($no == '' && $title == '' && $author == '' && $category == '') {
                    break;
                }
                if ($no == '' && $title == '' && $author == '' && $category == '' && $stock == '') {
                    return redirect('/books')->with('error', "Import data excel not completed!");                }

                $book->status = 0;
                $book->title = $title;
                $book->author = $author;
                $book->category = $category;
                $book->stock = $stock;


                $book->save();


            }

            return redirect('/books')->with('success', "Import Success!");
        } catch (\Exception $e) {
            dd($e) ;
        }
    }

    public function exportPDF(Request $request){
        $books = Book::all();

   
        $index = 0;


        $pdf = PDF::loadview('book.report_pdf',  ['books'=>$books,  'i'  => $index])->setOptions(['defaultFont' => 'sans-serif']);;
	    return $pdf->download('file_export/laporan.pdf');
        // return $pdf->stream();
    }
}
