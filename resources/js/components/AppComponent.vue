<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="navbar-nav">
                    <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
                    <router-link :to="{ name: 'game' }" class="nav-link" >New Game</router-link>
                </ul>
            </div>
        </nav>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
export default {
    name: "App",
    beforeCreate(){
        if(!localStorage.player){
            axios.get('/api/v1/player').then(res => {

                if(Object.keys(res.data.player).length > 0)
                {
                    localStorage.player =  JSON.stringify(res.data.player);
                }


            });
        }
    }
}
</script>
