{{-- resources/views/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VeilleSci Burkina</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body style="margin:0; padding:0;">

    {{-- Passe les infos utilisateur à React --}}
    <script>
        window.AppConfig = {
            user: @auth
                {
                    name:  "{{ auth()->user()->name }}",
                    email: "{{ auth()->user()->email }}",
                    initial: "{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}"
                }
            @else
                null
            @endauth,
            csrfToken: "{{ csrf_token() }}",
            logoutUrl: "{{ url('/logout') }}"
        };
    </script>

    <div id="root"></div>
</body>
</html>