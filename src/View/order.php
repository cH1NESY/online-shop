<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="/order" method="post">

                <div class="row">
                    <div class="col-50">
                        <h3>Billing Address</h3>
                        <label for="fname"><i class="fa fa-user"></i> Name</label>
                        <input type="text" id="name" name="name" placeholder="">
                        <label for="fname"><i class="fa fa-user"></i> Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="">
                        <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                        <input type="text" id="address" name="address" placeholder="">
                    </div>

                </div>

                <input type="submit" value="Create order" class="btn">
            </form>
        </div>
    </div>

    <div class="col-25">

        <div class="container">
            <h4>Cart
                <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
                    <?php $count = 0;?>
                    <?php foreach ($res as $r): $count++;?>
                    <?php endforeach;?>
                    <b><?php echo $count?></b>
        </span>
            </h4>
            <?php $totalPrice = 0;?>
            <?php foreach ($res as $r):?>
                <?php $allPrice = 1;?>
                <p><a href="#"><?php echo $r->getProduct()->getTitle() . " Кол-во: " . $r->getAmount();?>
                    </a> <span class="price"><?php $allPrice = $r->getProduct()->getPrice() * $r->getAmount();echo $allPrice . " руб"?></span></p>
                <hr>
            <?php $totalPrice += $allPrice?>
            <?php endforeach;?>
            <p>Total <span class="price" style="color:black"><b><?php echo $totalPrice . " руб"?></b></span></p>
        </div>
    </div>
</div>

<style>
    .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
    }

    input[type=text] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    span.price {
        float: right;
        color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }
        .col-25 {
            margin-bottom: 20px;
        }
    }
</style>
