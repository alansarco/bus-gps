@extends('back.layout.pages-layout')
@section('pageTitle', 'Location Map')
@section('content')

<!-- Back Button -->
<a href="{{ route('admin.home') }}" class="btn btn-primary mb-3">
    <i class="micon fa fa-arrow-left"></i> Back to Home
</a>

<!-- Location Details -->
<div class="row mb-3">
    <div class="col-md-4">
        <strong>Name:</strong> {{ $data->name }}
    </div>
    <div class="col-md-4">
        <strong>Date:</strong> {{ $data->formatted_date }}
    </div>
    <div class="col-md-4">
        <strong>Time:</strong> {{ $data->formatted_time }}
    </div>
    <div class="col-md-4">
        <strong>Latitude:</strong> {{ $data->latitude }}
    </div>
    <div class="col-md-4">
        <strong>Longitude:</strong> {{ $data->longitude }}
    </div>
</div>

<!-- Map Container -->
<div id="map" style="height: 480px;"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the map with latitude and longitude
        var map = L.map('map').setView([{{ $data->latitude }}, {{ $data->longitude }}], 15);

        // Add the tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker to the map
        L.marker([{{ $data->latitude }}, {{ $data->longitude }}]).addTo(map)
            .bindPopup("{{ $data->name }}")
            .openPopup();
    });
</script>

@endsection
