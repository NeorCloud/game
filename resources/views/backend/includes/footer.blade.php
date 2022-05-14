<footer class="c-footer">
    <div id="appVersion">
        <strong>
            @lang('Copyright') &copy; {{ date('Y') }}
            <x-utils.link href="https://neorcloud.com/" target="_blank" :text="__(appName())" />
        </strong>

        @lang('All Rights Reserved').
    </div>

    <div class="mfs-auto">
        @lang('Powered by')
        <x-utils.link href="http://alefbytegroup.com/" target="_blank" :text="'Alefbyte Group'" />
    </div>
</footer>
