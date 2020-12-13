<?php
    //include the connection file
    include '../../include/conn.php';

    //$ID =$_GET['Product'];
    $Query = "SELECT * FROM prod_reviews INNER JOIN products ON prod_reviews.product = products.prod_id
     INNER JOIN departments ON products.dep_id =departments.dep_id WHERE products.prod_id = 1";
    //Get All Prodect info
    $Result =mysqli_query($conn,$Query);
    //Store the result in side array

    $product_info =array();
    while($row =mysqli_fetch_array($Result)){
        $therow = array(
            'name'          => $row['prod_name'],
            'image'         => "../../server/prodects/" . $row['prod_imgs'],
            'desc'           => $row['describetion'],
            'weight'        => $row['weight'],
            'price'         => $row['price'],
            'review'        =>array(
                'rate' => $row['review'],
                'user' => $row['user'],
                'review_content' => $row['review_content']
            )
        );
            array_push($product_info,$therow);
    }

    
    // Functions 
    function rate_function($Total){
        //Stars Rate [HTML CODE]
        $ratetages="";

        while($Total>=1){
            $Total--;
            $ratetages.='<i class="fa fa-star"></i>';
        }
        //If The review was have half star
        if($Total>0){
            $ratetages.='<i class="fa fa-star-half-o"></i>';
            $Total--;
        }
        while(count(explode("</i>",$ratetages))-1 < 5 ){
            $ratetages  .= '<i class="fa fa-star-o"></i>';
        }
        return $ratetages;
    }
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../../css/style.css" type="text/css">
</head>


<body>
    <?php include '../../include/header.php'?>

   


  <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="../../server/departments/1/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php echo $product_info[0]['name'];?></h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <a href="./index.html">Vegetables</a>
                            <span><?php echo $product_info[0]['name'];?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <?php 
                            $path =$product_info[0]['image'];
                            $images=scandir($path);
                            $images=array_diff($images,array('.','..'));

                        ?>
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="<?php echo $path.'/'.$images[2]?>" alt="">
                        </div>

                        <div class="product__details__pic__slider owl-carousel">
                            <?php
                                foreach($images as $key=>$value){
                            ?>
                            <img data-imgbigurl="<?php echo $path .'/'. $value;?>"
                                src="<?php echo $path . '/thumb/' . $value;?>" alt="">
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3> <?php echo $product_info[0]['name'];?> </h3>
                        <div class="product__details__rating">
                            <?php 
                                //The Rate And The Reviews of This prodect
                              
                                $rate=array();
                                foreach($product_info as $key=>$value){
                                    array_push($rate , $product_info [$key]['review']['rate']);
                                }

                                $Total=array_sum($rate);
                                 $Total=$Total/count ($rate);
                                echo rate_function($Total);
                                echo " <span>(".count ($rate)." reviews)</span>"
                            ?>
                           
                        </div>
                        <div class="product__details__price">$<?php echo $product_info[0]['price'];?></div>
                        <p>
                            <?php

                            // If the describetion was have more than 250 letters then make
                            // link for Read all the describetion
                                $DESC = $product_info[0]['desc'] ;

                                if(strlen($DESC)>250){
                                    echo substr($DESC ,0,250). ".... <a href='#DESC'>Read More<a>";
                                }
                            ?>
                         </p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">ADD TO CARD</a>
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <ul>
                            <li><b>Availability</b> <span>In Stock</span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            <li><b>Weight</b> <span><?php echo $product_info[0]['weight'] ;?> kg</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Reviews <span>(<?php echo count($product_info);?>)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <!-- To Print the Description  -->
                                    <p><?php echo $product_info[0]['desc'] ; ?></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Reviews</h6>
                                    <div id="Reviews" class="carousel slide" data-ride="carousel">
                                        <!--Carousel Indicators-->
                                        <ol class="carousel-indicators">
                                            <li data-target="#Reviews" data-slide-to="0" class="active"></li>
                                            <li data-target="#Reviews" data-slide-to="1"></li>
                                            <li data-target="#Reviews" data-slide-to="2"></li>
                                            <li data-target="#Reviews" data-slide-to="3"></li>
                                            <li data-target="#Reviews" data-slide-to="4"></li>
                                        </ol>
                                        <!--Carousel Items-->
                                        <div class="carousel-inner">
                                            <!--tips: add data-interval="" to a .carousel-item to change the amount of time to delay before the next item.(Default: 5000)-->
                                            <?php 
                                                $active = TRUE;
                                                for($i=count($product_info)-1; $i>=count($product_info)-6; $i--){ 
                                            ?>
                                            <div class="carousel-item <?php if($active === TRUE){echo 'active';$active = FALSE;}?>">
                                                <div class="carousel-caption ">
                                                    <h5><?php echo $product_info[$i]['review']['user']; ?></h5>
                                                    <div class="product__details__rating">
                                                        <?php echo rate_function($product_info[$i]['review']['rate']);?>
                                                    </div>
                                                    <p><?php echo $product_info[$i]['review']['review_content']; ?></p>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <!--Carousel Controls-->
                                        <a class="carousel-control-prev" href="#Reviews" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#Reviews" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="./../server/prodects/1/product-details-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="./../server/prodects/1/product-details-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="./../server/prodects/1/product-details-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="./../server/prodects/1/product-details-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <?php include '../../include/footer.php'?>

    <!-- Js Plugins -->
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.nice-select.min.js"></script>
    <script src="../../js/jquery-ui.min.js"></script>
    <script src="../../js/jquery.slicknav.js"></script>
    <script src="../../js/mixitup.min.js"></script>
    <script src="../../js/owl.carousel.min.js"></script>
    <script src="../../js/main.js"></script>


</body>
</html>