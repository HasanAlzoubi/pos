@if ( session('success') )

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 1500,
            killer: true
        }).show();
    </script>

@endif
