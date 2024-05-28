require('./bootstrap');

import Vue from 'vue';
import StockComponent from './components/StockComponent.vue';

const app = new Vue({
    el: '#app',
    components: {
        StockComponent
    }
});
