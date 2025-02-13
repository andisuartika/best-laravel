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

    <style>
        #map {
            height: 300px;
        }
    </style>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <span>Akomodasi Wisata</span>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <li>
                    <a href="{{ route('homestays.index') }}" class="text-primary hover:underline">Penginapan</a>
                </li>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Ubah Penginapan</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ mt-3">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M2 11L10.1259 4.49931C11.2216 3.62279 12.7784 3.62279 13.8741 4.49931L22 11"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path opacity="0.5"
                        d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M4 22V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M20 22V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path opacity="0.5"
                        d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393C9 14.8787 9 15.5858 9 17V22"
                        stroke="currentColor" stroke-width="1.5" />
                    <path opacity="0.5"
                        d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z"
                        stroke="currentColor" stroke-width="1.5" />
                </svg>


            </div>
            <span class="ltr:mr-3 rtl:ml-3">Lokasi Penginapan: </span> Silahkan lengkapi data penginapan untuk
            menambah penginapan baru
        </div>
        <div class="pt-5 space-y-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel p-5">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Penginapan</h5>
                    </div>
                    <div>
                        <p class="mb-4">
                            Lengkapi form detai informasi penginapan yang anda tambahkan
                        </p>
                        <div>
                            <form class="space-y-5" method="POST" action="{{ route('homestays.update', $homestay) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class=" @error('name')  has-error @enderror">
                                    <label for="name">Nama Penginapan</label>
                                    <input id="name" name="name" type="text" required
                                        placeholder="Masukkan Nama Penginapan" class="form-input"
                                        value="{{ $homestay ? $homestay->name : old('name') }}" />
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class=" @error('description')  has-error @enderror">
                                    <label for="description">Deskripsi Penginapan</label>
                                    <textarea id="editor" name="description">{{ $homestay ? $homestay->description : old('description') }}</textarea>

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
                                    <label for="address">Alamat Penginapan</label>
                                    <input id="address" type="text" name="address"
                                        placeholder="Masukkan Alamat Penginapan" class="form-input" required
                                        value="{{ $homestay ? $homestay->address : old('address') }}" />
                                    @error('address')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address">Lokasi Penginapan</label>

                                    <div id="map" style="width: 100%; height: 300px;"></div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="@error('latitude')  has-error @enderror">
                                        <label for="latitude">Latitude</label>
                                        <input id="latitude" type="text" name="latitude"
                                            placeholder="Enter Latitude" class="form-input"
                                            value="{{ $homestay ? $homestay->latitude : old('latitude') }}" />
                                        @error('latitude')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="@error('longitude')  has-error @enderror">
                                        <label for="longitude">Longtitude</label>
                                        <input id="longitude" type="text" name="longitude"
                                            placeholder="Enter Longitude" class="form-input"
                                            value="{{ $homestay ? $homestay->longitude : old('longitude') }}" />
                                        @error('longitude')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="@error('facilities') has-error @enderror">
                                    <label for="facilities">Fasilitas Penginapan</label>
                                    <select class="facilitySelect form-select form-select-lg text-white-dark"
                                        name="facilities[]" multiple="multiple">
                                        @php
                                            // Konversi string JSON ke dalam array PHP
                                            $selectedFacilities = json_decode($homestay->facilities);
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
                                    </select>
                                    @error('facilities')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="@error('thumbnail')  has-error @enderror">
                                    <label for="ctnFile">Gambar Penginapan</label>
                                    <input id="ctnFile" type="file"
                                        class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                        onchange="readURL(this);" name="thumbnail" />
                                    <div class="py-5">
                                        <img id="preview" src="{{ asset($homestay->thumbnail) }}" alt="your image"
                                            class="rounded-md  object-fit"style="width: 300px;" />
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

                var marker = L.marker([{{ $homestay->latitude }}, {{ $homestay->longitude }}]).addTo(map);

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
