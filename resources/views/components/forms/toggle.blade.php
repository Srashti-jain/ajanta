<div class="form-group">
    <label>{{ $label }}</label>
    <br>
    <label class="switch">
      <input type="checkbox" name="{{ $name }}" {{ $checked == true ? 'checked' : '' }}>
      <span class="knob"></span>
    </label>
    @if(isset($helptext))
        <br>
        <small class="text-muted"><i class="fa fa-question-circle"></i> {{ $helptext }}</small>
    @endif
  </div>