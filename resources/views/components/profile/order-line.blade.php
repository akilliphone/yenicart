<div class="order">
    <div class="order-header">
        <div class="info">
            <div class="title">Sipariş Tarihi</div>
            <div class="descr">{{ Help::humanDate($order->orderDate) }}</div>
        </div>
        <div class="info">
            <div class="title">Sipariş Özeti</div>
            <div class="descr">@if($order->productCount) {{ $order->productCount }} Ürün @endif </div>
        </div>
        <div class="info">
            <div class="title">Alıcı</div>
            <div class="descr">{{ $order->name }} {{ $order->surName }}</div>
        </div>
        <div class="info">
            <div class="title">Tutar</div>
            <div class="descr">{{ Help::formatted_price($order->paymentTotal) }}</div>
        </div>
    </div>
    <div class="order-body">
        <a class="order-detail" href="{{ route('profile.order.detail', $order->id) }}">Sipariş Detayı</a>
    </div>
</div>
