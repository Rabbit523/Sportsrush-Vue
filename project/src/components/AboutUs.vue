<template>
    <div class="container">
        <div class="row">
            <h1>About Us</h1>
            <div class="col-md-12">
                <div class="about-logo content">
                    <h2>We are awesome <span class="color">TEAM</span></h2>
                    <p>Sed ut perspiciaatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas</p>
                        <p>Sed ut perspiciaatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas</p>
                </div>
            </div>
            <div class="block-heading-six">
                <h2 class="bg-color">Our Team</h2>
            </div>
            <div class="team-six">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <!-- Team Member -->
                        <div class="team-member">
                            <!-- Image -->
                            <img class="img-responsive" src="../assets/team1.png" alt="">
                            <!-- Name -->
                            <h4>Johne Doe</h4>
                            <span class="deg">Creative</span> 
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <!-- Team Member -->
                        <div class="team-member">
                            <!-- Image -->
                            <img class="img-responsive" src="../assets/team2.png" alt="">
                            <!-- Name -->
                            <h4>Jennifer</h4>
                            <span class="deg">Programmer</span> 
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <!-- Team Member -->
                        <div class="team-member">
                            <!-- Image -->
                            <img class="img-responsive" src="../assets/team4.png" alt="">
                            <!-- Name -->
                            <h4>Christean</h4>
                            <span class="deg">CEO</span> 
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <!-- Team Member -->
                        <div class="team-member">
                            <!-- Image -->
                            <img class="img-responsive" src="../assets/team3.png" alt="">
                            <!-- Name -->
                            <h4>Kerinele rase</h4>
                            <span class="deg">Manager</span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.team-six {
    display: table;
    margin-bottom: 50px;
}
.col-md-12 {
  display: table;
}
.block-heading-six {
  margin-top: 40px;
  margin-bottom: 40px;
}
.col-md-3 {
  width: 25%;
  float: left;
}
#content img {
  max-width: 100%;
  height: auto;
}

.img-responsive {
  display: block;
  max-width: 100%;
  height: auto;
}
h1.aligncenter {
  margin-bottom: 50px;
}
.aligncenter {
  text-align: center;
}
h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: "Open Sans", Arial, sans-serif;
  font-weight: 700;
  line-height: 1.1em;
  margin-bottom: 20px;
}
.row {
  display: table;
  margin-top: 50px;
}
.content {
  display: table;
  float: left;
}
.width-7 {
  width: 70%;
}
.width-3 {
  width: 30%;
}
.content p {
  font-size: 16px;
}
.left {
  position: relative;
}
.left img {
  position: absolute;
  bottom: 0;
}
.container {
  margin-left: 280px;
  margin-right: 280px;
}
</style>
