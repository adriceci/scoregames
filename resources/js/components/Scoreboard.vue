<script setup>
import { ref } from 'vue';

let playerName = ref('');

const players = getPlayers();

const PLAYER_BASE = {
    name: '',
    scores: [],
    totalScore: 0,
};

function addPlayer() {
    const name = playerName.value.trim();

    if (!name || players.find(player => player.name === name)) return;

    const player = Object.assign({}, PLAYER_BASE);
    player.name = name;
    players.push(player);

    localStorage.setItem('players', JSON.stringify(players));

    playerName.value = '';
    location.reload();
}

function getPlayers() {
    return localStorage.getItem('players') ? JSON.parse(localStorage.getItem('players')) : [];
}

function addScore(player) {
    const score = parseInt(event.target.value);

    if (!score) return;

    player.scores.push(score);
    player.totalScore = player.scores.reduce((a, b) => a + b, 0);


    localStorage.setItem('players', JSON.stringify(players));

    event.target.value = '';
    location.reload();
}

function reset() {
    const confirm = window.confirm('Are you sure you want to reset the scoreboard?');

    if (!confirm) return;
    localStorage.removeItem('players');
    players.value = [];
    location.reload();
}

async function save(){
    const gameName = prompt('Game Name');
    const data = {
        name: gameName,
        game_data: JSON.stringify(getPlayers()),
    };

    await axios.post('/api/scoreboard', data)
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        });
}

</script>

<template>
    <div>
        <div class="flex">
            <input type="text" placeholder="Player Name" v-model="playerName" class="mr-2 px-2 py-1" v-on:keyup.enter="addPlayer()">
            <button @click="addPlayer()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
            <button @click="reset()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>
            <button @click="save()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
            </button>
        </div>

        <!-- Scoreboard -->
        <table class="table-auto w-full my-8">
            <thead>
                <tr class="text-center">
                    <th
                        v-for="(player, index) in players"
                        :key="player.name"
                        class="p-1 border-b-2 border-primary align-top"
                        :class="{'border-r-2' : index < players.length - 1}"
                    >{{ player.name }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- Scores -->
                <tr class="text-center">
                    <td
                        v-for="(player, index) in players"
                        :key="player.name"
                        class="border-primary align-top"
                        :class="{'border-r-2' : index < players.length - 1}"
                    >
                        <div v-for="score in player.scores" :key="score" class="p-1">
                            {{ score }}
                        </div>
                    </td>
                </tr>
                <!-- Add new score -->
                <tr class="text-center border-t-2 border-b-2 border-primary">
                    <td
                        v-for="(player, index) in players"
                        :key="player.name"
                        class="p-2 border-primary align-top"
                        :class="{'border-r-2' : index < players.length - 1}"
                    >
                        <input type="number" class="mx-auto w-12 h-8 rounded-lg text-center" v-on:keyup.enter="addScore(player)">
                    </td>
                </tr>
                <!-- Total Scores -->
                <tr class="text-center">
                    <td
                        v-for="(player, index) in players"
                        :key="player.name"
                        class="p-1 border-primary align-top text-tertiary font-bold"
                        :class="{'border-r-2' : index < players.length - 1}"
                    >
                        {{ player.totalScore }}
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</template>

<style scoped>

</style>
