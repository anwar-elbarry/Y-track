<template>
  <div class="max-w-3xl mx-auto p-4">
    <div class="flex items-center gap-2 mb-2">
      <div class="text-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-800">Profile Settings</h1>
    </div>
    <p class="text-gray-600 mb-4">Manage your account settings and preferences</p>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
      <div class="flex">
        <button 
          @click="activeTab = 'personal'" 
          class="px-8 py-2 border-b-2 font-medium text-sm"
          :class="activeTab === 'personal' ? 'border-gray-800 text-gray-800' : 'border-transparent text-gray-500 hover:text-gray-700'"
        >
          Personal
        </button>
        <button 
          @click="activeTab = 'security'" 
          class="px-8 py-2 border-b-2 font-medium text-sm"
          :class="activeTab === 'security' ? 'border-gray-800 text-gray-800' : 'border-transparent text-gray-500 hover:text-gray-700'"
        >
          Security
        </button>
      </div>
    </div>

    <!-- Personal Information Tab -->
    <div v-if="activeTab === 'personal'" class="bg-white rounded-lg border border-gray-200 p-6">
      <div class="flex items-center gap-2 mb-4">
        <span class="text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </span>
        <h2 class="text-xl font-bold text-gray-800">Personal Information</h2>
      </div>
      <p class="text-gray-600 mb-6">Update your personal details</p>

      <div class="flex mb-6">
        <div class="mr-6">
          <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center relative">
            <span class="text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </span>
          </div>
          <button class="mt-2 px-4 py-2 text-sm bg-gray-800 text-white rounded hover:bg-gray-700">Change</button>
        </div>
        
        <div class="flex-1">
          <form @submit.prevent="savePersonalInfo">
            <div class="mb-4">
              <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input 
                id="fullName" 
                v-model="personalInfo.fullName" 
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <p v-if="errors.fullName" class="mt-1 text-sm text-red-600">{{ errors.fullName }}</p>
            </div>
            <div class="flex justify-end">
              <button 
                type="submit" 
                class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
              >
              <svg v-if="isSubmittingUser" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Security Settings Tab -->
    <div v-if="activeTab === 'security'" class="bg-white rounded-lg border border-gray-200 p-6">
      <div class="flex items-center gap-2 mb-1">
        <span class="text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </span>
        <h2 class="text-xl font-bold text-gray-800">Security Settings</h2>
      </div>
      <p class="text-gray-600 mb-6">Manage your password and security preferences</p>

      <div class="mb-8">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Change Password</h3>
        <form @submit.prevent="updatePassword">
          <div class="mb-4">
            <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
            <input 
              id="currentPassword" 
              v-model="securityInfo.currentPassword" 
              type="password" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
            <p v-if="errors.currentPassword" class="mt-1 text-sm text-red-600">{{ errors.currentPassword }}</p>
          </div>
          
          <div class="mb-4">
            <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input 
              id="newPassword" 
              v-model="securityInfo.newPassword" 
              type="password" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
            <p v-if="errors.newPassword" class="mt-1 text-sm text-red-600">{{ errors.newPassword }}</p>
          </div>
          
          <div class="mb-6">
            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input 
              id="confirmPassword" 
              v-model="securityInfo.confirmPassword" 
              type="password" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
            <p v-if="errors.confirmPassword" class="mt-1 text-sm text-red-600">{{ errors.confirmPassword }}</p>
          </div>
          
          <div class="mb-8">
            <button 
              type="submit" 
              class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
            >
            <svg v-if="isSubmittingPassword" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Update Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import auth from '../../stores/auth';
const  authStore = auth();
export default {
  name: 'ProfileSettings',
  data() {
    return {
      activeTab: 'personal',
      personalInfo: {
        fullName:authStore.user.name
      },
      securityInfo: {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
      },
      errors : {},
      isSubmittingPassword : false,
      isSubmittingUser : false,
    }
  },
  methods: {
   async savePersonalInfo() {
      this.isSubmittingUser = true;
      if(!this.personalInfo.fullName){
    this.errors.fullName = "name is required"
    
  }

  if (Object.keys(this.errors).length > 0) {
    return;
  }

  const userData = {
    'name': this.personalInfo.fullName
    };


try{
  await authStore.updateUser(userData);
  this.isSubmittingUser = false;
}catch(error){
     console.log(error);
     this.isSubmittingUser = false;
}
  
    },
  async  updatePassword() {
      this.isSubmittingPassword = true;
      // Validation
      if (this.securityInfo.newPassword !== this.securityInfo.confirmPassword) {
    alert('New passwords do not match!')
    
  }
  
  if(!this.securityInfo.currentPassword){
    this.errors.currentPassword = "Current password is required"
    
  }

  if(!this.securityInfo.newPassword){
    this.errors.newPassword = "New password is required"
    
  }

  if(this.securityInfo.newPassword.length < 8){
    this.errors.newPassword = "Password must be at least 8 characters"
  }
if(Object.keys(this.errors).length > 0){
  return this.isSubmitting = false;
}
      const data = {
        'oldPassword' : this.securityInfo.currentPassword,
        'newPassword' : this.securityInfo.confirmPassword,
      };
      await authStore.changePassword(data);
      console.log(authStore.message);
      
      // Reset form
      this.securityInfo.currentPassword = ''
      this.securityInfo.newPassword = ''
      this.securityInfo.confirmPassword = ''
      this.isSubmittingPassword = false;
    }
  }
}
</script>