@extends('layout.master')
@section('style')
@endsection

@section('content')

@foreach($orders as $order)
<div class="modal fade" id="order_{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_{{ $order->id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel_{{ $order->id }}">{{ $order->created_at }} | {{ $order->id }}</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <th>#</th>
            <th>Item</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th class="text-center">Total</th>
          </thead>
          <tbody>
            @foreach ($order->products as $key => $product)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $product->name }} (Grade {{ $product->pivot->grade }})</td>
              <td class="text-center" nowrap>{{ $product->pivot->quantity }} kg</td>
              <td class="text-center" nowrap>
                @switch($product->pivot->grade) 
                  @case("A") RM {{ number_format($product->priceLatest()["buying_price_a"], 2) }} @break
                  @case("B") RM {{ number_format($product->priceLatest()["buying_price_b"], 2) }} @break
                  @case("C") RM {{ number_format($product->priceLatest()["buying_price_b"], 2) }} @break
                @endswitch
              </td>
              <td class="text-center" nowrap>
                @switch($product->pivot->grade) 
                  @case("A") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buying_price_a"], 2) }} @break
                  @case("B") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buying_price_b"], 2) }} @break
                  @case("C") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buying_price_b"], 2) }} @break
                @endswitch
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <span class="pull-left">
          @if ($order->status === 1)
          <span class="label label-warning">Pending</span>
          @elseif ($order->status === 3)
          <span class="label label-success">Completed</span>
          @endif
        </span>
        <h3 class="pull-right">
          Total:
          <span class="label label-default">RM {{ number_format($order->totalPrice(), 2) }}</span>
        </h3>
      </div>
    </div>
  </div>
</div>
@endforeach

@foreach($stocks as $stock)
<div class="modal fade" id="stock_{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_{{ $stock->id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel_{{ $stock->id }}">{{ $stock->created_at }} | {{ $stock->id }}</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <th>#</th>
            <th>Item</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th class="text-center">Total</th>
          </thead>
          <tbody>
            @foreach ($stock->products as $key => $product)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $product->name }} (Grade {{ $product->pivot->grade }})</td>
              <td class="text-center" nowrap>{{ $product->pivot->quantity }} kg</td>
              <td class="text-center" nowrap>
                @switch($product->pivot->grade) 
                  @case("A") RM {{ number_format($product->priceLatest()["buying_price_a"], 2) }} @break
                  @case("B") RM {{ number_format($product->priceLatest()["buying_price_b"], 2) }} @break
                  @case("C") RM {{ number_format($product->priceLatest()["buying_price_b"], 2) }} @break
                @endswitch
              </td>
              <td class="text-center" nowrap>
                @switch($product->pivot->grade) 
                  @case("A") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buyer_price_a"], 2) }} @break
                  @case("B") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buyer_price_b"], 2) }} @break
                  @case("C") RM {{ number_format($product->pivot->quantity * $product->priceLatest()["buyer_price_b"], 2) }} @break
                @endswitch
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <span class="pull-left">
          @if ($stock->status === 1)
          <span class="label label-warning">Pending</span>
          @elseif ($stock->status === 3)
          <span class="label label-success">Completed</span>
          @endif
        </span>
        <h3 class="pull-right">
          Total:
          <span class="label label-default">RM {{ number_format($stock->totalPrice(), 2) }}</span>
        </h3>
      </div>
    </div>
  </div>
</div>
@endforeach

<section class="content-header">
  <h1>
    Order Management
    <small>Trackings</small>
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{ route('dashboard') }}">
        <i class="fa fa-dashboard"></i>Dashboard</a>
    </li>
    <li>Order Management</li>
    <li class="active">Trackings</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Buyer</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="order-table">
            <thead>
              <tr class="bg-black">
                <th>Date</th>
                <th>Order#</th>
                <th class="text-nowrap">Buyer Name</th>
                <th>Buyer#</th>
                <th>Location</th>
                <th class="text-nowrap">Lorry Assigned</th>
                <th class="text-center" style="width: 1%;">Status</th>
                <th style="width: 1%;"></th>
              </tr>
            </thead>

            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>{{ $order->created_at }}</td>
                <td>
                  <a href="#" data-toggle="modal" data-target="#order_{{ $order->id }}">
                    {{ $order->id }}
                  </a>
                </td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->id }}</td>
                <td>
                  {{ $order->user->address }}
                  <a href="https://www.google.com/maps/search/?api=1&query={{ $order->user->latitude }},{{ $order->user->longitude }}" target="_blank">
                    <i class="fa fa-map-marker"></i>
                  </a>
                </td>
                <td>
                  
                    
                    <select class="driver_drop" id="lorry_select_{{$order->id}}">
                      <option value="0">No driver selected</option>
                      @foreach($drivers as $driver)
               
                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                    @endforeach
                    </select>
 
                </td>
                <td class="text-center">
                  @if ($order->status === 1)
                  <span class="label label-warning">Pending</span>
                  @elseif ($order->status === 3)
                  <span class="label label-success">Completed</span>
                  @endif
                </td>
                <td class="text-center">
                  @if ($order->status === 1)
                  <div class="btn-group-vertical btn-group-sm">
                    <button class="btn btn-success" data-id="{{ $order->id }}" data-type="order" onclick="completeOrderStock(this)">Completed</button>
                    <button class="btn btn-warning" disabled>Pending</button>
                  </div>
                  @elseif ($order->status === 3)
                  <div class="btn-group-vertical btn-group-sm">
                    <button class="btn btn-success" disabled>Completed</button>
                    <button class="btn btn-warning" data-id="{{ $order->id }}" data-type="order" onclick="pendingOrderStock(this)">Pending</button>
                  </div>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="pull-right">
            {{ $orders->links() }}
          </div>
        </div>
      </div>
    </div>
    <!-- /.box -->
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Seller</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="stock-table">
            <thead>
              <tr class="bg-black">
                <th>Date</th>
                <th>Order#</th>
                <th class="text-nowrap">Seller Name</th>
                <th>Seller#</th>
                <th>Location</th>
                <th class="text-nowrap">Lorry Assigned</th>
                <th class="text-center" style="width: 1%;">Status</th>
                <th style="width: 1%;"></th>
              </tr>
            </thead>

            <tbody>
              @foreach($stocks as $stock)
              <tr>
                <td>{{ $stock->created_at }}</td>
                <td>
                  <a href="#" data-toggle="modal" data-target="#stock_{{ $stock->id }}">
                    {{ $stock->id }}
                  </a>
                </td>
                <td>{{ $stock->user->name }}</td>
                <td>{{ $stock->user->id }}</td>
                <td>
                  {{ $stock->user->address }}
                  <a href="https://www.google.com/maps/search/?api=1&query={{ $stock->user->latitude }},{{ $stock->user->longitude }}" target="_blank">
                    <i class="fa fa-map-marker"></i>
                  </a>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      No Lorry Assigned
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="#">Lorry 1</a>
                      </li>
                      <li>
                        <a href="#">Lorry 2</a>
                      </li>
                      <li>
                        <a href="#">Lorry 3</a>
                      </li>
                      <li>
                        <a href="#">Lorry 4</a>
                      </li>
                      <li>
                        <a href="#">Lorry 5</a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td class="text-center">
                  @if ($stock->status === 1)
                  <span class="label label-warning">Pending</span>
                  @elseif ($stock->status === 3)
                  <span class="label label-success">Completed</span>
                  @endif
                </td>
                <td class="text-center">
                  @if ($stock->status === 1)
                  <div class="btn-group-vertical btn-group-sm">
                    <button class="btn btn-success" data-id="{{ $stock->id }}" data-type="stock" onclick="completeOrderStock(this)">Completed</button>
                    <button class="btn btn-warning" disabled>Pending</button>
                  </div>
                  @elseif ($stock->status === 3)
                  <div class="btn-group-vertical btn-group-sm">
                    <button class="btn btn-success" disabled>Completed</button>
                    <button class="btn btn-warning" data-id="{{ $stock->id }}" data-type="stock" onclick="pendingOrderStock(this)">Pending</button>
                  </div>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <div class="pull-right">
            {{ $stocks->links() }}
          </div>
        </div>
      </div>
    </div>
    <!-- /.box -->
  </div>
</section>
@endsection 
@section('script')
<script>
  $(document).ready(function () {


    $('#order-table').DataTable({
      'ordering': false,
      'paging': false,
      'info': false,
    });

    $('#stock-table').DataTable({
      'ordering': false,
      'paging': false,
      'info': false,
    });
  });
  $('.driver_drop').change(function(){
    console.log($(this).val());
    console.log($(this).attr('id'))
    var orderId = ($(this).val()).split("_")[2];
    var data = {
      id: orderId,
      lorry_id: $(this).val()
    }

swal({
        title: "",
        text: "Assigning....",
        showConfirmButton: false
    });
       
   
    $.ajax("{{ route('orders.lorry.assign') }}", {
      data: data,
      dataType: "json",
      error: (jqXHR, textStatus, errorThrown) => {},
      method: "POST",
      success: (data, textStatus, jqXHR) => {
        console.log("OK");
        swal.close();
      }
    });


  })
  function completeOrderStock(btn) {
    var data = {
      id: $(btn).data('id'),
      type: $(btn).data('type')
    }

    $(btn).prop('disabled', true);
    $(btn).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

    $.ajax("{{ route('orders.update.status.complete') }}", {
      data: data,
      dataType: "json",
      error: (jqXHR, textStatus, errorThrown) => {},
      method: "PUT",
      success: (data, textStatus, jqXHR) => {
        window.location.href = window.location.href;
      }
    });
  }

  function pendingOrderStock(btn) {
    var data = {
      id: $(btn).data('id'),
      type: $(btn).data('type')
    }

    $(btn).prop('disabled', true);
    $(btn).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

    $.ajax("{{ route('orders.update.status.pending') }}", {
      data: data,
      dataType: "json",
      error: (jqXHR, textStatus, errorThrown) => {},
      method: "PUT",
      success: (data, textStatus, jqXHR) => {
        window.location.href = window.location.href;
      }
    });
  }

</script>
@endsection