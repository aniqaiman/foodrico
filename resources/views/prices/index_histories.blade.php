@extends('layout.master')

@section('style')
@endsection

@section('content')
<section class="content-header">
  <h1>
    Promo Price Management
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{ route('dashboard') }}">
        <i class="fa fa-dashboard"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="#">Promo Price Management</a>
    </li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body">
          <table class="table table-bordered" id="buyer-table" style="width:100%">
            <thead>
              <tr class="bg-black">
                <th>Date</th>
                <th>Item</th>
                <th>SKU#</th>
                <th>Buying Price (Grade A)</th>
                <th>Selling Price (Grade A)</th>
                <th>Buying Price (Grade B)</th>
                <th>Selling Price (Grade B)</th>
                <th style="width: 1%;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($prices as $price)
                <td>$price->price_date</td>
                <td>$price->product->name</td>
                <td></td>
                <td>$price->buying_price_a</td>
                <td>$price->selling_price_a</td>
                <td>$price->buying_price_b</td>
                <td>$price->selling_price_b</td>
                <td></td>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
@endsection

@section('script')
@endsection