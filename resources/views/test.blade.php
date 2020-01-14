@extends ('layout')

@section ('content')
<?= htmlspecialchars($name, ENT_QUOTES) ?>
{{ $name }}

@endsection