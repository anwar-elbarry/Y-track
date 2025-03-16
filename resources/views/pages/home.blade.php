@extends('layoats.base')
@include('components.navbar')
@section('base-content')
<section class="flex flex-col relative min-h-[759px] w-full overflow-hidden pt-4 pb-[71px] px-20 max-md:max-w-full max-md:px-5">
      <img
        src="{{ asset('images/heroimg.png') }}"
        alt="Hero background"
        class="absolute h-full w-full object-cover inset-0"
      />
      <Navbar />
      <div class="relative flex w-[507px] max-w-full flex-col items-stretch mt-41 max-md:mt-10">
        <div class="flex w-full max-w-[507px] flex-col items-stretch text-[#061C3D] max-md:max-w-full">
          <div class="bg-[#FFE9BD] gap-2 text-3 font-medium text-center uppercase tracking-[0.11px] leading-none px-4 py-2 rounded-[66.667px] w-fit">
            Welcome to Y-TRACK
          </div>
          <h1 class="text-5xl font-bold leading-17 tracking-[-0.96px] mt-4 max-md:max-w-full max-md:text-[40px] max-md:leading-[49px]">
            Simplify Your Finance
            <br />
            with Y-track
          </h1>
        </div>
        <p class="text-[#061C3D] text-base font-normal leading-5 mt-7 max-md:max-w-full">
          The all-in-one financial management platform designed for freelancers
        </p>
        <div class="flex gap-[11px] text-base font-bold capitalize leading-[48px] mt-7">
          <button class="self-stretch bg-[rgba(255,165,2,1)] gap-2 text-white px-5 rounded-2 max-md:px-5">
            Get Started
          </button>
          <button class="justify-center items-center bg-[#F0F5FF] flex gap-2 text-[#FFA502] px-5 rounded-1 max-md:px-5">
            <i class="fa-solid fa-book self-stretch" style=" color:#FFA502 ;display: flex; align-items: center;;"></i>
            <span class="self-stretch my-auto">See Document</span>
          </button>
        </div>
      </div>
      <div class="relative flex items-center  gap-2 text-24 text-black font-medium leading-normal justify-center h-10 mt-38 max-md:mt-10">
      <i class="fa-solid fa-computer-mouse" ></i>
      <i class="fa-solid fa-down-long"></i>
      </div>
    </section>
@endsection
@include('components.footer')