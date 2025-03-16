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
          <button class="justify-center items-center bg-[#FFA502] flex gap-2 text-[#F0E9E2] px-5 rounded-1 max-md:px-5">
            <i class="fa-solid fa-book self-stretch" style=" color:#F0E9E2 ;display: flex; align-items: center;;"></i>
            <span class="self-stretch my-auto">See Document</span>
          </button>
        </div>
      </div>
      <div class="relative flex items-center  gap-2 text-24 text-black font-medium leading-normal justify-center h-10 mt-38 max-md:mt-10">
      <i class="fa-solid fa-computer-mouse" ></i>
      <i class="fa-solid fa-down-long"></i>
      </div>
    </section>
    <!-- features -->
    <section class="flex w-full flex-col items-stretch justify-center max-md:max-w-full">
  <!-- Features Section -->
  <section class="flex w-full flex-col items-stretch justify-center max-md:max-w-full">
    <div class="flex w-full flex-col items-center text-[#061C3D] text-center justify-center max-md:max-w-full">
      <h2 class="text-[37px] font-bold leading-10 tracking-[-0.75px] w-[880px] max-md:max-w-full">
        Y-Track
        <br>
        Your Smart Finance Manager
      </h2>
      <p class="text-[13px] font-normal leading-[19px] w-[432px] mt-[21px] max-md:max-w-full">
        Track & optimize your financial journey effortlessly, Manage
        transactions, monitor expenses, and achieve your financial goals with
        ease.
      </p>
    </div>
    <div class="cards flex w-full flex-col items-center justify-center mt-12 max-md:max-w-full max-md:mt-10">
      <!-- First row of feature cards -->
      <div class="flex gap-4 flex-wrap max-md:max-w-full">
        <!-- Expense Tracking -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5">
          <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
            <i class="fa-solid fa-magnifying-glass-dollar fa-xl text-orange-500"  ></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Expense Tracking
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Monitor where your money goes with real-time expense tracking.
            </p>
          </div>
        </div>

        <!-- Income Management -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5">
        <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
        <i class="fa-solid fa-money-bill-transfer fa-xl text-orange-500"></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Income Management
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Keep an eye on all your income sources in one place.
            </p>
          </div>
        </div>

        <!-- Recurring Bills -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5 ">
        <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
        <i class="fa-solid fa-bullhorn fa-xl text-orange-500"></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Recurring Bills
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Automate and track your monthly and yearly bills easily.
            </p>
          </div>
        </div>
      </div>

      <!-- Second row of feature cards -->
      <div class="flex gap-4 flex-wrap mt-4 max-md:max-w-full">
        <!-- Financial Reports -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5">
        <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
        <i class="fa-solid fa-chart-pie fa-xl text-orange-500"></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Financial Reports
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Generate detailed reports for better financial analysis.
            </p>
          </div>
        </div>

        <!-- Goal Planning -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5">
        <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
        <i class="fa-solid fa-bullseye fa-xl text-orange-500"></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Goal Planning
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Set financial goals and stay on track to achieve them.
            </p>
          </div>
        </div>

        <!-- Invoice Generator -->
        <div class="card justify-center items-center bg-white flex min-w-60 flex-col p-[21px] rounded-[10.667px] max-md:px-5">
        <div class="iconcover items-center bg-[#F0E9E2] flex items-center  w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
        <i class="fa-solid fa-file-invoice fa-xl text-orange-500"></i>
          </div>
          <div class="flex max-w-full w-60 flex-col items-center text-center justify-center mt-4 pt-[3px]">
            <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
              Invoice Generator
            </h3>
            <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
              Create and manage professional invoices quickly.
            </p>
          </div>
        </div>
      </div>
    </div>
    </section>
@endsection
@include('components.footer')