<form action="{{ route('login.as',Crypt::encrypt($id)) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success-rgba btn-rounded">
        <i class="fa fa-key"></i>
    </button>
</form>