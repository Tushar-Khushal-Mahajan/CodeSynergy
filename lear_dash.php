<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>card</title>
  <!-- <script src="https://kit.fontawesome.com/66aa7c98b3.js" crossorigin="anonymous"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;

      user-select: none;
    }

    body {
      font-family: 'Times New Roman', Times, serif;

      background-image: url("./images/a-visually-engaging-and-sleek-background-image-for-4CvW6QDwRryyLnkLqJkkOg-Ft3SmlMGQdCEFRHJu2l2MA.jpeg");

      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;


    }

    .container {
      display: flex;
      justify-content: center;

      background: rgba(0, 0, 0, 0.5);

      align-items: flex;
      min-height: 50%;

      padding-top: 150px;

      height: 100%;
      width: 100%;
    }


    .card {
      position: relative;
      width: 300px;
      height: 400px;
      background: #fff;
      border-radius: 10px;
      background: rgba(0, 0, 0, 0.132);

      border: 1px solid white;
      backdrop-filter: blur(10px);

      box-shadow: 0 0 5px white, 0 0 10px wheat;

    }

    .img-bx {
      position: absolute;
      top: 0;
      left: 0;
      width: 110%;
      height: 100%;
      border-radius: 10px;
      overflow: hidden;
      transform: translateY(30px) scale(0.5);
      transform-origin: top;
      align-items: center;
    }

    .img-bx1 {
      position: absolute;
      top: 0;
      left: 0;
      width: 110%;
      height: 100%;
      border-radius: 10px;
      overflow: hidden;
      transform: translateY(30px) scale(0.5);
      transform-origin: top;
      align-items: center;
    }

    .img-bx img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .content {
      position: absolute;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      padding-bottom: 30px;
    }

    .content .detail {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
    }

    .content .detail h2 {
      color: #f8f6f6;
      font-size: 1.6em;
      font-weight: bolder;
    }

    .content .detail h2 span {
      font-size: 0.7em;
      color: #03a9f4;
      font-weight: bold;
    }

    .sci {
      position: relative;
      display: flex;
      margin-top: 5px;
    }

    .sci li {
      list-style: none;
      margin: 4px;
    }

    .sci li a {
      width: 45px;
      height: 45px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      background: transparent;
      font-size: 1.5em;
      color: #f8f0f0;
      text-decoration: none;
      box-shadow: 0 3px 6px rgba(248, 245, 245, 0.16), 0 3px 6px rgba(250, 247, 247, 0.23);
      transition: 0.5s;
    }

    .sci li a:hover {
      background: #03a9f4;
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="img-bx">
        <a href="java1.php"><img src="https://imgs.search.brave.com/LB00K_BfSH4fSi_RTZUzIRxrZcsM0A5EBCm3a03bY0g/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9wbmdp/bWcuY29tL3VwbG9h/ZHMvbGV0dGVyX2Mv/c21hbGwvbGV0dGVy/X2NfUE5HMjIucG5n" alt="img" /></a>
      </div>
      <div class="content">
        <div class="detail">
          <h2>C LANGUAGE<br /></h2>
          <ul class="sci">
            <li>
              <a href="#" id="C_BTN"><i class="fa fa-leanpub" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="editor.php"><i class="fa fa-code" aria-hidden="true"></i></a>
            </li>

          </ul>
        </div>
      </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <div class="card">
      <div class="img-bx">
        <a href="python.php"><img src="https://imgs.search.brave.com/4ODLwWYy7h8EEQzjOzTrpzFiWpNynz27SB73upo1Fag/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudmVjdGVlenku/Y29tL3N5c3RlbS9y/ZXNvdXJjZXMvcHJl/dmlld3MvMDI3LzEy/Ny80NjMvbm9uXzJ4/L2phdmFzY3JpcHQt/bG9nby1qYXZhc2Ny/aXB0LWljb24tdHJh/bnNwYXJlbnQtZnJl/ZS1wbmcucG5n" alt="img" /></a>
      </div>
      <div class="content">
        <div class="detail">
          <h2>JAVASCRIPT <br /></h2>
          <ul class="sci">
            <li>
              <a href="#" id="JS_BTN"><i class="fa fa-leanpub" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="htmleditor.html"><i class="fa fa-code" aria-hidden="true"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <div class="card">
      <div class="img-bx">
        <a href="tp.php"><img src="https://imgs.search.brave.com/-oNZpuafneeuK39sZo1tQpHA-_wO-ofZRtrOEEF_9Tc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZnJlZXBuZ2xvZ29z/LmNvbS91cGxvYWRz/L2h0bWw1LWxvZ28t/cG5nL2h0bWw1LWxv/Z28taHRtbC1sb2dv/LTAucG5n" alt="img" /></a>
      </div>
      <div class="content">
        <div class="detail">
          <h2>HTML / CSS <br /></h2>
          <ul class="sci">
            <li>
              <a href="#" id="HTML_BTN"><i class="fa fa-leanpub" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="htmleditor.html"><i class="fa fa-code" aria-hidden="true"></i></a>
            </li>

          </ul>
        </div>
      </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    console.log("Hello");
    $.ajax({
      url: "./services/test-service.php",
      method: "GET",
      data: {},
      success: function(data) {
        console.log("success");
        let languages = (JSON.parse(data).languages);

        let i = 0;

        let lang = ["#C_BTN", "#JS_BTN", "#HTML_BTN"];

        languages.forEach(element => {
          $(lang[i]).attr("href", "content.php?id=" + element.lid);
          i++;
        });
      },
      error: function(error) {
        console.error(error);
      }
    });
  </script>
</body>

</html>