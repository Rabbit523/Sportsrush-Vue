<template>
    <div id="MainTitle">
        <img src='../assets/logoSR.png' alt="logo">
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
        display: flex;
        max-width: 541px;
        max-hight: 151px;
    }
    img{
        flex: flex-shrink;
        flex-shrink: 10;
    }
</style>
