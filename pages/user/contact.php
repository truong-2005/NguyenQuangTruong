<form action="/action_page.php">
    <h1 class ="text-warning">ĐIỀN THÔNG TIN LIÊN HỆ  </h1>
  <div class="mb-3 mt-3">
    <label for="userid" class="form-label">Mã khách hàng </label> <br>
    <input type="userid" class="form-control" id="userid" placeholder="Ma kh" name="userid">
  </div>
  <div class="mb-3">
    <label for="fname" class="form-label">Họ tên :</label> <br>
    <input type="fname" class="form-control" id="fname" placeholder="Hoten" name="pswd">
  </div>
  <div class="mb-3">
    <label for="pwd" class="form-label">Địa chỉ:</label> <br>
    <input type="password" class="form-control" id="pwd" placeholder="Dia chi" name="pswd">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email:</label> <br>
    <input type="email" class="form-control" id="email" placeholder="qn4444@gmail.com" name="pswd">
  </div>
  <label for="comment">Nội dung liên hệ:</label>
  <div class="comment">
    <textarea class="form-control" rows="5" id="comment" name="text"></textarea>
</div>
  <div class="mb-3">
  <button type="submit" class="btn btn-primary">Lấy Thông Tin</button>
</form>