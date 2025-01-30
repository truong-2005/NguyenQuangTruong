<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card" style="width: 25rem;">
        <div class="card-body">
            <h5 class="card-title text-center">Đăng Nhập</h5>
            <form action="<?= PATH ?>page=logindata" method="post" id="formlogindata">
                <div class="mb-3">
                    <label name="username" class="form-label">Tên Đăng Nhập</label>
                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                </div>
                <button type="submit" class="btn-submit">Đăng Nhập</button>
            </form>
        </div>
    </div>
</div>
