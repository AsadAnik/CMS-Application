<?php
///Checking CategoryId which is came out from category...
if(isset($_GET['categoryId'])){
    $category_id = $_GET['categoryId'];
}

///Select All From Database here..
$query = "SELECT * FROM `posts` WHERE `post_category_id` = {$category_id}";
$select_all_posts = mysqli_query($connection, $query);

//Checking the Query in Content...
if (!$select_all_posts) {
    die("ERROR When get query in Content " . mysqli_error($connection));
}
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <!-- Now Posts are dynamically Cammings from Database -->
            <?php
            ///PHP for Getting Contents Data from Database..
            while ($posts = mysqli_fetch_assoc($select_all_posts)) {
                $post_id = $posts['post_id'];
                $post_title = $posts['post_title'];
                $post_author = $posts['post_author'];
                $post_date = $posts['post_date'];
                $post_image = $posts['post_image'];
                $post_content = $posts['post_content'];
            ?>   
                    
                 <h2>
                    <a href="post.php?postId=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                
            <?php } ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>