<template>
    <div class="h-screen flex items-center justify-center bg-gray-50">
      <div class="text-center max-w-lg px-6 py-16 bg-white rounded-lg shadow-lg">
        <div class="mb-8">

          <div class="mb-4 inline-flex p-4 bg-orange-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          
  
          <h1 class="text-5xl font-bold text-gray-800 mb-2">404</h1>
          <h2 class="text-2xl font-semibold text-gray-700 mb-6">Page Not Found</h2>
          <p class="text-gray-600 mb-8">
            The page you're looking for doesn't exist or has been moved.
          </p>
          

          <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <router-link to="/" class="px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-colors">
              Back to Home
            </router-link>
            <router-link to="/dashboard" class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
              Go to Dashboard
            </router-link>
          </div>
        </div>
        
        <!-- Logo -->
        <div class="mt-8">
          <img class="h-10 mx-auto" src="/images/Y-TRACK_dark.svg" alt="Y-Track Logo">
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NotFound'
  }
  </script>