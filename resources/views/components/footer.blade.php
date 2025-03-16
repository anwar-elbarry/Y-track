@extends('layoats.app')
@section('main-content')
<footer class="bg-[#061C3D] w-full overflow-hidden mt-[111px] pl-[202px] pr-48 max-md:max-w-full max-md:mt-10 max-md:px-5">
      <div class="flex items-center gap-[40px_91px] justify-center flex-wrap py-[83px] max-md:max-w-full">
        <div class="self-stretch text-xs text-gray-400 font-normal leading-5 w-[210px] my-auto">
          <img
            src="{{ asset('images/Y-TRACK_light.svg') }}"
            alt="Y-track logo"
            class="aspect-[2.73] object-contain w-[164px] max-w-full"
          />
          <p class="mt-[22px]">
            The all-in-one financial management platform designed for
            freelancers
          </p>
        </div>
        <nav class="self-stretch min-w-60 text-base font-medium my-auto">
          <div class="flex gap-4 whitespace-nowrap">
            <a href="#" class="text-[#838E9E] w-[134px] py-1">
              About
            </a>
          </div>
          <div class="flex gap-4 text-[#838E9E] mt-[5px]">
            <a href="#" class="whitespace-nowrap w-[134px] py-1">
              Services
            </a>
            <a href="#" class="w-[134px] py-1">
              Pricing Plans
            </a>
          </div>
          <div class="flex gap-4 text-[#838E9E] whitespace-nowrap mt-[5px]">
            <a href="#" class="w-[134px] py-1">
              Career
            </a>
            <a href="#" class="w-[134px] py-1">
              Contact
            </a>
          </div>
        </nav>
        <div class="self-stretch w-[210px] my-auto">
          <div class="text-white text-base font-medium leading-none">
            support@ytrack.com
          </div>
          <div class="text-[#838E9E] text-xs font-normal leading-[17px] mt-4">
            901 N Pitt Str., Suite 170
            <br />
            Marrakech, Morocco
          </div>
        </div>
      </div>
      <div class="justify-between items-center shadow-[0px_-0.672px_0px_0px_#243752] bg-[#061C3D] flex w-full max-w-[887px] gap-[40px_100px] flex-wrap py-[22px] max-md:max-w-full">
        <div class="text-white text-center text-[11px] font-normal self-stretch my-auto">
          © 2025 - Y-track
        </div>
      </div>
    </footer>
@endsection
