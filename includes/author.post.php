<?php
///Code...
//Checking Author and post id to collect related post of specific author..
if ($_GET['postId']) {
    $post_related_id = $_GET['postId'];
    $related_author = $_GET['author'];
}

///Select All From Database here..
$query = "SELECT * FROM `posts` WHERE `post_user` = '{$related_author}'";
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
                All Posts Of
                <small><?php echo $related_author; ?></small>
            </h1>

            <!-- First Blog Post -->
            <!-- Now Posts are dynamically Cammings from Database -->
            <?php
            ///PHP for Getting Contents Data from Database..
            while ($posts = mysqli_fetch_assoc($select_all_posts)) {
                $post_id = $posts['post_id'];
                $post_title = $posts['post_title'];
                $post_user = $posts['post_user'];
                $post_date = $posts['post_date'];
                $post_image = $posts['post_image'];
                $post_content = substr($posts['post_content'], 0, 200);
                $post_status = $posts['post_status'];

                ///Checking The Status And Then Viewing The Post...
                if ($post_status == 'published') {
            ?>
                    <!-- Title Of Post -->
                    <h2>
                        <a href="post.php?postId=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>

                    <!-- Date Of Post -->
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>

                    <!-- Image Of Post -->
                    <a href="post.php?postId=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>

                    <!-- Post Content -->
                    <p><?php echo $post_content; ?></p>

                    <!-- Read More Button of Post -->
                    <a class="btn btn-primary" href="post.php?postId=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php
                } else if (!$post_id) {
                    echo "<h1 class='text-center text-danger'>No Posts Area Available!</h1>";
                }
            } ?>

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