
@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<h2>Add New Customer</h2>
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


<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$customer->id ?? ''}}" />
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" value="{{$customer->name ?? ''}}" class="form-control" placeholder="Name">
            </div>
        </div><br>

        <br>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group"><br>
                <strong>Phone:</strong>
            </div>
            </div>
            <input type="integer" name="phone_number" value="{{$customer->phone_number?? ''}}" class="form-control"  placeholder="phone">
            {{-- <textarea class="form-control" style="height:150px" name="detail"  value="{{$product->detail ?? ''}}" class="form-control" placeholder="Detail"></textarea> --}}
            </div>
        </div>
   
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group"><br>
                <strong>Address:</strong>
            </div>
            </div>
            <input type="text" name="address" value="{{$customer->address?? ''}}" class="form-control"   placeholder="address">
            {{-- <textarea class="form-control" style="height:150px" name="detail"  value="{{$product->detail ?? ''}}" class="form-control" placeholder="Detail"></textarea> --}}
            </div>
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
            <th>Name</th>
            <th>Phone No.</th>
            <th>Address</th>

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
            ajax: "{{ route('customers.index') }}",
            columns : [
                {data:'id',name:'id'},
                {data:'name',name:'name'},
                {data:'phone_number',name:'phone_number'},
                {data:'address',name:'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


        $('body').on('click', '.deleteCustomer', function (){
            var customer_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('customers.store') }}"+'/'+customer_id,
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
