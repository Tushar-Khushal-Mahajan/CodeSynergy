<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/line-icons.css" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     fetch('check_session.php')
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.loggedIn) {
    //                 window.location.href = 'editor.php';
    //             }
    //         });
    // });
  </script>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">
  <?php
  session_start();
  ?>
  <header class="header">
    <div id="menu-btn" class="fas fa-bars"></div>
    <a href="#" class="logo" data-aos="flip-up"><img src="https://blogs.vmware.com/management/files/2019/05/code-stream.png"> CodeSynergy </a>
    <nav class="navbar" data-aos="flip-up">
      <a href="main.php">HOME</a>
      <a href="editor.php">COMPILER</a>
      <a href="lear_dash.php">LEARNING</a>
      <a href="notes.php">NOTES</a>
      <a href="fetchcodetitle.php">DEV HUB</a>
      <a href="pdffetch.php">RESOURCES</a>
    </nav>

    <?php
    if (isset($_SESSION['id'])) {
    ?>
      <a href="user-profile.php?uid=<?php echo $_SESSION['id']; ?>" class="btn" data-aos="flip-left">PROFILE</a>
    <?php
    } else {
    ?>
      <a href="login.html" class="btn" data-aos="flip-left">PROFILE</a>
    <?php
    }
    ?>
    <!-- <a href="user-profile.php?uid=" <?php echo $_SESSION["id"]; ?> class="btn" data-aos="flip-left">PROFILE</a> -->

  </header>


  <!-- Hero Section Starts -->
  <section id="home" style="background-image: url(https://user-images.githubusercontent.com/95478989/198955082-6e78ebb5-e1e4-49f9-8d32-6e5af3984dcd.gif)" class="bg-cover hero-section">
    <div class="overlay"></div>
    <div class="container text-white text-left">
      <div class="row">
        <div class="col-12">
          <h1 class="display-5" data-aos="zoom-in" data-aos="flip-up">
            <i>IMPROVE YOUR LEARNING<br />WITH US...!</i>
          </h1>
          <p class="my-4" data-aos="fade-up">
            Enhance your learning journey with us through innovative tools, real-time <br />
            collaboration, and personalized resources.

          </p>
          <button class="btn btn-main" data-aos="fade-up">
            <a style="color: white" href="lear_dash.php">
              Get Started
            </a>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Services section Starts -->
  <section id="services" class="text-center">
    <div class="container">
      <div class="row">
        <div class="col-12 section-intro text-center" data-aos="fade-up">
          <h1>Our Services</h1>
          <div class="divider"></div>

          <p>
            We provide Multi-Language Code Compiler, Personalized Learning Paths, and Community
            Engagement services, enhancing coding, education, collaboration, and real-time
            problem-solving.
          </p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-md-4" data-aos="zoom-in">
          <div class="service">
            <div class="service-img">
              <img src="https://img.freepik.com/premium-photo/male-software-engineer-working-multiple-computers-dark-room_605022-11943.jpg" alt="" />
              <div class="icon"><i class="bi bi-file-earmark-code-fill"></i></div>
              <h5 class="mt-5 pt-4">Multi-Language Code Compiler</h5>
              <p>
                Facilitates writing, executing, and sharing <br>code in real-time across
                various<br> programming languages, enhancing collaborative coding.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4" data-aos="zoom-in">
          <div class="service">
            <div class="service-img">
              <img src="https://www.corporatevision-news.com/wp-content/uploads/2023/05/AdobeStock_590327085-scaled.jpeg" alt="" />
              <div class="icon"><i class="bi bi-signpost-split"></i></div>
              <h5 class="mt-5 pt-4">Personalized Learning Paths</h5>
              <p>
                Offers customized educational journeys with MCQ tests, enabling progression based on
                individual knowledge and validated understanding.


              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4" data-aos="zoom-in">
          <div class="service">
            <div class="service-img">
              <img src="https://www.shutterstock.com/image-photo/two-professional-programers-discussing-blockchain-600nw-1590824917.jpg" alt="" />
              <div class="icon"><i class="bi bi-people"></i></div>
              <h5 class="mt-5 pt-4">Developer Hub</h5>
              <p>
                Encourages user interaction through liking, sharing,
                commenting on code, and real-time collaborative coding spaces, fostering a supportive community.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" style="background-image: url(https://img.freepik.com/premium-photo/web-development-coding-programming-site-application-laptop_272306-16.jpg)" class="bg-cover">
    <div class="overlay"></div>
    <div class="container text-white">
      <div class="row align-items-center">
        <div class="col-12 text-center" data-aos="fade-up">
          <h1>Our Mission</h1>
          <div class="divider"></div>
        </div>
        <div class="col-md-6" data-aos="fade-right">
          <h3>
            Discover the Future of Learning with Us! </h3>Join our vibrant community and unlock a world of knowledge and innovation. Our platform offers real-time code execution, seamless collaboration, and personalized learning paths tailored just for you. Dive into an extensive library of educational resources, connect with like-minded learners, and showcase your coding prowess. Whether you're a beginner or an expert, our user-friendly interface and cutting-edge tools will elevate your learning experience to new heights. Don’t miss out—register now and start your journey towards mastering the skills of tomorrow!
          </p>
        </div>
        <div class="col-md-6 text-center" data-aos="fade-left">
          <div class="image-container">
            <img src="hero_desk-CVrZTmY6-removebg-preview (1).png" alt="Our Mission" class="img-fluid custom-shape">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="text-center">
    <div class="container">
      <div class="row">
        <div class="col-12 section-intro text-center" data-aos="fade-up">
          <h1>Our Features</h1>
          <div class="divider"></div>
          <p>
            Our website provides ultimate features like multi-language code compilation, real-time collaboration, personalized learning paths, and extensive community engagement tools.
          </p>
        </div>
      </div>

      <div class="row gx-4 gy-5">
        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-file-earmark-code"></i></div>
          <h5 class="mt-4 mb-3">Multi-Language Code Compiler</h5>
          <p>
            Supports real-time code execution for various programming languages,
            enhancing development efficiency.
          </p>
        </div>

        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-share"></i></div>
          <h5 class="mt-4 mb-3">Code Sharing and Management</h5>
          <p>
            Allows users to share, save, delete, and update code files efficiently.
          </p>
        </div>

        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-chat-dots"></i></i></div>
          <h5 class="mt-4 mb-3">Real-Time Collaboration</h5>
          <p>
            Offers collaborative coding spaces for real-time interaction and problem-solving.
          </p>
        </div>

        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-laptop"></i></i></div>
          <h5 class="mt-4 mb-3">Developer Hub</h5>
          <p>
            Enables liking, sharing, and commenting on code to foster a supportive community.
          </p>
        </div>

        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-signpost-2-fill"></i></div>
          <h5 class="mt-4 mb-3">Personalized Learning Paths</h5>
          <p>
            Tailored educational journeys based on individual knowledge levels, validated through MCQ tests
          </p>
        </div>

        <div class="col-md-4 feature" data-aos="fade-up">
          <div class="icon"><i class="bi bi-file-earmark-pdf"></i></div>
          <h5 class="mt-4 mb-3">Educational Resources</h5>
          <p>
            Access to comprehensive learning materials, including notes, videos, and tasks.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Counter -->
  <section style="background-image: url(images/cover_2.jpg)" class="bg-cover">
    <div class="overlay"></div>
    <div class="container text-white text-center">
      <div class="row gy-4" data-aos="fade-up">
        <div class="col-md-3">
          <i class="bi bi-file-earmark-code h1"></i>
          <h1 class="mt-3 mb-2">5+</h1>
          <p>Compilers</p>
        </div>

        <div class="col-md-3">
          <i class="bi bi-book-half h1"></i>
          <h1 class="mt-3 mb-2">3+</h1>
          <p>Learning Plan</p>
        </div>

        <div class="col-md-3">
          <i class="icon-happy h1"></i>
          <h1 class="mt-3 mb-2">30+</h1>
          <p>Happy Clients</p>
        </div>

        <div class="col-md-3">
          <i class="bi bi-filetype-pdf h1"></i>
          <h1 class="mt-3 mb-2">40+</h1>
          <p>Study Resources</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews Section -->
  <section id="reviews" class="text-center">
    <div class="container">
      <div class="row">
        <div class="col-12 section-intro text-center">
          <h1>Our Testimonial</h1>
          <div class="divider"></div>
          <p>
            Transform Your Learning Experience with Real-Time Collaboration and Personalized Educational Resources
          </p>
        </div>
      </div>

      <div class="row g-4 text-start">
        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/Mayur.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Mayur Patil</h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              This platform has transformed my learning experience. The real-time code execution and
              collaborative features have made me more productive in my coding abilities
            </p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/Ruchita.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Ruchita Raul</h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              The educational resources and community engagement features are outstanding. Students are more engaged, managing code files efficiently and easily. </p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/tushar.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Tushar Mahajan </h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              The administrator and user management features are top-notch, easy to track activities, and foster a supportive, <br>growth-oriented community.
            </p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>


        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/pooja.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Pooja Patil</h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              The real-time collaboration tools have allowed seamless work with peers globally. It's a fantastic platform for improving coding skills efficiently.</p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/pratik.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Partik Jamodkar</h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              This platform has transformed my learning experience. Real-time code execution and collaborative features make me productive coding abilities now. </p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up">
          <div class="review p-4">
            <div class="person">
              <img src="images/devesh.png" alt="" />
              <div class="text ms-3">
                <h6 class="mb-0">Devesh Kumbhar</h6>
                <small>Verified User <i class="bi bi-patch-check-fill"></i></small>
              </div>
            </div>
            <p class="pt-4">
              I love how this platform tailors learning paths based on knowledge levels. The MCQ tests and personalized resources transformed my studies.</p>
            <div class="stars">
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
              <i class="bx bxs-star"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section id="contact" style="background-image: url(images/cover_3.jpg)" class="bg-cover text-white">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-12 section-intro text-center" data-aos="fade-up">
          <h1>Get in Touch</h1>
          <div class="divider"></div>
          <p>
            Share your valuable feedback to help us enhance and improve future updates. Thank you!
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 mx-auto" data-aos="fade-up">
          <form action="#" class="row g-4">
            <div class="form-group col-md-6">
              <input type="text" placeholder="Full Name" class="form-control" />
            </div>

            <div class="form-group col-md-6">
              <input type="email" placeholder="Email Address" class="form-control" />
            </div>

            <div class="form-group col-md-12">
              <input type="text" placeholder="Subject" class="form-control" />
            </div>

            <div class="form-group col-md-12">
              <textarea name="" id="" cols="30" rows="8" class="form-control" placeholder="Message"></textarea>
            </div>

            <div class="text-center">
              <button class="btn btn-main" type="submit">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <section class="footer" id="footer">

    <div class="box-container">

      <div class="box">
        <h3>our branches</h3>
        <a href="#"> <i class="fas fa-arrow-right"></i> Maharashta </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Rajastan </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Gujrat </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Goa </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Karnatak </a>
      </div>

      <div class="box">
        <h3>quick links</h3>
        <a href="#"> <i class="fas fa-arrow-right"></i> Home </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> About </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Menu </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Review </a>
        <a href="#"> <i class="fas fa-arrow-right"></i> Book </a>
      </div>

      <div class="box">
        <h3>contact info</h3>
        <a href="#"> <i class="fas fa-phone"></i> +91 8530371218 </a>
        <a href="#"> <i class="fas fa-phone"></i> +91 8637729558 </a>
        <a href="#"> <i class="fas fa-envelope"></i> patilmayur4102002@gmail.com </a>
        <a href="#"> <i class="fas fa-envelope"></i> mahajantushar208@gmail.com</a>
        <a href="#"> <i class="fas fa-envelope"></i> ruchitaraul18@gmail.com</a>
        <a href="#"> <i class="fas fa-envelope"></i> patil.sakari@gmail.com</a>
      </div>

      <div class="box">
        <h3>contact info</h3>
        <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
        <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
        <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
        <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
      </div>

    </div>

    <div class="credit"> Created By Team Hustler's | all rights reserved </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="js/script.js"></script>
</body>

</html>