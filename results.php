<?php
include_once __DIR__ . '/includes/headers.php';
include('results-provider-action.php');
include_once __DIR__ . '/includes/csrf_token_helper.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>EventsWave</title>

    <link rel="icon" href="assets/images/event_accepted_50px.png" type="image/icon type">

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/profile-page.css">

    <link rel="stylesheet" href="assets/css/section.css">

    <link rel="stylesheet" href="assets/css/posting.css">

    <link rel="stylesheet" href="assets/css/right_col.css">

    <link rel="stylesheet" href="assets/css/responsive.css">

    <link rel="stylesheet" href="assets/css/discover.css">

    <link rel="stylesheet" href="assets/css/results.css">

</head>

<body>

    <div class="container">

        <nav class="navbar">

            <div class="nav-wrapper">

                <img src="assets/images/black_logo.png" class="brand-img" id="logo-img">

                <div class="nav-items">

                    <div class="icon user-profile">

                        <a href="my-profile.php" style="text-transform: none; color: #1c1f23;"><i class="fas fa-user-circle fa-lg"></i></a>

                    </div>

                </div>

            </div>

            <?php

            include('config.php');

            validateCsrfToken(); // Validate the CSRF token


            if (isset($_POST['find'])) {

                $search_input = $_POST['find'];

                $SQL = "SELECT * FROM posts WHERE Caption LIKE ? OR HashTags LIKE ?;";

                $stmt = $conn->prepare($SQL);
                $search_string = "%{$search_input}%";
                $stmt->bind_param("ss", $search_string, $search_string);
                $stmt->execute();

                $posts = $stmt->get_result();
            } else {
                $search_input = "car";

                $stmt = $conn->prepare("SELECT * FROM posts WHERE Caption like ? OR HashTags like ? limit 12");

                $search_string = "%{$search_input}%";
                $stmt->bind_param("ss", $search_string, $search_string);

                $stmt->execute();

                $posts = $stmt->get_result();
            }
            ?>

        </nav>
        <br><br><br>

        <h3>Search Results For <small><?php echo htmlspecialchars($search_input); ?></small></h3><br>


        <ul class="nav nav-pills nav-justified">

            <li class="active">
                <a data-toggle="pill" href="#home"><i class="icon fas fa-vote-yea fa-lg"></i>Posts</a>
            </li>

            <li>
                <a data-toggle="pill" href="#menu2"><i class="icon fas fa-users fa-lg"></i>Profiles</a>
            </li>

            <li>
                <a data-toggle="pill" href="#menu3"><i class="icon fas fa-video fa-lg"></i>Videos</a>
            </li>

            <li>
                <a data-toggle="pill" href="#menu-4"><i class="icon fas fa-calendar-check fa-lg"></i>Events</a>
            </li>

        </ul>

        <div class="tab-content">

            <div id="home" class="tab-pane fade in active">

                <main>

                    <div class="discover-container">

                        <div class="gallery">

                            <?php foreach ($posts as $post) { ?>
                                <div class="gallery-items">

                                    <img src="<?php echo htmlspecialchars("assets/images/posts/" . $post['Img_Path']); ?>" alt="post"
                                        class="gallery-img">

                                    <div class="gallery-item-info">

                                        <ul>

                                            <li class="gallery-items-likes">
                                                <span class="hide-gallery-elements"><?php echo htmlspecialchars($post['Likes']); ?></span>
                                                <i class="icon fas fa-thumbs-up"></i>
                                            </li>

                                            <li class="gallery-items-likes">
                                                <span class="hide-gallery-elements">Opinions</span>
                                                <a href="single-post.php?post_id=<?php echo htmlspecialchars($post['Post_ID']); ?>" style="color: white" target="_blank"><i class="icon fas fa-comment"></i></a>
                                            </li>
                                        </ul>

                                    </div>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </main>

            </div>
            <div id="menu2" class="tab-pane fade">

                <br>

                <ul class="list-group">

                    <?php

                    $users = find_Users($search_input);

                    foreach ($users as $members) {
                    ?>

                        <div class="result-section">

                            <li class="list-group-item search-result-item">

                                <img src="<?php echo htmlspecialchars("assets/images/profiles/" . $members['IMAGE']); ?>" alt="profile-image">


                                <div class="profile_card" style="margin-left: 20px;">

                                    <div>

                                        <p class="username"><?php echo htmlspecialchars($members['FULL_NAME']); ?></p>

                                        <p class="sub-text"><?php echo htmlspecialchars($members['USER_NAME']); ?></p>

                                    </div>

                                </div>

                                <div class="search-result-item-button">

                                    <form method="post" action="follower-acc.php">
                                        <input type="hidden" value="<?php echo htmlspecialchars($members['User_ID']); ?>" name="target_id">

                                        <?php getCsrfTokenElement(); // Include CSRF token as hidden input 
                                        ?>

                                        <button type="submit" class="btn btn-outline-primary">Visit Profile</button>
                                    </form>

                                </div>

                            </li>
                            <br>

                        </div>

                    <?php } ?>
                </ul>

            </div>

            <div id="menu-4" class="tab-pane fade">

                <br>
                <ul class="list-group">

                    <?php

                    $events = find_Events($search_input);

                    foreach ($events as $event) {
                    ?>

                        <div class="result-section">

                            <li class="list-group-item search-result-item">

                                <img src="assets/images/calender.jpg" alt="profile-image">

                                <div class="profile_card" style="margin-left: 20px;">

                                    <div>
                                        <p class="username"
                                            style="text-transform: capitalize;"><?php echo htmlspecialchars($event['Caption']); ?></p>
                                    </div>

                                </div>

                                <div class="search-result-item-button">

                                    <button class="btn btn-outline-primary" style="background: white none;">
                                        <a href="single-event.php?post_id=<?php echo htmlspecialchars($event['Event_ID']); ?>" style="text-decoration: none; font-weight: bold;" target="_blank">
                                            View Event
                                        </a>
                                    </button>

                                </div>

                            </li>
                            <br>

                        </div>
                    <?php } ?>

                </ul>
            </div>

            <div id="menu3" class="tab-pane fade">

                <br>

                <ul class="list-group">

                    <?php

                    $shorts = find_Shorts($search_input);

                    foreach (
                        $shorts

                        as $video
                    ) {
                    ?>

                        <div class="result-section">

                            <li class="list-group-item search-result-item">

                                <img src="<?php echo 'assets/videos/' . htmlspecialchars($video['Thumbnail_Path']); ?>" alt="profile-image">

                                <div class="profile_card" style="margin-left: 20px;">

                                    <div>
                                        <p class="username"

                                            <?php $vid_data = "single-video.php?post_id= " . $video['Video_ID']; ?>

                                            <?php
                                            $sanitized_caption = htmlspecialchars($video['Caption'], ENT_QUOTES, 'UTF-8');
                                            $new_string = mb_strimwidth($sanitized_caption, 0, 200, "....<br><a href='$vid_data'> Read More</a>");
                                            ?>

                                            style="text-transform: capitalize; font-weight: bold; font-size: 13px;"><?php echo htmlspecialchars($new_string, ENT_QUOTES, 'UTF-8'); ?></p>

                                    </div>

                                </div>

                                <div class="search-result-item-button">

                                    <button class="btn btn-outline-primary" style="background: white none;">
                                        <a style="font-weight: bold; text-decoration: none;"
                                            href="single-video.php?post_id=<?php echo htmlspecialchars($video['Video_ID']); ?>"
                                            target="_blank">View Video
                                        </a>
                                    </button>
                                </div>

                            </li>
                            <br>

                        </div>

                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>

</body>
<script type="text/javascript">
    document.getElementById("logo-img").onclick = function() {
        location.href = "home.php";
    };
</script>

</html>