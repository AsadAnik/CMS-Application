<?php
///Code...
//To Showing value inner forms, fetched all items...
if (isset($_GET['editId'])) {
    $edit_id = $_GET['editId'];
}

///Make Query to get fetching all posts from specific Get EditId URL...
$query = "SELECT * FROM `posts` WHERE `post_id` = $edit_id";
$get_specific_post = mysqli_query($connection, $query);

//Checking the Query when get check..
if (!$get_specific_post) {
    die("GET ERR! when try to make query for specific post to Show on value attribute in Admin " . mysqli_error($connection));
}

///Looping To Fetch Data for all Form Value Adding Data...
while ($fetch_specific_post = mysqli_fetch_assoc($get_specific_post)) {
    $post_title = $fetch_specific_post['post_title'];
    $post_user = $fetch_specific_post['post_user'];
    $post_date = $fetch_specific_post['post_date'];
    $post_image = $fetch_specific_post['post_image'];
    $post_category_id = $fetch_specific_post['post_category_id'];
    $post_tags = $fetch_specific_post['post_tags'];
    $post_status = $fetch_specific_post['post_status'];
    $post_comment_count = $fetch_specific_post['post_comment_count'];
    $post_content = $fetch_specific_post['post_content'];
}


///Updating/Editing POST...
if (isset($_POST['update-post'])) {
    $post_title = $_POST['title'];
    $post_title = mysqli_real_escape_string($connection, $post_title);

    $post_user = $_POST['user'];
    $post_user = mysqli_real_escape_string($connection, $post_user);

    $post_status = $_POST['status'];
    $post_category_id = $_POST['category-select'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tag = $_POST['tags'];

    $post_content = $_POST['content'];
    $post_content = mysqli_real_escape_string($connection, $post_content);

    $post_comment_count = 4;

    //Make Local Image to our  project/Application here...
    ///Way to upload Image/Files...
    move_uploaded_file($post_image_temp, "../images/$post_image");

    ///Image Impty So Make Fetch Image from Database Again..
    if (empty($post_image)) {
        $query_image = "SELECT * FROM `posts` WHERE post_id = {$edit_id}";
        $make_image_query = mysqli_query($connection, $query_image);

        while ($row_image = mysqli_fetch_assoc($make_image_query)) {
            $post_image = $row_image['post_image'];
        }
    }

    //Making Query here...
    $query = "UPDATE `posts` SET ";
    $query .= "`post_title` = '{$post_title}', ";
    $query .= "`post_user` = '{$post_user}', ";
    $query .= "`post_category_id` = {$post_category_id}, ";
    $query .= "`post_date` = now(), ";
    $query .= "`post_status` = '{$post_status}', ";
    $query .= "`post_image` = '{$post_image}', ";
    $query .= "`post_tags` = '{$post_tag}', ";
    $query .= "`post_content` = '{$post_content}' ";
    $query .= "WHERE `post_id` = {$edit_id}";

    //Make Query Result..
    $update_post_now = mysqli_query($connection, $query);

    //Checking the Query...
    if (!$update_post_now) {
        die("GET ERR! when try to make query for specific post to update in Admin " . mysqli_error($connection));
    }

    ///When Updated Successfully Done Then Return this message..
?>
    <div class="bg-warning text-center" style="padding: 10px; border-radius: 5px;">
        <span>Post Updated Successfully</span>
        <span> | </span>
        <a href="posts.php">View All Posts!</a>
    </div>
<?php
}
?>

<!-- HTML for Update/Edit Items here... -->
<h1 class="page-header">
    Post
    <small>Editing</small>
</h1>

<!-- Add Categories HTML -->
<section id="category">
    <div class="row">
        <!-- Add Category Column -->
        <div class="col-xs-12">
            <!-- Form Action takes to update Post -->
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Title -->
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input value="<?php echo $post_title; ?>" type="text" class="form-control" placeholder="Title" name="title">
                </div>

                <!-- User -->
                <div class="form-group">
                    <label for="author">Post Author</label>
                    <select name="user" class="form-control">
                        <option value="">Choose User</option>
                        <?php
                        ///Code...
                        $users_query = "SELECT * FROM `users`";
                        $query_result = mysqli_query($connection, $users_query);

                        //Checking the query..
                        if (!$query_result) {
                            die("ERR! when try to make query posts all users " . mysqli_error($connection));
                        }

                        //fetching all users..
                        while ($fetch_user = mysqli_fetch_assoc($query_result)) {
                            $post_user = $fetch_user['users_name'];
                        ?>
                            <option value="<?php echo $post_user; ?>"><?php echo $post_user; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <!-- Categories -->
                <div class="form-group">
                    <label for="category-select">Category Select</label>
                    <br>
                    <select name="category-select" class="form-control">
                        <option value="0">Select Category To Update</option>
                        <?php
                        //Categories Needs To View All From categories Table...
                        $query_cat = "SELECT * FROM `categories`";
                        $category_show = mysqli_query($connection, $query_cat);

                        //Checking Query..
                        if (!$category_show) {
                            die("Get ERR! when try to make query in post update category view " . mysqli_error($connection));
                        }

                        //Fetching The Categories Items For Select Option..
                        while ($fetch_all_category = mysqli_fetch_assoc($category_show)) {
                            $cat_id = $fetch_all_category['cat_id'];
                            $cat_title = $fetch_all_category['cat_title'];
                        ?>
                            <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                        <?php
                        } ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Post Status</label>
                    <select name="status" class="form-control">
                        <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
                        <?php
                        if ($post_status == 'published') {
                            echo "<option value='draft'>Draft</option>";
                        } else {
                            echo "<option value='published'>Publish</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image">Post Image</label>
                    <input value="<?php echo $post_image; ?>" type="file" class="form-control" name="image">
                    <br>
                    <img src="../images/<?php echo $post_image; ?>" alt="image-thumbnail" width="100" class="img img-thumbnail">
                </div>

                <!-- Tags -->
                <div class="form-group">
                    <label for="tags">Post Tags</label>
                    <input value="<?php echo $post_tags; ?>" type="text" class="form-control" placeholder="Tags" name="tags">
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea name="content" cols="30" rows="10" class="form-control" placeholder="Write post here..."><?php echo $post_content; ?>
                            </textarea>
                </div>

                <!-- Submit Form -->
                <div class="form-group">
                    <input type="submit" class="btn btn-warning text-capitalize" name="update-post" value="Update Post">
                </div>
            </form>
        </div>
    </div>
</section>