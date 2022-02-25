<div class="container">
<h5 style="color:#dfa974" class="mt-4 mb-4">Cập nhật thông tin</h5>
    <hr>
    <form action="" method="post" id="form_info">
        @csrf
        <div class="col-md-8 m-auto">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{$customer->phone}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{$customer->address}}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="">Giới tính</label>
                        <select class="form-control" name="gender">
                            <option value="">Chọn giới tính</option>
                            <option value="1" {{$customer->gender==1?'selected':''}}>Nam</option>
                            <option value="0" {{$customer->gender=='0'?'selected':''}}>Nữ</option>
                        </select>
                    </div>  
                </div>
            </div>
            <input type="submit" class="form-control mt-2 text-white font-weight-bold btn-submit" value="Cập nhật" style="background-color:#dfa974">
            <input type="button" class="form-control mt-2 btn-secondary" value="Hủy">
        </div>
    </form>
</div>
