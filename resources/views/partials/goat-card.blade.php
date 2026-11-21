<a class="card {{ $goat->status === 'terjual' ? 'sold' : '' }}" href="{{ route('goats.show', $goat->code) }}">
  <div class="photo">
    <img src="{{ $goat->photo_url }}" alt="{{ $goat->name }}, {{ $goat->breed_label }}" loading="lazy">
    <span class="badge s-{{ $goat->status }}">{{ ucfirst($goat->status) }}</span>
  </div>
  <div class="body">
    <span class="breed">{{ $goat->breed_label }}</span>
    <h3>{{ $goat->name }}</h3>
    <div class="meta">{{ $goat->sex }}, {{ $goat->age_months }} bulan, {{ $goat->weight_kg }} kg</div>
    <div class="price">Rp {{ number_format($goat->price, 0, ',', '.') }}</div>
  </div>
</a>
