@extends('layout.master') 
@section('style')
@endsection
 
@section('content')

<section class="content-header">
  <h1>
    Order Management
  </h1>

  <ol class="breadcrumb">
    <li>
      <a href="{{ route('dashboard') }}">
        <i class="fa fa-dashboard"></i>Dashboard</a>
    </li>
    <li class="active">Order</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Order Rejects</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="order-table" style="width:100%">
            <thead>
              <tr class="bg-black">
                <th>Date</th>
                <th>Order#</th>
                <th class="text-nowrap">Buyer Name</th>
                <th>Buyer#</th>
                <th>Feedback Topic</th>
                <th>Description</th>
                <th>Response</th>
                <th class="col-xs-1">Status</th>
                <th class="col-xs-1"></th>
              </tr>
            </thead>

            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->id }}</td>
                <td>None</td>
                <td>None</td>
                <td>None</td>
                <td>None</td>
                <td class="text-nowrap">
                  <a class="btn btn-primary" href="">Feedback</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- Main content -->
</section>
@endsection
 
@section('script')
<script>
  $(document).ready(function () {
    $('#order-table').DataTable({
      'ordering': false,
      'responsive': true,
    });

  });

  function updateStatus(btn) {
    var order = {
      order_id: $(btn).data('id'),
      status: $(btn).data('status')
    }

    $.ajax("{{ route('order.status') }}", {
      data: order,
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