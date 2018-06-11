@extends('layout.master') 
@section('style')
@endsection
 
@section('content') @foreach($orders as $order)
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
                                @switch($product->pivot->grade) @case("A") RM {{ number_format($product->price_latest["seller_price_a"], 2) }} @break @case("B")
                                RM {{ number_format($product->price_latest["seller_price_b"], 2) }} @break @endswitch
                            </td>
                            <td class="text-center" nowrap>
                                @switch($product->pivot->grade) @case("A") RM {{ number_format($product->pivot->quantity * $product->price_latest["buyer_price_a"],
                                2) }} @break @case("B") RM {{ number_format($product->pivot->quantity * $product->price_latest["buyer_price_b"],
                                2) }} @break @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="pull-left">
                    @if ($order->status === 0)
                    <span class="label label-default">Submitted</span> @elseif ($order->status === 1)
                <span class="label label-warning">Pending</span> @elseif ($order->status === 2)
                <span class="label label-danger">Rejected</span> @elseif ($order->status === 3)
                <span class="label label-success">Completed</span> @endif
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

<section class="content-header">
    <h1>
        Buyer Transaction
    </h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('index') }}">
                <i class="fa fa-dashboard"></i>Dashboard</a>
        </li>
        <li class="active">Buyer Transaction</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab">Pending</a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab">Completed</a>
                    </li>
                    <li class="pull-right" style="margin-top: 3px;">
                        <form method="get" class="form-inline text-center">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="{{ route('orders.buyers.index') }}">Show All</a>
                                </span>
                                <input type="date" class="form-control" name="filter_date" value="{{ $filter_date }}" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                        Filter
                                    </button>
                                </span>
                            </div>
                        </form>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab_1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="pending-order-table">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Order#</th>
                                        <th>Buyer#</th>
                                        <th>Buyer Name</th>
                                        <th>Total Price</th>
                                        <th>Lorry</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($pending_orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#order_{{ $order->id }}">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->user->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->totalPrice() }}</td>
                                        @if ($order["driver"])
                                        <td>{{$order->driver->name}}</td>
                                        @else
                                        <td>No driver assigned</td>
                                        @endif
                                        <td>
                                            @if ($order->status === 0)
                                            <span class="label label-default">Submitted</span> 
                                            @elseif ($order->status === 1)
                                            <span class="label label-warning">Pending</span>
                                            @elseif ($order->status === 2)
                                            <span class="label label-danger">Rejected</span>
                                            @elseif ($order->status === 3)
                                            <span class="label label-success">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="completed-order-table">
                                <thead>
                                    <tr class="bg-black">
                                        <th>Date</th>
                                        <th>Order#</th>
                                        <th>Buyer#</th>
                                        <th>Buyer Name</th>
                                        <th>Total Price</th>
                                        <th>Lorry</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($completed_orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#order_{{ $order->id }}">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->user->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->totalPrice() }}</td>
                                        @if ($order["driver"])
                                        <td>{{$order->driver->name}}</td>
                                        @else
                                        <td>No driver assigned</td>
                                        @endif
                                        <td>
                                            @if ($order->status === 0)
                                            <span class="label label-default">Submitted</span> 
                                            @elseif ($order->status === 1)
                                            <span class="label label-warning">Pending</span>
                                            @elseif ($order->status === 2)
                                            <span class="label label-danger">Rejected</span>
                                            @elseif ($order->status === 3)
                                            <span class="label label-success">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
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
            'order': [],
            'ordering': true,
            'info': false,
        });

    });

</script>
@endsection