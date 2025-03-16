@extends('layoats.app')
@section('main-content')
<footer class="bg-[#061C3D] w-full overflow-hidden mt-[111px] pl-[202px] pr-48 max-md:max-w-full max-md:mt-10 max-md:px-5">
      <div class="flex items-center gap-[40px_91px] justify-center  py-[83px] lg:flex-nowrap flex-wrap max-md:max-w-full">
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
        <div class="self-stretch flex text-gray-400 justify-evenly min-w-67 text-base font-medium my-auto">
            <a href="#" class="w-fit py-1">
              Home
            </a>
            <a href="#" class="w-fit py-1">
              About
            </a>
            <a href="#" class="w-fit py-1">
            Features                   
            </a>
            <a href="#" class="w-fit py-1">
              Contact
            </a>
        </div>
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
      <div class="justify-between items-center shadow-[0px_-0.672px_0px_0px_#243752] bg-[#061C3D] flex w-full gap-[40px_100px] flex-wrap py-5 max-md:max-w-full">
    <div class="social_Footer flex justify-evenly items-center w-33 gap-2 h-6">
    <a class="h-full w-full flex justify-center items-center" href="http://" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-lg fa-discord" style=" height: 100%;align-content: center;"></i></a>
    <a class="h-full w-full flex justify-center items-center" href="http://" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-lg fa-facebook" style="height: 100%;align-content: center;"></i></a>    
    <a class="h-full w-full flex justify-center items-center" href="http://" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-lg fa-square-x-twitter" style="height: 100%;align-content: center;"></i></a> 
    <a class="h-full w-full flex justify-center items-center" href="http://" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-lg fa-github" style="height: 100%;align-content: center;"></i></a> 
    </div>
        <div class="text-white text-center text-[11px] font-normal self-stretch">
          © 2025 - Y-track
        </div>
      </div>
    </footer>
@endsection
