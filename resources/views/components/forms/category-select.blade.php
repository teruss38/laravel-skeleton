<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)<label class="form-label">{{ $label }}</label>@endif
    <select name="{{$name}}" id="{{$id}}" class="form-control @error($name) is-invalid @enderror">
        <option>{{ $placeholder }}</option>
        @foreach($categories as $value=>$option)
            <option value="{{ $value }}">{{ $option }}</option>
        @endforeach
    </select>
    @error($name)
        <span role="alert" class="invalid-feedback"><strong>{{ $message }}</strong></span>
    @enderror
</div>
