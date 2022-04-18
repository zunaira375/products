<div class="row"  style="text-align:right">
    <div class="col-lg-6 " class="mxy-auto" style="width: 400px ;" >
        <div  >
            <h2>Add New Product</h2>

       @if(isset($products))

{{ Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) }}
@else
{{ Form::open(['route' => 'products.create']) }}
@endif

Name:{{ Form::text('name', Input::old('name')) }}<br><br>
Detail:{{ Form::text('detail', Input::old('detail')) }}
{{-- More fields... --}}<br><br>
{{ Form::submit('Save', ['index' => 'submit']) }}
{{ Form::close() }}

    </div>
</div>

</div>
