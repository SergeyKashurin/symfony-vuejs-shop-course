import Vue from "vue";
import App from './App';
import store from "./store";

if (document.getElementById('appMainMenuCart')) {
    new Vue({
        el: "#appMainMenuCart",
        store,
        render: h => h(App)
    })
}