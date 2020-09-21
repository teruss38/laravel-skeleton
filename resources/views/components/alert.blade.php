@if(Session::has('flash.message'))
    <div class="flash-message" style="z-index: 2109;">
        <div class="flash-message-group">
            @if(Session::get('flash.type')=='success')
                <i class="flash-icon icon-success fa fa-check-circle-o"></i>
            @elseif(Session::get('flash.type')=='warning')
                <i class="flash-icon icon-warning fa fa-exclamation-circle"></i>
            @elseif(Session::get('flash.type')=='error')
                <i class="flash-icon icon-error fa fa-times-circle"></i>
            @elseif(Session::get('flash.type')=='info')
                <i class="flash-icon icon-info fa fa-info-circle"></i>
            @endif

            <p>{{Session::get('flash.message')}}</p>
            <i class="icon-close fa fa-times"></i>
        </div>
        @push('footer')
        <script>
            $('.flash-message').animate({top: '20px', opacity: 1}).fadeIn('fast').delay(3000).fadeOut();
            $('.icon-close').click(function () {
                $('.flash-message').hide();
            });
        </script>
        @endpush
    </div>
@endif
