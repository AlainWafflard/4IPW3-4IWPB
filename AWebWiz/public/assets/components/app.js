import { createApp } from 'vue'
import Counter from './counter.js'

const app = createApp({

    components: {
        Counter: Counter
    },

})

app.mount('section#vuejs_fetch_sample');

