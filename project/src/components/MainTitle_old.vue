<template>
  <div id="MainTitle">
      <!--logo-->
  </div>
</template>

<script>   
export default {
  data () {
    return {
      msg: ''
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    #MainTitle {
            height: 151px;
            background: url('../assets/logoSR.png')center center no-repeat scroll;
        }
    
    @media (max-width: 760px) { 
        #MainTitle {
            height: 120px;
            background: url('../assets/logoSR_mobile.png')center center no-repeat scroll;
        }
    }
    
    @media (max-width: 350px) { 
        #MainTitle {
            height: 120px;
            background: url('../assets/logoSR_mobile_min.png')center center no-repeat scroll;
        }
    }
</style>
