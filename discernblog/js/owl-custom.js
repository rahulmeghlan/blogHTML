var sld = {
    cons: {
        par_sld: '#slider',
        chl_sld: '#whiteslider',
        nextbtn: '.nextbtn',
        owldot: '.owl-dot',
        owlprev: '.owl-prev',
        owlnext: '.owl-next',
        auto:false
    },
    init: function(setup) {
        var parr = this;
        $.each(setup, function(key, val) {
            parr.cons[key] = val;
        });
    },
    fire: function(setup) {
        var parr = this;
        parr.init(setup);
        var carousel1 = $(parr.cons.par_sld);
        carousel1 = $(carousel1).owlCarousel({
            loop: true,
            autoplay: parr.cons.auto,
            smartSpeed: 1000,
            nav: false,
            items: 1
        });

        var carousel2 = $(parr.cons.chl_sld);
        carousel2 = $(carousel2).owlCarousel({
            loop: true,
            autoplay: parr.cons.auto,
            smartSpeed: 1000,
            nav: false,
            items: 1,
            callbacks: true
        });

        // trigger
        var evt = '';
        var car1_over = false;
        var from_car1 = from_car2 = false;

        $(carousel2).find(parr.cons.nextbtn).click(function(event) {
            if (evt == '') {
                console.log(1);
                evt = 'next';
                carousel2.trigger('next.owl.carousel');
            }
            return false;
        });
        $(carousel2).find(parr.cons.owldot).click(function(event) {
            if (evt == '') {
                var op = $(this).index();
                via_dot = 1;
                evt = 'to';
                carousel2.trigger('to.owl.carousel', op);
            }
            return false;
        });
        $(carousel2).find(parr.cons.owlprev).click(function(event) {
            if (evt == '') {
                evt = 'prev';
                carousel2.trigger('prev.owl.carousel');
            }
            return false;
        });

        $(carousel2).find(parr.cons.owlnext).click(function(event) {
            if (evt == '') {
                evt = 'next';
                carousel2.trigger('next.owl.carousel');
            }
            return false;
        });

        // carousel trans
        carousel2.on('translate.owl.carousel', function(event) {
            if (!from_car1) {
                if (evt != '') {
                    if (evt == 'to')
                        carousel1.trigger('to.owl.carousel', event.page.index);
                    else
                        carousel1.trigger(evt + '.owl.carousel');
                } else { // drag
                    from_car1 = true;
                }
            }
        });
        carousel2.on('translated.owl.carousel', function(event) {
            if (from_car1) {
                from_car1 = false;
                carousel1.trigger('to.owl.carousel', event.page.index);
            }
            from_car1 = false;
        });

        carousel1.on('translated.owl.carousel', function(event) {
            evt = '';
            event.preventDefault();
        });

        carousel1.on('translate.owl.carousel', function(event) {
            if (evt == '') { // came from drag
                from_car1 = true;
                carousel2.trigger('to.owl.carousel', event.page.index);
            }
            event.preventDefault();
        });
    }
};

$(document).ready(function() {
    sld.fire({
        par_sld: '#slider',
        chl_sld: '#whiteslider'
    });
    
});