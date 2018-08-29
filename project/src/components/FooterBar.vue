<template>
<footer class="footer-distributed">

			<div class="footer-left">

        <img src="../assets/logoSR_mobile_min.png"/>

				<p class="footer-links">
					<a href="#">Home</a>
					·
					<a href="#">Blog</a>
					·
					<a href="#">Pricing</a>
					·
					<a href="#">About</a>
					·
					<a href="#">Faq</a>
					·
					<a href="#">Contact</a>
				</p>

				<p class="footer-company-name">Sportsrush © 2015</p>
			</div>

			<div class="footer-center">

				<div>
          <div class="fa"><icon name="map-marker" scale="1" class="alert" color="white" ></icon></div>
					<p><span>21 Revolution Street</span> Paris, France</p>
				</div>

				<div>
          <div class="fa"><icon name="phone" scale="1" class="alert" color="white" ></icon></div>
					<p>+1 555 123456</p>
				</div>

				<div>
          <div class="fa fa-phone"><icon name="envelope" scale="1" class="alert" color="white" ></icon></div>
          <p><a href="mailto:support@company.com">support@company.com</a></p>
				</div>

			</div>

			<div class="footer-right">

				<p class="footer-company-about">
					<span>About us</span>
					Lorem ipsum dolor sit amet, consectateur adispicing elit. Fusce euismod convallis velit, eu auctor lacus vehicula sit amet.
				</p>

				<div class="footer-icons">

					<a href="#"><font-awesome-icon :icon="['fab', 'facebook']" /></a>
					<a href="#"><font-awesome-icon :icon="['fab', 'twitter']" /></a>
					<a href="#"><font-awesome-icon :icon="['fab', 'linkedin']" /></a>

				</div>

			</div>

		</footer>
</template>
<style scoped>
@import url("http://fonts.googleapis.com/css?family=Open+Sans:400,700");

* {
  padding: 0;
  margin: 0;
}

html {
  background-color: #eaf0f2;
}

body {
  font: 14px/1.5 Arial, Helvetica, sans-serif;
}

header {
  text-align: center;
  padding-top: 100px;
  margin-bottom: 200px;
}

header h1 {
  font: normal 32px/1.5 "Open Sans", sans-serif;
  color: #3f71ae;
  padding-bottom: 16px;
}

header h2 {
  color: #f05283;
}

header h2 a {
  color: inherit;
  text-decoration: none;
  display: inline-block;
  border: 1px solid #f05283;
  padding: 10px 15px;
  border-radius: 3px;
  font: bold 14px/1 "Open Sans", sans-serif;
  text-transform: uppercase;
}

header h2 a:hover {
  background-color: #f05283;
  transition: 0.2s;
}

header ul {
  max-width: 600px;
  margin: 60px auto 0;
}

header ul a {
  text-decoration: none;
  text-align: left;
  background-color: #b9c1ca;
  padding: 10px 16px;
  border-radius: 2px;
  opacity: 0.8;
  font-size: 16px;
  display: inline-block;
  margin: 4px;
  line-height: 1;
  outline: none;

  transition: 0.2s ease;
}

header ul li a.active {
  background-color: #66b650;
  pointer-events: none;
}

header ul li a:hover {
  opacity: 1;
}

header ul {
  list-style: none;
  padding: 0;
}

header ul li {
  display: inline-block;
}

/* In our demo, the footers are fixed to the bottom of the page */
/*
footer {
  position: fixed;
  bottom: 0;
}

@media (max-height: 800px) {
  footer {
    position: static;
  }
  header {
    padding-top: 40px;
  }
}*/
.footer-distributed {
  background-color: #000;
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
  box-sizing: border-box;
  width: 100%;
  text-align: left;
  font: bold 16px sans-serif;

  padding: 55px 280px;
}

.footer-distributed .footer-left,
.footer-distributed .footer-center,
.footer-distributed .footer-right {
  display: inline-block;
  vertical-align: top;
}
.footer-distributed .footer-center > div {
  display: table;
}
/* Footer left */

.footer-distributed .footer-left {
  width: 40%;
}

/* The company logo */

.footer-distributed h3 {
  color: #ffffff;
  font: normal 36px "Cookie", cursive;
  margin: 0;
}

.footer-distributed h3 span {
  color: #5383d3;
}

/* Footer links */

.footer-distributed .footer-links {
  color: #ffffff;
  margin: 20px 0 12px;
  padding: 0;
}

.footer-distributed .footer-links a {
  display: inline-block;
  line-height: 1.8;
  text-decoration: none;
  color: inherit;
}

.footer-distributed .footer-company-name {
  color: #8f9296;
  font-size: 14px;
  font-weight: normal;
  margin: 0;
}

/* Footer Center */

.footer-distributed .footer-center {
  width: 35%;
}

.footer-distributed .footer-center i {
  background-color: #33383b;
  color: #ffffff;
  font-size: 25px;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  text-align: center;
  line-height: 42px;
  margin: 10px 15px;
  vertical-align: middle;
}

.footer-distributed .footer-center div.fa {
  font-size: 17px;
  line-height: 38px;
  display: table;
  float: left;
  background-color: #33383b;
  color: #ffffff;
  font-size: 25px;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  text-align: center;
  margin: 10px 15px;
  vertical-align: middle;
}

.footer-distributed .footer-center p {
  display: inline-block;
  color: #ffffff;
  vertical-align: middle;
  margin: 0;
  padding-top: 15px;
}

.footer-distributed .footer-center p span {
  display: block;
  font-weight: normal;
  font-size: 14px;
  line-height: 2;
}

.footer-distributed .footer-center p a {
  color: #5383d3;
  text-decoration: none;
}

/* Footer Right */

.footer-distributed .footer-right {
  width: 20%;
}

.footer-distributed .footer-company-about {
  line-height: 20px;
  color: #92999f;
  font-size: 13px;
  font-weight: normal;
  margin: 0;
}

.footer-distributed .footer-company-about span {
  display: block;
  color: #ffffff;
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 20px;
}

.footer-distributed .footer-icons {
  margin-top: 25px;
}

.footer-distributed .footer-icons a {
  display: inline-block;
  width: 35px;
  height: 35px;
  cursor: pointer;
  background-color: #33383b;
  border-radius: 2px;

  font-size: 20px;
  color: #ffffff;
  text-align: center;
  line-height: 35px;

  margin-right: 3px;
  margin-bottom: 5px;
}

/* If you don't want the footer to be responsive, remove these media queries */

@media (max-width: 880px) {
  .footer-distributed {
    font: bold 14px sans-serif;
  }

  .footer-distributed .footer-left,
  .footer-distributed .footer-center,
  .footer-distributed .footer-right {
    display: block;
    width: 100%;
    margin-bottom: 40px;
    text-align: center;
  }

  .footer-distributed .footer-center i {
    margin-left: 0;
  }
}
</style>
