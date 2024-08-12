<div class="orders">
    <div class="top">
        <div class="search">
            <input placeholder="Ürün İsmi İle Ara" type="search">
            <button class=""><img width="49" height="49" src="../assets/images/search-icon.svg" alt=""></button>
        </div>
        <div class="signup-select">
            <select style="display: none">
                <option value="0"></option>
                <option value="1" selected>Tüm siparişler</option>
                <option value="2">Son 30 Gün</option>
                <option value="3">Son 6 Ay</option>
            </select>
        </div>
    </div>
    <div class="order-list">
        @if(isset($orders))
            @foreach($orders as $order)
                <x-profile.order-line :order="$order" />
            @endforeach
        @endif
    </div>
</div>


