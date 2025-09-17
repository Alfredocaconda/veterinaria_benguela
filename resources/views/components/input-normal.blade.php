<div class="form-group col-12 col-md-6 col-lg-6">
    <label for="nome">{{$titulo}} <span style="color: red;">*</span> </label>
    <div class="form-input">
        <input type="{{$type}}" class="form-control" name="{{$name}}" id="{{$id}}">
        <small id="nomeHelp" class="form-text text-muted">{{$alert}}</small>
    </div>
</div>