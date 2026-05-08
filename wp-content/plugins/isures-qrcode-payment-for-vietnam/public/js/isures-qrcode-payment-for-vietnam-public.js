document.addEventListener('DOMContentLoaded', function() {
    var logos = document.querySelectorAll('.vicweb-payment--logo');

    logos.forEach(function(logo) {
        logo.addEventListener('click', function(e) {
            if (!this.classList.contains('active')) {
                var account = this.getAttribute('data-account');
                var allLogos = document.querySelectorAll('.vicweb-payment--logo');

                allLogos.forEach(function(otherLogo) {
                    otherLogo.classList.remove('active');
                });

                this.classList.add('active');

                var paymentInfoWraps = document.querySelectorAll('.payment_info_wrap');
                paymentInfoWraps.forEach(function(infoWrap) {
                    if (infoWrap.getAttribute('data-account') === account) {
                        infoWrap.classList.add('active');
                    } else {
                        infoWrap.classList.remove('active');
                    }
                });
            }

            e.preventDefault();
        });
    });
});