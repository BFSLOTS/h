 <script>
     @if (session('failed'))
         notifier.show('Failed!', '{{ session('failed') }}', 'danger',
         '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
     @endif

     @if (session('errors'))
         notifier.show('Error!', '{{ session('errors') }}', 'danger',
         '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
     @endif

     @if (session('successful'))
         notifier.show('SuccessfulLY!', '{{ session('successful') }}', 'success',
         '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
     @endif

     @if (session('success'))
         notifier.show('Done!', '{{ session('success') }}', 'success',
         '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
     @endif
     @if (session('warning'))
         notifier.show('Warning!', '{{ session('warning') }}', 'warning',
         '{{ asset('assets/images/notification/medium_priority-48.png') }}', 4000);
     @endif

     @if (session('status'))
         notifier.show('Great!', '{{ session('status') }}', 'info',
         '{{ asset('assets/images/notification/survey-48.png') }}', 4000);
     @endif
 </script>
 <script>
    $(document).on('click', '.delete-action', function() {
        var form_id = $(this).attr('data-form-id')
    $.confirm({
        title: '{{ __('Alert !') }}',
        content: '{{ __('Are You sure ?') }}',
        buttons: {
            confirm: function() {
                $("#" + form_id).submit();
            },
            cancel: function() {}
        }
    });
});
</script>
