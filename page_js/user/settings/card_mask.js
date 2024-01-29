//card_mask
window.addEventListener("DOMContentLoaded", function() {
    [].forEach.call(document.querySelectorAll('.bank_card'), function(input) {
        function mask(event) {
            var val = this.value.replace(/\D/g, '');
            var formattedVal = formatCardNumber(val);
            this.value = formattedVal;
        }

        function formatCardNumber(value) {
            value = value.substring(0, 16);
            var formattedVal = '';

            for (var i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedVal += ' ';
                }
                formattedVal += value[i];
            }

            return formattedVal;
        }

        input.addEventListener("input", mask, false);
    });
});
