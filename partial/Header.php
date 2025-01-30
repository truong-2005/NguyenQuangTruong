<!DOCTYPE html>
<html>
<head>
    <title>Figure Shop</title>
    <meta charset="utf-8">
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js" integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="asset/css/style.css" rel="stylesheet"/>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
        
    </style>

</head>
<body>
    <div class="container-fluid border-warning">
        <div class="row bg-white">
            <div class="col-md-4 pt-3">
                <form action="<?=PATH?>"method="get">
                    <div class="input-group">
                        <input type="hidden" name="page" value="search">
                        <input type="text" class="form-control"  placeholder="Search products" name="product">
                        <input type="submit" class="btn btn-success" /> 
                    </div>
                </form>
            </div>
            
            <div class="col-md-4 text-end pt-3">
				<?php
				if(!isset($_SESSION['user'])){
					echo "<a href='login.php' class='btn border'>
					<i class='fa-solid fa-face-smile text-warning'></i>
					<span class='badge text-black'>Khách</span>
				  </a>";
				}
				else{
					echo "<a href='".PATH."page=account&id=".$_SESSION['userId']."' 
					class='btn border'>
                <i class='fa-solid fa-user text-warning'></i>
                <span class='badge text-black'>" . htmlspecialchars($_SESSION['user']) . "</span>
              </a>";
				}
				?>
                <a href="<?= PATH ?>page=cart" class="btn border">
                    <i class="fas fa-heart text-success"></i>
                    <span class="badge text-black">1</span>
                </a>
                <a href="<?= PATH ?>page=cart" class="btn border">
                    <i class="fas fa-shopping-cart text-success"></i>
                    <span class="badge text-black"><?= isset($_SESSION['cart']) ? intval($_SESSION['number_of_item']) : 0 ?></span> 
                </a>
            </div>
        </div>
        <div class="row header">
            
            <div class="col-md-12">
                <ul>
                    <li class="active"><a href="<?=PATH?>">Trang chủ</a></li>
                    <li><a href="<?=PATH?>page=product">Sản Phẩm</a>
                        <ul>
                            <?php
                                $sql="SELECT * FROM category WHERE status = 1 AND trash = 0 AND parent = 0";
                                $result = $f->getAll($sql);
                                foreach($result as $c):
                            ?>
                            <li class="cat_parent"><a href=""><?=$c['category_name']?></a>
                                <ul class="cat_child">
                                    <?php
                                        $sql_child = "SELECT * FROM category WHERE status = 1 AND trash = 0 AND parent = ".$c['id'];
                                        $result_child = $f->getAll($sql_child);
                                        foreach ($result_child as $child)
                                        {
                                            echo"<li><a href=' ".PATH."page=catProduct&catId=" .$child['id'] . "'>". $child['category_name'] . "
                                            </a></li>";
                                        }
                                    ?>
                                </ul>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    </li>
                    <li><a href="<?=PATH?>page=contact">Liên hệ</a></li>
                    <li><a href="<?=PATH?>page=registration">Đăng ký</a></li>
                    <li><?php
								if(!isset($_SESSION['user']))
								{
									echo"<a href=' ".PATH."page=login'>Đăng Nhập</a>";
								}
								else{
									echo"<a href='".PATH."logout=true'>Đăng xuất</a>";
								}
							?>
							</li>
                </ul>
            </div>  
        </div>
        <div class="row">
            <div class="col-md-12 banner">
                <img src="asset/images/banneranime.png" />
            </div>
        </div>
        
