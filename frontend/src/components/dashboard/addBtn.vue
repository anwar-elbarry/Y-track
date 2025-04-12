<template>
     <button
      class="bg-[rgba(8,16,33,1)] cursor-pointer border text-3 text-white px-4 py-3 rounded-md border-solid max-md:px-5"
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