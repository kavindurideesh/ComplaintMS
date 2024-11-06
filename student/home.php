<?php 
session_start();
include("../connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$imagePath = "../profileimages/person.png";

// Database connection check
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch unresolved complaints
$result1 = mysqli_query($con, "SELECT * FROM complaints WHERE status = 'unresolved' ORDER BY up_count DESC");
if (!$result1) {
    die("Error retrieving complaints: " . mysqli_error($con));
}

// Fetch user's upvoted complaints
$userVotes = [];
$userVotesQuery = mysqli_query($con, "SELECT issue_id FROM votes WHERE user_id = $user_id");
if ($userVotesQuery) {
    while ($voteRow = mysqli_fetch_assoc($userVotesQuery)) {
        $userVotes[] = $voteRow['issue_id'];
    }
}

// Include profile image path (if available)
$profileQuery = "SELECT path FROM user_profiles WHERE user_id = '$user_id'";
$profileResult = mysqli_query($con, $profileQuery);
if ($profileResult && mysqli_num_rows($profileResult) > 0) {
    $row = mysqli_fetch_assoc($profileResult);
    $imagePath = $row['path'];
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
    <button onclick="window.location.href='../logout.php'" class="logout-btn">Logout</button>

    <script>
        $(document).ready(function(){
    // Set profile image on load
    const profileImageElement = document.getElementById("profile");
    profileImageElement.src = "<?php echo $imagePath; ?>";

    // Upvote function with color toggle and debugging
    function upvoteComplaint(issueId) {
        const button = document.getElementById(`upvote-${issueId}`);
        const isUpvoted = button.classList.contains('upvoted');
        
        // Send AJAX request to either add or remove upvote
        $.ajax({
            url: 'upvote.php',
            type: 'POST',
            data: { 
                issue_id: issueId,
                action: isUpvoted ? 'remove' : 'add' // Determine if we are adding or removing the vote
            },
            success: function(response) {
                const upvoteCount = document.getElementById(`upvote-count-${issueId}`);
                
                if (response.trim() === "added") {
                    button.classList.add('upvoted');
                    upvoteCount.textContent = parseInt(upvoteCount.textContent) + 1; // Increase the count
                } else if (response.trim() === "removed") {
                    button.classList.remove('upvoted');
                    upvoteCount.textContent = parseInt(upvoteCount.textContent) - 1; // Decrease the count
                }
            },
            error: function() {
                alert('Error upvoting');
            }
        });
        location.reload()
    }
    
    // Expose the function globally so it can be called in the HTML
    window.upvoteComplaint = upvoteComplaint;
});

    </script>
    <style>
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
            text-align: center;
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
            color: green;
        }

        .post img{
            width: 50%;
            height:auto;
        }
        .logout-btn {             
    background-color: #ff4d4d;             
    color: white;             
    border: none;             
    padding: 10px 15px;             
    cursor: pointer;             
    font-size: 1em;             
    border-radius: 5px;             
    margin-left: 10px;         
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
                <li>
                    <!-- Add the logout button here -->
                    <button onclick="window.location.href='../logout.php'" class="logout-btn">Logout</button>
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
                        echo '<img src='.$row['image_path'].'>';
                        echo '<h3>' . htmlspecialchars($row['type']) . '</h3>';
                        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                        echo '<p><strong>Date:</strong> ' . htmlspecialchars($row['date']) . '</p>';
                        echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['issue']) . '</p>';
                        echo '<p><strong>Serial:</strong> ' . htmlspecialchars($row['serial']) . '</p>';
                        echo '<p align="right">' . $row['up_count'] . ' ';
                        echo '<button id="upvote-' . $issueId . '" class="upbtn ' . ($isUpvoted ? 'upvoted' : '') . '" onclick="upvoteComplaint(' . $issueId . ')">';
                        echo '<i class="ri-arrow-up-circle-'.($isUpvoted ? 'fill' : 'line').'"></i></button></p>';
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
