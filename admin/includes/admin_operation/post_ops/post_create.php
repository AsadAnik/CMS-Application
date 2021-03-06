<?php
///Code With PHP...
if (isset($_POST['publish-post'])) {
    $post_title = $_POST['title'];
    $post_title = mysqli_real_escape_string($connection, $post_title);

    $post_user = $_POST['user'];
    $post_user = mysqli_real_escape_string($connection, $post_user);

    $post_category_id = $_POST['category-id'];
    $post_status = $_POST['status'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    // $post_date = date('d-m-y');
    $post_tag = $_POST['tags'];

    $post_content = $_POST['content'];
    $post_content = mysqli_real_escape_string($connection, $post_content);

    $post_comment_count = 4;

    //Make Local Image to our  project/Application here...
    ///Way to upload Image/Files...
    move_uploaded_file($post_image_temp, "../images/$post_image");


    ///Another Way to Upload Files With Deept...
    ///Making Operation for Image Uploading...
    //Creating File Uploading System with PHP..
    // $file = $_FILES['image'];

    // $file_name = $file['name'];
    // $file_temp = $file['tmp_name'];
    // $file_type = $file['type'];
    // $file_size = $file['size'];
    // $file_error = $file['error'];

    // // print_r($file);

    // //Do Ops here..
    // $file_extension = explode('.', $file_name);
    // $real_extension = strtolower(end($file_extension));

    // //Allowing Format of File to upload...
    // $allowable = array('jpg', 'png', 'jpeg');

    // ///Decition making now...
    // if(in_array($real_extension, $allowable)){
    //     if($file_error === 0){
    //         if($file_size < 1000000){

    //             $file_name_new = uniqid('', true) . "." . $real_extension;
    //             $file_destination = '../images/'.$file_name_new;

    //             //Move FIle to Local Temporary storage to server...
    //             move_uploaded_file($file_temp, $file_destination);

    //             //make redirect with header..
    //             header("Location: posts.php?source=add_post");

    //         }else{
    //             echo "Your File is too Big!";
    //         }

    //     }else{
    //         echo "There is an ERR! when try to Fetch Files";
    //     }

    // }else{
    //     echo "You can not upload files of this type";
    // }


    ///INSERTING into the DATABASE...
    $query = "INSERT INTO `posts` (post_category_id, post_title, post_user, post_date, post_image, post_tags, post_content, post_status, post_comment_count, post_views_count) ";
    $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}','{$post_tag}' ,'{$post_content}', '{$post_status}', '{$post_comment_count}', 0)";

    //Make query for all data to submit on database..
    $make_query = mysqli_query($connection, $query);

    ///Checking query...
    if (!$make_query) {
        die("GET ERROR! when try to make query to INSERT posts data to database!" . mysqli_error($connection));
    }

    ///when created the post then return this message..
?>
    <div class="bg-success text-center" style="padding: 10px; border-radius: 5px;">
        <span>Post Created Successfully</span>
        <span> | </span>
        <a href="posts.php">View All Posts!</a>
    </div>
<?php
}
?>

<!------- Template HTML ------->
<h1 class="page-header">
    Posts
    <small>Adding</small>
</h1>

<!-- Add Categories HTML -->
<section id="category">
    <div class="row">
        <!-- Add Category Column -->
        <div class="col-xs-12">
            <form action="posts.php?source=add_post" method="POST" enctype="multipart/form-data">
                <!-- Title -->
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" placeholder="Title" name="title">
                </div>

                <!-- Category Id -->
                <div class="form-group">
                    <label for="category-id">Post Category</label>
                    <select name="category-id" id="category-id" class="form-control">
                        <option value="0">Select Category</option>
                        <?php
                        $category_query = "SELECT * FROM `categories`";
                        $query_make_cat = mysqli_query($connection, $category_query);

                        ///Checking The Category Id here..
                        if (!$query_make_cat) {
                            die("ERR! when try to make query categories all to add post" . mysqli_error($connection));
                        }

                        //Loop throw to fetching data from here..
                        while ($fetch_category = mysqli_fetch_assoc($query_make_cat)) {
                            $cat_id = $fetch_category['cat_id'];
                            $cat_title = $fetch_category['cat_title'];
                        ?>
                            <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                        <?php
                        }
                        ?>
                    </select>
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

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Post Status</label>
                    <select name="status" class="form-control">
                        <option value="draft">Select Status Post Type</option>
                        <option value="published">Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image">Post Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- Tags -->
                <div class="form-group">
                    <label for="tags">Post Tags</label>
                    <input type="text" class="form-control" placeholder="Tags" name="tags">
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea name="content" cols="30" rows="10" class="form-control" placeholder="Write post here..."></textarea>
                </div>

                <!-- Submit Form -->
                <div class="form-group">
                    <input type="submit" class="btn btn-success text-capitalize" name="publish-post" value="Publish Post">
                </div>
            </form>
        </div>
    </div>
</section>