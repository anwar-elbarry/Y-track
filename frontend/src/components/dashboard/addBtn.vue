<template>
     <button
      class="bg-[rgba(8,16,33,1)] border text-[13px] text-white px-[23px] py-[17px] rounded-md border-solid max-md:px-5"
    >
      {{ name }}
    </button>
</template>

<script>
export default {
    name : 'AddBtn',
    props : {
        name : {
           type : String,
           default :  'Add income'
        }
    }
}
</script>