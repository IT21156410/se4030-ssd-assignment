<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

validateCsrfToken(); // Validate the CSRF token

if(isset($_POST['drop_comments']))
{
    $post_id = $_POST['post_id'];

    $comment_id = $_POST['comment_id'];

    Drop_Comment($comment_id, $post_id);
}
else
{
    $send = "single-post.php?post_id=$post_id&error_message=Unrecognized Request";

    header("location: $send");

    exit;
}

function Drop_Comment($comment_id, $post_id)
{
    include 'config.php';

    $SQL = "DELETE FROM comments WHERE COMMENT_ID = $comment_id";

    $stmt = $conn->prepare($SQL);

    if ($stmt->execute())
    {
        $send = "single-post.php?post_id=$post_id&success_message=Opinion Successfully Dropped";

        header("location: $send");

        exit;

    } else {

        $send = "single-post.php?post_id=$post_id&error_message=Problem With Drop Your Post";

        header("location: $send");

        exit;
    }
}
