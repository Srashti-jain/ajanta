<div class="form-group">

    <label for="{{ $name }}">{{ $label }} @if($required == true) <span class='text-danger'>*</span> @endif</label> 
    <input value="{{ $value }}" type="text" {{ $required == true ? 'required' : '' }} class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" placeholder="{{ $placeholder }}">
    
    @error($name)
       <span class="text-danger">
            {{$message}}
       </span>
    @enderror

</div>