@extends('layouts.front.home')
@section('title')<title>Vendor Invoices</title>@endsection
@section('content')
<main class="container py-4">
    <h3 class="mb-3">???????? ????????</h3>
    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3"><input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control"></div>
        <div class="col-md-3"><input type="date" name="date_to" value="{{ $dateTo }}" class="form-control"></div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">?? ???????</option>
                <option value="paid" {{ $status==='paid'?'selected':'' }}>Paid</option>
                <option value="pending" {{ $status==='pending'?'selected':'' }}>Pending</option>
                <option value="2" {{ $status==='2'?'selected':'' }}>Scheduled</option>
            </select>
        </div>
        <div class="col-md-3"><button class="btn btn-primary w-100">?????</button></div>
    </form>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Paid</small><h5>{{ $totals['paid'] }}</h5></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Pending</small><h5>{{ $totals['pending'] }}</h5></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Scheduled</small><h5>{{ $totals['scheduled'] }}</h5></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Completed</small><h5>{{ $totals['completed'] }}</h5></div></div></div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead><tr><th>#</th><th>Order Details</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($invoices as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td><a href="{{ route('vendor/orders/show', $order->id) }}">??? {{ $order->id }} - {{ $order->user->name ?? '-' }}</a></td>
                        <td>{{ number_format((float)($order->total_cost ?? 0), 2) }} SAR</td>
                        <td>{{ ucfirst((string)($order->payment_status ?? 'pending')) }}</td>
                        <td>{{ (int)$order->request_type === 2 ? 'Scheduled' : 'Normal' }}</td>
                        <td>{{ optional($order->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">?? ???? ??????</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $invoices->links('pagination::bootstrap-4') }}
        </div>
    </div>
</main>
@endsection
