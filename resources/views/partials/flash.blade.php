@if(session('success'))
  <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">
    <ul class="list-disc list-inside">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif
