<template>
    <div class="descriptionBox">
        <article class="content">
            <p>{{description}}</p>  
        </article>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                description: 'Welcome to sportsrush!'
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .descriptionBox {
        display: flex;
        margin: auto;
        width: 700px;
        border: 2px solid white;
        background-color: #af1945;
        border-radius: 5px;
        margin-bottom: 10px;
        margin-top: 20px;
    }

    .content {
        text-align: justify;
        padding: 2px;
        margin: auto;
    }

    @media (max-width: 760px) { 
        .descriptionBox {
            display: flex;
            margin: auto;
            width: 75%;
            border: 2px solid white;
            background-color: #af1945;
            border-radius: 5px;
            margin-bottom: 10px;
            margin-top: 20px;
        }
    }

</style>
