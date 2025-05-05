<template>
    <div class="w-full overflow-x-auto">
      <!-- Filters -->
      <div class="bg-white p-4 mb-4 flex gap-4 items-center">
        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">Role:</label>
          <select 
            v-model="selectedRole" 
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
          >
            <option value="">All Roles</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
        </div>

        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">Status:</label>
          <select 
            v-model="selectedStatus" 
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
          >
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="suspended">Suspended</option>
          </select>
        </div>

        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">Search:</label>
          <input 
            type="text" 
            v-model="searchQuery"
            placeholder="Search users..."
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 w-64"
          />
        </div>

        <button 
          @click="clearFilters"
          class="text-sm text-gray-600 hover:text-orange-500 flex items-center gap-1"
        >
          Clear Filters
        </button>
      </div>

      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead>
          <tr class="border-b border-gray-300 bg-gray-50">
            <th class="w-12 p-3">
              <input type="checkbox" class="rounded border-gray-300" @change="toggleSelectAll" v-model="selectAll">
            </th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">ID</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Name</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Email</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Role</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Status</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Joined Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          <tr v-for="(user, index) in paginatedUsers" :key="user.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="user.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ user.id }}</td>
            <td class="p-3 text-sm">
              <div class="flex items-center">
                <img v-if="user.avatar" :src="user.avatar" class="w-8 h-8 rounded-full mr-2" alt="Profile">
                <div v-else class="w-8 h-8 rounded-full bg-gray-200 mr-2 flex items-center justify-center">
                  <span class="text-gray-600 font-bold">{{ getInitials(user.name) }}</span>
                </div>
                <div>
                  <div class="text-gray-700">{{ user.name }}</div>
                </div>
              </div>
            </td>
            <td class="p-3 text-sm text-gray-700">{{ user.email }}</td>
            <td class="p-3 text-sm text-gray-700">
              <span 
                class="px-2 py-1 text-xs rounded-full" 
                :class="{ 
                  'bg-yellow-100 text-yellow-800': user.role === 'admin', 
                  'bg-blue-100 text-blue-800': user.role === 'user' 
                }"
              >
                {{ user.role }}
              </span>
            </td>
            <td class="p-3">
              <span 
                class="px-2 py-1 text-xs rounded-full" 
                :class="{ 
                  'bg-green-100 text-green-800': user.status === 'active', 
                  'bg-red-100 text-red-800': user.status === 'suspended' 
                }"
              >
                <span 
                  class="inline-block w-2 h-2 rounded-full mr-1" 
                  :class="{ 
                    'bg-green-500': user.status === 'active', 
                    'bg-red-500': user.status === 'suspended' 
                  }"
                ></span>
                {{ user.status }}
              </span>
            </td>
            <td class="p-3 text-sm text-gray-700">{{ formatDate(user.created_at) }}</td>
            <td class="p-3 text-sm text-gray-700">
              <div class="flex space-x-2">
                <button 
                  @click="toggleUserStatus(user)" 
                  class="text-sm py-1 px-2 rounded"
                  :class="{
                    'bg-red-100 text-red-700 hover:bg-red-200': user.status === 'active',
                    'bg-green-100 text-green-700 hover:bg-green-200': user.status === 'suspended'
                  }"
                >
                  {{ user.status === 'active' ? 'Suspend' : 'Activate' }}
                </button>
                <button 
                  @click="confirmDeleteUser(user)" 
                  class="bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm py-1 px-2 rounded flex items-center"
                >
                  <v-icon name="oi-trash" class="mr-1" /> Delete
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="flex items-center justify-between p-4">
        <div class="flex justify-between items-center w-full">
          <div class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ startIndex + 1 }}</span>
            to
            <span class="font-medium">{{ endIndex }}</span>
            of
            <span class="font-medium">{{ totalUsers }}</span>
            results
          </div>
          <div class="flex items-center space-x-2">
            <button 
              @click="previousPage" 
              :disabled="currentPage === 1"
              :class="[
                'relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md',
                currentPage === 1 
                  ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                  : 'bg-white text-gray-700 hover:bg-gray-50'
              ]"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Previous
            </button>
            
            <div class="flex items-center space-x-2">
              <template v-for="page in displayedPages" :key="page">
                <span 
                  v-if="page !== '...'" 
                  class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer"
                  :class="{ 'bg-orange-100 text-orange-800': page === currentPage }"
                  @click="goToPage(page)"
                >
                  {{ page }}
                </span>
                <span v-else class="px-3 py-1 text-sm cursor-default">...</span>
              </template>
            </div>
            
            <button 
              @click="nextPage"
              :disabled="currentPage >= totalPages"
              :class="[
                'relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md',
                currentPage >= totalPages 
                  ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                  : 'bg-white text-gray-700 hover:bg-gray-50'
              ]"
            >
              Next
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Delete</h3>
        <p class="text-sm text-gray-500 mb-4">
          Are you sure you want to delete the user <span class="font-semibold">{{ userToDelete?.name }}</span>? This action cannot be undone.
        </p>
        <div class="flex justify-end space-x-3">
          <button 
            @click="cancelDelete" 
            class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200"
          >
            Cancel
          </button>
          <button 
            @click="deleteUser" 
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </template>

<script>
import { format } from 'date-fns';
import { notify } from '@kyvg/vue3-notification';
import adminService from '../../services/adminService';
export default {
  name: 'UsersTable',
  data() {
    return {
      users: [],
      selectedRole: '',
      selectedStatus: '',
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      selectAll: false,
      totalUsers: 0,
      
      // Delete modal
      showDeleteModal: false,
      userToDelete: null
    };
  },
  computed: {
    filteredUsers() {
      let result = [...this.users];
      
      // Apply filters
      if (this.selectedRole) {
        result = result.filter(user => user.role === this.selectedRole);
      }
      
      if (this.selectedStatus) {
        result = result.filter(user => user.status === this.selectedStatus);
      }
      
      if (this.searchQuery.trim()) {
        const query = this.searchQuery.toLowerCase();
        result = result.filter(user => 
          user.name.toLowerCase().includes(query) || 
          user.email.toLowerCase().includes(query)
        );
      }
      
      return result;
    },
    
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredUsers.slice(start, end);
    },
    
    totalPages() {
      return Math.ceil(this.filteredUsers.length / this.itemsPerPage);
    },
    
    startIndex() {
      return (this.currentPage - 1) * this.itemsPerPage;
    },
    
    endIndex() {
      const end = this.startIndex + this.itemsPerPage;
      return Math.min(end, this.filteredUsers.length);
    },
    
    displayedPages() {
      const range = [];
      const maxVisiblePages = 5;
      
      if (this.totalPages <= maxVisiblePages) {
        for (let i = 1; i <= this.totalPages; i++) {
          range.push(i);
        }
      } else {
        range.push(1);
        
        let startPage = Math.max(2, this.currentPage - 1);
        let endPage = Math.min(this.totalPages - 1, this.currentPage + 1);
        
        if (startPage > 2) range.push('...');
        
        for (let i = startPage; i <= endPage; i++) {
          range.push(i);
        }
        
        if (endPage < this.totalPages - 1) range.push('...');
        range.push(this.totalPages);
      }
      
      return range;
    }
  },
  methods: {
    async fetchUsers() {
      try {
        const users = await adminService.getAllUsers();
        this.users = users.map(user => ({
          ...user,
          selected: false
        }));
        this.totalUsers = this.users.length;
      } catch (error) {
        console.error('Error fetching users:', error);
        notify({
          type: 'error',
          title: 'Error',
          text: 'Failed to load users'
        });
      }
    },
    
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      return format(new Date(dateString), 'MMM dd, yyyy');
    },
    
    getInitials(name) {
      if (!name) return '';
      return name
        .split(' ')
        .map(part => part[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);
    },
    
    clearFilters() {
      this.selectedRole = '';
      this.selectedStatus = '';
      this.searchQuery = '';
      this.currentPage = 1;
    },
    
    toggleSelectAll() {
      this.paginatedUsers.forEach(user => {
        user.selected = this.selectAll;
      });
    },
    
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    
    goToPage(page) {
      if (typeof page === 'number') {
        this.currentPage = page;
      }
    },
    
    async toggleUserStatus(user) {
      try {
        const newStatus = user.status === 'active' ? 'suspended' : 'active';
        await adminService.updateUserStatus(user.id, newStatus);
        
        user.status = newStatus;
        
        notify({
          type: 'success',
          title: 'Success',
          text: `User has been ${newStatus}`
        });
      } catch (error) {
        console.error('Error updating user status:', error);
        notify({
          type: 'error',
          title: 'Error',
          text: 'Failed to update user status'
        });
      }
    },
    
    confirmDeleteUser(user) {
      this.userToDelete = user;
      this.showDeleteModal = true;
    },
    
    cancelDelete() {
      this.showDeleteModal = false;
      this.userToDelete = null;
    },
    
    async deleteUser() {
      if (!this.userToDelete) return;
      
      try {
        await adminService.deleteUser(this.userToDelete.id);
        
        const index = this.users.findIndex(u => u.id === this.userToDelete.id);
        if (index !== -1) {
          this.users.splice(index, 1);
        }
        
        notify({
          type: 'success',
          title: 'Success',
          text: 'User has been deleted successfully'
        });
        
        this.showDeleteModal = false;
        this.userToDelete = null;
      } catch (error) {
        console.error('Error deleting user:', error);
        notify({
          type: 'error',
          title: 'Error',
          text: 'Failed to delete user'
        });
      }
    },
  },
  mounted() {
    this.fetchUsers();
  }
};
</script>