<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header("location: login.php");
}
?>

<?php include_once "php/header.php"; ?>
<body>
    <?php include_once 'weather.php'; ?>
    <div class="wrapper">
        <section class="chat-area">
            <header>
            <?php
include_once "php/db.php";
$uid = mysqli_real_escape_string($db, $_GET['uid']);
$sql = mysqli_query($db, "SELECT * FROM users WHERE uid='{$uid}'");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
}
?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname'] . " " . $row['lname']; ?></span>
                    <p></p>
                    <input type="text" class="fid" name="fid" value="<?php echo $uid;?>" hidden>
                </div>
                <div class="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                    <div class="dropdown-list">
                        <div class="dropdown-item image">Image
                        <input type="file" name="image" hidden>
                        </div>
                        <div class="dropdown-item file">File
                        <input type="file" name="file" hidden>
                        </div>
                    </div>
                </div>
            </header>
            <div class="chat-box">
            </div>
            <div class="typing-box">
                <div class="typing">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <input type="text" name="update" class="update" hidden>
            <form action="#" class="typing-area">
                <input type="text" name="incoming_id" class="incoming_id" value="<?php echo $uid; ?>" hidden>
                <input type="text" name="outgoing_id" class="outgoing_id" value="<?php echo $_SESSION['uid']; ?>" hidden>
                <div class="emojiSet">
                    <i class="fa-solid fa-face-smile-beam"></i>
                    <div class="emoji-list">
                    </div>
                </div>
                <input type="text" name="message" placeholder="Type a message..." class="message" autocomplete="off">
                <button class="send"><i class="fab fa-telegram-plane"></i></button>
                <button class="voice"><i class="fa-solid fa-microphone"></i></button>
            </form>
        </section>
    </div>

    <script src="js/weather.js"></script>
    <script src="js/chat.js"></script>
</body>
</html>