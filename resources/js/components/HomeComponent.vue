<template>
    <div class="container">
        <form class="form-game" v-if="Object.keys(player).length === 0" method="post" @submit.prevent="setName()">

            <h3 class="h3 mb-3 font-weight-normal">Please set your Name</h3>

            <input type="text" v-model="name" name="name" class="form-control" placeholder="Set Your name">


            <button class="btn btn-sm btn-primary  " type="submit">
                Set Name
            </button>
        </form>
        <form class="form-game" method="post" @submit.prevent="playGame()" v-else>

            <h3 class="h3 mb-3 font-weight-normal">Welcome {{ player.name }}</h3>


            <button class="btn btn-sm btn-success " type="submit">
                Start a game
            </button>
        </form>

        <last-games-component games="games"></last-games-component>
    </div>

</template>

<script>

import LastGamesComponent from "./LastGamesComponent";

export default {
    name: "Home",
    components: {'lastGames': LastGamesComponent},
    data() {
        return {
            name: '',
            games: {},
            player: {},


        }
    },
    created() {

        if (localStorage.player){

            this.player = JSON.parse(localStorage.player);


        } else {
        axios.get('/api/v1/player').then(res => {

            if (Object.keys(res.data.player).length > 0) {
                localStorage.player = JSON.stringify(res.data.player);
            }
            this.player = res.data.player;

        });
        }

        axios.get('/api/v1/game').then(res => {
            this.games = res.data;
            console.log(res.data);
        });

    },
    methods: {
        setName() {
            if (this.name.trim() !== '') {
                axios.post('/api/v1/player', {name: this.name}).then(res => {
                    this.player = '';
                    console.log(res.data);
                    this.player = res.data.player;
                    localStorage.player = JSON.stringify(res.data.player);
                    window.setCookie('player', this.player.hashed_name, 365);
                });
            }
        },
        logoutGame() {

            this.player = '';
            localStorage.player = '';
            window.setCookie('player', null, 0);


        },
        playGame() {
            this.$router.push('/game');
        }
    }
}
</script>

<style scoped>

</style>
