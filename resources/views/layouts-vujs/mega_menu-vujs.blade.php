<div class="mega-menu">
    <div class="container order-box">
        <div class="drop-down">
            <div class="dropbtn">
                <a href="" style="text-decoration: none;">@{{ first_category.categoryName }}</a>
            </div>
            <div class="dropdown-content-wrapper">
                <div class="dropdown-content container">
                    <div class="dropdown-sub" v-for="(item, index) in first_category.children" :key="index">
                        <a :href="item.url" class="dropbtn2">@{{ item.categoryName }}</a>
                        <div class="dropdown-content-sub">
                            <h5 style="font-size: 22px; margin: 25px 15px;">@{{ item.categoryName }}</h5>
                            <div class="sub-div" v-if="item.children">
                                <div class="item" v-for="(child, index) in item.children" :key="index">
                                    <a :href="child.url">
                                        <img width="75" height="75" :src="child.image" alt="Menu Image">
                                        <span>@{{ child.categoryName }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="arrow"></div>
                </div>
            </div>
        </div>

        <div class="drop-down" v-for="(item, index) in mega_menu.categories" :key="index">
            <div class="dropbtn">
                <a :href="item.url" style="text-decoration: none;">@{{ item.categoryName }}</a>
            </div>
            <div class="dropdown-content-wrapper">
                <div class="container not-sub-category">
                    <div class="item" v-for="(child, index) in item.children" :key="index">
                        <a :href="child.url">
                            <img width="75" height="75" :src="child.image" alt="Menu Image">
                            <span>@{{ child.categoryName }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="page-header">
    <nav>
        <!-- Ikonlar -->
        <div class="footer-bar">
            <div class="bottom-nav-link">
                <a href="/">
                    <svg id="Component_3_1" data-name="Component 3 – 1" xmlns="http://www.w3.org/2000/svg" width="24.001" height="23.986" viewBox="0 0 24.001 23.986">
                        <path id="home_2_" data-name="home (2)" d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,1,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,1,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586a1.008,1.008,0,0,1,.293.7Z" transform="translate(0 -0.021)" fill="#c3c3c3"/>
                        <g id="home_3_" data-name="home (3)" transform="translate(0 -0.16)" opacity="0">
                            <path id="Path_1886" data-name="Path 1886" d="M195,319.841a3,3,0,0,0-3,3v6h6v-6A3,3,0,0,0,195,319.841Z" transform="translate(-183 -304.696)" fill="#1a9afc"/>
                            <g id="Group_5179" data-name="Group 5179" transform="translate(0 0.16)">
                                <path id="Path_1887" data-name="Path 1887" d="M17,18.145v6h4a3,3,0,0,0,3-3V12.024a2,2,0,0,0-.563-1.392l-8.5-9.187a4,4,0,0,0-5.653-.223q-.116.107-.223.223L.581,10.629A2,2,0,0,0,0,12.039v9.106a3,3,0,0,0,3,3H7v-6a5,5,0,1,1,10,0Z" transform="translate(0 -0.16)" fill="#1a9afc"/>
                                <path id="Path_1888" data-name="Path 1888" d="M195,319.841a3,3,0,0,0-3,3v6h6v-6A3,3,0,0,0,195,319.841Z" transform="translate(-183 -304.856)" fill="#1a9afc"/>
                            </g>
                        </g>
                    </svg>
                </a>
                <span>Keşfet</span>
            </div>

            <div class="toggle-menu bottom-nav-link">
                <svg id="Component_2_1" data-name="Component 2 – 1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g id="apps-add">
                        <path id="Path_1878" data-name="Path 1878" d="M7,0H4A4,4,0,0,0,0,4V7a4,4,0,0,0,4,4H7a4,4,0,0,0,4-4V4A4,4,0,0,0,7,0ZM9,7A2,2,0,0,1,7,9H4A2,2,0,0,1,2,7V4A2,2,0,0,1,4,2H7A2,2,0,0,1,9,4Z" fill="#c3c3c3"/>
                        <path id="Path_1879" data-name="Path 1879" d="M7,13H4a4,4,0,0,0-4,4v3a4,4,0,0,0,4,4H7a4,4,0,0,0,4-4V17A4,4,0,0,0,7,13Zm2,7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V17a2,2,0,0,1,2-2H7a2,2,0,0,1,2,2Z" fill="#c3c3c3"/>
                        <path id="Path_1880" data-name="Path 1880" d="M20,13H17a4,4,0,0,0-4,4v3a4,4,0,0,0,4,4h3a4,4,0,0,0,4-4V17A4,4,0,0,0,20,13Zm2,7a2,2,0,0,1-2,2H17a2,2,0,0,1-2-2V17a2,2,0,0,1,2-2h3a2,2,0,0,1,2,2Z" fill="#c3c3c3"/>
                        <path id="Path_1881" data-name="Path 1881" d="M14,7h3v3a1,1,0,0,0,2,0V7h3a1,1,0,0,0,0-2H19V2a1,1,0,1,0-2,0V5H14a1,1,0,0,0,0,2Z" fill="#c3c3c3"/>
                    </g>
                    <g id="apps-add_1_" data-name="apps-add (1)" opacity="0">
                        <path id="Path_1882" data-name="Path 1882" d="M3.939,0H6.893a3.939,3.939,0,0,1,3.939,3.939V6.893a3.939,3.939,0,0,1-3.939,3.939H3.939A3.939,3.939,0,0,1,0,6.893V3.939A3.939,3.939,0,0,1,3.939,0Z"/>
                        <path id="Path_1883" data-name="Path 1883" d="M3.939,277.333H6.893a3.939,3.939,0,0,1,3.939,3.939v2.954a3.939,3.939,0,0,1-3.939,3.939H3.939A3.939,3.939,0,0,1,0,284.227v-2.954A3.939,3.939,0,0,1,3.939,277.333Z" transform="translate(0 -264.166)"/>
                        <path id="Path_1884" data-name="Path 1884" d="M281.273,277.333h2.954a3.939,3.939,0,0,1,3.939,3.939v2.954a3.939,3.939,0,0,1-3.939,3.939h-2.954a3.939,3.939,0,0,1-3.939-3.939v-2.954A3.939,3.939,0,0,1,281.273,277.333Z" transform="translate(-264.167 -264.166)"/>
                        <path id="Path_1885" data-name="Path 1885" d="M278.319,27.243h2.954V30.2a.985.985,0,1,0,1.97,0V27.243H286.2a.985.985,0,1,0,0-1.97h-2.954V22.319a.985.985,0,1,0-1.97,0v2.954h-2.954a.985.985,0,1,0,0,1.97Z" transform="translate(-264.167 -20.349)"/>
                    </g>
                </svg>
                <span>Kategoriler</span>
            </div>

            <div class="toggle-menu2 bottom-nav-link" type="button">
                <svg id="Component_4_2" data-name="Component 4 – 2" xmlns="http://www.w3.org/2000/svg" width="23.996"
                     height="23.231" viewBox="0 0 23.996 23.231">
                    <path id="star"
                          d="M23.836,8.794a3.179,3.179,0,0,0-3.067-2.226H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832L4.887,15,3.535,19.187a3.228,3.228,0,0,0,4.984,3.594L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.177,3.177,0,0,0,1.163-3.606Zm-2.343,1.991-4.144,3.029a1,1,0,0,0-.362,1.116l1.575,4.87a1.227,1.227,0,0,1-1.9,1.365l-4.075-3a1,1,0,0,0-1.184,0l-4.075,3a1.227,1.227,0,0,1-1.9-1.365l1.58-4.87a1,1,0,0,0-.362-1.116L2.507,10.785a1.227,1.227,0,0,1,.724-2.217h5.1a1,1,0,0,0,.952-.694l1.55-4.831a1.227,1.227,0,0,1,2.336,0l1.55,4.831a1,1,0,0,0,.952.694h5.1a1.227,1.227,0,0,1,.724,2.217Z"
                          transform="translate(-0.008 -0.19)" fill="#c3c3c3" />
                    <path id="star_1_" data-name="star (1)"
                          d="M1.327,12.4,4.887,15,3.535,19.187a3.228,3.228,0,0,0,4.984,3.594L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z"
                          transform="translate(-0.008 -0.19)" fill="#1a9afc" opacity="0" />
                </svg>

                <span>Markalar</span>
            </div>

            <div class="bottom-nav-link">
                <a href="{{ route('basket.index') }}">
                    <svg id="Component_5_1" data-name="Component 5 – 1" xmlns="http://www.w3.org/2000/svg" width="23.411" height="24" viewBox="0 0 23.411 24">
                        <g id="shopping-cart">
                            <path id="Path_1889" data-name="Path 1889" d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354a2.994,2.994,0,0,0-.65-2.456ZM21.4,6.178l-.786,4.354A3,3,0,0,1,17.657,13H5.419L4.478,5H20.41a1,1,0,0,1,.99,1.178Z" fill="#c3c3c3"/>
                            <circle id="Ellipse_113" data-name="Ellipse 113" cx="2" cy="2" r="2" transform="translate(5 20)" fill="#c3c3c3"/>
                            <circle id="Ellipse_114" data-name="Ellipse 114" cx="2" cy="2" r="2" transform="translate(15 20)" fill="#c3c3c3"/>
                        </g>
                        <g id="shopping-cart_1_" data-name="shopping-cart (1)" opacity="0">
                            <path id="Path_1890" data-name="Path 1890" d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354a2.994,2.994,0,0,0-.65-2.456Z" fill="#1a9afc"/>
                            <circle id="Ellipse_115" data-name="Ellipse 115" cx="2" cy="2" r="2" transform="translate(5 20)" fill="#1a9afc"/>
                            <circle id="Ellipse_116" data-name="Ellipse 116" cx="2" cy="2" r="2" transform="translate(15 20)" fill="#1a9afc"/>
                        </g>
                    </svg>
                    <span>Sepetim</span>
                </a>
            </div>
        </div>
        <!-- Ikonlar -->
        <!-- Mega-menu Mobil kısmı çalışılmadı -->

{{--        <div class="menu-brands">--}}
{{--            <div class="list-brands">--}}
{{--                <span style="font-size:21px;padding:0 0 2rem 0rem;font-weight:bold;display: block;">Markalar</span>--}}
{{--                <ul class="menu level-1">--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=1')}}">Baseus</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=2')}}">Puluz</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=3')}}">Kuulaa</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=4')}}">Ezere</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=5')}}">Plextone</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=6')}}">Ally</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=7')}}">Floveme</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=8')}}">Mijobs</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=9')}}">GOR</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=10')}}">DUX DUCİS</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=11')}}">USAMS</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=12')}}">Borofone</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=13')}}">Memo</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=14')}}">Hxsj</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=15')}}">Best</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=16')}}">Jakemy</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=17')}}">USLİON</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=18')}}">NORTH BAYOU</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=19')}}">Haweel</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=20')}}">Jiafa</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=21')}}">Hoco</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=22')}}">Duzzona</a></li>--}}
{{--                    <li> <a href="{{url('/reyonlar?brand=23')}}">Diğer</a></li>--}}
{{--                    <li> </li>--}}
{{--                    <li> </li>--}}
{{--                    <li> </li>--}}
{{--                    <li> </li>--}}
{{--                    <li> </li>--}}
{{--                    <li> </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- Mega-menu -->
        <!-- Kategoriler -->
{{--        <div class="menu-wrapper">--}}
{{--            <div class="list-wrapper">--}}
{{--                <span style="font-size:21px;padding:0 0 2rem 0rem;font-weight:bold;display: block;">Kategoriler</span>--}}
{{--                <ul class="menu level-1">--}}

{{--                    @foreach ($main_menu['categories'] as $item)--}}
{{--                        @if($item->children!=[])--}}
{{--                            <li>--}}
{{--                                <a href="" class="nested">{{$item->categoryName}}</a>--}}
{{--                                <ul class="sub-menu level-2">--}}
{{--                                    @foreach ($item->children as $child)--}}
{{--                                        @if($child->children!=[])--}}
{{--                                            <li>--}}
{{--                                                <a href="" class="nested">{{$child->categoryName}} </a>--}}
{{--                                                <ul class="sub-menu level-3">--}}
{{--                                                    @foreach($child->children as $lastChild)--}}
{{--                                                        <li><a href="#">{{$lastChild->categoryName}}</a></li>--}}
{{--                                                    @endforeach--}}
{{--                                                </ul>--}}
{{--                                            </li>--}}
{{--                                        @else--}}
{{--                                            <li><a href="#">{{$child->categoryName}}</a></li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                        @else--}}
{{--                            <li><a href="#">{{$item->categoryName}}</a></li>--}}
{{--                        @endif--}}

{{--                    @endforeach--}}

{{--                </ul>--}}
{{--            </div>--}}

{{--            <div class="list-wrapper">--}}
{{--                <button type="button" class="back-one-level">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="5.322" height="8.07" viewBox="0 0 5.322 8.07">--}}
{{--                        <path id="Path_1894" data-name="Path 1894"--}}
{{--                              d="M84.571,4.038,87.2,1.519a.624.624,0,0,0,.2-.469.624.624,0,0,0-.2-.469L86.8.192a.723.723,0,0,0-.981,0L82.284,3.566a.649.649,0,0,0,0,.938l3.534,3.374a.723.723,0,0,0,.981,0L87.2,7.49a.621.621,0,0,0,.2-.467.637.637,0,0,0-.2-.472Z"--}}
{{--                              transform="translate(-82.083)" fill="#FFFFFF" />--}}
{{--                    </svg>--}}
{{--                    <span>Geri Dön</span>--}}
{{--                </button>--}}
{{--                <div class="sub-menu-wrapper"></div>--}}
{{--            </div>--}}
{{--            <div class="list-wrapper">--}}
{{--                <button type="button" class="back-one-level">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="5.322" height="8.07" viewBox="0 0 5.322 8.07">--}}
{{--                        <path id="Path_1894" data-name="Path 1894"--}}
{{--                              d="M84.571,4.038,87.2,1.519a.624.624,0,0,0,.2-.469.624.624,0,0,0-.2-.469L86.8.192a.723.723,0,0,0-.981,0L82.284,3.566a.649.649,0,0,0,0,.938l3.534,3.374a.723.723,0,0,0,.981,0L87.2,7.49a.621.621,0,0,0,.2-.467.637.637,0,0,0-.2-.472Z"--}}
{{--                              transform="translate(-82.083)" fill="#FFFFFF" />--}}
{{--                    </svg>--}}
{{--                    <span>Geri Dön</span>--}}
{{--                </button>--}}
{{--                <div class="sub-menu-wrapper"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- Kategoriler -->
    </nav>
</div>
