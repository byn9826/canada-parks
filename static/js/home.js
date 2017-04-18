//for display footprint at homepage
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 5,
        nav: true,
        // loop: true,
        responsive: {
            0: {
                items: 1
            },
            420: {
                items: 2
            },
            700: {
                items: 3
            }
        }
    })
