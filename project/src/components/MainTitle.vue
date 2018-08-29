<template>
    <div id="MainTitle">
        <!--logo-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                msg: ''
            }
        }
    }
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    #MainTitle {
        height: 170px;
        background: url('../assets/logoSR.png') center no-repeat scroll;
        background-size: cover;
        width: 600px;
        margin: auto;
    }

    @media (max-width: 760px) { 
        #MainTitle {
            height: 120px;
            background: url('../assets/logoSR_mobile.png') center no-repeat scroll;
            background-size: 60% 120px;
            margin-left: 1%;
        }
    }

    @media (max-width: 400px) { 
        #MainTitle {
            height: 82px;
            background: url('../assets/logoSR_mobile.png') center no-repeat scroll;
            background-size: 50% 82px;
            margin: auto;
            margin-left: 1%;
        }
    }

</style>
