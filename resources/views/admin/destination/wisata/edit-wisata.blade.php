<x-layout.default>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="/assets/js/file-upload-with-preview.iife.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.css" />
    <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #map {
            height: 300px;
        }
    </style>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('destination.index') }}" class="text-primary hover:underline">Destinasi Wisata</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Lokasi Wisata</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ mt-3">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 8.51464C4.25 4.45264 7.77146 1.25 12 1.25C16.2285 1.25 19.75 4.45264 19.75 8.51464C19.75 12.3258 17.3871 16.8 13.5748 18.4292C12.574 18.8569 11.426 18.8569 10.4252 18.4292C6.61289 16.8 4.25 12.3258 4.25 8.51464ZM12 2.75C8.49655 2.75 5.75 5.38076 5.75 8.51464C5.75 11.843 7.85543 15.6998 11.0147 17.0499C11.639 17.3167 12.361 17.3167 12.9853 17.0499C16.1446 15.6998 18.25 11.843 18.25 8.51464C18.25 5.38076 15.5034 2.75 12 2.75ZM12 7.75C11.3096 7.75 10.75 8.30964 10.75 9C10.75 9.69036 11.3096 10.25 12 10.25C12.6904 10.25 13.25 9.69036 13.25 9C13.25 8.30964 12.6904 7.75 12 7.75ZM9.25 9C9.25 7.48122 10.4812 6.25 12 6.25C13.5188 6.25 14.75 7.48122 14.75 9C14.75 10.5188 13.5188 11.75 12 11.75C10.4812 11.75 9.25 10.5188 9.25 9ZM3.59541 14.9966C3.87344 15.3036 3.84992 15.7779 3.54288 16.0559C2.97519 16.57 2.75 17.0621 2.75 17.5C2.75 18.2637 3.47401 19.2048 5.23671 19.998C6.929 20.7596 9.31952 21.25 12 21.25C14.6805 21.25 17.071 20.7596 18.7633 19.998C20.526 19.2048 21.25 18.2637 21.25 17.5C21.25 17.0621 21.0248 16.57 20.4571 16.0559C20.1501 15.7779 20.1266 15.3036 20.4046 14.9966C20.6826 14.6895 21.1569 14.666 21.4639 14.9441C22.227 15.635 22.75 16.5011 22.75 17.5C22.75 19.2216 21.2354 20.5305 19.3788 21.3659C17.4518 22.2331 14.8424 22.75 12 22.75C9.15764 22.75 6.54815 22.2331 4.62116 21.3659C2.76457 20.5305 1.25 19.2216 1.25 17.5C1.25 16.5011 1.77305 15.635 2.53605 14.9441C2.84309 14.666 3.31738 14.6895 3.59541 14.9966Z"
                        fill="currentColor" />
                </svg>

            </div>
            <span class="ltr:mr-3 rtl:ml-3">Lokasi Desa Wisata: </span> Silahkan lengkapi data desa wisata untuk
            menambah destinasi wisata baru
        </div>
        <div class="pt-5 space-y-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Lokasi Destinasi Wisata</h5>
                    </div>
                    <div>
                        <h4 class="mb-4 text-2xl font-semibold">Detail Informasi Destinasi Wisata</h4>
                        <p class="mb-4">
                            Lengkapi form detai informasi destinasi wisata yang anda tambahkan
                        </p>
                        <div>
                            <form class="space-y-5" method="POST"
                                action="{{ route('destination.update', $destination) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class=" @error('name')  has-error @enderror">
                                    <label for="name">Nama Destinasi</label>
                                    <input id="name" name="name" type="text" required
                                        placeholder="Masukkan Nama Destinasi" class="form-input"
                                        value="{{ $destination ? $destination->name : old('name') }}" />
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class=" @error('description')  has-error @enderror">
                                    <label for="description">Deskripsi Destinasi</label>
                                    <textarea id="editor" name="description">{{ $destination ? $destination->description : old('description') }}</textarea>

                                    <style>
                                        .ck-editor__editable[role="textbox"] {
                                            /* Editing area */
                                            min-height: 200px;
                                        }
                                    </style>
                                    <!-- script -->
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#editor'))
                                            .catch(error => {
                                                console.log('error');
                                                console.error(error);
                                            });
                                    </script>
                                    @error('description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="@error('address')  has-error @enderror">
                                    <label for="address">Alamat Destinasi</label>
                                    <input id="address" type="text" name="address"
                                        placeholder="Masukkan Alamat Destinasi" class="form-input" required
                                        value="{{ $destination ? $destination->address : old('address') }}" />
                                    @error('address')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address">Lokasi Destinasi</label>

                                    <div id="map" style="width: 100%; height: 300px;"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="@error('latitude')  has-error @enderror">
                                        <label for="latitude">Latitude</label>
                                        <input id="latitude" type="text" name="latitude"
                                            placeholder="Enter Latitude" class="form-input"
                                            value="{{ $destination ? $destination->latitude : old('latitude') }}" />
                                        @error('latitude')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="@error('longitude')  has-error @enderror">
                                        <label for="longitude">Longtitude</label>
                                        <input id="longitude" type="text" name="longitude"
                                            placeholder="Enter Longitude" class="form-input"
                                            value="{{ $destination ? $destination->longitude : old('longitude') }}" />
                                        @error('longitude')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="@error('manager')  has-error @enderror">
                                    <label for="manager">Pilih Pengelola Destinasi</label>
                                    <select class="managerSelect selectize form-select form-select-lg text-white-dark"
                                        name="manager">
                                        <option value="">Pilih Pengelola</option>
                                        @foreach ($managers as $manager)
                                            <option value="{{ $manager->code }}"
                                                {{ $destination->manager == $manager->code ? 'selected' : '' }}>
                                                {{ $manager->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('manager')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="@error('categories')  has-error @enderror">
                                    <label for="categories">Pilih Kategori Destinasi</label>
                                    <select class="categorySelect form-select form-select-lg text-white-dark"
                                        name="categories[]" multiple="multiple">
                                        @php
                                            // Konversi string JSON ke dalam array PHP
                                            $selectedCategories = json_decode($destination->category);
                                        @endphp
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->code }}"
                                                {{ in_array($category->code, $selectedCategories) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="@error('facilities') has-error @enderror">
                                    <label for="facilities">Fasilitas Destinasi</label>
                                    <select class="facilitySelect form-select form-select-lg text-white-dark"
                                        name="facilities[]" multiple="multiple">
                                        @php
                                            // Konversi string JSON ke dalam array PHP
                                            $selectedFacilities = json_decode($destination->facilities);
                                        @endphp
                                        @foreach ($selectedFacilities as $selectedFacility)
                                            @php
                                                $facilityFound = false;
                                            @endphp
                                            @foreach ($facilities as $facility)
                                                @if ($facility->name === $selectedFacility)
                                                    <option value="{{ $facility->name }}" selected>
                                                        {{ $facility->name }}
                                                    </option>
                                                    @php
                                                        $facilityFound = true;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (!$facilityFound)
                                                <option value="{{ $selectedFacility }}" selected>
                                                    {{ $selectedFacility }}
                                                </option>
                                            @endif
                                        @endforeach
                                        @foreach ($facilities as $facility)
                                            @if (!in_array($facility->name, $selectedFacilities))
                                                <option value="{{ $facility->name }}">
                                                    {{ $facility->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('facilities')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="@error('thumbnail')  has-error @enderror">
                                    <label for="ctnFile">Gambar Destinasi</label>
                                    <input id="ctnFile" type="file"
                                        class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                        onchange="readURL(this);" name="thumbnail" />
                                    <div class="py-5">
                                        <img id="preview" src="{{ asset($destination->thumbnail) }}"
                                            alt="your image" class="rounded-md  object-fit"style="width: 300px;" />
                                    </div>
                                    <script>
                                        function readURL(input) {
                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                                reader.onload = function(e) {
                                                    $('#preview')
                                                        .attr('src', e.target.result);
                                                };

                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script>
                                    @error('thumbnail')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary !mt-6">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <script>
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                });
                toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    padding: '10px 20px',
                });
            </script>
        @endif
        {{-- LeaftletJS --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.js"></script>
        <script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const providerOSM = new GeoSearch.OpenStreetMapProvider();
                var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });

                var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });

                var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });

                var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });
                var map = L.map('map', {
                    fullscreenControl: true,
                    fullscreenControl: {
                        pseudoFullscreen: true
                    },
                    minZoom: 2
                }).setView([-8.17333150405403, 115.12680484846346], 10);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var marker = L.marker([{{ $destination->latitude }}, {{ $destination->longitude }}]).addTo(map);


                map.on('click', function(e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;
                    marker.setLatLng(e.latlng);
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;

                });

                var baseMaps = {
                    "Streets": googleStreets,
                    "Hybrid": googleHybrid,
                    "Satellite": googleSat,
                    "Terrain": googleTerrain,
                };
                var layerControl = L.control.layers(baseMaps).addTo(map);

                const search = new GeoSearch.GeoSearchControl({
                    notFoundMessage: 'Maaf, lokasi tidak ditemukan.',
                    provider: providerOSM,
                    style: 'bar',
                    searchLabel: 'Buleleng',
                });
                map.addControl(search);
                map.addControl(new L.Control.Fullscreen());
                map.on('enterFullscreen', function() {
                    if (window.console) window.console.log('enterFullscreen');
                });
                map.on('exitFullscreen', function() {
                    if (window.console) window.console.log('exitFullscreen');
                });
            });
        </script>

        {{-- Select2 --}}
        <script>
            $(document).ready(function() {
                $('.categorySelect').select2({
                    placeholder: 'Pilih Kategori Destinasi',

                });
            });
            $(document).ready(function() {
                $('.facilitySelect').select2({
                    placeholder: 'Pilih Fasilitas Destinasi',
                    tags: []
                });
            });
            $(document).ready(function() {
                $('.managerSelect').select2({
                    placeholder: 'Pilih Pengelola Destinasi',
                });
            });
        </script>
        <!-- start hightlight js -->
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
        <script src="/assets/js/highlight.min.js"></script>

</x-layout.default>
