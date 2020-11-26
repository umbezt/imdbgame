<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center">{{ player1Name }} <small>{{ score1 }}</small><span> VS  </span> {{
                        player2Name
                    }} <small>{{ score2 }}</small></h2>
                <a href="#" class="btn btn-sm" @click.prevent="nextQuestion()">Start</a>
                <div class="clear"></div>
                <div class="card d-block" v-for="(question, index) in questions" :key="question.pivot.id"
                     v-if="index === questionIndex">
                    <div class="card-body">
                        <h3 class="card-title">{{ question.title }}</h3>

                        <input type="text" v-model="question.pivot.answer1" v-if="player.id === game.player1">
                        <input type="text" v-model="question.pivot.answer2" v-if="player.id === game.player2">
                        <a href="#" class="btn btn-sm" @click.prevent="setAnswer(question)">Set Answer</a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "Game",
    data() {
        return {
            player: JSON.parse(localStorage.player),
            game: {},
            player1Name: '',
            player2Name: '',
            questions: [],
            questionIndex: 8,
            score1: 0,
            score2: 0
        }
    },

    created() {


    },
    mounted() {
        axios.get('/api/v1/player/start').then(res => {

            console.log("Call method to trigger event");




        });
        Echo.channel('gameUpdates').listen('GameUpdated',
            (r) => {
                console.log("**********");

                console.log(r);
                if(_.isEmpty(this.game)){
                    this.game = r.game;
                    this.questions = r.game.movie;
                    this.score1 = r.game.score1;
                    this.score2 = r.game.score2;

                }
               let localGame = r.game;
                this.player1Name = localGame.player1_game.name;


                if (localGame.player2 != null) {
                    if (Object.keys(localGame.player2_game).length > 0) {
                        this.player2Name = localGame.player2_game.name;
                        this.manageGame();
                    }
                } else {
                    this.player2Name = 'Waiting for a second player to join';
                }

                console.log("**********");
            });
        Echo.channel('scoreUpdates').listen('ScoreUpdated',
            (r) => {
                console.log("--------");

                this.score1 = r.game.score1;
                this.score2 = r.game.score2;
                console.log("--------");
            });
    },
    methods: {
        manageGame() {
            //
            if (this.game.state == 2) {
                Swal.fire({
                    icon: 'info',
                    timer: 2500,
                    title: 'Game starting now',
                    text: 'Good luck!',

                }) ;
                return setTimeout(this.nextQuestion, 3000);
            }
        },
        nextQuestion() {

            if (this.questionIndex >= 0) {

                this.questionIndex -= 1;
                return setTimeout(this.nextQuestion, 8000);
            } else {
                this.endGame();
            }
        },
        endGame() {
            let data = {state: 3};

            if (this.score2 !== this.score1) {
                if (this.score1 > this.score2) {
                    data.winner = this.game.player1;
                } else {
                    data.winner = this.game.player2;
                }
            }
            let gameURL = '/api/v1/game/' + this.game.id;
            axios.put(gameURL, data).then(res => {
                if (data.winner) {
                    if (data.winner == this.player.id) {
                        Swal.fire({
                            icon: 'success',
                            timer: 3000,
                            title: 'Yeah... You Won',
                            text: 'Congratulations!',

                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            timer: 3000,
                            title: 'Oops...',
                            text: 'Better luck next time!',

                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'info',
                        timer: 3000,
                        title: '-_-',
                        text: 'No winner!',

                    })
                }

                //reset game objects
                this.questionIndex = 8;
                this.game = {};
                this.player1Name = '';
                this.player2Name = '';
                this.questions = [];
                this.score1 = 0;
                this.score2 = 0;
                this.$router.push('/');
            });
        }
        ,
        setAnswer(info) {

            let data = {game_movie_id: info.pivot.id};
            if (this.player.id === this.game.player1) {
                data.answer1 = info.pivot.answer1;
                data.correct =  parseInt(info.pivot.answer1) === info.yearOfRelease;
                if (data.correct) {
                    this.game.score1 += 5;
                } else {
                    this.game.score1 -= 3;
                }
                this.score1 = this.game.score1;
                data.score1 = this.score1;

            }

            if (this.player.id === this.game.player2) {
                data.answer2 = info.pivot.answer2;
                data.correct =  parseInt(info.pivot.answer2) === info.yearOfRelease;
                if (data.correct) {
                    this.game.score2 += 5;
                } else {
                    this.game.score2 -= 3;
                }
                this.score2 = this.game.score2;
                data.score2 = this.score2;
            }

            let gameURL = '/api/v1/game/' + this.game.id;
            axios.put(gameURL, data).then(res => {

            });
        }
    }
}
</script>

<style scoped>

</style>
