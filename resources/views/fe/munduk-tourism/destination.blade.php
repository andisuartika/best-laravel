@extends('fe.munduk-tourism.layout')
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate fadeInUp ftco-animated">
                    <span class="subheading">Munduk Tourism</span>
                    <h2 class="mb-4">Destination List</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($destinations as $destination )
                    <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                        <div class="project-wrap">
                            <a href="{{ asset($destination->thumbnail) }}" class="img" style="background-image: url({{ asset($destination->thumbnail) }});">
                            </a>
                            <div class="text p-4">
                                <span class="days">
                                    @foreach ($destination->categories as $category)
                                        <a href="https://munduktourism.com/destination?category={{ $category->slug }}">{{ $category->name }}</a>
                                        @if (!$loop->last)
                                            ,
                                        @endif

                                    @endforeach
                                </span>
                                <h3>
                                    <a href="{{ route('munduk-tourism.destination.detail', Str::slug($destination->name)) }}">
                                        {{ $destination->name }}
                                    </a>
                                </h3>
                                <p class="location"><span class="fa fa-map-marker"></span>
                                   {{ $destination->address }}
                                </p>
                                <span>
                                    <p>---------</p>
                                   <p>{!! Str::limit($destination->description, 100, '...') !!}</p>
                                </span>
                                <a href="{{ route('munduk-tourism.destination.detail', Str::slug($destination->name)) }}" class="pb-2 btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center p-5">
        <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($destinations->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                            <span class="page-link" aria-hidden="true">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $destinations->previousPageUrl() }}" rel="prev" aria-label="« Previous">‹</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($destinations->getUrlRange(1, $destinations->lastPage()) as $page => $url)
                        @if ($page == $destinations->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($destinations->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $destinations->nextPageUrl() }}" rel="next" aria-label="Next »">›</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                            <span class="page-link" aria-hidden="true">›</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </section>
@endsection

