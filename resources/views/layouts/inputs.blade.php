<div class="form-group input-group">
    <span class="input-group-addon" style="color: red;">*</span>
    <input name="phone" type="text" class="form-control" placeholder="Phone">
    @error('phone')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group input-group">
    <span class="input-group-addon" style="color: red;">*</span>
    <input name="quantity" type="number" class="form-control" placeholder="Quantity">
    @error('quantity')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group input-group">
    <span class="input-group-addon" style="color: red;">*</span>
    <input name="file" type="file" class="form-control" placeholder="Upload Image">
    @error('file')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group input-group">
    <label class="form-label">{{__('vendor/products.product_images')}}</label>
    <input type="file" class="form-control" name="files[]" multiple>
    @error('files[]')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group input-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Description"></textarea>
</div>
<div class="input-group">
    <span class="input-group-text">ملاحظات</span>
    <textarea class="form-control" name="notes" aria-label="With textarea" rows="2"></textarea>
</div>
<td>
    <div class="ml-2 d-flex">
        <img src="" alt="admin image"
            class="img-fluid img-50 rounded-circle blur-up lazyloaded" width="100">
    </div>
</td>
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
    <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
</div>
<div class="form-group input-group">
    <label for="projectinput1"> {{__('vendor/products.select_category')}}</label>
    <select name="categories[]" class="js-example-basic-multiple col-sm-12" multiple="multiple">
        @isset($categories)
            @foreach($categories as $category)
                <option value="{{$category -> id }}">{{$category -> name}}</option>
            @endforeach
        @endisset
    </select>
    @error('categories')
    <span class="text-danger"> {{$message}}</span>
    @enderror
</div>
<div class="col-xxl-12 col-md-12">
    <label for="payment_types">Payment Type <span class="text-danger">*</span></label>
    <div class="col-xxl-6 col-md-6">
        <select name="payment_type_id" class="form-control" id="payment_types"></select>                                                
    </div>
</div>
