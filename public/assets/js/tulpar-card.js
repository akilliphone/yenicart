const TulparCard = {
    ccNumberInput:'',
    ccExpiryInput:'',
    ccCVCInput:'',
    ccNumberSeparator : " ",
    ccNumberInputOldValue:'',
    ccNumberInputOldCursor:'',
    ccExpiryPattern: /^\d{0,4}$/g,
    ccExpirySeparator: "/",
    ccExpiryInputOldValue: '',
    ccExpiryInputOldCursor: '',
    ccNumberPattern: /^\d{0,16}$/g,
    ccCVCPattern: /^\d{0,3}$/g,
    init: function (ccNumberInput, ccExpiryInput, ccCVCInput){
        this.ccNumberInput = document.querySelector(ccNumberInput);
        this.ccExpiryInput = document.querySelector(ccExpiryInput);
        this.ccCVCInput = document.querySelector(ccCVCInput);

        this.ccNumberInput.addEventListener('keydown', this.ccNumberInputKeyDownHandler);
        this.ccNumberInput.addEventListener('input', this.ccNumberInputInputHandler);

        this.ccExpiryInput.addEventListener('keydown', this.ccExpiryInputKeyDownHandler);
        this.ccExpiryInput.addEventListener('input', this.ccExpiryInputInputHandler);
        return this;
    },
    mask:function (value, limit, separator){
        var output = [];
        for (let i = 0; i < value.length; i++) {
            if ( i !== 0 && i % limit === 0) {
                output.push(separator);
            }
            output.push(value[i]);
        }
        return output.join("");
    },
    unmask:function(value){
        return value.replace(/[^\d]/g, '');
    },
    checkSeparator:function (position, interval) {
        return Math.floor(position / (interval + 1));
    },
    highlightCC :function(ccValue){
        let ccCardType = '',
            ccCardTypePatterns = {
                amex: /^3/,
                visa: /^4/,
                mastercard: /^5/,
                disc: /^6/,
                genric: /(^1|^2|^7|^8|^9|^0)/,
            };

        for (const cardType in ccCardTypePatterns) {
            if ( ccCardTypePatterns[cardType].test(ccValue) ) {
                ccCardType = cardType;
                break;
            }
        }
        let activeCC = document.querySelector('.cc-types__img--active'),
            newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);
        if (activeCC) activeCC.classList.remove('cc-types__img--active');
        if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
    },
    ccNumberInputKeyDownHandler :function(e){
        let el = e.target;
        TulparCard.ccNumberInputOldValue = el.value;
        TulparCard.ccNumberInputOldCursor = el.selectionEnd;
    },
    ccNumberInputInputHandler :function(e) {
        let el = e.target,
            newValue = TulparCard.unmask(el.value),
            newCursorPosition;

        if ( newValue.match(TulparCard.ccNumberPattern) ) {
            newValue = TulparCard.mask(newValue, 4, TulparCard.ccNumberSeparator);
            newCursorPosition =TulparCard.ccNumberInputOldCursor - TulparCard.checkSeparator(TulparCard.ccNumberInputOldCursor, 4) +
                TulparCard.checkSeparator(TulparCard.ccNumberInputOldCursor + (newValue.length - TulparCard.ccNumberInputOldValue.length), 4) +
                (TulparCard.unmask(newValue).length - TulparCard.unmask(TulparCard.ccNumberInputOldValue).length);
            el.value = (newValue !== "") ? newValue : "";
        } else {
            el.value = TulparCard.ccNumberInputOldValue;
            newCursorPosition = TulparCard.ccNumberInputOldCursor;
        }
        el.setSelectionRange(newCursorPosition, newCursorPosition);
        TulparCard.highlightCC(el.value);
    },
    ccExpiryInputKeyDownHandler :function (e) {
        let el = e.target;
        TulparCard.ccExpiryInputOldValue = el.value;
        TulparCard.ccExpiryInputOldCursor = el.selectionEnd;
    },
    ccExpiryInputInputHandler:function (e) {
        let el = e.target,
            newValue = el.value;

        newValue = TulparCard.unmask(newValue);
        if ( newValue.match(TulparCard.ccExpiryPattern) ) {
            newValue = TulparCard.mask(newValue, 2, TulparCard.ccExpirySeparator);
            el.value = newValue;
        } else {
            el.value = TulparCard.ccExpiryInputOldValue;
        }
    },
}
