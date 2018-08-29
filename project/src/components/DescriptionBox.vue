<template>
    <div class="descriptionBox">
        <article class="contentDescriptionBox">
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

    .contentDescriptionBox {
        text-align: justify;
        padding: 2px;
        margin: auto;
    }

    @media (max-width: 760px) { 
        .descriptionBox {
            display: flex;
            margin: auto;
            width: 50%;
            border: 2px solid white;
            background-color: #af1945;
            border-radius: 5px;
            margin-bottom: 10px;
            margin-top: 20px;
        }
    }

</style>
