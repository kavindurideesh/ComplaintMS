<?php ob_start(); ?>
<?php
session_start();
include("../connection.php");

if (isset($_SESSION['user_id']) && isset($_POST['issue_id'])) {
    $user_id = $_SESSION['user_id'];
    $issue_id = $_POST['issue_id'];

    // Check if the user has already upvoted
    $checkVoteQuery = "SELECT * FROM votes WHERE user_id = ? AND issue_id = ?";
    $stmt = $con->prepare($checkVoteQuery);
    $stmt->bind_param("ii", $user_id, $issue_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has already upvoted, so remove the upvote
        $deleteVoteQuery = "DELETE FROM votes WHERE user_id = ? AND issue_id = ?";
        $stmt = $con->prepare($deleteVoteQuery);
        $stmt->bind_param("ii", $user_id, $issue_id);
        $stmt->execute();

        // Decrement the up_count in complaints
        $updateComplaintQuery = "UPDATE complaints SET up_count = up_count - 1 WHERE issue_id = ?";
        $stmt = $con->prepare($updateComplaintQuery);
        $stmt->bind_param("i", $issue_id);
        $stmt->execute();

        echo "removed";
    } else {
        // User has not upvoted, so add the upvote
        $insertVoteQuery = "INSERT INTO votes (user_id, issue_id) VALUES (?, ?)";
        $stmt = $con->prepare($insertVoteQuery);
        $stmt->bind_param("ii", $user_id, $issue_id);
        $stmt->execute();

        // Increment the up_count in complaints
        $updateComplaintQuery = "UPDATE complaints SET up_count = up_count + 1 WHERE issue_id = ?";
        $stmt = $con->prepare($updateComplaintQuery);
        $stmt->bind_param("i", $issue_id);
        $stmt->execute();

        echo "added";
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>Student - Home</title>
    <link rel="icon" href="favicon.png" sizes="120x120" type="image/png">
    <script>
        $(document).ready(function(){
            $(".hamburger .hamburger__inner").click(function(){
                $(".wrapper").toggleClass("active");
            });

            $(".top_navbar .fas").click(function(){
                $(".profile_dd").toggleClass("active");
            });

            // Set profile image on load
            const profileImageElement = document.getElementById("profile");
            const imagePath = "<?php echo $imagePath; ?>"; 
            profileImageElement.src = imagePath;

            // Upvote function with color toggle
            function upvoteComplaint(issueId) {
    $.ajax({
        url: 'upvote.php',
        type: 'POST',
        data: { issue_id: issueId },
        success: function(response) {
            const button = document.getElementById(`upvote-${issueId}`);
            if (response.trim() === "added") {
                button.classList.add('upvoted');
            } else if (response.trim() === "removed") {
                button.classList.remove('upvoted');
            }
            location.reload(); // Reload to update the upvote count
        },
        error: function(error) {
            alert('Error upvoting');
        }
    });
}


            window.upvoteComplaint = upvoteComplaint; // Expose function globally
        });
    </script>
    <style>
        /* Additional styling */
        .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }
        .post {
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            border-radius: 5px;
            background: #fff;
            padding: 30px 20px;
        }
        .post h3 {
            margin: 0 0 10px;
            font-size: 1.5em;
            color: #333;
            text-align: center;
        }
        .post p {
            margin: 5px 0;
            font-size: 1.1em;
        }
        .upbtn {
            border: none;
            background-color: #fff;
            font-size: 20px;
            color: blue;
            cursor: pointer;
        }
        .upbtn.upvoted {
            color: green; /* Change color if upvoted */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="top_navbar">
            <div class="hamburger">
                <div class="hamburger__inner">
                    <div class="one"></div>
                    <div class="two"></div>
                    <div class="three"></div>
                </div>
            </div>
            <div class="menu">
                <div class="logo">Home</div>
                <div class="right_menu">
                    <ul>
                        <li><i class="fas fa-user"></i>
                            <div class="profile_dd">
                                <div class="dd_item"><a href="../logout.php">Logout</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="main_container">
            <div class="sidebar">
                <div class="sidebar__inner">
                    <div class="profile">
                        <div class="img">
                            <img id="profile" src="" alt="profile_pic">
                        </div>
                        <div class="profile_info">
                            <p>Welcome</p>
                            <p class="profile_name">User</p>
                        </div>
                    </div>
                    <ul>
                        <li><a href="home.php" class="active"><span class="icon"><i class="ri-home-4-fill"></i></span><span class="title">Home</span></a></li>
                        <li><a href="about.php"><span class="icon"><i class="ri-information-fill"></i></span><span class="title">About</span></a></li>
                        <li><a href="profile.php"><span class="icon"><i class="ri-account-circle-fill"></i></span><span class="title">Profile</span></a></li>
                        <li><a href="password.php"><span class="icon"><i class="ri-key-2-fill"></i></span><span class="title">Change Password</span></a></li>
                        <li><a href="complaint.php"><span class="icon"><i class="ri-add-circle-fill"></i></span><span class="title">Add Complaint</span></a></li>
                        <li><a href="history.php"><span class="icon"><i class="ri-check-double-line"></i></span><span class="title">Your Complaints</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <h1 align="center" style="margin-bottom:20px">Ongoing Complaints</h1>
                <div class="box-container">
                <?php
                if (mysqli_num_rows($result1) > 0) {
                    while ($row = mysqli_fetch_assoc($result1)) {
                        $issueId = $row['issue_id'];
                        $isUpvoted = in_array($issueId, $userVotes);
                        echo '<div class="post">';
                        echo '<h3>' . htmlspecialchars($row['type']) . '</h3>';
                        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                        echo '<p><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
                        echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['issue']) . '</p>';
                        echo '<p><strong>Serial:</strong> ' . htmlspecialchars($row['serial']) . '</p>';
                        echo '<p align="right">' . $row['up_count'] . ' ';
                        echo '<button id="upvote-' . $issueId . '" class="upbtn ' . ($isUpvoted ? 'upvoted' : '') . '" onclick="upvoteComplaint(' . $issueId . ')">';
                        echo '<i class="ri-arrow-up-circle-line"></i></button></p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No unresolved complaints found.</p>';
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
