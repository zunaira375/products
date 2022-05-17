@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sales Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">;
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        ___scripts_1___ />
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

        <div class="container" style="display:inline block;">

            <h3 style="color: green;text-align:center;"><strong>CRUD using JAVASCRIPT In Table</strong>
            </h3><br>
            <form action="" onsubmit="event.preventDefault();onFormSubmit();" autocomplete="off" id="editform"
                target="frame" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $saleDetail->id ?? '' }}" />

                <div class="form-row " style="margin-left:15px;">

                    <div class="form-group col-md-4" style="margin-left: 5px;">
                        <strong>Select Date:</strong>
                        <input type="date" name="date" id="date" value="{{ $saleDetail->date ?? '' }}"
                            class="form-control" id="date" placeholder="Date">
                    </div>



                    <div class="form-group col-md-4" style="margin-left: 20px;">
                        <strong>Select Customer:</strong>
                        <select class="form-control " name="sale_master_id" id="sale_master_id" required>
                            <option value="" disabled selected hidden>Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select><br>
                    </div>

                </div>

                <div class="container" style="display:inline-block;float:right">

                    <div class="container col-md-6" style="float:right;diplay:inline;margin-top:22px;">
                        <table id="tbl1" class="table table-bordered" style="table-layout: fixed;">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>total </th>
                                    <th width="150px;">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>

                        <div class="col-lg-12 col-md-12 col-lg-12 text-right" style="text-align: center">
                            <button type="submit" class="btn btn-success" id="btnSave"
                                style="margin:20px;width:100px">Save</button>
                        </div>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4" style="float: left;">

                        <strong>Select Product:</strong>
                        <select class="form-control " name="product_id" id="product_id" required>
                            <option value="" disabled selected hidden>Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->name }}">{{ $product->name }}</option>
                            @endforeach
                        </select><br>

                        <strong>Quantity:</strong>
                        <input type="integer" name="quantity" id="quantity" value="{{ $saleDetail->quantity ?? '' }}"
                            class="form-control" placeholder="Qunatity">
                        <br>
                        <strong>Price:</strong>
                        <input type="integer" name="price" id="price" value="{{ $saleDetail->price ?? '' }}"
                            class="form-control" placeholder="Price">
                        <br>
                        <div style="text-align: center">


                            <button id="updateButton" onclick="productUpdate();" class="btn btn-success"
                                style="margin:20px;width:80px;align:center;">Add</button>
                        </div>



                    </div>

            </form>

            <iframe name="frame" style=" display: none;"></iframe>

            {{-- //SeconD table --}}
            <table id="tbl2" class="table table-bordered">
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

        </div>

    </body>

    <script type="text/javascript">
        function productAddToTable() {
            // First check if a <tbody> tag exists, add one if not
            if ($("#tbl1 tbody").length == 0) {
                $("#tbl1").append("<tbody></tbody>");
            }

            // Append product to the table
            $("#tbl1 tbody").append("<tr>" +
                "<td>" + $("#product_id").val() + "</td>" +
                "<td>" + $("#quantity").val() + "</td>" +
                "<td>" + $("#price").val() + "</td>" +
                "<td>" + $("#quantity").val() * $("#price").val() + "</td>" +
                "<td>" +
                "<a style='width:60px;'' onclick='detailDisplay(this);' class='btn btn-primary btn-sm btnEdit text-white'>Edit</a>.<button  onclick='btnDelete(this);' class='btn btn-danger  btn-sm btnDelete'>Delete</button> " +
                "</td>" +
                "</tr>");
        }


        function formClear() {
            $("#product_id").val("");
            $("#quantity").val("");
            $("#price").val("");
        }

        function btnDelete(ctl) {
            alert("Are You sure want to delete ?");
            $(ctl).parents("tr").remove();
        }

        // Current product being edited
        var _row = null;
        _row = $(ctl).parents("tr");
        var cols = _row.children("td");

        function detailDisplay(ctl) {
            _row = $(ctl).parents("tr");
            var cols = _row.children("td");
            $("#product_id").val($(cols[0]).text());
            $("#quantity").val($(cols[1]).text());
            $("#price").val($(cols[2]).text());

            // Change Update Button Text
            $("#updateButton").text("Update");
        }

        function productUpdate() {
            if ($("#updateButton").text() == "Update") {
                productUpdateInTable();
            } else {
                productAddToTable()
            }

            // Clear form fields
            formClear();

            // Focus to product name field
            // $("#product_id").focus();
        }

        function productBuildTableRow(id) {
            var ret = "<tr>" +
                "<td>" + $("#product_id").val() + "</td>" +
                "<td>" + $("#quantity").val() + "</td>" +
                "<td>" + $("#price").val() + "</td>" +
                "<td>" + $("#quantity").val() * $("#price").val() + "</td>" +
                "<td>" +
                "<a style='width:60px;'' onclick='detailDisplay(this);' class='btn btn-primary btn-sm btnEdit text-white'>Edit</a>.<button  onclick='btnDelete(this);' class='btn btn-danger  btn-sm btnDelete'>Delete</button> " +
                "</td>" +
                "</tr>"

            return ret;
        }



        function productUpdateInTable() {
            // Add changed product to table
            $(_row).after(productBuildTableRow());

            // Remove old product row
            $(_row).remove();

            // Clear form fields
            formClear();

            // Change Update Button Text
            $("#updateButton").text("Add");
        }
    </script>

    </html>
@endsection
