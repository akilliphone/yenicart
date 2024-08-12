@extends('layouts.default')
@section('head')
    <title>Hakkımızda - AkıllıPhone</title>
    <link rel="stylesheet" href="{{ url('assets/css/aboutUs.css?_t=1.01') }}">
    <style>
        .welcome-about {
            margin: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="welcome-about">
        <div class="contact-us-title">
            <h1 class="main-title">{{ $page['seoTitle'] }}</h1>
        </div>
        <div class="aboutus-content">

            <p>
                Akilliphone.com sitesi, müşterine hizmet etmenin mutluluğu ile çalışmalarından ödün vermeksizin, her daim daha iyi hizmet ve kaliteyi sunmayı hedeflemekte olan bir firmadır. Cep telefonu aksesuarlarından ev yaşam ürünlerine kadar binlerce ürünlük geniş skalasıyla 10 yılı aşkın süredir müşterilerinin ihtiyaçlarına cevap vermekten memnuniyet duymaktadır. Akla gelebilecek her türlü aksesuar ve elektronik ürünleri stoklarında barındırarak, müşterilerine hızlı, güvenilir ve kaliteli bir hizmet sunabilmek firmanın öncelikli amaçlarındandır. Türkiye'de aksesuar ve elektronik marketi olarak giderek büyüyen bir yapıya sahiptir. akilliphone.com 20000'den fazla ürün çeşidiyle, müşterilerine dönemin son moda trendlerine uygun tüm ürünlerini kaliteli ürün ve hizmet anlayışıyla donatılmış bir misyon içerisinde hazırlayıp sunmaktadır. Akilliphone.com site bünyesinde sunduğu ürünlerin % 90'a varan geniş bir aralığını stoklarında bulundurmakta, bu sayede firma müşterilerine en hızlı ve en güvenilir hizmeti sunabilmenin haklı gururunu yaşamaktadır.
            </p>
            <br>
            <p>
                2011 yılında kurulmuş olan Akıllıphone bilişim teknolojileri, bu alanda hizmet vermeyi bir onur ve gurur saymaktadır. Müşterilerine hizmet etmenin verdiği memnuniyet ile müşteri memnuniyetini en yüksek seviyelerde tutabilme hedefiyle çalışmalarını sürdürmektedir. Firma, müşterilerinin ihtiyaçlarını göz önünde bulundurarak, aksesuar ve elektronik alanında en kaliteli ürün portföyünü sunma hedefiyle bugünlere ulaşmıştır. Alt yapısını ve uzmanlığını 2006 yılından bu yana Türkiye'nin lider cep telefonu yedek parça ve aksesuar tedarikçisi olan Allymobile'dan sağlamakta olan akilliphone.com firması, kaliteden ödün vemeksizin çalışmalarına devam etmeyi vizyon edinmiştir.
            </p>
        </div>
    </div>
    <div class="body-about">
        <div class="container">
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/bayimiz-olun.svg') }}">
                </div>
                <div class="about-content ">
                    <div class="title">Bayimiz<span>&nbsp;Olun</span></div>
                    <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo non felis ut feugiat. Sed nec nisi sit amet augue tempor malesuada eget non orci. Maecenas at neque vestibulum, varius nunc non, luctus augue. Duis </div>
                    <div class="btn" ><a href="{{route('member.bayi.register')}}">Bayilik Başvurusu</a></div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/kapsamli.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">Kapsamlı Ürün<span>&nbsp;Hatları</span></div>
                    <div class="text">
                        akilliphone.com sahip olduğu 20000'den fazla ürün çeşidiyle, müşterilerine en geniş ürün portföyünü sunabilmek adına 7 gün 24 saat çalışmalarına devam etmektedir. Günümüz dünyasına uygun en son moda ürün çeşitleri, sayısız marka ve model ürünler, müşterilerin ihtiyaçları doğrultusunda her gün yeniden geliştirilmekte, güncellenmekte olan aksesuar ve elektronik listesiyle, teknolojinin gereklerini müşterilerinin ayağına getirmektedir.                    </div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/kalite.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">En İyi<span>&nbsp;Kalite</span></div>
                    <div class="text">
                        akilliphone.com sitesi kapsamında hizmete sunulmuş ürünler, kalitesi test edilmiş, sorunsuz ürünlerdir. Bünyesinde yer alan çoğu aksesuar ve elektronik ürününü garanti kapsamına alarak da müşterilerine bu kalitenin derecesini sunma isteğiyle çalışır. Ürünler müşterilere gönderilmeden önce, ürünün kalitesi, herhangi bir problem içermediği test edilerek kullanıcıya gönderilir. Bu durum, firmanın müşteri memnuniyetine verdiği önem ve hassasiyetle ilişkilidir.
                    </div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/fiyat.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">En Düşük<span>&nbsp;Fiyat</span></div>
                    <div class="text">
                        2011 yılında kurulmasına rağmen, çok daha önceden bu yana sektörün içerisinde yer almakta olan akilliphone.com firması, sektörde yer alan her ürün hakkında detaylı ürün incelemesinde bulunarak, fiyatların belirlenmesinde son derece hassastır. Tecrübesi ve müşteri memnuniyetine, güvenine duyduğu hassasiyet ile müşterilerine en uygun fiyat garantisiyle ürün satışını gerçekleştirebilmek adına çalışmalar sergiler. Bu amaçla pek çok markanın yetkili distrübitörü olmakta, öte yandan gelişmiş tedarik zinciri sayesinde en kaliteli ürünü en düşük fiyatla müşterilerine sunabilmektedir.                    </div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/musteri.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">Müşteri<span>&nbsp;Hizmetleri</span></div>
                    <div class="text">
                        Müşterilerine danışmanlık hizmeti sunup, merak ettikleri konularda bilgi desteği sunabilmek adına canlı destek hatları ile ürün alımlarından önce ya da sonra gerekli ilgi ve alakanın gösterilmesine önem verir. Ürün hakkındaki sorular, kargo, depolama işlemleri, ürünün test süreçleri hakkındaki bilgilerin edinilebilmesi için, müşterilerin daha huzurla ve içleri rahat ederek alışveriş yapabilmesini sağlamak adına gerekli tüm hizmeti sunabilmek hedeflenmektedir.                    </div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/teslimat.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">Hızlı ve Güvenli<span>&nbsp;Teslimat</span></div>
                    <div class="text">
                        akilliphone.com firması bünyesinde sunulan ürünlerin % 90'ı stoklarda bulundurulmaktadır. Bu işlemin amacı ise müşterilerin talepleri doğrultusunda zaman kaybı yaşanmaksızın, ürünü müşterinin eline en kısa zaman içerisinde ulaşmasını sağlamaktır. Günümüz dünyasında zamanın ne kadar önemli olduğunun bilincinde olan akilliphone.com firması, bu konuda müşterilerine sorunsuz ve hızlı ürün ulaştırılması konusunda son derece hassastır. Ürün siparişinin akabinde 1-3 gün içerisinde ürün müşterilere ulaşacaktır.
                    </div>
                </div>
            </div>
            <div class="c_row" >
                <div class="about-img">
                    <img width="500" height="450" src="{{ url('assets/images/kultur.svg') }}" alt>
                </div>
                <div class="about-content ">
                    <div class="title">Akilliphone.com<span>&nbsp;Kültür</span></div>
                    <div class="text">
                        Müşterilerine en iyi hizmeti sunmayı hedefleyerek, aralıksız çalışmakta olan firma, vizyon ve misyonlarına gönülden bağlı, kaliteli hizmet anlayışıyla çalışmalarını sürdüren yenilikçi bir firmadır. Sektöre bakış açısı, müşterilerinin duyduğu güven ve her daim daha iyiye yönelme arzusuyla akilliphone.com firması, bilişim ve teknoloji sektöründe, yerini ve hedeflerini her daim bilen bir firma olmuştur.                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
