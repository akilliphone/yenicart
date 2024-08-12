<style>
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert {
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }
</style>
<div class="alert alert-success" role="alert">Yorum işleminizi siparişler sayfasından sipariş verdiğiniz ürün içerisinden yapabilirsiniz</div>
<div class="comment-list">
    @if(isset($comments))
        @foreach($comments as $comment)

            <div class="comment">
                <div class="comment-header">
                    <div class="comment-header-top">
                        <img src="{{ $comment->product->thumb }}" width="80" height="80" alt="">
                        <div>{{ $comment->product->productName }}</div>
                    </div>
                    <div class="comment-header-bottom">
                        <div class="rating-area">{!! Help::stars($comment->reviewPoint) !!}</div>
                        <div>{{ Help::humanDate($comment->date) }}</div>
                    </div>
                </div>
                <div class="comment-body">{{ $comment->reviewText }}</div>
            </div>
        @endforeach
    @endif

</div>
