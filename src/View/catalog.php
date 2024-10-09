<?php

require_once './../Controller/ProductController.php';
$products = new ProductController();
$result = $products->showProducts();


?>


<!DOCTYPE html>
<!-- Coding By CodingNepal - www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Slider HTML & CSS | CodingNepal</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Linking SwiperJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container swiper">
    <!--<form action="/add_product" method="get">
   <div class="button input-box" >
       <input type="submit" value="logout">
   </div>
   </form>-->
    <h1>Catalog</h1>
    <div class="card-wrapper">
        <!-- Card slides container -->
        <?php foreach ($result as $product):?>
            <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide">
                    <a href="#" class="card-link">

                        <img src="<?php echo $product['image']?>" alt="Card Image" class="card-image">
                        <p class="badge badge-designer"><?php echo $product['title'];?></p>
                        <h2 class="card-title"><?php echo $product['description'] ?></h2>
                        <label ><?php echo $product['price'] . 'руб';?></label>
                    </a>
                </li>
            </ul>
        <?php endforeach;?>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>

        <!-- Navigation Buttons -->

    </div>
</div>

<!-- Linking SwiperJS script -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Linking custom script -->
<script src="script.js"></script>
</body>
</html>

<style>
    /* Importing Google fonts - Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
    }
    h1 {
        font-size: 2.2rem;
        margin-top: 80px;
        text-align: center;
    }
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(#ECEFFE, #C5CFFC);
    }

    .card-wrapper {
        max-width: 1100px;
        margin:  60px 35px;
        padding: 20px 10px;
        overflow: hidden;
    }

    .card-list .card-item {
        list-style: none;
    }

    .card-list .card-item .card-link {
        display: block;
        background: #fff;
        padding: 18px;
        user-select: none;
        border-radius: 12px;
        text-decoration: none;
        border: 2px solid transparent;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.05);
        transition: 0.2s ease;
    }

    .card-list .card-item .card-link:active {
        cursor: grabbing;
    }

    .card-list .card-item .card-link:hover {
        border-color: #5372F0;
    }

    .card-list .card-link .card-image {
        width: 100%;
        border-radius: 10px;
        aspect-ratio: 16 / 9;
        object-fit: cover;
    }

    .card-list .card-link .badge {
        color: #5372F0;
        width: fit-content;
        padding: 8px 16px;
        font-size: 0.95rem;
        border-radius: 50px;
        font-weight: 500;
        background: #DDE4FF;
        margin: 16px 0 18px;
    }

    .card-list .card-link .badge-designer {
        color: #B22485;
        background: #F7DFF5;
    }

    .card-list .card-link .badge-marketer {
        color: #B25A2B;
        background: #FFE3D2;
    }

    .card-list .card-link .badge-gamer {
        color: #205C20;
        background: #D6F8D6;
    }

    .card-list .card-link .badge-editor {
        color: #856404;
        background: #fff3cd;
    }

    .card-list .card-link .card-title {
        color: #000;
        font-size: 1.19rem;
        font-weight: 600;
    }

    .card-list .card-link .card-button {
        height: 35px;
        width: 35px;
        color: #5372F0;
        margin: 30px 0 5px;
        background: none;
        cursor: pointer;
        border-radius: 50%;
        border: 2px solid #5372F0;

        transition: 0.4s ease;
    }

    .card-list .card-link:hover .card-button {
        color: #fff;
        background: #5372F0;
    }

    .card-wrapper .swiper-pagination-bullet {
        height: 13px;
        width: 13px;
        opacity: 0.5;
        background: #5372F0;
    }

    .card-wrapper .swiper-pagination-bullet-active {
        opacity: 1;
    }

    .card-wrapper .swiper-slide-button {
        color: #5372F0;
        margin-top: -35px;
    }

    /* Responsive media query code for small screens */
    @media (max-width: 768px) {
        .card-wrapper {
            margin: 0 100px 25px;
        }

        .card-wrapper .swiper-slide-button {
            display: none;
        }
    }
    .button {
        color: #fff;
        margin-top: 40px;
    }
    .button input {
        color: #fff;
        background: #7d2ae8;
        border-radius: 6px;
        padding: 0;
        cursor: pointer;
        transition: all 0.4s ease;
    }
    .button input:hover {
        background: #5b13b9;
    }
    .input-box {
        display: flex;
        align-items: center;
        height: 50px;
        width: 100%;
        margin: 10px 1px;
        position: relative;
    }
    .input-box input {
        height: 100%;
        width: 15%;
        outline: none;
        border: none;
        padding: 0 30px;
        font-size: 16px;
        font-weight: 500;
        border-bottom: 2px solid rgba(0, 0, 0, 0);
        transition: all 0.3s ease;
    }
</style>
<script>

</script>
