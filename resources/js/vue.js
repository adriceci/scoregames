import { createApp } from 'vue';

// Import components
import Scoreboard from "./components/Scoreboard.vue";

const app = createApp();

// Register components
app.component('scoreboard', Scoreboard);

app.mount('#app');
