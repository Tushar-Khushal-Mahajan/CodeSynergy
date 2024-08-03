<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


    <link rel="stylesheet" href="./styles/content.css">

    <title>Learning</title>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <?php


    session_start();
    if (isset($_GET["id"])) {
    ?>
        <!-- header section starts -->
        <header class="header" data-aos="fade-up">
            <section class="toggleBtn">
                <input type="checkbox" id="sidebarCheckBox">
                <label for="sidebarCheckBox" class="toggleCheckBox">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </label>
            </section>


            <section class="heading" data-aos="fade-up">
                <h2 class="content-heading" data-aos="fade-up"></h2>
                <h4 class="content-sub-heading" data-aos="fade-up"></h4>
            </section>
        </header>
        <!-- header section END -->


        <!-- Main section starts -->
        <main class="main">

            <!-- Sidebar starts -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <label for="sidebarCheckBox" class="toggleCheckBox">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </label>
                </div>

                <section class="sidebar-body">

                    <div class="sidebar-content">
                        <!--autofill using ajax  -->
                    </div>

                    <section class="sidebar-footer pb-5">

                        <section class="footer-top" data-aos="fade-up">
                            <h3>
                                <button class="btn" onclick="resourceBtnClick()">
                                    RESOURCES
                                </button>
                            </h3>
                            <h3>
                                <a href="open-test.php" target="_blank" class="btn">
                                    TEST
                                </a>
                            </h3>
                        </section>
                        <section class="footer-bottom">
                            <h3>
                                <button class="btn" onclick="openComp(<?php echo $_GET['id'];?>)">
                                    PRACTICE
                                </button>
                            </h3>
                        </section>
                    </section>
            </aside>
            </section>

            <!-- Sidebar ENDS -->

            <div class="content space-for-sidebar">

                <!-- autofill data by ajax -->

                <footer class="footer">
                    This is footer
                </footer>
            </div>
        </main>
        <!-- Main section END -->


        <div class="Front-Window">
            <div class="window-header">
                <i class="fa fa-times" onclick="resourceBtnClick()" aria-hidden="true"></i>
            </div>

            <div class="window-body">
                <div class="top">

                    <form action="#" id="searchForm">
                        <label for="SEARCH-RESOURCE"><b>Search Resource</b></label>
                        <div>
                            <input type="text" placeholder="ex., C Language" id="SEARCH-RESOURCE">
                            <button>
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="body">
                    <div class="left">
                        <h2>
                            <u>Language -</u>
                        </h2>

                        <br>
                        <div class="languages-div">

                            <!-- autofill using ajax -->
                            <!-- <p>java</p> -->
                        </div>
                    </div>
                    <div class="right">
                        <h2>
                            <u>Resources -</u>
                        </h2>

                        <div class="right-content">

                        </div>
                    </div>
                </div>
            </div>
            <div class="window-footer">
                <div class="logo">
                    <img src="https://blogs.vmware.com/management/files/2019/05/code-stream.png" alt="">
                </div>
                <div class="name">
                    CODE SYNERGY
                </div>
            </div>
        </div>


        <!-- dummy form for send a request to download a pdf file
            This section cannot be visible for user
    -->
        <form action="./services/resources-service.php" id="downlodForm" method="post">
            <input type="hidden" name="reason" value="DOWNLOAD_RESOURCE" />

            <input type="hidden" id="r_id" name="r_id">
        </form>



        <!-- SCRIPTS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


        <script>
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            

            /** 
             * FOR TOGGLING THE SIDEBAR
             */
            document.querySelector("#sidebarCheckBox").addEventListener("click", toggleSideBar);
            document.querySelector("#sidebarCheckBox").focus();
            /*document.querySelector("#sidebarCheckBox").addEventListener("blur", () => {
                document.querySelector(".sidebar").classList.add("toggle-in-out");
                document.querySelector(".content").classList.remove("space-for-sidebar");
            });*/

            function toggleSideBar() {

                document.querySelector(".sidebar").classList.toggle("toggle-in-out");
                document.querySelector(".content").classList.toggle("space-for-sidebar");
            }
            // end sidebar Toggle

            //=================================

            /**
             * INSERT DATA INTO SIDEBAR
             */
            $.ajax({
                url: "services/sidebar-content.php",
                type: "GET",
                data: {
                    id: <?php echo $_GET['id'] ?>
                },

                success: function(result) {
                    $(".sidebar-content").html(result);
                },

                error: function(error) {
                    console.log(error);
                }
            });

            //==========================

            /**
             * INSERT DATA INTO MAIN SECTION
             */
            function subHeading(subTopicId) {

                $.ajax({
                    url: "services/get-content.php",
                    type: "GET",
                    data: {
                        id: subTopicId,
                        lang_id: <?php echo $_GET['id'] ?>
                    },

                    success: function(data) {

                        try {
                            data = JSON.parse(data);

                            $(".content").html(data.content);
                            $(".content-heading").text(data.topic);
                            $(".content-sub-heading").text(data.sub_topic);

                            p_id = data.sub_topic_id;

                        } catch (error) {
                            document.body.innerHTML = `<?php echo showAlert("Not Found", "404 Page Not Found", "bg-warning", "./"); ?>`;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                    }
                });
            }

            subHeading();

            function openComp(id){
            if(id==1){
                window.location.href="editor.php";

            }
            else{
                window.location.href="htmleditor.html";


            }
            }

            //=======================================

            // Hide or show resouces window
            function resourceBtnClick() {
                // document.getElementsByClassName("Front-Window")[0].classList.toggle("Front-Window-show");

                document.getElementsByClassName("Front-Window")[0].classList.toggle("Front-Window-show");

            }

            /** 
             * LOAD LANGUAGES INTO THE LEFT SECTION IN RESOURCES WINDOW
             */
            function loadLanguages() {
                $.ajax({
                    url: "services/resources-service.php",
                    method: "post",
                    data: {
                        reason: "loadLanguages"
                    },
                    success: function(data) {
                        try {
                            data = JSON.parse(data);

                            document.getElementsByClassName("languages-div")[0].innerHTML = "<p onClick='loadAllResourceIdAndTitle()'>All</p>";

                            data.forEach((e) => {

                                document.getElementsByClassName("languages-div")[0].innerHTML += `
                                <p onClick="loadResourceByLanguageId(${e.l_id})">${e.l_name}</p>
                            `;
                            });
                        } catch (error) {
                            // console.log(e);
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            loadLanguages();


            /**
             * LOAD RESOURCES IN THE FRONT WINDOW
             * This function provide the service for another functions
             */
            function loadResoucesCards(title, r_id) {
                document.getElementsByClassName("right-content")[0].innerHTML += `
                <div class="resource-card">
                         <div class="resource-card-heading">
                                <img src="./images/a-visually-striking-and-modern-logo-design-for-a-p-Lm7f8D_BTbGZTv5JKJdxig-5d213TJ3RSa_T8pJW2HSRg.jpeg" alt="">
                                <p>${title}</p>
                          </div>
                          <div class="resource-card-body">
                                <button type="submit" onclick="downloadPdfById(${r_id})"><i class="fa fa-cloud-download" aria-hidden="true"></i>
                            </div>
                </div>
            `;
            }


            /** 
             * FOR LOAD ALL RESOURCES INTO FRONT WINDOW/RESOURCES WINDOW
             */
            function loadAllResourceIdAndTitle() {
                $.ajax({
                    url: "services/resources-service.php",
                    method: "POST",

                    data: {
                        reason: "GET_RID_TITLE"
                    },

                    success: function(data) {
                        data = JSON.parse(`${data}`);

                        document.getElementsByClassName("right-content")[0].innerHTML = '';

                        data.forEach(element => {
                            // load data into resource cards.
                            loadResoucesCards(element.title, element.r_id);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            }
            loadAllResourceIdAndTitle();


            /** 
             * FOR LOAD RESOURCE BY ID IN FRONT WINDOW/RESOURCES WINDOW
             */
            function loadResourceByLanguageId(l_id) {

                $.ajax({
                    url: "services/resources-service.php",
                    method: "POST",

                    data: {
                        reason: "GET_RES_BY_LNG_ID",
                        l_id: l_id
                    },

                    success: function(data) {

                        data = JSON.parse(data);

                        document.getElementsByClassName("right-content")[0].innerHTML = '';

                        data.forEach(element => {
                            loadResoucesCards(element.title, element.r_id);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            }


            /**
             * SHOW RESOURCES BY USER SEARCH
             */
            document.getElementById("searchForm").addEventListener("submit", (e) => {
                e.preventDefault();

                let searchValue = document.getElementById("SEARCH-RESOURCE").value;

                $.ajax({
                    url: "services/resources-service.php",
                    method: "POST",

                    data: {
                        reason: "GET_RES_BY_USER_SERACH",
                        searchValue
                    },

                    success: function(data) {

                        data = JSON.parse(data);

                        document.getElementsByClassName("right-content")[0].innerHTML = '';

                        data.forEach(element => {
                            loadResoucesCards(element.title, element.r_id);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error:', textStatus, errorThrown);
                    }
                });
            });



            /**
             * FOR DOWNLOADING THE PDF RESOURCE BY RESOURCE-ID
             */
            function downloadPdfById(r_id) {
                /**
                 * SET REASONG AND SUBMIT A DUMMY FORM FOR DOWNLOAD A PDF FILE
                 */
                document.getElementById("r_id").value = r_id;

                document.getElementById("downlodForm").submit();
            }
        </script>

    <?php
    } else {
        showAlert("Error", "Required parameters missing.", "bg-danger", "./");
    }
    function showAlert($title, $desc, $bg, $url)
    {
        echo '
        <div class="container mt-5">
            <div class="card ' . $bg . ' text-white">
                <div class="card-header">' . $title . '</div>
                <div class="card-body">
                    <h5 class="card-title">' . $title . '</h5>
                    <p class="card-text">' . $desc . '</p>
                    <a href=' . $url . ' class="btn btn-light">CLOSE</a>
                </div>
            </div>
        </div>
        ';
    }
    ?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

</html>