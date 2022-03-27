<form action="{{ url('/indiapay') }}" method="POST">
    @csrf
    <input type="text" name="gateway" value="">
    <input type="submit">
</form>