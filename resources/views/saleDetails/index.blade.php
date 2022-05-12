
@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sales Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">;
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

</head>
<body>
 @section('content')
 <!--alert -->
 @if ($message = Session::get('success'))
<div class="alert alert-success alert-server" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p>{{ $message }}</p>
</div>
@endif
<header>
   <!--- NavBar-->




</header>
<!--end of header-->

<div  style="padding-left:2px;padding-top:20px" >
<h2>Add New SalesDetails</h2>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('saledetails.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$saleDetail->id ?? ''}}" />
     <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Date:</strong>
                <input type="date" name="date" value="{{$saleDetail->date ?? ''}}" class="form-control" placeholder="Date">
            </div>
        </div><br>


        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Quantity:</strong>
                <input type="integer" name="quantity" value="{{$saleDetail->quantity ?? ''}}" class="form-control" placeholder="Qunatity">
            </div>
        </div><br>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>price:</strong>
                    <input type="integer" name="price" value="{{$saleDetail->price ?? ''}}" class="form-control" placeholder="Price">
                </div>
            </div><br>

 <div class="row">



                    <select class="form-control select2" name="sale_master_id" required>
                     <option>Select customer</option>
                       @foreach ($salemasters as $salesMaster)
                            <option value="{{$salesMaster->id}}" @if(isset($saleDetail) && $saleDetail->sale_master_id==$salesMaster->id) selected="selected" @endif>{{$salesMaster->id}} </option>
                       @endforeach
                    </select>

            </div> <br>
        <br>


        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                <button type="submit"   class="btn btn-primary"style="margin:35px" >Submit</button>
        </div>
    </div>

</form>
 <table id="table" class="table table-bordered">
    <thead class="bg-secondary text-white">
        <tr>
            <th>No</th>
            <th>Date</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Customer</th>


            <th width="280px">Action</th>
        </tr>
    </thead>

     <tbody>

     </tbody>
    </table>

</body>
<script>
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('saledetails.index') }}",
            columns : [
                {data:'id',name:'id'},
                {data:'date',name:'date'},
                {data:'price',name:'price'},
                {data:'quantity',name:'quantity'},
                {data:'sale_master_id',name:'sale_master_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


        $('body').on('click', '.deleteDetails', function (){
            var details_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('saledetails.store') }}"+'/'+details_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }else{
                return false;
            }
        });
    });
</script>

</html>
@endsection
