
<html>
<head>
    <title>

    </title>

 <!-- Custom styles for this template-->
 <link href="css/sb-admin-2.css" rel="stylesheet">

 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

 <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
 </style>

</head>
<body>

    
    <div class="container">
        <h1> Books Data</h1>
    
   
    
        
        <table class="table mt-2 table table-bordered"  >
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Category</th>
                    <th scope="col">Stock</th>
                </tr>
            </thead>
            <tbody>
    
    
       
    
    
                    @foreach ($books as $data )
    
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->author }}</td>
                        <td>{{ $data->bookCategory->name_category }}</td>
                        <td>{{ $data->stock }}</td>
                     
                    </tr>
                    @endforeach
    
            </tbody>
        </table>
    </div>
</body>

</html>