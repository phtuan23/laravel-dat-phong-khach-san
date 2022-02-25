<div class="container">
<h5 style="color:#dfa974" class="mt-4 mb-4">Thay đổi mật khẩu</h5>
    <hr>
    <form action="" method="post" id="form_password">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="">Mật khẩu hiện tại</label>
                    <br>
                    <input type="password" class="form-control" name="old_password" placeholder="Nhập mật khẩu hiện tại" value="{{old('old_password')}}"/>
                </div>
                <div class="form-group mb-2">
                    <label for="">Mật khẩu mới</label>
                    <br>
                    <input type="password" class="form-control" name="new_password" placeholder="Nhập mật khẩu mới" value="{{old('new_password')}}"/>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nhập lại mật khẩu mới</label>
                    <br>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu mới" value="{{old('confirm_password')}}"/>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="alert alert-secondary">
                <h5 class="mb-2">Gợi ý</h5>
                    <ul>
                        <li class="mb-1">Mật khẩu từ 6 ký tự trở lên.</li>
                        <li class="mb-1">Không sử dụng ký tự đặc biệt</li>
                        <li class="mb-1">Mật khẩu không chứa khoảng trắng</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-group mt-2">
            <button class="btn btn-danger js-btn-submit">Xác nhận</button>
        </div>
    </form>
</div>
