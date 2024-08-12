<div class="profile-infos">
    <div class="top">
        <div class="title">Üyelik Bilgilerim</div>
    </div>
    <form action="">
        <div class="form-wrapper">
            <div class="signup-input">
                <span class="label">Adı<span>&nbsp;*</span></span>
                <input type="text" value="{{ member_get('name') }}">
            </div>
            <div class="signup-input">
                <span class="label">Soyadı<span>&nbsp;*</span></span>
                <input type="text" value="{{ member_get('surName') }}">
            </div>
            <div class="signup-input">
                <span class="label">E-Posta Adresi<span>&nbsp;*</span></span>
                <input type="text" value="{{ member_get('email') }}">
            </div>
            <div class="signup-input">
                <div class="signup-select">
                    <span class="label">Cinsiyet<span>&nbsp;*</span></span>
                    <select style="display: none">
                        <option value="0"></option>
                        <option value="1">Erkek</option>
                        <option value="2">Kadın</option>
                    </select>
                </div>
            </div>

            <div class="signup-input">
                <span class="label">Cep Tel<span>&nbsp;*</span></span>
                <input id="mobilePhone" type="text" value="{{ member_get('gsm') }}">
            </div>
            <div class="signup-input">
                <span class="label">İş Tel<span>&nbsp;*</span></span>
                <input id="mobilePhone" type="text" value="{{ member_get('workPhone') }}">
            </div>
            <div class="signup-buttons">
                <a class="submit-btn" href="#">Bilgilerimi Güncelle</a>
            </div>
        </div>
    </form>
</div>
