<template>
    <div class="Billss_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Bills" />
            <AddBtn name="Add Bills" @click="showForm = true"/>
            <AddBtn name="Add Category" @click="showCategoryForm = true"/>
        </div>
        
        <Bills_table 
        :BillItems="bills"
        @removed-bill="removeBill"
        @updated-bill="payBill"/>
        <BillForm 
        v-if="showForm"
        :billsCategories="billCategories"
        @close="closeForm"
        @bill-added="fetchBills"
        />
        <Bills_category_form 
        v-if="showCategoryForm"
        @close="closeCategoryForm"
        @category-added="fetchBillCategories"
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

export default {
    name: 'Billss',
    data(){
        return{
            showForm:false,
            billCategories:[],
            bills:[],
            showCategoryForm : false,
        }
    },
    setup(){
        const billStore = useBillStore();
        const billCategoryStore = useBillCategoryStore();
        return { billStore, billCategoryStore };
    },
    components: {
        AddBtn,
        SearchBare,
        Bills_table,
        BillForm,
        Bills_category_form
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
       async payBill(id,billData){
            await this.billStore.updatebill(id,billData);
            await this.fetchBills();
        },
    },
    created(){
        this.fetchBills();
    }
}
</script>