<template>
    <div class="Expences_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Expence" />
            <button
            @click="openCategoryForm = true" 
            class="bg-[rgba(8,16,33,1)] cursor-pointer border text-3 text-white px-4 py-3 rounded-md border-solid max-md:px-5"
    >
      Add Category
    </button>
            <AddBtn @click="openForm = true" name="Add Expence"/>
        </div>
        <Expence_table 
        :expenses="expenses"
        @reload-expenses="fetchExpenses"
        @selected-expense="openForm = true"
        />
        <Expence_form 
        v-if="openForm"
        :categories="categories"
        @close="closeForm"
        @reload-expenses="fetchExpenses"
        />
        <Expence_category_form 
        v-if="openCategoryForm"
        @reload-categories=""
        @close="closeCategoryForm"
        
        />
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Expence_category_form from '../components/expences/expence_category_form.vue';
import Expence_form from '../components/expences/expence_form.vue';
import Expence_table from '../components/expences/expence_table.vue';
import { useCategoryStore } from '../stores/categoryStore';
import { useExpenseStore } from '../stores/expenseStore';
export default {
    name: 'Expences',
    components: {
        AddBtn,
        SearchBare,
        Expence_table,
        Expence_form,
        Expence_category_form
    },
    setup(){
        const expenseStore = useExpenseStore()
        const categoryStore = useCategoryStore()
        return { expenseStore , categoryStore}
    },
    data(){
        return {
            openForm : false,
            openCategoryForm : false,
            expenses: [],
            categories: [],
        }
    },
    methods : {
        closeForm(){
            this.openForm = false;
        },
        closeCategoryForm(){
            this.openCategoryForm = false;
        },
        async fetchExpenses(){
            await this.expenseStore.fetchExpenses()
            this.expenses = this.expenseStore.expenses
            console.log('expenses in table :',this.expenses);
            
        },
        async fetchCategories(){
              await this.categoryStore.fetchCategories()
              this.categories = this.categoryStore.categories;
        }
    },
    created(){
        this.fetchExpenses();
        this.fetchCategories();
    }
}
</script>