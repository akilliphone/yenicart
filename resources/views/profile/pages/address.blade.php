<div>                        <a href="{{route('profile.address.update', 'new')}}" class="new-address-btn">
        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zm0 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 3.5a.5.5 0 0 1 .5.5v2.5H11a.5.5 0 0 1 .492.41L11.5 8a.5.5 0 0 1-.5.5H8.5V11a.5.5 0 0 1-.41.492L8 11.5a.5.5 0 0 1-.5-.5V8.5H5a.5.5 0 0 1-.492-.41L4.5 8a.5.5 0 0 1 .5-.5h2.5V5a.5.5 0 0 1 .41-.492z" fill="#1A9AFC" fill-rule="evenodd"></path></svg>
        Adres Ekleme
    </a>
</div>
    @foreach($addresses as $addres)

        <div class="address-list">
            <div class="address">
                <div class="address-header">
                    {{$addres['addressDescription']}}
                </div>
                <div class="address-body">
                    {{$addres['address']}}<br>{{$addres['state']}}/{{$addres['city']}}
                </div>
                <div class="address-footer">
                    <a class="edit-address" href="{{ route('profile.address.update', $addres['id']) }}">Düzenle</a>
                    <a class="delete-address confirm-link" data-confirm="Adres Silinsin mi?" href="{{ route('profile.address.delete', $addres['id']) }}">Sil</a>
                </div>
            </div>
        </div>

    @endforeach
</div>



