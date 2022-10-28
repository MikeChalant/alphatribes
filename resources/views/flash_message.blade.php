@if (session()->has('alert') && session()->get('alert') === 'success')
<script>
        let successMsg = '{{ session("message") }}';
        Notiflix.Notify.success(successMsg);
</script>
@endif

@if (session()->has('alert') && session()->get('alert') === 'failure')
<script type="text/javascript">
        let failureMsg = '{{session("message")}}';
        Notiflix.Notify.failure(failureMsg);
</script>
@endif

@if (session()->has('alert') && session()->get('alert') === 'warning')
<script type="text/javascript">
        let warningMsg = '{{session("message")}}';
        Notiflix.Notify.warning(warningMsg);
</script>
@endif

@if (session()->has('alert') && session()->get('alert') === 'info')
<script type="text/javascript">
        let infoMsg = '{{session("message")}}';
        Notiflix.Notify.info(infoMsg);
</script>
@endif
