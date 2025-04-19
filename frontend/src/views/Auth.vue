<template>
  <div class="auth-container">
    <Navbar />
    <div id="auth-wrapper" class="flex min-h-screen w-full bg-gray-50 pt-20">
    <!-- Left side banner-->
    <div class="hidden lg:flex lg:w-1/2 bg-black p-12 items-center justify-center">
      <div class="max-w-xl text-center">
        <img class="w-full h-auto mb-8 mx-auto" src="/images/Y-TRACK_light.svg" alt="Platform illustration">
        <h2 class="text-white text-2xl font-bold mb-4">Welcome to Y-TRACK</h2>
        <p class="text-orange-100 text-lg">Take control of your finances with Y-Track.
Track your income, expenses, and investments effortlessly.
Make informed decisions and stay on top of your financial goals.</p>
      </div>
    </div>
    
    <!-- Right side authentication forms -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
      <div class="w-full max-w-md space-y-8">
        <!-- Logo for mobile view -->
        <div class="block lg:hidden text-center mb-8">
          <img class="h-12 mx-auto" src="/images/Y-TRACK_dark.svg" alt="Y-track">
        </div>
        
        <!-- Form tabs -->
        <div class="flex space-x-4 border-b border-gray-200">
          <button  @click="toggleForm('signin')" id="signin-tab" class="px-4 py-2 text-sm font-medium text-black border-b-2 border-black transition-colors duration-200">Sign In</button>
          <button  @click="toggleForm('signup')" id="signup-tab" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors duration-200">Sign Up</button>
        </div>
        
        <!-- Error messages -->
        <div id="error-container" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold" id="error-title">Error!</strong>
          <span class="block sm:inline" id="error-message">An error occurred. Please try again.</span>
        </div>
        
        <!-- Sign In Form -->
        <form id="signin-form" 
        @submit.prevent="submitLogin"
        class="space-y-6">
       
          <div>
            <label for="signin-email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input v-model="loginCredentials.email" type="email" id="signin-email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="name@gmail.com" required>
          </div>
          <div>
            <label for="signin-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
              <input v-model="loginCredentials.password" type="password" id="signin-password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="••••••••" required>
              <button @click="togglePasswordVisibility('signin-password' , 'signin-password-icon')" type="button" class="absolute right-3 top-2 text-gray-500" >
                <i id="signin-password-icon" class="fa-regular fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input type="checkbox" id="remember-me" name="remember-me" class="h-4 w-4 text-orange-600 border-gray-300 rounded">
              <label for="remember-me" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>
            <a href="#" class="text-sm text-orange-600 hover:text-orange-500 transition-colors duration-200">Forgot password?</a>
          </div>
          <button type="submit" class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-200 transition-colors duration-200">
            Sign in
          </button>
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-gray-50 text-gray-500">Or continue with</span>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <a href="#" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              <i class="fa-brands fa-google text-xl text-gray-600 mr-2"></i>
              Google
            </a>
            <a href="#" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              <i class="fa-brands fa-facebook text-xl text-blue-600 mr-2"></i>
              Facebook
            </a>
          </div>
          <div class="text-center text-sm text-gray-600">
            Don't have an account? 
            <span  @click="toggleForm('signin')" class="text-orange-600 hover:text-orange-500 cursor-pointer transition-colors duration-200">Sign up</span>
          </div>
        </form>
  
        <!-- Sign Up Form -->
        <form id="signup-form" 
        @submit.prevent="submitRegisteration" 
        class="hidden space-y-6">
          <div>
            <label for="signup-username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input v-model="singupCredentials.name" type="text" id="signup-username" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="johndoe" required>
          </div>
          <div>
            <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input v-model="singupCredentials.email" type="email" id="signup-email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="name@gmail.com" required>
          </div>
          <div>
            <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
              <input v-model="singupCredentials.password" type="password" id="signup-password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="••••••••" required>
              <button @click="togglePasswordVisibility('signup-password' , 'signup-password-icon')" type="button" class="absolute right-3 top-2 text-gray-500">
                <i id="signup-password-icon" class="fa-regular fa-eye"></i>
              </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters with numbers and special characters.</p>
          </div>
          <div>
            <label  for="signup-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <div class="relative">
              <input v-model="singupCredentials.confirmPassword" type="password" id="signup-confirm-password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600" placeholder="••••••••" required>
            </div>
          </div>
          <div>
    <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Preferred Currency</label>
    <div class="relative">
      <select v-model="singupCredentials.currency" id="currency" name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600">
      <option value="#">Select your preffered Currency</option>
        <option v-for="country in currencies" :value="country.currency">{{ country.currency }}  :  {{ country.name }}</option>
      </select>
    </div>
  </div>
          <div class="flex items-start">
            <input type="checkbox" id="agree-terms" name="agree_terms" class="h-4 w-4 mt-1 text-orange-600 border-gray-300 rounded" required>
            <label for="agree-terms" class="ml-2 text-sm text-gray-600">I agree to the <a href="/terms" class="text-orange-600 hover:text-orange-500">Terms of Service</a> and <a href="/privacy" class="text-orange-600 hover:text-orange-500">Privacy Policy</a></label>
          </div>
          <button type="submit" class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-200 transition-colors duration-200">
            Create Account
          </button>
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-gray-50 text-gray-500">Or continue with</span>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <a href="#" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              <i class="fa-brands fa-google text-xl text-gray-600 mr-2"></i>
              Google
            </a>
            <a href="#" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
              <i class="fa-brands fa-facebook text-xl text-blue-600 mr-2"></i>
              Facebook
            </a>
          </div>
          <div class="text-center text-sm text-gray-600">
            Already have an account? 
            <span @click="toggleForm('signin')" class="text-orange-600 hover:text-orange-500 cursor-pointer transition-colors duration-200">Sign in</span>
          </div>
        </form>
      </div>
    </div>
  </div>
  <Footer_componant />
  </div>
</template>
<script >

import Footer_componant from '../components/Footer.vue';
import Navbar from '../components/Navbar.vue';
import api from '../api'
import auth from '../stores/auth';
import axios from 'axios';

export default {
  name: 'Auth',
  components: {
    Navbar,
    Footer_componant
  },
  data() {
    return {
      activeForm: 'signin',
      currencies: [] ,
      loginCredentials : {
        email : '',
        password : '',
      },
      singupCredentials : {
        name : '',
        email : '',
        password : '',
        confirmPassword : '',
        currency : '',
      }
    }
  },
  methods: {
    toggleForm(formType) {
      this.activeForm = formType;
      
      // For direct DOM manipulation if needed (though Vue's reactivity is preferred)
      const signinForm = document.getElementById('signin-form');
      const signupForm = document.getElementById('signup-form');
      const signinTab = document.getElementById('signin-tab');
      const signupTab = document.getElementById('signup-tab');
      
      if (formType === 'signin') {
        signinForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
        signinTab.classList.add('text-black', 'border-b-2', 'border-black');
        signinTab.classList.remove('text-gray-600');
        signupTab.classList.add('text-gray-600');
        signupTab.classList.remove('text-black', 'border-b-2', 'border-black');
      } else {
        signinForm.classList.add('hidden');
        signupForm.classList.remove('hidden');
        signinTab.classList.remove('text-black', 'border-b-2', 'border-black');
        signinTab.classList.add('text-gray-600');
        signupTab.classList.remove('text-gray-600');
        signupTab.classList.add('text-black', 'border-b-2', 'border-black');
      }
    },
    togglePasswordVisibility(inputId, iconId) {
      const passwordInput = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    },
   async submitRegisteration(){
      api.post('api/auth/signup',this.singupCredentials)
      .then(Response => {
        console.log(Response.data.user);
        console.log(Response.data.message);
          this.singupCredentials.name = '';
          this.singupCredentials.email = '';
          this.singupCredentials.confirmPassword = '';
          this.singupCredentials.currency = '';
          this.singupCredentials.password = '';
            this.$router.push('/auth#signin-form')
      })
      .catch(error => {
        console.log('error' , error);
      });
      },
   async getCurrencies() {
  axios.get('https://countriesnow.space/api/v0.1/countries/currency')
    .then(response => {
      // Map the data to extract the country name and currency
      this.currencies = response.data.data.map(item => ({
        name: item.name,
        currency: item.currency
      }));
      console.log(this.currencies);
    })
    .catch(error => {
      console.log('error', error);
    });
},
    async submitLogin(){
        try {
          const authStore = auth()
          await authStore.login(this.loginCredentials)
          console.log(authStore.message)
          this.loginCredentials.email = '';
          this.loginCredentials.password = '';
          this.$router.push('/dashboard')
        }catch(error){
          console.log(error)
          this.loginError = error.response?.data?.message || 'Login failed'
        }
    }
  },
  created(){
    this.getCurrencies();
  }
}
</script>