
                <div class="right">
                    <div class="profile-infos">
                        <div class="top">
                            <div class="title">Favorilerim</div>
                            <div>{{count($favorites)}} ürün</div>
                        </div>
                        <div class="favorite-list">
                            <div class="row">
                                @if(isset($favorites))
                                    @foreach($favorites as $favorite)

                                        <div class="favorite-item">
                                            <div>
                                                <div class="product-image">
                                                    <img class="lazyload" width="140" height="140" src="{{ $favorite->thumb }}" alt="product image">
                                                </div>
                                                <a href="{{ $favorite->url }}">
                                                <div class="product-info">
                                                    <div class="product-name">
                                                        {{ $favorite->productName }}

                                                    </div>
                                                </div>
                                                </a>
                                                <a class="delete-favorite confirm-link" href="{{ route('profile.favorite.remove', $favorite->id) }}" data-confirm="Ürün favorilerinizden kaldırılsın mı?" data-productid="{{ $favorite->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="#fff" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
