<div class="left">
    <div class="user-info">
        <div class="shortened"><?php echo member_get('avatar'); ?></div>
        <div class="fullname"><?php echo member_get('name') ?> <?php echo member_get('surName') ?></div>
    </div>
    <div>
        <a href="{{ route('profile.informations') }}" class="left-section @if($page=='informations') active @endif">
            <div class="left-section-title">
                <img src="../assets/images/icons/info.svg" alt="">Üyelik Bilgilerim
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">
                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>
            </svg>
        </a>
        <a href="{{ route('profile.orders') }}" class="left-section @if($page=='orders') active @endif">
            <div class="left-section-title">
                <img src="../assets/images/icons/order.svg" alt="">Siparişlerim
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">
                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>
            </svg>
        </a>
        {{--        <a href="{{ route('profile.coupons') }}" class="left-section" active>--}}
        {{--            <div class="left-section-title">--}}
        {{--                <img src="../assets/images/icons/coupon.svg" alt="">--}}
        {{--                Kuponlarım--}}
        {{--            </div>--}}
        {{--            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">--}}
        {{--                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>--}}
        {{--            </svg>--}}
        {{--        </a>--}}
        <a href="{{ route('profile.favorites') }}" class="left-section @if($page=='favorites') active @endif">
            <div class="left-section-title">
                <img src="../assets/images/icons/favorite.svg" alt="">Favorilerim / Listelerim
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">
                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>
            </svg>
        </a>
        <a href="{{ route('profile.comments') }}" class="left-section  @if($page=='comments') active @endif">
            <div class="left-section-title">
                <img src="../assets/images/icons/comment.svg" alt="">Yorumlarım
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">
                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>
            </svg>
        </a>
        <a href="{{ route('profile.address') }}" class="left-section">
            <div class="left-section-title">
                <img src="../assets/images/icons/address.svg" alt="">Adres Bilgilerim
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847" viewBox="0 0 5.214 8.847">
                <path id="Path_12527" data-name="Path 12527" d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z" transform="translate(11.054 10.947) rotate(180)" opacity="0.492"/>
            </svg>
        </a>
        {{--        <a href="{{ route('profile.payments') }}"  class="left-section">--}}
        {{--            <div class="left-section-title">--}}
        {{--                <img src="../assets/images/icons/card.svg" alt="">--}}
        {{--                Harici Ödeme--}}
        {{--            </div>--}}
        {{--            <svg xmlns="http://www.w3.org/2000/svg" width="5.214" height="8.847"--}}
        {{--                 viewBox="0 0 5.214 8.847">--}}
        {{--                <path id="Path_12527" data-name="Path 12527"--}}
        {{--                      d="M11.054,2.891l-.8-.791L5.84,6.523l4.423,4.423.791-.791L7.422,6.523Z"--}}
        {{--                      transform="translate(11.054 10.947) rotate(180)" opacity="0.492" />--}}
        {{--            </svg>--}}
        {{--        </a>--}}
        <a href="{{ route('logout') }}"  class="left-section login-link confirm" style="
    background-color: #1a9afc;
    color: white;
">
            <div class="left-section-title">Çıkış Yap</div>
        </a>
    </div>
</div>
