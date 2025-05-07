<template>
    <div class="Billss_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <AddBtn name="Add Bills" @click="showForm = true"/>
            <AddBtn name="Add Category" @click="showCategoryForm = true"/>
            <AddBtn 
                :name="showUpcomingBills ? 'Regular Bills' : 'Upcoming Bills'" 
                @click="showUpcomingBills = !showUpcomingBills"
            />
        </div>
        
        <Bills_table 
            v-if="!showUpcomingBills"
            :bills="bills"
            @removed-bill="removeBill" 
        />
        <BillForm 
            v-if="showForm"
            :billsCategories="billCategories"
            @close="closeForm"
            @bill-added="fetchBills"
        />
        <Bills_category_form 
            v-if="showCategoryForm"
            :categories="billCategories"
            @close="closeCategoryForm"
            @category-added="handleCategoryAdded"
        />        
        <Upcoming_Bills_table
            v-if="showUpcomingBills"
            :upcomingBillItems="upcomingBills"
            @removed-upcoming-bill="removeUpcomingBill"
            @paid-upcoming-bill="payUpcomingBill"
        />
    </div>
</template>

<script>
import Bills_table from '../components/Bills/Bills_table.vue';
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import BillForm from '../components/Bills/Bills_Form.vue';
import Bills_category_form from '../components/Bills/Bills_category_form.vue';
import { useBillStore } from '../stores/billsStore';
import { useBillCategoryStore } from '../stores/billsCategoryStore';
import Upcoming_Bills_table from '../components/Bills/Upcoming_Bills_table.vue';

export default {
    name: 'Billss',
    data(){
        return{
            showForm:false,
            billCategories:[],
            bills:[],
            showCategoryForm : false,
            showUpcomingBills:false,
            upcomingBills:[],
        }
    },
    setup(){
        const billStore = useBillStore();
        const billCategoryStore = useBillCategoryStore();
        return { billStore, billCategoryStore};
    },
    components: {
        AddBtn,
        SearchBare,
        Bills_table,
        BillForm,
        Bills_category_form,
        Upcoming_Bills_table
    },
    mounted(){
        this.fetchBills()
    },
    methods:{
      async fetchBills(){
            await this.billStore.fetchBills();
            this.bills = this.billStore.bills;
        },
        async fetchBillCategories(){
            await this.billCategoryStore.fetchCategories();
            this.billCategories = this.billCategoryStore.categories;
        },
        async fetchUpcomingBills(){
            await this.billStore.fetchUpcomingBills();
            this.upcomingBills = this.billStore.upcomingBills;
            console.log('upcomingBills',this.upcomingBills);
        },
        async handleCategoryAdded(newCategory){
            await this.billCategoryStore.addCategory(newCategory);
        },
        closeForm(){
            this.showForm = false;
            this.fetchBills();
        },
        closeCategoryForm(){
            this.showCategoryForm = false;
            this.fetchBillCategories();
        },
        openCategoryForm(){
            this.showCategoryForm = true;
        },
       async removeBill(billId){
            await this.billStore.removebill(billId);
            this.bills = this.bills.filter(client => client.id !== billId);
        },
       async payUpcomingBill(id){
            await this.billStore.paybill(id);
            await this.fetchUpcomingBills();
        },
        async removeUpcomingBill(id){
            await this.billStore.removeUpcomingBill(id);
            this.upcomingBills = this.upcomingBills.filter(upcomingBill => upcomingBill.id !== id);
        },
    },
    created(){
        this.fetchBills();
        this.fetchBillCategories();
        this.fetchUpcomingBills();
    },
    watch: {
        showUpcomingBills(newVal) {
            if (newVal) {
                this.fetchUpcomingBills();
            } else {
                this.fetchBills();
            }
        }
    }
}
</script>