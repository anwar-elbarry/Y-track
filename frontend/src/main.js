import { createApp } from 'vue'
import { createPinia  } from 'pinia'

import './style.css'
import App from './App.vue'
import router from './router';


import { OhVueIcon, addIcons } from "oh-vue-icons";
import { FaWallet, BiChevronRight,RiLogoutCircleRLine,BiPerson,BiLinkedin,IoTrendingDownOutline,IoTrendingUpOutline ,FaGlobe,IoArrowForwardCircleOutline,FaFileInvoiceDollar, BiCashCoin,BiInstagram ,GiArcheryTarget,MdTimerOutlined, BiCalendarCheckFill,BiPlusSquareDotted ,LaEditSolid,OiTrash, BiEyeFill,RiLineChartLine , GiOnTarget , RiFileTextFill , BiArrowLeft , BiArrowRight} from "oh-vue-icons/icons";
addIcons(FaWallet, BiChevronRight,RiLogoutCircleRLine,BiPerson,BiLinkedin,IoTrendingDownOutline,IoTrendingUpOutline,FaGlobe ,IoArrowForwardCircleOutline,FaFileInvoiceDollar, BiCashCoin ,BiInstagram,GiArcheryTarget,MdTimerOutlined,BiCalendarCheckFill ,BiPlusSquareDotted,LaEditSolid,OiTrash,BiEyeFill, RiLineChartLine , GiOnTarget , RiFileTextFill , BiArrowLeft, BiArrowRight);


const app = createApp(App);
app.component("v-icon", OhVueIcon);

import Navbar from './components/Navbar.vue'
app.component("Navbar",Navbar);

import Footer from './components/Footer.vue'
app.component('Footer_componant',Footer);

import Aside from './components/Aside.vue';
app.component('Aside',Aside)

app.use(router);
app.use(createPinia());
app.mount("#app");