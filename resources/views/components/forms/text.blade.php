<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)<label class="form-label">{{ $label }}</label>@endif
    <input id="{{$id}}" name="{{$name}}" type="text" class="form-control @error($name) is-invalid @enderror" placeholder="{{$placeholder}}"></input>
    @error($name)<span role="alert" class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
</div>
