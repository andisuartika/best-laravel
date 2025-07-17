@extends('fe.munduk-tourism.layout')
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    <span class="subheading">Munduk Tourism</span>
                    <h2 class="mb-4">Accommodations List</h2>
                </div>
            </div>
        </div>
        <section class="ftco-section">
                <div class="container">
                    @foreach ($accommodations as $item )
                    <div class="row">
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap hotel">
                                <a href="{{ route('munduk-tourism.accommodation.detail',$item->slug) }}" class="img" style="background-image: url({{asset( $item->thumbnail) }});">

                                </a>
                                <div class="text p-4">
                                    <p class="star mb-2">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </p>
                                    <span class="days">Homestay</span>
                                    <h3><a href="{{ route('munduk-tourism.accommodation.detail',$item->slug) }}">{{ $item->name }}</a></h3>
                                    <p class="location"><span class="fa fa-map-marker"></span> {{ $item->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                   <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                            <ul>
                                {{-- Previous Page Link --}}
                                @if ($accommodations->onFirstPage())
                                <li class="disabled"><span>&lt;</span></li>
                                @else
                                <li><a href="{{ $accommodations->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($accommodations->links()->elements[0] as $page => $url)
                                @if ($page == $accommodations->currentPage())
                                    <li class="active"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($accommodations->hasMorePages())
                                <li><a href="{{ $accommodations->nextPageUrl() }}">&gt;</a></li>
                                @else
                                <li class="disabled"><span>&gt;</span></li>
                                @endif
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </section>

    <script src="https://munduktourism.com/js/jquery.min.js"></script>
    <script src="https://munduktourism.com/js/jquery-migrate-3.0.1.min.js"></script>
@endsection

