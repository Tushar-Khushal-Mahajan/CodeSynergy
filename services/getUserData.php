<?php


include("../config/config.php");


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {
        // RETURN USER DATA
        if ($_GET['REASON'] === 'getUserData') {

            if (isset($_GET['u_id'])) {

                // $userDetails = mysqli_query($con, "SELECT a.uid, a.name, a.email, a.mobile, a.address, a.about, a.`user-profile`,b.sid,b.platform, b.link  FROM student AS a LEFT JOIN `user_social_links` as b ON a.uid = b.uid WHERE a.uid=1");
                $userDetails = mysqli_query($con, "SELECT a.id, a.name, a.email, a.mobile, a.address, a.about, a.`user-profile` FROM student AS a WHERE a.id='" . $_GET['u_id'] . "'");


                $socialMediaObject = mysqli_query($con, "SELECT *FROM user_social_links WHERE uid = '" . $_GET['u_id'] . "'");

                $socialMedia = [];
                while ($row = mysqli_fetch_assoc($socialMediaObject)) {
                    $socialMedia[$row['platform']] = $row['link'];
                }



                $data = [

                    'userData' => mysqli_fetch_assoc($userDetails),
                    'socialMedia' => $socialMedia

                ];

                echo json_encode($data);
            }
        }


        // get languages
        else if ($_GET['REASON'] === 'getLanguages') {

            if (isset($_GET["uid"])) {

                $uid = $_GET["uid"];

                $lang_result =  mysqli_query($con, "SELECT *FROM languages");

                $languages = [];

                while ($row = mysqli_fetch_assoc($lang_result)) {

                    $l_id =  $row['l_id'];

                    // echo "lang id = " . $row['l_id'] . " lang name = " . $row['l_name'];


                    $userLvel_result = mysqli_query($con, "SELECT *FROM user_level WHERE uid = $uid AND l_id = $l_id");

                    $user_level = mysqli_fetch_assoc($userLvel_result);

                    $did;
                    if (isset($user_level['did'])) {
                        global $did;

                        $did = $user_level['did'];
                    } else {
                        global $did;

                        $did = 0;
                    }

                    $languages[] = [
                        "language" => $row['l_name'],
                        "level" => $did
                    ];
                }

                echo json_encode($languages);
            } else {
                echo 'Required parameters are missing.';
            }
        }
        //if no any requst matches
        else {
            echo "INVALID REQUEST";
        }
    } catch (Exception) {
        throw new Exception("something went wrong");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //UPDATE AND INSERT USER DATA AND SOCIAL-MEDIA LINKS 
    if ($_POST['REASON'] === 'updateUserData') {
        if (isset($_POST['User']) && isset($_POST['socialMedia'])) {
            $user = json_decode($_POST['User'], true);
            $socialMedia = json_decode($_POST['socialMedia'], true);


            // if decode successfully :-
            if (json_last_error() === JSON_ERROR_NONE) {

                $uid = $user['uid'];
                $name = $user['name'];
                $email = $user['email'];
                $mobile = $user['phone'];
                $address = $user['address'];
                $about = $user['about'];


                $profile = $user['profile'];


                foreach ($socialMedia as $key => $val) {

                    $result = mysqli_query($con, "SELECT count(sid) as count, sid as sid FROM user_social_links WHERE platform = '" . $key . "' AND uid = $uid");


                    $row =  mysqli_fetch_assoc($result);

                    $isAvl = $row['count'];

                    if ($isAvl == 1) { //UPDATE DATA IF ALREADY EXISTS

                        echo "sid avl for = " . $key;

                        $mediaId = $row['sid'];
                        mysqli_query($con, "UPDATE user_social_links SET link = '" . $val . "' WHERE sid = $mediaId");
                    } else { //Insert IF NEW DATA
                        if (trim($val) != "") {
                            mysqli_query($con, "INSERT INTO user_social_links(uid, platform, link) VALUES($uid, '" . $key . "', '" . $val . "')");
                        }
                    }
                }

                // UPDATE STUDENT DATA :-
                mysqli_query($con, "UPDATE student SET name = '$name', email = '$email', mobile = '$mobile', address = '$address', about = '$about', `user-profile` = '$profile' WHERE id = $uid");
            } else {
                echo 'JSON decoding error: ' . json_last_error_msg();
            }
        } else {
            echo 'Required parameters are missing.';
        }
    }
}
