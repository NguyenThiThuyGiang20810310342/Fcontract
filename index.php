<?php
    require 'config.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)) {
        header('location: login.php');
    }

    if(isset($_POST['add_to_cart'])) {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart`
        WHERE name = '$product_name' AND user_id = '$user_id'") or die("Query Failed");

        if(mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = "already added to cart!";
        } else {
            mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, quantity, image) 
            VALUES ('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die("Query Failed");
            $message[] = "product added to cart.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <!-- section start -->
    <section class="home">
        <div class="content">
            <h3>Quiin house jewelry</h3>
            <p>Come explore with us</p>
            <a href="about.php" class="white-btn">discover more</a>
        </div><!--content-->
    </section>
    <!-- section end -->

    <!-- section start -->
    <section class="products">
        <h1 class="title">latest products</h1>
        <div class="box-container">
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`
                LIMIT 6") 
                or die("Query Failed");
                if(mysqli_num_rows($select_products) > 0) {
                    while($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <input type="number" name="product_quantity"  min="1" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
                    }
                } else{
                    echo '<p class="empty">no product added yet</p>';
                }
            ?>
        </div><!--box-container-->

        <div class="load-more" style="margin-top: 2rem; text-align: center;">
            <a href="shop.php" class="option-btn">load more</a>
        </div><!--load-more-->
    </section>
    <!-- section end -->

    <!-- section start -->
    <section class="about">
        <div class="flex">

            <div class="image">
                <img src="images/7.jpg" alt="">
            </div><!--image-->

            <div class="content">
                <h3>about us</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut quo obcaecati 
                    accusantium officia reprehenderit aliquam laboriosam. Sequi veniam esse vero?
                </p>
                <a href="about.php" class="btn">read more</a>
            </div><!--content-->

        </div><!--flex-->
    </section>
    <!-- section end -->

    <!-- section start -->
    <section class="home-contact">
        <div class="content">
            <h3>have any questions?</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vero enim sit libero iusto, voluptatum quos.</p>
            <a href="contact.php" class="white-btn">contact us</a>
        </div><!--content-->
    </section>
    <!-- section end -->

    <?php include 'footer.php'; ?>

    <!-- custom js file link -->
    <script src="js/script.js"></script>

</body>
</html>