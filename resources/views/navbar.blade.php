<nav class="bg-white shadow p-4 rounded mb-6 flex justify-between items-center">
  <a href="{{ route('gifts.index') }}" class="font-bold">Intercambio Regalos</a>
  <div class="flex items-center gap-4">
    @auth
      <span class="hidden sm:inline">Hola, {{ auth()->user()->name }}</span>
      <a href="{{ route('gifts.create') }}" class="btn">Crear regalo</a>
      <form method="POST" action="{{ route('logout') }}"> @csrf
        <button class="btn-ghost">Logout</button>
      </form>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
    @endauth
  </div>
</nav>
