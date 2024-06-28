<footer class="footer footer-black footer-white">
    <div class="container-fluid">
        <div class="row">
           
            <div class="credits ml-auto">
                <span class="copyright">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>{{ __(', made  ') }}{{ __(' for ') }}<a class="@if(Auth::guest()) text-white @endif"  target="_blank">{{ __('PUNTOACCESO') }}</a>
                </span>
            </div>
        </div>
    </div>
</footer>