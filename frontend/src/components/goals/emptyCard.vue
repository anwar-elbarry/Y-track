<template>
<button
      class="bg-gray-50 border-gray-300 hover:border-orange-400 hover:text-orange-400 hover:shadow-md cursor-pointer flex min-w-2xs max-h-60  flex-col items-center text-base text-gray-600 font-medium px-[60px] py-[68px] rounded-xl border-dashed border-2 max-md:px-5"
    >
    <v-icon name="bi-plus-square-dotted" scale="3"/>
      <div class="bg-[rgba(0,0,0,0)] w-full max-w-full mt-2 pt-0.5 pb-2.5 px-px">
        Add New Goal
      </div>
    </button>
</template>

<script>
export default {
    name : 'emptyCard'
}
</script>