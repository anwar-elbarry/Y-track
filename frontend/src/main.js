import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router';

import { OhVueIcon, addIcons } from "oh-vue-icons";
import { FaWallet, BiCashCoin , BiCalendarCheckFill , RiLineChartLine , GiOnTarget , RiFileTextFill , BiArrowLeft , BiArrowRight} from "oh-vue-icons/icons";
addIcons(FaWallet, BiCashCoin ,BiCalendarCheckFill , RiLineChartLine , GiOnTarget , RiFileTextFill , BiArrowLeft, BiArrowRight);


const app = createApp(App);
app.component("v-icon", OhVueIcon);

import Navbar from './components/Navbar.vue'
app.component("navbar",Navbar);

app.use(router)

app.mount("#app");