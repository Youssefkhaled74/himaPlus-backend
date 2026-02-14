<!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('title')
        {{-- <title>HemaPulse - Smart Medical Procurement</title> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
        @if(app()->getLocale() == 'ar')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
        @else
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        @endif
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
        <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/select_2.css') }}" rel="stylesheet">
        <style>
            .select2-container, .select2.select2-container {
                /* width: 595px !important; */
            }
            .no-min-height {
                height: auto !important;
                min-height: calc(1.5em + .75rem + 2px) !important;
                padding: .375rem .75rem !important;
                line-height: 1 !important;
            }
            html, body { overflow-x: hidden; }

        </style>
        @yield('css')
    </head>
    <body class="landing-page">

        @include('layouts.front.navbar')
        @yield('content')
        @include('layouts.front.footer')

        <!-- JAVASCRIPT -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script src="{{ asset('admin/assets/js/select_2.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('front/assets/js/app.js') }}"></script>
        <script>
            $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            function flyToCartWithImage($fromButton, $cart, imgUrl, size=48, duration=700){
                const fromRect = $fromButton[0].getBoundingClientRect();
                const cartRect = $cart[0].getBoundingClientRect();
                const $ball = $('<div class="fly-clone"></div>').css({
                    left: fromRect.left + fromRect.width/2  - size/2,
                    top:  fromRect.top  + fromRect.height/2 - size/2,
                    width: size, height: size,
                    backgroundImage: `url('${imgUrl}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    opacity: 1
                }).appendTo(document.body);
                const destX = cartRect.left + cartRect.width/2  - (size*0.6)/2;
                const destY = cartRect.top  + cartRect.height/2 - (size*0.6)/2;
                void $ball[0].offsetWidth;                                 
                requestAnimationFrame(() => {                              
                    $ball.css({
                        left: destX, top: destY,
                        width: size*0.6, height: size*0.6,
                        opacity: .7
                    });
                });
                setTimeout(()=>{ $ball.remove(); }, duration + 80);
            }
            $(document).on('click', '.add-to-cart', function(e){
                e.preventDefault();
                const $btn   = $(this);
                const id     = $btn.data('id');
                const imgUrl = $btn.data('img');
                const $cart  = $('#cartIcon');
                const route  = `{{ route('user/cart/toggle') }}`;
                flyToCartWithImage($btn, $cart, imgUrl);
                $cart.addClass('shake');
                $.get(route + '/' + id, { quantity: 1 })
                .done(function(res){
                    if (res && typeof res.count !== 'undefined') {
                        $('#cartCount').text(res.count);
                    }
                })
                .always(function(){
                    setTimeout(()=> $cart.removeClass('shake'), 500);
                });
            });

            $(document).on('click', '.wishlist-btn', function (e) {
                e.preventDefault();
                const $btn  = $(this);
                const id    = $btn.data('id');
                const $icon = $btn.find('i');
                $btn.toggleClass('active');
                $icon.toggleClass('bi-heart bi-heart-fill');
                $.ajax({
                    url: `{{ route("user/favorites/toggle") }}/${id}`,
                    type: 'GET',
                    contentType: 'application/json; charset=utf-8',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                }).fail(function () {
                    $btn.toggleClass('active');
                    $icon.toggleClass('bi-heart bi-heart-fill');
                });
            });
        </script>

        @yield('script')
    </body>
</html>
