
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
</div><br>
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

    <div class="form-row">
    <div class="form-group col-md-2">
            <div class="form-group">
                <strong>Select Date:</strong>
                <input type="date" name="date" value="{{$saleDetail->date ?? ''}}" class="form-control" id="date" placeholder="Date">
            </div>
  </div>


    <div class="form-group col-md-2" style="margin-left:50px">
        <strong>Select Customer:</strong>
        <select class="form-control " name="sale_master_id" required>
        <option>Select Customer</option>
        @foreach ($customers as $customer)
           <option value="{{ $customer->id }}">{{ $customer->name }}</option>
         @endforeach
       </select><br>
  </div>

    </div>
    <div class="form-row">
        <div class="col-xs-12 col-sm-12 col-md-2">

            <strong>Select Product:</strong>
             <select class="form-control " name="product_id" required>
             <option>Select Product</option>
             @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
            </select><br>
</div>


{{-- First Table --}}
<div class="col-sm-12 col-sm-12 col-md-6" style="margin-left: 150px">

   <table  id="myTable1" class="table table-bordered"  style="width:900px">

    <thead class="bg-success text-white">
        <tr>
            <th>Product</th>
             <th>quantity</th>
             <th>price</th>
             <th>total</th>
            <th width="280px">Action</th>
        </tr>
    </thead>

     <tbody>

     </tbody>
    </table>

<br>
</div>
</div>

<div class="form-row">
    <div class="col-xs-12 col-sm-12 col-md-2">
                <strong>Quantity:</strong>
                <input type="integer" name="quantity" value="{{$saleDetail->quantity ?? ''}}" class="form-control" placeholder="Qunatity">

                <strong>Price:</strong>
                <input type="integer" name="price" value="{{$saleDetail->price?? ''}}" class="form-control" placeholder="Price">


        <div class="col-lg-12 col-md-12 col-lg-12 text-center">
                <button type="submit" id="add"  class="btn btn-success"  style="margin:20px;width:100px" >Add</button>
        </div>

            </div>


            <div class="col-lg-12 col-md-12 col-lg-12 text-right">
                <button type="submit"   class="btn btn-success"  style="margin:20px;width:100px" >Save</button>
        </div>

</form>


{{-- //SeconD table --}}
<table id="myTable2" class="table table-bordered" >
    <thead class="bg-success text-white">
        <tr>
            <th>No.</th>
            <th>Customer</th>
             <th>Date</th>
             <th>total amount</th>
            <th width="280px">Action</th>
        </tr>
    </thead>

     <tbody>

     </tbody>
    </table>

    <script type="text/javascript">
        $('#add').on('click', function() {
        var id=$('#id').val();
        var date=$('#date').val();
        var sale_master_id=$('#sale_master_id').val();
        var product_id=$('#product_id').val();
        var quantity=$('#quantity').val();
        var price=$('#price').val();
        var count = $('#myTable1 tr').length;
        if(id!="" && date !="" && sale_master_id!="" && product_id!="" && quantity!="" && price !=""){
        $('#myTable1 tbody').append('<tr class="child"><td>'+count+'</td><td>'+id+'</td><td>'+date+'</td><td>'+sale_master_id+'</td><td>'+product_id+'</td><td>'+quantity+'</td><td>'+price+'</td><td><a href="javascript:void(0);" class="remCF1 btn btn-small btn-danger">Remove</a></td></tr>');
        }
        });
        $(document).on('click','.remCF1',function(){
        $(this).parent().parent().remove();
        $('#myTable1 tbody tr').each(function(i){
         $($(this).find('td')[0]).html(i+1);
        });
        });
        </script>
</body>


{{-- <script>
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('saledetails.index') }}",
            columns : [
                {data:'id',name:'id'},
                {data:'product',name:'product'},
                {data:'quantity',name:'quantity'},
                {data:'price',name:'price'},
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
</script> --}}
</html>
@endsection



