<template>
    <div class="container">
        <div class="row">
            <div class="content left width-7">
                <img src="../assets/img1.png"/>
            </div>
            <div class="content width-3">
                <div><h1 class="aligncenter">WHO WE ARE?</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><p> Dolores quae porro consequatur aliquam, 
                    incidunt eius magni provident, doloribus omnis minus temporibus perferendis nesciunt quam repellendus 
                    nulla nemo ipsum odit corrupti consequuntur possimus, vero mollitia velit ad consectetur. 
                    </p><p>Alias, laborum excepturi nihil autem nemo numquam, ipsa architecto non, magni consequuntur quam.</p>
                </div>
                <br>
            </div>
        </div>
    </div>
</template>
<style scoped>
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
  min-height: 550px;
}
.width-7 {
  width: 70%;
}
.width-3 {
  width: 30%;
}
.content p {
  font-size: 18px;
}
.left {
  position: relative;
}
.left img {
  /* position: absolute; */
  bottom: 0;
  height: 450px;
}
.container {
  margin-left: 280px;
  margin-right: 280px;
}
</style>
