<div class="flex bg-white rounded-lg p-6 mt-6">
  <div class="flex-shrink-1 bg-blue-600 rounded-lg lg:w-2/12 py-4 block h-full">
    <div class="text-center tracking-wide">
      <div class="text-white font-bold text-2xl ">{{$day}}</div>
      <div class="text-white font-normal text-1xl">{{$month}}</div>
      <div class="text-white font-normal text-1xl">{{$time}}</div>
    </div>
  </div>
  <div class="flex-grow mt-4 md:mt-0 md:m-6">
    <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">Diretta</div>
    <a href="{{$event->url}}" target="_blank" class="block mt-1 text-lg leading-tight font-semibold text-gray-900 hover:underline">{{$event->title}}</a>
    @if($event->description)
      <p class="mt-2 text-gray-600">{{$event->description}}</p>
    @endif
  </div>
  @if($event->image_url)
  <div class="flex-shrink-1">
    <img class="rounded-lg md:w-56" src="{{$event->image_url}}">
  </div>
  @endif
</div>

