<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyParkingSpot</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Poppins&family=Sacramento&display=swap" rel="stylesheet">

</head>
<style>
    .topnav {
  position: fixed;
  width: 100%;
  height:8%;
  z-index: 1000; 
  background-color: white;
  overflow: hidden;
}
.topnav a {
    float: right;
    color:rgb(236, 165, 11);
    text-align: center;
    padding: 14px 10px;
    text-decoration: none;
    font-size: 17px;
  }
  
.topnav a:hover {
    background-color: #ddd;
    color: black;
  }
  
.topnav a.active {
    background-color: rgb(236, 165, 11);
    color: white;
  }
.flexiable{
    display:flex;
}
.starthalf{
    flex:1 2 auto;
}
.logo{
    height: 100px;
    width: 200px;
}
footer{
    color: white;
    text-align: center;
    background-color: rgb(255, 255, 255);
    display: block;
}
.halfpart{
    width: 50%;
    }
.halfpart img{
        display: block;
        margin-left: auto;
        margin-right: auto;
      }

.about{
    background-color:rgb(236, 165, 11);
}
.us{
    font-family: 'Poppins', sans-serif;
    text-align: center;
    font-size: 60px;
}
.descrip{
    text-align: center;
    font-size: 30px;
    color: rgb(27, 26, 26);
    font-family: 'Caveat', cursive;
}
.button{
    text-decoration: none;
    background-image: linear-gradient(rgb(236, 165, 11), rgb(255, 198, 11));
    color: white;
    font-weight: 700;
    padding: 10px 40px;
    border-radius: 5px;
    }
    .container {
        height: 150px;
        position: relative;
        border: 3px solid rgb(208, 238, 238);
      }
      
      .center {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
      }
.cater{
      background-color:white;
  }
  .containercater {
    height: 150px;
    position: relative;
    
  }
  
  body {
    margin: 0;
    padding: 0;
    background-image: url('peakpx.jpg');
    background-attachment: fixed;
    background-size: cover; 
    background-position: center center; 
    font-family: 'Poppins', sans-serif; 
}

</style>
<body>
    <section class="starting">
        <div class="flexiable">
            <div class="starthalf">
    
            </div>
            <div class="topnav">
                <img class="logo" src="park.jpg" alt="logo">
                <a href="https://www.google.com/maps"> <img src="maps.jpg" width="60px" height="30px"></a>
                <a href="#about-section">About</a>
                <a href="login_are_you_a.html">Login</a>
                <a href="are_you_a_reg.html">Register</a>
                <a class="active" href="">HOME</a>
            </div>
        </div>
        <div class="starthalfvid">
            <!-- <img class="wallpaper" src="peakpx.jpg" alt="wallpaper"> -->
        </div>

        

        <!-- <section class="cater"> -->
            <div class="flexiable">
                <div class="halfpart">
                    <h1 class="us">Why use MyParkingSpot?</h1>
                    <p class="descrip">With us, you can pick the nearest spot very easily for parking your transportation exactly upto your preferences with guaranteed safety.</p>
                    <div class="containercater">
                        <div class="center">
                            <a class="button" target="_blank" href="are_you_a_reg.html">Not registered yet?</a>
                        </div>
                      </div>
                    </div>
                    <div class="halfpart">
                    
                    </div>
            </div>
        </section>

    </section>
      <div class="flexiable">
          <div class="halfpart">
    
            </div>
          <div class="halfpart">
              <h1 class="us">Want to rent a parking spot?</h1>
              <p class="descrip">You can rent your free space for us! Click the button below for details.</p>
              <div class="containercater">
                  <div class="center">
                      <a class="button" target="_blank" href="parkingowner.php">RENT NOW!</a>
                  </div>
                </div>
              </div>
      </div>
    </section>

    <section id="about-section"></section>
    <section class="about">
        <div class="flexiable">
            <div class="halfpart">
            </div>
            <div class="halfpart">
                <h1 class="us">About Us</h1>
                <p class="descrip">My Parking Spot helps us to park your vehicle safely as you travel anywhere, anytime, anyplace! We ensure safe parking spot for you</p>
            </div>
        </div>
    </section>
<script>
    function scrollToAbout() {
        const aboutSection = document.getElementById('about-section');
        aboutSection.scrollIntoView({ behavior: 'smooth' });
    }
</script>