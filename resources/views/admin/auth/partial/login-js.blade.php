@if(config('martvill.is_demo'))
    <script>
        var demoCredentials = '{!! json_encode(config('martvill.credentials')) !!}';
    </script>
@endif
<!-- Login Script -->
@includeIf ('externalcode::layouts.scripts.loginScript')
